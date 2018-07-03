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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'products', 'namespace' => 'Product'], function() {
    Route::get('/', 'ProductController@index');
    Route::get('/{id}/', 'ProductController@show');
    Route::post('/{id}/store', 'PriceController@store')->name('products.store');
});
