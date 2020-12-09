<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'WebController@index');
Route::get('/contactUs', 'WebController@contactUs');
Route::post('/readNotification', 'WebController@readNotification');



Route::resource('fakeProducts', 'FakeProductController');
Route::resource('products', 'ProductController');
Route::post('products/checkProduct', 'ProductController@checkProduct');
Route::get('products/{id}/sharedUrl', 'ProductController@sharedUrl');

Route::post('signup', 'AuthController@signup');
Route::post('login', 'AuthController@login');

Route::group(
    [
    'middleware' => 'auth:api'
],
    function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

        Route::get('carts', 'CartController@index');
        Route::post('carts/checkout', 'CartController@checkout');
        Route::resource('cart-items', 'CartItemController');
    }
);

Route::resource('admin/products', 'Admin\ProductController');
Route::post('admin/orders/{id}/delivery', 'Admin\OrderController@delivery');
Route::get('admin/orders/export', 'Admin\OrderController@export');
Route::get('admin/orders/exportByShipped', 'Admin\OrderController@exportByShipped');
Route::get('admin/orders/datatables', 'Admin\OrderController@datatables')->name('orders.datatables');
Route::resource('admin/orders', 'Admin\OrderController');
Route::post('admin/products/uploadImage', 'Admin\ProductController@uploadImage');
Route::post('admin/products/import', 'Admin\ProductController@import');
Route::post('admin/tools/updateProductPrice', 'Admin\ToolController@updateProductPrice');
Route::post('admin/tools/createProductRedis', 'Admin\ToolController@createProductRedis');
