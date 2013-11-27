<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('user/social', 'UserController@social');
Route::get('user/welcome', 'UserController@welcome');
Route::get('user/login', 'UserController@login');
Route::get('user/logout', 'UserController@logout');
Route::resource('user', 'UserController');