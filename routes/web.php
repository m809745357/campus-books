<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WechatController@index');

Route::get('/oauth_callback', 'WechatController@oauthCallback');

Route::get('/users', 'UserController@index')->name('user.index');

Route::get('/users/bindmobile', 'BindMobileController@index')->name('bind.mobile');

Route::post('/users/bindmobile', 'UserController@mobile')->name('user.bindmobile');

Route::post('/users/sendmobile', 'BindMobileController@store')->name('user.send.mobile');

Route::get('/users/profile', 'UserController@profile')->name('user.profile');

Route::get('/users/favorites', 'UserController@favorites')->name('user.favorites');

Route::get('/users/threads', 'UserController@threads')->name('user.threads');

Route::get('/users/replies', 'UserController@replies')->name('user.replies');

Route::get('/threads', 'ThreadController@index')->name('threads.index');

Route::get('/threads/create', 'ThreadController@create')->name('threads.create');

Route::get('/threads/channels', 'ChannelController@index')->name('threads.channels');

Route::get('/threads/{channel}', 'ThreadController@index')->name('threads.index.channel');

Route::post('/threads', 'ThreadController@store')->name('threads.store');

Route::get('/threads/{channel}/{thread}', 'ThreadController@show')->name('threads.show');

Route::post('/threads/{channel}/{thread}/favorites', 'FavoriteController@storeThreads')->name('threads.favorite');

Route::delete('/threads/{channel}/{thread}/favorites', 'FavoriteController@destoryThreads')->name('threads.unfavorite');

Route::post('/threads/{channel}/{thread}/reply', 'ReplyController@store')->name('reply.store');

Route::delete('/replies/{reply}', 'ReplyController@destory')->name('reply.delete');

Route::post('/replies/{reply}/favorites', 'FavoriteController@store')->name('reply.favorite');

Route::delete('/replies/{reply}/favorites', 'FavoriteController@destory')->name('reply.unfavorite');

Auth::routes();
