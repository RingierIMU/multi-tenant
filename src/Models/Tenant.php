<?php

namespace Ringierimu\MultiTenancy\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tenant
 *
 * @property string $title
 * @property string $domain
 * @property string $aliases
 * @property int $country_id
 * @property bool $enabled
 * @property string $hreflang
 *
 * @package Ringierimu\MultiTenancy\Models
 */
class Tenant extends Model
{
    protected $fillable = [
        'title',
        'domain',
        'aliases',
        'country_id',
        'enabled',
        'hreflang'
    ];
}
