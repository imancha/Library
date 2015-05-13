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

Route::get('/', ['as' => 'home','uses' => 'PublicController@getIndex']);
Route::get('/book/{jenis?}', ['as' => 'book','uses' => 'PublicController@getBook']);
Route::get('/book/download/{file}', ['as' => 'book.download','uses' => 'PublicController@getDownload']);
Route::get('/service/{id?}', ['as' => 'service','uses' => 'PublicController@getService']);
Route::any('/guest', ['as' => 'guest','uses' => 'PublicController@guestBook']);
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
	Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'Admin\HomeController@index']);
	Route::get('/dashboard/data', ['as' => 'admin.dashboard.data', 'uses' => 'Admin\HomeController@getData']);
	Route::get('/lockscreen', ['as' => 'admin.lockscreen', 'uses' => 'Admin\HomeController@lockscreen']);
	Route::get('/borrow/return', ['as' => 'admin.borrow.return', 'uses' => 'Admin\BorrowController@patch']);
	Route::get('/book/export/{type}', ['as' => 'admin.book.export', 'uses' => 'Admin\BookController@export']);
	Route::get('/borrow/export/{type}', ['as' => 'admin.borrow.export', 'uses' => 'Admin\BorrowController@export']);
	Route::get('/member/export/{type}', ['as' => 'admin.member.export', 'uses' => 'Admin\MemberController@export']);
	Route::post('/book/borrow', ['as' => 'admin.book.borrow', 'uses' => 'Admin\HomeController@postBook']);
	Route::post('/book/return', ['as' => 'admin.book.return', 'uses' => 'Admin\HomeController@postReturn']);
	Route::post('/member/borrow', ['as' => 'admin.member.borrow', 'uses' => 'Admin\HomeController@postMember']);
	Route::post('/dashboard/address', ['as' => 'admin.dashboard.address', 'uses' => 'Admin\HomeController@postAddress']);
	Route::post('/welcome', ['as' => 'admin.welcome','uses' => 'Admin\HomeController@postDashboard']);
	Route::post('/service/{id}', ['as' => 'admin.service','uses' => 'Admin\HomeController@postService']);
	Route::post('/guest', ['as' => 'admin.guest','uses' => 'Admin\HomeController@guestBook']);
	Route::resource('book', 'Admin\BookController');
	Route::resource('member', 'Admin\MemberController');
	Route::resource('borrow', 'Admin\BorrowController');
	Route::resource('trash', 'Admin\TrashController');
	Route::resource('slider', 'Admin\SliderController');
});
