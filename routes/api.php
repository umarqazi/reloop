<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('dependencies', 'Api\RegisterController@dependencies');
Route::post('register', 'Api\RegisterController@signUp');
Route::post('login', 'Api\LoginController@login');
Route::post('forgot-password', 'Api\LoginController@forgotPassword');
Route::middleware('auth:api')->group(function () {

    Route::get('categories', 'Api\ProductController@categories');
    Route::get('category/products', 'Api\ProductController@categoryProducts');
    Route::post('buy-plan', 'Api\PaymentController@buyPlan');
    Route::post('buy-product', 'Api\PaymentController@buyProduct');
    Route::post('coupon-verification', 'Api\CouponController@couponVerification');
    Route::post('change-password', 'Api\LoginController@changePassword');
});
