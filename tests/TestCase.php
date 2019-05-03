<?php

namespace Ringierimu\MultiTenant\Tests;

use Ringierimu\MultiTenant\MultiTenancyServiceProvider;

/**
 * Class TestCase
 * @package Ringierimu\MultiTenant
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->withFactories(__DIR__ . '/Fixtures/database/factories');
        $this->loadMigrationsFrom(__DIR__ . '/Fixtures/database/migrations');
        $this->loadLaravelMigrations();
    }

    protected function getPackageProviders($app)
    {
        return [MultiTenancyServiceProvider::class];
    }
}
