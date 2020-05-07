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
Route::get('/activate-account/{id}/{token}', 'UserController@accountVerification');
Route::get('/thankyou', 'PageController@thankyou')->name('thankyou');
Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'Admin\HomeController@index')->name('home');
    Route::get('/cities', 'Admin\CityController@index')->name('cities');
    Route::get('/districts', 'Admin\DistrictController@index')->name('districts');
    Route::resource('product', 'Admin\ProductController');
    Route::resource('subscription', 'Admin\SubscriptionController');
    Route::resource('user', 'Admin\UserController');
    Route::resource('supervisor', 'Admin\SupervisorController');
    Route::resource('driver', 'Admin\DriverController');
    Route::resource('material-category', 'Admin\MaterialCategoryController');
    Route::resource('organization', 'Admin\OrganizationController');
    Route::resource('coupon', 'Admin\CouponController');
    Route::resource('reward-point', 'Admin\RewardPointController');
    Route::resource('orders', 'Admin\OrderController');
    Route::resource('pages', 'Admin\PageController');
    Route::resource('settings', 'Admin\SettingController');
    Route::resource('questions', 'Admin\QuestionController');
    Route::resource('cities', 'Admin\CityController');
    Route::resource('districts', 'Admin\DistrictController');
    Route::resource('contact-us', 'Admin\ContactUsController');
    Route::resource('collection-requests', 'Admin\CollectionRequestController');
    Route::resource('request-collections', 'Admin\RequestCollectionController');
    Route::resource('password-requests', 'Admin\PasswordResetController');

    Route::get('get-cities', 'Admin\CityController@getCities')->name('getCities');
    Route::get('get-related-districts/{city_id}', 'Admin\CityController@getDistricts')->name('getRelatedDistricts');
    Route::get('district-create/{city_id}', 'Admin\DistrictController@districtCreate')->name('districtCreate');
    Route::resource('donation-products', 'Admin\DonationProductController');
    Route::get('/all-users', 'Admin\RewardPointController@allUsers')->name('all-users');
    Route::get('/get-user/{id}', 'Admin\RewardPointController@getUser')->name('get-user');
    Route::put('/update-user', 'Admin\RewardPointController@updateRewardPoints')->name('update-user');
    Route::get('/user-subscription', 'Admin\UserController@userSubscription')->name('user-subscription');
    Route::get('/user-donations', 'Admin\UserController@userDonation')->name('user-donation');
    Route::put('/assign-request/{id}', 'Admin\CollectionRequestController@assignOrder')->name('assign.request');
    Route::put('/confirm-request/{id}', 'Admin\CollectionRequestController@confirmRequest')->name('confirm.request');

    //export list routes
    Route::get('/users/export', 'Admin\UserController@export')->name('user.export');
    Route::get('/supervisors/export', 'Admin\SupervisorController@export')->name('supervisor.export');
    Route::get('/drivers/export', 'Admin\DriverController@export')->name('driver.export');
    Route::get('/passwordRequests/export', 'Admin\PasswordResetController@export')->name('password-requests.export');
    Route::get('/user-subscriptions/export', 'Admin\UserController@userSubscriptionExport')->name('user-subscriptions.export');
    Route::get('/user-donations/export', 'Admin\UserController@userDonationExport')->name('user-donations.export');
    Route::get('/organizations/export', 'Admin\OrganizationController@export')->name('organizations.export');
    Route::get('/order/export', 'Admin\OrderController@export')->name('userOrders.export');
    Route::get('/requests/export', 'Admin\CollectionRequestController@export')->name('requests.export');
    Route::get('/material-categories/export', 'Admin\MaterialCategoryController@export')->name('material-categories.export');
    Route::get('/products/export', 'Admin\ProductController@export')->name('products.export');
    Route::get('/subscriptions/export', 'Admin\SubscriptionController@export')->name('subscriptions.export');
    Route::get('/coupons/export', 'Admin\CouponController@export')->name('coupons.export');
    Route::get('/all-users/export', 'Admin\RewardPointController@export')->name('all-users.export');
    Route::get('/all-questions/export', 'Admin\QuestionController@export')->name('questions.export');
    Route::get('/donationProducts/export', 'Admin\DonationProductController@export')->name('questions.export');
    Route::get('/all-settings/export', 'Admin\SettingController@export')->name('settings.export');
    Route::get('/contactUs/export', 'Admin\ContactUsController@export')->name('contact-us.export');
    Route::get('/city/export', 'Admin\CityController@export')->name('cities.export');


    //supervisor routes
    Route::get('/get-orders', 'Supervisor\OrderController@index')->name('get-orders');
    Route::get('/show-order/{id}', 'Supervisor\OrderController@show')->name('supervisor.order.show');
    Route::put('/assign-order/{id}', 'Supervisor\OrderController@assignOrder')->name('supervisor.assign.order');
    Route::get('/drivers-availability/{date}/{order}', 'Supervisor\OrderController@availableDrivers')->name('drivers.availability');
    Route::get('/contact-Admin-form', 'Admin\SupervisorController@contactAdminForm')->name('contact-admin-form');
    Route::get('/contact-admin', 'Admin\SupervisorController@contactAdmin')->name('contact-admin');
    Route::get('/get-requests', 'Supervisor\CollectionRequestController@index')->name('get-requests');

});

// Chart Routes
Route::post('get-barChart-data', 'Admin\ChartController@barChart');
Route::post('get-pieChart-data', 'Admin\ChartController@pieChart');

Route::get('/test', function () {
   dd(now()->format('Y-m-d'), now()->addDays(- 0)->format('Y-m-d'));
});
