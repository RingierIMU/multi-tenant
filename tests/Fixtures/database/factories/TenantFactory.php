<?php

use Faker\Generator as Faker;

$factory->define(\Ringierimu\MultiTenant\Models\Domain::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'host' => "tenant.test",
        'aliases' => "tt",
        'country_id' => 1,

    ];
});
