<?php

use App\File;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(File::class, function (Faker $faker) {
    $ext = $faker->fileExtension;
    return [
        'path' => $faker->slug . $ext,
        'name' => $faker->firstName,
        'type' => 'image',
        'ext' => $ext,
        'hidden' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});