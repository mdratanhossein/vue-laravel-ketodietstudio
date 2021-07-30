<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\HelpArticle;
use Faker\Generator as Faker;

$factory->define(HelpArticle::class, function (Faker $faker) {
    return [
        'title'      => $faker->text(30),
        'image'      => file_get_contents(database_path('/images/article/' . rand(1, 6) . '.jpg')),
        'content'    => $faker->paragraph(15),
    ];
});
