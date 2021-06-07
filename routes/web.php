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

$router->view('{any}', 'index')->where('any', '^(?!api).*$');

///** Payment page */
//$router->get('/checkout/{order_id}/payment', [
//    'as' => 'checkout.payment',
//    'uses' =>  'PaymentController@index'
//]);
//
///** Update Order Status */
//$router->post('/checkout/{order_id}/update-status', [
//
//    'as' => 'checkout.update.status',
//    'uses' => 'Api\OrderController@updateStatus'
//]);
