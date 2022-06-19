<?php

namespace App\Providers;

use App\Interfaces\SampleInterface;
use App\Repositories\SampleRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider for Repository
 * 
 * @author  PhyoNaing Htun
 * @create  2022/06/08
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SampleInterface::class, SampleRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
