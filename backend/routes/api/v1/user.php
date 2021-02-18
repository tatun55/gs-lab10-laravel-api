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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('regist', 'AuthController@regist');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});


Route::apiResource('products', 'ProductController');
Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::apiResource('addresses', 'AddressController');
    Route::get('cart', 'CartController@index');
    Route::post('products/{product}/cart', 'CartController@store');
    Route::put('products/{product}/cart', 'CartController@update');
    Route::delete('products/{product}/cart', 'CartController@destroy');
    Route::post('purchase', 'PurchaseController@store');
});
