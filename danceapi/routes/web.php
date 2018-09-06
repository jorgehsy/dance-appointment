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



$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('appointments',  ['uses' => 'AppointmentsController@showAll']);
  
    $router->get('appointments/{year}/{month}/{day}', ['uses' => 'AppointmentsController@showAppointmentsOnDate']);
    
    $router->get('appointment/{id}', ['uses' => 'AppointmentsController@showAppointment']);
    
    $router->post('appointment', ['uses' => 'AppointmentsController@create']);
  
    $router->delete('appointment/{id}', ['uses' => 'AppointmentsController@delete']);
  
    $router->put('appointment/{id}', ['uses' => 'AppointmentsController@update']);
  });