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

$router->group(['middleware' => ['web']], function () use ($router) {

    /** Add to Cart */
    $router->post('/products/{goods_id}/add-to-cart', ['as' => 'products.add-to-cart', 'uses' => 'Api\CartController@add']);
});
