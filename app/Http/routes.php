<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
	Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'Admin\HomeController@index']);
	Route::get('/lockscreen', ['as' => 'admin.lockscreen', 'uses' => 'Admin\HomeController@lockscreen']);
	Route::resource('book', 'Admin\BookController');
	Route::resource('member', 'Admin\MemberController');
	Route::resource('borrow', 'Admin\BorrowController');
});
