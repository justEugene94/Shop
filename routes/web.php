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

/** @var Route $router */

/** Home */
$router->get('/', [
    'as' => 'home',
    'uses' => 'IndexController@index'
]);

/** Product */
$router->get('/products/{goods_id}', [
    'as' => 'product',
    'uses' => 'IndexController@show'
]);

/** Checkout */
$router->get('/checkout', [
    'as' => 'checkout',
    'uses' => 'CheckoutController@index'
]);

/** Add to Cart */
$router->post('/products/{goods_id}/add-to-cart', [
    'as' => 'products.add-to-cart',
    'uses' => 'Api\CartController@add'
]);

/** Delete from Cart */
$router->delete('/products/{goods_id}/delete-from-cart', [
    'as' => 'products.delete-from-cart',
    'uses' => 'Api\CartController@delete'
]);

/** Get Areas From Nova Poshta */
$router->post('/nova-poshta/warehouses', [
    'as' => 'nova-poshta.warehouses',
    'uses' => 'Api\NovaPoshtaController@getWarehouses',
]);
