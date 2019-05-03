<?php

namespace Ringierimu\MultiTenancy\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Domain
 *
 * @property int $id
 * @property string $title
 * @property string $host
 * @property string $aliases
 * @property int $country_id
 *
 * @package Ringierimu\MultiTenancy\Models
 */
class Domain extends Model
{
    protected $fillable = [
        'title',
        'host',
        'aliases',
        'country_id',
    ];
}
