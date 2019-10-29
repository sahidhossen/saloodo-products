<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api/v1'], function() use (&$router){
    
    // For everyone
    $router->get('/products', 'ProductController@getAll');

    // Only authenticated admin
    $router->group(['middleware' => ['auth:api','role:admin']], function() use (&$router){
        $router->post('/product/create', 'ProductController@create');
        $router->post('/product/edit', 'ProductController@edit');
     });

     // Only authenticated customer
    $router->group(['middleware' => ['auth:api','role:customer']], function() use (&$router){
        $router->post('/order/create', 'OrderController@create');
        $router->get('/orders', 'OrderController@getOrders');
     });

});