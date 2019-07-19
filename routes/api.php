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
Route::get('/customers', 'API\CustomerController@getDataCustomer');
Route::get('/customers/{customer}', 'API\CustomerController@detailCustomer');

Route::Resource('/branch', 'API\BranchProductController');
Route::match(['GET'], '/branch/{search}/search', 'API\BranchProductController@searchData');

Route::Resource('/order', 'API\OrderController');
Route::get('/order/{search}/customer', 'API\OrderController@index');

// Route::Resource('/piutang', 'API\PiutangController');
// Route::get('/piutang/{dates}/order', 'API\PiutangController@index');

// Route Laporan
Route::get('/laporan/{dates}/{product?}/penjualan', 'Laporan\laporanPenjualanController@index');
Route::get('/laporan/{dates}/{customer?}/piutang', 'Laporan\laporanPiutangController@index');

// Route::group(['prefix' => 'branch'], function(){
//     Route::apiResource('/search/{branch}', 'API\BranchProductController@search');
// });