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
Route::post('reset-password', 'Api\LoginController@resetPassword');
Route::post('password-change-request', 'Api\DriverController@passwordChangeRequest');
Route::middleware('auth:api')->group(function () {

    Route::post('logout', 'Api\LoginController@logout');
    Route::get('dashboard', 'UserController@dashboard');
    Route::get('categories', 'Api\ProductController@categories');
    Route::get('category/products', 'Api\ProductController@categoryProducts');
    Route::post('buy-plan', 'Api\PaymentController@buyPlan');
    Route::post('buy-product', 'Api\PaymentController@buyProduct');
    Route::post('coupon-verification', 'Api\CouponController@couponVerification');
    Route::post('redeem-points', 'UserController@redeemPoints');
    Route::get('currency-conversion', 'UserController@currencyConversion');
    Route::post('change-password', 'Api\LoginController@changePassword');
    Route::get('user-profile', 'UserController@userProfile');
    Route::post('update-address', 'UserController@updateAddress');
    Route::post('update-user-profile', 'UserController@updateUserProfile');
    Route::get('material-categories', 'Api\RequestController@materialCategories');
    Route::get('get-plan', 'UserController@getUserPlans');
    Route::post('collection-request', 'Api\RequestController@collectionRequests');
    Route::get('privacy-policy', 'Api\PageController@getPageContent')->name('privacy-policy');
    Route::get('terms-and-conditions', 'Api\PageController@getPageContent')->name('terms-and-conditions');
    Route::get('about-us', 'Api\PageController@getPageContent')->name('about-us');
    Route::get('orders-listing', 'Api\OrderController@userOrders');
    Route::get('user-subscriptions', 'UserController@userSubscriptions');
    Route::post('contact-us', 'Api\PageController@contactUs');
    Route::get('billing-listing', 'UserController@userBillings');
    Route::post('delete-address', 'UserController@deleteAddress');
    Route::post('default-address', 'UserController@defaultAddress');
    Route::get('donation-categories', 'Api\DonationController@donationCategories');
    Route::post('donation-products', 'Api\DonationController@donationProducts');
    Route::post('donations', 'Api\DonationController@donations');
    Route::post('organization-verification', 'UserController@organizationVerification');

    //Driver routes
    Route::post('assigned-trips', 'Api\DriverController@driverAssignedTrips');
    Route::post('trip-status', 'Api\DriverController@tripStatusUpdate');
    Route::post('record-weight', 'Api\DriverController@recordWeight');
    Route::get('feedback-questions', 'Api\DriverController@feedbackQuestions');
    Route::post('feedback', 'Api\DriverController@feedback');
    Route::post('driver-location', 'Api\DriverController@driverLocation');

    // Chart Api's
    Route::post('get-barChart-data', 'UserController@barChart');
});
