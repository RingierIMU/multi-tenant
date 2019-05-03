<?php

namespace Ringierimu\MultiTenant\Tests\Unit;

use Ringierimu\MultiTenant\Models\Domain;
use Ringierimu\MultiTenant\TenantManager;
use Ringierimu\MultiTenant\Tests\TestCase;

/**
 * Class TenantManagerUnitTest
 * @package Ringierimu\MultiTenant\Tests\Unit
 */
class TenantManagerUnitTest extends TestCase
{
    public function testItShouldReturnTenant()
    {
        /** @var Domain $tenant */
        $tenant = factory(Domain::class)->create();

        /** @var TenantManager $tenantManager */
        $tenantManager = app(TenantManager::class);
        $tenantManager->setDomain($tenant);

        $this->assertInstanceOf(Domain::class, $tenantManager->getDomain());
    }

    public function testItShouldLoadTenantFromDomain()
    {
        factory(Domain::class)->create();

        $domain = "tenant.test";
        /** @var TenantManager $tenantManager */
        $tenantManager = app(TenantManager::class);
        $this->assertTrue($tenantManager->loadDomain($domain));

        /** @var TenantManager $manager */
        $manager = app(TenantManager::class);

        $this->assertInstanceOf(Domain::class, $manager->getDomain());
        $this->assertEquals($domain, $manager->getDomain()->host);
    }

}
