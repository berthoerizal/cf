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
    $router->delete('/users/{id}', 'UsersController@destroy');

    $router->get('/entitas', 'EntitasController@index');
    $router->post('/entitas', 'EntitasController@store');
    $router->patch('/entitas/{id}', 'EntitasController@update');
    $router->delete('/entitas/{id}', 'EntitasController@destroy');

    $router->get('/departemens', 'DepartemensController@index');
    $router->post('/departemens', 'DepartemensController@store');
    $router->patch('/departemens/{id}', 'DepartemensController@update');
    $router->delete('/departemens/{id}', 'DepartemensController@destroy');

    $router->get('/positions', 'PositionsController@index');
    $router->post('/positions', 'PositionsController@store');
    $router->patch('/positions/{id}', 'PositionsController@update');
    $router->delete('/positions/{id}', 'PositionsController@destroy');
    
    $router->get('/projects', 'ProjectsController@index');
    $router->post('/projects', 'ProjectsController@store');
    $router->patch('/projects/{id}', 'ProjectsController@update');
    $router->delete('/projects/{id}', 'ProjectsController@destroy');
    
    $router->get('/invests', 'InvestsController@index');
    $router->post('/invests', 'InvestsController@store');
    $router->patch('/invests/{id}', 'InvestsController@update');
    $router->delete('/invests/{id}', 'InvestsController@destroy');
    
    $router->get('/installments', 'InstallmentsController@index');
    $router->post('/installments', 'InstallmentsController@store');
    $router->patch('/installments/{id}', 'InstallmentsController@update');
    $router->delete('/installments/{id}', 'InstallmentsController@destroy');
});
