<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'content' =>$faker->text(1000),
        'gallery_id' => rand(1,30),
        'user_id' => rand(1,30)
    ];
});
