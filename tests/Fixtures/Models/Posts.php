<?php

namespace Ringierimu\MultiTenancy\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Ringierimu\MultiTenancy\Models\Tenant;
use Ringierimu\MultiTenancy\Traits\TenantDependableTrait;

/**
 * Class Posts
 *
 * @property string $title
 * @property string $slug
 * @property int $tenant_id
 * @property Tenant $tenant
 * @package Ringierimu\MultiTenancy\Tests\Fixtures\Models
 */
class Posts extends Model
{
    use TenantDependableTrait;

    protected $fillable = [
        'title',
        'slug',
        'tenant_id'
    ];
}
