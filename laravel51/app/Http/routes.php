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

Route::get('metrics', 'MetricsController@index');

Route::group(['prefix' => 'health'], function () {
    Route::get('readiness', 'HealthController@readiness');
    Route::get('worker-readiness', 'HealthController@workerReadiness');
});

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'jobs'], function () {
        Route::post('inventory', 'JobController@dispatchInventory');
        Route::post('notification', 'JobController@dispatchNotification');
        Route::post('invoice', 'JobController@dispatchInvoice');
    });
});
