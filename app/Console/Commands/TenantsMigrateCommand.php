<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;

class TenantsMigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrate {tenant?} {--fresh} {--refresh} {--seed} {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make migration into each or all tenants database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('tenant')) {
            $this->migrate(
                Tenant::find($this->argument('tenant'))
            );
        } else {
            Tenant::all()->each(
                fn($tenant) => $this->migrate($tenant)
            );
        }
    }

    /**
     * @param \App\Tenant $tenant
     * @return int
     */
    public function migrate($tenant)
    {
        $tenant->configure()->use();

        $this->line('');
        $this->line("-----------------------------------------");
        $this->info("Migrating Tenant #{$tenant->id} ({$tenant->customer_name})");
        $this->line("-----------------------------------------");

        $options = ['--force' => true];

        if ($this->option('seed')) { 
            $options['--seed'] = true;
        }

        if ($this->option('path')) {
            $options['--path'] = $this->option('path');
        }

        if($this->option('fresh')) {
            $command = 'migrate:fresh';
        } else if ($this->option('refresh')) {
            $command = 'migrate:refresh';
        } else {
            $command = 'migrate';
        }

        $this->call($command, $options);
    }
}
