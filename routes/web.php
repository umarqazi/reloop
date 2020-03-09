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

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'Admin\HomeController@index')->name('home');
    Route::get('/activate-account/{id}/{token}', 'UserController@accountVerification');
    Route::get('/thankyou', 'PageController@thankyou')->name('thankyou');
    Route::get('/logout', 'Admin\HomeController@logout')->name('logout');
    Route::get('/cities', 'Admin\CityController@index')->name('cities');
    Route::resource('product', 'Admin\ProductController');
    Route::resource('subscription', 'Admin\SubscriptionController');
    Route::resource('user', 'Admin\UserController');
    Route::resource('supervisor', 'Admin\SupervisorController');
    Route::resource('driver', 'Admin\DriverController');
    Route::resource('material-category', 'Admin\MaterialCategoryController');
    Route::resource('organization', 'Admin\OrganizationController');
    Route::resource('coupon', 'Admin\CouponController');
    Route::resource('reward-point', 'Admin\RewardPointController');

});
