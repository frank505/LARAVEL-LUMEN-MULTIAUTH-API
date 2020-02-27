<?php

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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });


$router->group(['prefix' => 'user'], function () use ($router) {
   
   $router->post('register', 'UserController@register');
    $router->post('login', 'UserController@login');
    $router->get('view-profile','UserController@viewProfile');
});





$router->group(['prefix' => 'admin'], function () use ($router) {
  
   $router->post('register', 'AdminController@register');
    $router->post('login', 'AdminController@login');
    $router->get('view-profile','AdminController@viewProfile');
});