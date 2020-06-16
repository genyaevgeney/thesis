<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resources([
    'days' => 'EnterpriseDayController'
]);

Route::resources([
    'lines' => 'LineController'
]);

Route::resources([
    'shifts' => 'ShiftController'
]);

Route::resources([
    'sensors' => 'SensorController'
]);

Route::resources([
    'controls' => 'ControlController'
]);

Route::get('/generate-day', "EnterpriseController@generateDay");

Route::get('/day/{id}/sensor-data', "SensorController@getByDayId");

Route::get('/day/{id}/control-data', "ControlController@getByDayId");

Route::get('/line/{id}/shifts', "ShiftController@getByLineId");

Route::get('/shift/{id}/sensor-data', "SensorController@getByShiftId");

Route::get('/shift/{id}/control-data', "ControlController@getByShiftId");

Route::get('/day/{dayId}/shift/{shiftId}/sensor-data', "SensorController@getByDayShiftId");

Route::get('/day/{dayId}/shift/{shiftId}/control-data', "ControlController@getByDayShiftId");

Route::get('/line/{id}/sensor-data', "SensorController@getByLineId");

Route::get('/line/{id}/control-data', "ControlController@getByLineId");

Route::post('/calculate/energy-costs', "SensorController@getEnergyPerShift");

Route::post('/calculate/fuel-costs', "SensorController@getFuelPerShift");

Route::post('/calculate/gas-costs', "SensorController@getGasPerShift");

Route::post('/calculate/unit-costs', "SensorController@getUnitCostsPerShift");

Route::get('/shifts', "ShiftController@getAll");

Route::get('/enterprise-days', "EnterpriseDayController@getAll");

Route::post('/calculate/shifts-energy-costs', "SensorController@getAllLineEnergyPerShift");

Route::post('/calculate/shifts-fuel-costs', "SensorController@getAllLineFuelPerShift");

Route::post('/calculate/shifts-gas-costs', "SensorController@getAllLineGasPerShift");

Route::post('/calculate/carbon-params', "ControlController@calculateCarbonQualityParametersPerShift");

