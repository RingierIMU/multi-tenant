<?php

use Faker\Generator as Faker;

$factory->define(\Ringierimu\MultiTenancy\Models\Tenant::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'domain' => "tenant.test",
        'aliases' => "tt",
        'country_id' => 1,

    ];
});
