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

Route::get('/users/{user}/bindmobile', 'BindMobileController@index')->name('bind.mobile');

Route::get('/threads', 'ThreadController@index')->name('threads.index');

Route::get('/threads/create', 'ThreadController@create')->name('threads.create');

Route::post('/threads', 'ThreadController@store')->name('threads.store');

Route::get('/threads/{thread}', 'ThreadController@show')->name('threads.show');

Route::post('/threads/{thread}/reply', 'ReplyController@store')->name('reply.store');

Route::delete('/replies/{reply}', 'ReplyController@destory')->name('reply.delete');

Route::post('/replies/{reply}/favorites', 'FavoriteController@store')->name('reply.favorite');

Route::delete('/replies/{reply}/favorites', 'FavoriteController@destory')->name('reply.delete');

Auth::routes();
