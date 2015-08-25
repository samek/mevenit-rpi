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
Route::any('/', 'DeviceSetupController@index');
route::get('/test','DeviceSetupController@create');

//STATUS//////////
Route::get('/api/status', 'StatusControllerAPI@index');
Route::get('/api/status/online', 'StatusControllerAPI@online');
Route::get('/api/status/dev/{iface}', 'StatusControllerAPI@iface');
///DEVICE//

Route::get('/api/device/reboot', 'DeviceControllerAPI@reboot');
Route::get('/api/device/resetnetwork', 'DeviceControllerAPI@resetNetwork');
Route::get('/api/device/factoryreset', 'DeviceControllerAPI@factoryReset');
Route::get('/api/device/update', 'DeviceControllerAPI@update');










Route::get('/api/settings/','SettingsControllerAPI@index');


Route::get('/api/jump', 'JumpControllerAPI@index');
Route::get('/api/network', 'NetworkControllerAPI@index');


Event::listen('illuminate.query', function($query, $params)
{
//	error_log("q ".($query)."\nparams:" . print_r($params,1) . "\n", 3, "/tmp/query.log");

   // echo $query."\n".print_r($params,1)."\n-----\n";
});