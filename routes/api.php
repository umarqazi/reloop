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

Route::post('register', 'Api\RegisterController@signUp');
Route::post('login', 'Api\LoginController@login');
Route::post('password/email', 'Api\LoginController@getPasswordResetToken');
Route::middleware('auth:api')->group(function () {

    Route::get('product_categories', 'Api\ProductController@productCategoriesList');
});
