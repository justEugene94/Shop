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

$router->view('{any}', 'index')->where('any', '.*');

//
///** Checkout */
//$router->get('/checkout', [
//    'as' => 'checkout.index',
//    'uses' => 'CheckoutController@index'
//]);
//
///** Add Order */
//$router->post('/checkout/store', [
//    'as' => 'checkout.store',
//    'uses' =>  'CheckoutController@store'
//]);
//
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
//
///** Get Areas From Nova Poshta */
//$router->post('/nova-poshta/warehouses', [
//    'as' => 'nova-poshta.warehouses',
//    'uses' => 'Api\NovaPoshtaController@getWarehouses',
//]);
//
///** Thank you page */
//$router->get('/orders/{order_id}/thankyou', [
//    'as' => 'thankyou',
//    'uses' => 'CheckoutController@getThankYouPage'
//]);
