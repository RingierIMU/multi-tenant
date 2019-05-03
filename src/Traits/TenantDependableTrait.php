<?php

namespace Ringierimu\MultiTenancy\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ringierimu\MultiTenancy\Models\Domain;
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
            if (!$model->{$model->domainForeignKey()} && !$model->relationLoaded('domain')) {
                /** @var Domain $tenant */
                $tenant = app(TenantManager::class)->getTenant();

                $model->{$model->domainForeignKey()} = $tenant->id;
                $model->setRelation('domain', $tenant);
            }
            return $model;
        });
    }

    /**
     * @return BelongsTo
     */
    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class, $this->getDomainForeignKey(), $this->primaryKey);
    }

    /**
     * @return string
     */
    public function domainForeignKey(): string
    {
        return 'domain_id';
    }

    /**
     * @return string
     */
    public function getDomainForeignKey(): string
    {
        return $this->domainForeignKey();
    }
}
