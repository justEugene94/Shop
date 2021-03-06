<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    /**
     * Api Routes
     */
    $router->resource('customers', CustomersController::class);
    $router->resource('orders', OrdersController::class);
    $router->get('cities', 'CitiesController@index');
    $router->get('departments', 'DepartmentsController@index');
    $router->resource('products', ProductsController::class);

});
