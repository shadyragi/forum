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
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Thread::class, function($faker) {
	return [
		'title' => $faker->sentence(),
		'body'  => $faker->paragraph(),
		'user_id' => function() {
			return factory('App\User')->create()->id;
		},
		'channel_id' => function()
		{
			return factory('App\Channel')->create()->id;
		}
	];
});

$factory->define(App\Channel::class, function($faker) {
	$name = $faker->word();
	return [
		'name' => $name,
		'slug' => $name
	];
});



$factory->define(App\Reply::class, function($faker) {
		return [
		'user_id' => function() {
			return factory('App\User')->create()->id;
		},
		'thread_id' => function() {
			return factory('App\Thread')->create()->id;
		},
		'body' => $faker->paragraph(),

	
		];
});

$factory->define(App\Like::class, function($faker) {
	return [
	'user_id' => function() {
		return factory('App\User')->create()->id;
	},
	'reply_id' => function()
	{
		return factory('App\User')->create()->id;
	}
	];
});
