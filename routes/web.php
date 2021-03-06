<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('redis',['uses' => 'RedisController@redis']);
$router->put('payment',['uses' => 'PaymentController@payment']);
$router->get('billing',['uses' => 'PaymentController@billing']);
//$router->put('payment',function(){
//    return response()->json(['test'=>'tests']);
//});
