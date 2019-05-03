<?php

namespace Ringierimu\MultiTenant\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Ringierimu\MultiTenant\Models\Domain;
use Ringierimu\MultiTenant\Traits\TenantDependableTrait;

/**
 * Class Posts
 *
 * @property string $title
 * @property string $slug
 * @property int    $tenant_id
 * @property Domain $tenant
 * @package Ringierimu\MultiTenant\Tests\Fixtures\Models
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
