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

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/activate-account/{id}/{token}', 'UserController@accountVerification');
Route::get('/thankyou', 'PageController@thankyou')->name('thankyou');
Route::resource('product', 'Admin\ProductController');
Route::resource('subscription', 'Admin\SubscriptionController');
Route::resource('user', 'Admin\UserController');
Route::resource('supervisor', 'Admin\SupervisorController');
Route::resource('driver', 'Admin\DriverController');
