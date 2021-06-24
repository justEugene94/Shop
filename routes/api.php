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

/** @var Route $router */

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

$router->get('promo-products', [
    'as' => 'api.promo.products',
    'uses' => 'Api\ProductController@getPromo',
]);

/** Products */
$router->apiResource('products', 'Api\ProductController')->only(['index', 'show']);

/** Cart */
$router->get('/cart', [
    'as' => 'api.cart',
    'uses' =>'Api\CartController@index',
]);
$router->post('/cart/add', [
    'as' => 'api.cart.add',
    'uses' =>'Api\CartController@add',
]);
$router->delete('/cart/delete', [
    'as' => 'api.cart.delete',
    'uses' =>'Api\CartController@delete',
]);
$router->delete('/cart/clear', [
    'as' => 'api.cart.clear',
    'uses' =>'Api\CartController@clear',
]);
$router->get('/cart/products-count', [
    'as' => 'api.cart.products.count',
    'uses' =>'Api\CartController@productsCount',
]);

/** Nova Poshta */
$router->get('/nova-poshta/cities', [
    'as' => 'api.nova-poshta.cities',
    'uses' =>'Api\NovaPoshtaController@getCities',
]);
$router->get('/nova-poshta/warehouses', [
    'as' => 'api.nova-poshta.warehouses',
    'uses' =>'Api\NovaPoshtaController@getWarehouses',
]);

/** Order */
$router->post('/orders', [
    'as' => 'api.orders.store',
    'uses' =>'Api\OrderController@store',
    'middleware' => 'check.products.in.cart',
]);
$router->post('/orders/{order}', [
    'as' => 'api.orders.pay',
    'uses' =>'Api\Api\OrderController@pay',
]);
