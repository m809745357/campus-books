<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'nickname' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'avatar' => $faker->imageUrl(50, 50),
        'openid' => str_random(10),
        'sex' => rand(1, 2),
        'school' => $faker->word,
        'specialty' => $faker->word,
        'password' => $password ?: $password = bcrypt('secret'),
        'balances' => 0,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Thread::class, function (Faker $faker) {

    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'channel_id' => function () {
            return factory('App\Models\Channel')->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'replies_count' => 0,
        'views_count' => 0,
        'money' => $faker->randomNumber(2),
    ];
});

$factory->define(App\Models\Reply::class, function (Faker $faker) {

    return [
        'thread_id' => function () {
            return factory('App\Models\Thread')->create()->id;
        },
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'body' => $faker->paragraph,
        'favorites_count' => 0,
    ];
});

$factory->define(App\Models\Channel::class, function (Faker $faker) {

    return [
        'slug' => $faker->word,
        'name' => $faker->word,
        'icon' => $faker->imageUrl(50, 50),
        'desc' => $faker->sentence,
    ];
});

$factory->define(App\Models\Demand::class, function (Faker $faker) {

    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'money' => $faker->randomNumber(2),
        'images' => [
            $faker->imageUrl(200, 200),
            $faker->imageUrl(200, 200),
            $faker->imageUrl(200, 200)
        ],
    ];
});

$factory->define(App\Models\Recharge::class, function (Faker $faker) {

    return [
        'money' => $faker->randomNumber(4),
        'status' => 1,
    ];
});

$factory->define(App\Models\Book::class, function (Faker $faker) {

    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'book_number' => date("YmdHis") . rand(1000, 9999),
        'title' => $faker->sentence,
        'author' => $faker->name,
        'published_at' => $faker->year() . '-' . $faker->month(),
        'press' => $faker->address,
        'type' => 'PBook',
        'keywords' => $faker->words(3),
        'category_id' => function () {
            return factory('App\Models\Category')->create()->id;
        },
        'money' => $faker->randomNumber(2),
        'logistics' => 'express', //face, online
        'freight' => $faker->randomNumber(2),
        'cover' => $faker->imageUrl(200, 200),
        'images' => [
            $faker->imageUrl(200, 200),
            $faker->imageUrl(200, 200),
            $faker->imageUrl(200, 200)
        ],
        'body' => $faker->paragraph,
        'annex' => $faker->imageUrl(200, 200)
    ];
});

$factory->define(App\Models\Category::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'slug' => $faker->word,
        'parent_id' => function () {
            return factory('App\Models\Category')->create([
                'parent_id' => function () {
                    return factory('App\Models\Category')->create(['parent_id' => 0])->id;
                }
            ])->id;
        }
    ];
});

$factory->define(App\Models\Message::class, function (Faker $faker) {

    return [
        'from_user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'to_user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'message' => $faker->paragraph
    ];
});

$factory->define(App\Models\Address::class, function (Faker $faker) {

    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'user_name' => $faker->name,
        'postal_code' => $faker->postcode,
        'province_name' => $faker->city,
        'city_name' => $faker->city,
        'country_name' => $faker->country,
        'detail_info' => $faker->address,
        'tel_number' => $faker->phoneNumber,
        'national_code' => '86'
    ];
});

$factory->define(App\Models\Order::class, function (Faker $faker) {
    $book = factory('App\Models\Book')->create();

    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'book_id' => $book->id,
        'book_detail' => $book->id,
        'address' => function () {
            return factory('App\Models\Address')->create()->id;
        },
        'pay' => '',
        'order_number' => config('wechat.app_id') . date('YmdHis') . rand(1000, 9999),
        'status' => '0000'
    ];
});

$factory->define(App\Models\Carousel::class, function (Faker $faker) {
    return [
        'image' => $faker->imageUrl(375, 135),
        'target_url' => 'https://book.mandokg.com',
        'type' => 'home'
        ];
});

$factory->define(App\Models\Withdraw::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'money' => $faker->randomNumber(2),
        'status' => rand(1, 2)
    ];
});
