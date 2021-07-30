<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ingredient;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$faker = \Faker\Factory::create();
$faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));

$factory->define(Ingredient::class, function () use($faker) {
    return [
        'name' => $faker->vegetableName(),
    ];
});
