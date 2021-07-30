<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Recipe;

$faker = \Faker\Factory::create();
$faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));

$factory->define(Recipe::class, function () use ($faker) {
    $prepare_options = [1, 5, 10, 20, 30, 31, 60, 61, 90, 91, 120, 121];
    return [
        'title'      => $faker->foodName(),
        'image'      => file_get_contents(database_path('/images/food/' . rand(1, 2) . '.jpg')),
        'meal_type'  => rand(0, 4),
        'prep_time'  => $prepare_options[rand(0, count($prepare_options) - 1)],
        'cook_time'  => $prepare_options[rand(0, count($prepare_options) - 1)],
        'total_time' => $prepare_options[rand(0, count($prepare_options) - 1)],
        'servings'   => $prepare_options[rand(0, count($prepare_options) - 1)],
        'energy'     => rand(100, 400),
        'content'    => $faker->paragraph(15),
    ];
});
