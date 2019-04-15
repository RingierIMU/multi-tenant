<?php

namespace Ringierimu\MultiTenancy\Tests;

use Ringierimu\MultiTenancy\MultiTenancyServiceProvider;

/**
 * Class TestCase
 * @package Ringierimu\MultiTenancy
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function getPackageProviders($app)
    {
        return [MultiTenancyServiceProvider::class];
    }
}
