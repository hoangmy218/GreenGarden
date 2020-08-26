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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//v1 - public


Route::apiResource('categories','v1\CategoryController');
Route::apiResource('products','v1\ProductController');
Route::apiResource('payments','v1\PaymentController');
Route::apiResource('orderstates','v1\OrderStateController');
Route::get('relatedProduct/{pro_id}','v1\ProductController@relatedProduct');
Route::get('category/{cate_id}', 'v1\ProductController@proByCate');
Route::get('user/activation/{token}', 'Auth\RegisterController@activateUser')->name('user.activate');

//v2 -admin

// Route::apiResource('category','CategoryController');
// Route::apiResource('account','AccountController');
// Route::apiResource('order','OrderController');
// Route::apiResource('detailsOrder','DetailsOrderController');
// Route::apiResource('orderState','OrderStateController');
// Route::apiResource('payment','PaymentController');
// Route::apiResource('product','ProductController');
// Route::apiResource('role','RoleController');

// Route::post('login', 'UserController@login');
// Route::post('register', 'UserController@register');
// Route::group(['middleware' => 'auth:api'], function() {
//     Route::post('details', 'UserController@details');
// });


