<?php

namespace Ringierimu\MultiTenancy;

use Ringierimu\MultiTenancy\Models\Tenant;

/**
 * Class TenantManager
 * @package Ringierimu\MultiTenancy
 */
class TenantManager
{
    /** @var Tenant */
    private $tenant;

    /**
     * @return Tenant
     */
    public function getTenant(): Tenant
    {
        return $this->tenant;
    }

    /**
     * @param Tenant $tenant
     */
    public function setTenant(Tenant $tenant): void
    {
        $this->tenant = $tenant;
    }

    /**
     * @param string $domain
     *
     * @return bool
     */
    public function loadTenant(string $domain): bool
    {
        /** @var Tenant $tenant */
        $tenant = Tenant::query()
            ->where("domain", $domain)
            ->first();

        if (!$tenant) {
            return false;
        }

        $this->setTenant($tenant);

        return true;
    }
}
