<?php

namespace Ringierimu\MultiTenant;

use Illuminate\Support\Facades\File;
use Ringierimu\MultiTenant\Models\Domain;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

/**
 * Class TenantManager
 * @package Ringierimu\MultiTenant
 */
class TenantManager
{
    /** @var Domain */
    private $tenant;

    /**
     * @return Domain
     */
    public function getTenant(): Domain
    {
        return $this->tenant;
    }

    /**
     * @param Domain $domain
     */
    public function setTenant(Domain $domain): void
    {
        $this->tenant = $domain;
    }

    /**
     * @param string $domain
     *
     * @return bool
     */
    public function loadTenant(string $domain): bool
    {
        $domain = parse_domain($domain);

        /** @var Domain $domain */
        $domain = Domain::query()
            ->where("host", $domain['host'])
            ->first();

        if (!$domain) {
            return false;
        }

        $this->setTenant($domain);
        $this->loadTenantConfig($domain);

        return true;
    }

    /**
     * @param Domain $domain
     */
    public function loadTenantConfig(Domain $domain)
    {
        $envConfigPath = config_path() . "/tenants/{$domain->aliases}";
        $config = app('config');
        $excludedDirectories = [];
        $environment = app()->environment();

        if (!File::exists($envConfigPath)) {
            return;
        }

        /** @var SplFileInfo $directories */
        foreach (Finder::create()->directories()->in($envConfigPath)->exclude($environment) as $directories) {
            $excludedDirectories[] = basename($directories->getRealPath());
        }

        /** @var SplFileInfo $file */
        foreach (Finder::create()->files()->name('*.php')->in($envConfigPath)->exclude($excludedDirectories) as $file) {
            $key_name = basename($file->getRealPath(), '.php');
            $old_values = $config->get($key_name) ?: [];
            $new_values = require $file->getRealPath();

            $config->set($key_name, array_replace_recursive($old_values, $new_values));
        }
    }
}
