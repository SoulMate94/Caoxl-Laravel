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

Route::get('/test_queue', 'UserController@sendNoticeEmail');
Route::get('/test_cache', 'TestController@testCache');

# ShopCar Routes

Route::get('shopping/add/{id}', 'ShoppingController@add')->name('shopping.add');

Route::get('shopping/shop_car_info', 'ShoppingController@getShopCarInfo')->name('shopping.shop_car_info');

Route::get('shopping/shop_add/{id}', 'ShoppingController@shopCarAdd')->name('shopping.shop_add');

Route::get('shopping/shop_del/{id}', 'ShoppingController@shopCarDel')->name('shopping.shop_del');

Route::get('shopping/shop_clean/{id}', 'ShoppingController@cleanShopCar')->name('shopping.shop_clean');