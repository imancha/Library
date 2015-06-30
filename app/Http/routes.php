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
Route::get('/member', ['as' => 'member','uses' => 'PublicController@getMember']);
Route::get('/borrow', ['as' => 'borrow','uses' => 'PublicController@getBorrow']);
Route::get('/report', ['as' => 'report','uses' => 'PublicController@getReport']);
Route::get('/report/data', ['as' => 'report.data','uses' => 'PublicController@getData']);
Route::get('/report/detail', ['as' => 'report.detail','uses' => 'PublicController@getDetail']);
Route::any('/guest', ['as' => 'guest','uses' => 'PublicController@guestBook']);
Route::get('/register', 'Admin\UserController@getRegister');
Route::post('/register', 'Admin\UserController@postRegister');
Route::get('/login', 'Admin\UserController@getLogin');
Route::post('/login', 'Admin\UserController@postLogin');
/*
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
	Route::get('/', ['as' => 'admin.dashboard', 'uses' => 'Admin\HomeController@index']);
	Route::get('/dashboard/data', ['as' => 'admin.dashboard.data', 'uses' => 'Admin\HomeController@getData']);
	Route::get('/dashboard/detail', ['as' => 'admin.dashboard.detail', 'uses' => 'Admin\HomeController@getDetail']);
	Route::post('/dashboard/address', ['as' => 'admin.dashboard.address', 'uses' => 'Admin\HomeController@postAddress']);
	Route::post('/dashboard/slider', ['as' => 'admin.dashboard.slider', 'uses' => 'Admin\HomeController@postSlider']);
	Route::post('/dashboard/slider_', ['as' => 'admin.dashboard.slider_', 'uses' => 'Admin\HomeController@postSlider_']);
	Route::post('/dashboard/welcome', ['as' => 'admin.welcome','uses' => 'Admin\HomeController@postDashboard']);
	Route::post('/dashboard/guest', ['as' => 'admin.guest','uses' => 'Admin\HomeController@guestBook']);
	Route::post('/dashboard/gallery', ['as' => 'admin.gallery', 'uses' => 'Admin\HomeController@postGallery']);
	Route::get('/dashboard/gallery/{id}', ['as' => 'admin.galery.delete', 'uses' => 'Admin\HomeController@getGallery']);
	Route::get('/book/export/{type}', ['as' => 'admin.book.export', 'uses' => 'Admin\BookController@export']);
	Route::post('/book/borrow', ['as' => 'admin.book.borrow', 'uses' => 'Admin\HomeController@postBook']);
	Route::post('/book/return', ['as' => 'admin.book.return', 'uses' => 'Admin\HomeController@postReturn']);
	Route::get('/member/export/{type}', ['as' => 'admin.member.export', 'uses' => 'Admin\MemberController@export']);
	Route::post('/member/borrow', ['as' => 'admin.member.borrow', 'uses' => 'Admin\HomeController@postMember']);
	Route::get('/borrow/export/{type}', ['as' => 'admin.borrow.export', 'uses' => 'Admin\BorrowController@export']);
	Route::get('/borrow/return', ['as' => 'admin.borrow.return', 'uses' => 'Admin\BorrowController@patch']);
	Route::post('/user/update', ['as' => 'admin.user.update', 'uses' => 'Admin\UserController@postUpdate']);
	Route::get('/logout', ['as' => 'admin.user.logout', 'uses' => 'Admin\UserController@getLogout']);
	Route::resource('book', 'Admin\BookController');
	Route::resource('member', 'Admin\MemberController');
	Route::resource('borrow', 'Admin\BorrowController');
	Route::resource('slider', 'Admin\SliderController');
});
