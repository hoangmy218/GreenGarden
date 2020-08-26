<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResource('categories','CategoryController')->middleware('auth:api');
Route::apiResource('products','ProductController')->middleware('auth:api');
Route::get('file/product_list/{fileName}','FileController@productList');
Route::post('file/product_list','FileController@productSave');
Route::apiResource('accounts','AccountController');
Route::apiResource('orders','OrderController')->middleware('auth:api');
Route::apiResource('detailsOrders','DetailsOrderController')->middleware('auth:api');
Route::apiResource('orderStates','OrderStateController');
Route::apiResource('payments','PaymentController');
Route::get('allUsers','UserController@getAllUser')->middleware('auth:api');
Route::put(
        'updateStateOrder/{order_id}/{state_id}', 
        'OrderController@updateStateOrder'
        )->middleware('auth:api');


Route::apiResource('roles','RoleController');
Route::get('stripe', 'StripePaymentController@stripe');
Route::post('payWithStripe', 'StripePaymentController@stripePost');
Route::apiResource('myorders','MyOrderController')->middleware('auth:api');
Route::get('totalNewOrder', 'OrderController@getTotalNewOrder');
Route::get('totalRevenue', 'OrderController@getTotalRevenue');
Route::get('totalProduct', 'ProductController@getTotalProduct');
Route::get('outOfStock', 'ProductController@getOutOfStock');
// Route::post('login', 'UserController@login');
// Route::post('register', 'UserController@register');
// Route::group(['middleware' => 'auth:api'], function() {
//     Route::post('details', 'UserController@details');
// });

//JWT
// Route::post('register', 'UserController@register');
// Route::post('login', 'UserController@login');
// Route::group([
//     'middleware' => 'api',
//     'prefix' =>'auth'
// ], function () {
//     // Route::post('details', 'UserController@details');
//     Route::post('login', 'AuthController@login');
//     Route::post('logout', 'AuthController@logout');
//     Route::post('refresh', 'AuthController@refresh');
//     Route::post('me', 'AuthController@me');

// });

Route::group([
    'middleware' => 'api',
    'prefix' =>'auth'
], function () {

    Route::post('signup', 'AuthController@signup'); 
    Route::post('login', 'AuthController@login');
    Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify'); // Make sure to keep this as your route name

    Route::get('email/resend', 'VerificationController@resend')->name('verification.resend');
    
});

Route::group(['middleware' => 'jwt.auth', 'prefix' =>'auth'], function () { 
    Route::get('auth', 'AuthController@user'); 
    Route::post('logout', 'AuthController@logout'); 
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::post('payload', 'AuthController@payload');
    Route::put('updateProfile', 'AuthController@updateProfile');
    Route::get('getCode', 'AuthController@getVerifyCode');
    Route::post('activateUser', 'AuthController@activateUser');
    Route::get('resendEmail', 'AuthController@resendEmail');
});

// Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');
