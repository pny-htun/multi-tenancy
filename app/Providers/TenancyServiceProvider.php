<?php

namespace App\Providers;

use App\Models\Tenant;
use Illuminate\Support\ServiceProvider;

class TenancyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRequests();

        $this->configureQueue();
    }

    /**
     * Get customer name from incoming request to change customer database
     */
    public function configureRequests()
    {
        if (!$this->app->runningInConsole()) {
            // get customer name form url path
            $customerName = collect($this->app['request']->segments())[1];

            // load customer's database
            Tenant::whereCustomerName($customerName)->firstOrFail()->configure()->use();
        }
    }

    /**
     * Change queue job for specific customers
     */
    public function configureQueue()
    {
        $this->app['queue']->createPayloadUsing(function () {
            return $this->app['mysql'] ? ['tenant_id' => $this->app['mysql']->id] : [];
        });

        $this->app['events']->listen(JobProcessing::class, function ($event) {
            if (isset($event->job->payload()['tenant_id'])) {
                Tenant::find($event->job->payload()['tenant_id'])->configure()->use();
            }
        });
    }
}
