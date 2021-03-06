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


Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'api/v1'], function () {

    Route::resource('cities', 'CityController');
    Route::resource('stations', 'StationController');

    
    Route::post('measurements/filterByCity', 'MeasurementsController@filterByCity');
    Route::post('measurements/filterByStation', 'MeasurementsController@filterByStation');
    Route::get('measurements/filter', 'MeasurementsController@filter');
    Route::get('measurements/allYearsWithMonths', 'MeasurementsController@allYearsWithMonths');
    Route::get('measurements', 'MeasurementsController@index');
    Route::get('measurements/{id}', 'MeasurementsController@show');

    # Route::post('users', 'UsersController@create');
    # Route::post('users/login', 'UsersController@login');

    Route::group(['middleware' => ['jwt.auth']], function () {

    });

});


