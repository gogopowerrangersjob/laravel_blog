<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->sentence,
        'image' => 'photo1.png',
        'date' => '08/09/17',
        'views'	=>	$faker->numberBetween(0, 5000),
        'category_id'	=>	1,
        'user_id'	=>	1,
        'status'	=>	1,
        'is_featured'	=>	0
    ];
});
