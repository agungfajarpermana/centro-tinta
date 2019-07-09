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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::Resource('/products', 'API\ProductController');
Route::get('/products/{search}/items', 'API\ProductController@index');

Route::Resource('/customer', 'API\CustomerController');

Route::Resource('/branch', 'API\BranchProductController');
Route::match(['GET'], '/branch/{search}/search', 'API\BranchProductController@searchData');

Route::Resource('/order', 'API\OrderController');
Route::get('/order/{search}/customer', 'API\OrderController@index');

// Route::group(['prefix' => 'branch'], function(){
//     Route::apiResource('/search/{branch}', 'API\BranchProductController@search');
// });