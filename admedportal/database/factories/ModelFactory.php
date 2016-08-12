<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => 'koha',
        'email' => 'koha@sydt.com.tw',
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => 'root',
        'email' => 'root@gmail.com',
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => 'bbb',
        'email' => 'bbb@gmail.com',
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => 'ccc',
        'email' => 'ccc@gmail.com',
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => 'ddd',
        'email' => 'ddd@gmail.com',
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => 'eee',
        'email' => 'eee@sydt.com.tw',
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});
