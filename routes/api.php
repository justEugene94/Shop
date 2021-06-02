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

$router->get('promo-products', 'Api\ProductController@getPromo')->name('api.promo.products');

/** Products */
$router->apiResource('products', 'Api\ProductController')->only(['index', 'show']);

/** Cart */
$router->get('/cart', 'Api\CartController@index')->name('api.cart');
$router->post('/cart/add', 'Api\CartController@add')->name('api.cart.add');
$router->delete('/cart/delete', 'Api\CartController@delete')->name('api.cart.delete');
$router->delete('/cart/clear', 'Api\CartController@delete')->name('api.cart.clear');
$router->get('/cart/products-count', 'Api\CartController@productsCount')->name('api.cart.products.count');
