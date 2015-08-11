<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'StatusController@index');
Route::get('/jump', 'JumpController@index');
Route::get('/network', 'NetworkController@index');


Event::listen('illuminate.query', function($query, $params)
{
//	error_log("q ".($query)."\nparams:" . print_r($params,1) . "\n", 3, "/tmp/query.log");

   // echo $query."\n".print_r($params,1)."\n-----\n";
});