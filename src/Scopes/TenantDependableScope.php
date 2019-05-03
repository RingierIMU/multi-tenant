<?php

namespace Ringierimu\MultiTenant\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Ringierimu\MultiTenant\TenantManager;

/**
 * Class TenantDependableScope
 * @package Ringierimu\MultiTenant\Scopes
 */
class TenantDependableScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model   $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        /** @var TenantManager $tenantManager */
        $tenantManager = app(TenantManager::class);
        $builder->where($model->getDomainForeignKey(), $tenantManager->getTenant()->id);
    }
}
