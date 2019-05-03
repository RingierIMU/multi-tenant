<?php

namespace Ringierimu\MultiTenant;

use Illuminate\Support\ServiceProvider;
use Ringierimu\MultiTenant\Models\Domain;

/**
 * Class MultiTenancyServiceProvider
 * @package Ringierimu\MultiTenant
 */
class MultiTenancyServiceProvider extends ServiceProvider
{
    /**
     *  Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrations();
    }

    /**
     *  Register the application services...
     */
    public function register()
    {
        $manager = new TenantManager();

        $this->app->instance(TenantManager::class, $manager);
        $this->app->bind(Domain::class, function () use ($manager) {
            return $manager->getTenant();
        });
    }

    /**
     * Load migration files
     */
    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
