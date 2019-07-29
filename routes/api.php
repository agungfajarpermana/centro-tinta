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
Route::get('/products/file/downloadFile', 'API\ProductController@exportFileItems');
Route::post('/products/file/importFile', 'API\ProductController@importFileItems');

Route::Resource('/customer', 'API\CustomerController');
Route::get('/customers', 'API\CustomerController@getDataCustomer');
Route::post('/customers/{customer}', 'API\CustomerController@detailCustomer');
Route::post('/customer/create', 'API\CustomerController@createNewCustomer');

Route::Resource('/branch', 'API\BranchProductController');
Route::match(['GET'], '/branch/{search}/search', 'API\BranchProductController@searchData');

Route::Resource('/order', 'API\OrderController');
Route::get('/orders', 'API\OrderController@orderEdit');
Route::post('/orders', 'API\OrderController@orderDelete');
Route::get('/order/{search}/customer', 'API\OrderController@index');
Route::get('/order/{orders}/customers', 'API\OrderController@customerSales');

Route::Resource('/piutang', 'API\PiutangController');
Route::get('/piutang/{dates}/order', 'API\PiutangController@index');
Route::get('/piutang/confirm/sales', 'API\PiutangController@getDataCofirmSales');

// Route Laporan
Route::get('/laporan/{dates}/{product?}/penjualan', 'Laporan\laporanPenjualanController@index');
Route::get('/laporan/{dates}/{customer?}/piutang', 'Laporan\laporanPiutangController@index');
Route::get('/laporan/{dates}/{customer?}/cash', 'Laporan\laporanCashController@index');
Route::get('/laporan/{order}/customer', 'Laporan\laporanOrdersController@index');

// Route::group(['prefix' => 'branch'], function(){
//     Route::apiResource('/search/{branch}', 'API\BranchProductController@search');
// });