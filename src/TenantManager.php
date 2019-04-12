<?php

namespace Ringierimu\MultiTenancy;

use Illuminate\Support\Facades\File;
use Ringierimu\MultiTenancy\Models\Tenant;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

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
        $this->loadTenantConfig($tenant);

        return true;
    }

    /**
     * @param \Ringierimu\MultiTenancy\Models\Tenant $tenant
     */
    private function loadTenantConfig(Tenant $tenant)
    {
        $envConfigPath = config_path() . "/tenants/{$tenant->aliases}";
        $config = app('config');

        if (!File::exists($envConfigPath)) {
            return;
        }

        /** @var SplFileInfo $file */
        foreach (Finder::create()->files()->name('*.php')->in($envConfigPath) as $file) {
            $key_name = basename($file->getRealPath(), '.php');
            $old_values = $config->get($key_name) ?: [];
            $new_values = require $file->getRealPath();

            $config->set($key_name, array_replace_recursive($old_values, $new_values));
        }
    }
}
