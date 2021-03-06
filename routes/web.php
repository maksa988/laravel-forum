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

Route::redirect('/', 'threads');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('threads', 'ThreadsController@index')->name('threads');
Route::get('threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('threads/search', 'SearchController@show')->name('threads.search');
Route::post('threads', 'ThreadsController@store')->name('threads.store')->middleware('verified');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::patch('threads/{channel}/{thread}', 'ThreadsController@update')->name('threads.update');
Route::get('threads/{channel}', 'ThreadsController@index')->name('channels');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy')->name('threads.delete');
Route::get('threads/{channel}/{thread}/replies' ,'RepliesController@index');
Route::post('threads/{channel}/{thread}/replies' ,'RepliesController@store')->middleware('verified');
Route::post('threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
Route::delete('threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');
//
Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');
//
Route::post('pinned-threads/{thread}', 'PinnedThreadsController@store')->name('pinned-threads.store')->middleware('admin');
Route::delete('pinned-threads/{thread}', 'PinnedThreadsController@destroy')->name('pinned-threads.destroy')->middleware('admin');
//
Route::delete('replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');
Route::patch('replies/{reply}', 'RepliesController@update');
//
Route::post('replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');
//
Route::post('replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('replies/{reply}/favorites', 'FavoritesController@destroy');
//
Route::get('profiles/{user}', 'ProfilesController@show')->name('profile');
Route::get('profiles/{user}/notifications', 'UserNotificationsController@index');
Route::delete('profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');

Route::get('api/users', 'Api\UsersController@index');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');