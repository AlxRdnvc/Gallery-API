<?php

use Faker\Generator as Faker;

$factory->define(App\Gallery::class, function (Faker $faker) {
    return [
        'gallery_name' =>$faker->sentence(1,true),
        'description' => $faker->text(1000),
        'user_id' => rand(1,20)
    ];
});
