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
$router->get('/products/{product_id}', [
    'as' => 'product',
    'uses' => 'IndexController@show'
]);

/** Checkout */
$router->get('/checkout', [
    'as' => 'checkout.index',
    'uses' => 'CheckoutController@index'
]);

$router->post('/checkout/store', [
    'as' => 'checkout.store',
    'uses' =>  'CheckoutController@store'
]);

$router->get('/checkout/{order_id}/payment', [
    'as' => 'checkout.payment',
    'uses' =>  'CheckoutController@getPaymentPage'
]);

/** Add to Cart */
$router->post('/products/{product_id}/add-to-cart', [
    'as' => 'products.add-to-cart',
    'uses' => 'Api\CartController@add'
]);

/** Delete from Cart */
$router->delete('/products/{product_id}/delete-from-cart', [
    'as' => 'products.delete-from-cart',
    'uses' => 'Api\CartController@delete'
]);

/** Get Areas From Nova Poshta */
$router->post('/nova-poshta/warehouses', [
    'as' => 'nova-poshta.warehouses',
    'uses' => 'Api\NovaPoshtaController@getWarehouses',
]);
