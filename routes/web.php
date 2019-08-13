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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/login', 'AuthController@postLogin');
$router->post('/logout', 'AuthController@postLogout');

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->get('/users', 'UsersController@index');
    $router->post('/users', 'UsersController@store');
    $router->patch('/users/{id}', 'UsersController@update');
    $router->delete('/users/{id}', 'UsersController@delete');
});
