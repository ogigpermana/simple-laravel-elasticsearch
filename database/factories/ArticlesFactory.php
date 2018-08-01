<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    $tags = collect(['bash', 'php', 'javascript', 'java', 'ruby'])
        ->random(2)
        ->values()
        ->all();

    return [
        'title' => $faker->sentence,
        'body' => $faker->text,
        'tags' => $tags,
    ];
});
