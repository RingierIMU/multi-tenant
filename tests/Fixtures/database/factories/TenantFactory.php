<?php

use Faker\Generator as Faker;

$factory->define(\Ringierimu\MultiTenancy\Models\Domain::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'host' => "tenant.test",
        'aliases' => "tt",
        'country_id' => 1,

    ];
});
