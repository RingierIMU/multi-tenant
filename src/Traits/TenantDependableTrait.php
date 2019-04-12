<?php

namespace Ringierimu\MultiTenancy\Traits;

use Illuminate\Database\Eloquent\Model;
use Ringierimu\MultiTenancy\Models\Tenant;
use Ringierimu\MultiTenancy\Scopes\TenantDependableScope;
use Ringierimu\MultiTenancy\TenantManager;

/**
 * Trait TenantDependableTrait
 * @package Ringierimu\MultiTenancy\Traits
 */
trait TenantDependableTrait
{
    public static function bootTenantDependableTrait()
    {
        static::addGlobalScope(new TenantDependableScope());

        static::creating(function (Model $model) {
            if (!$model->tenant_id && !$model->relationLoaded('tenant')) {
                /** @var Tenant $tenant */
                $tenant = app(TenantManager::class)->getTenant();

                $model->tenant_id = $tenant->id;
                $model->setRelation('tenant', $tenant);
            }
            return $model;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
