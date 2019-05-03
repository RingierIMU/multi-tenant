<?php namespace Ringierimu\MultiTenant\Tests\Unit\Helper;

use Ringierimu\MultiTenant\Models\Domain;
use Ringierimu\MultiTenant\TenantManager;
use Ringierimu\MultiTenant\Tests\TestCase;
use TypeError;

/**
 * Class DomainUnitTest
 * @package Ringierimu\MultiTenant\Tests\Unit\Helper
 */
class DomainUnitTest extends TestCase
{
    public function testHelperShouldReturnDomain()
    {
        /** @var Domain $domain */
        $domain = factory(Domain::class)->create();

        /** @var TenantManager $tenantManager */
        $tenantManager = app(TenantManager::class);
        $tenantManager->setDomain($domain);

        $this->assertEquals($domain, domain());
    }

    public function testHelperShouldReturnNull()
    {
        $this->expectException(TypeError::class);
        $this->assertNull(domain());
    }
}
