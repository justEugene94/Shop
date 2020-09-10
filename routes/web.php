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
$router->get('/', ['as' => 'home', 'uses' => 'IndexController@index']);

/** Product */
$router->get('/products/{goods_id}', ['as' => 'product', 'uses' => 'IndexController@show']);
