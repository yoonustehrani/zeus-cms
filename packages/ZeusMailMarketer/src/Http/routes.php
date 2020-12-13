<?php

use Illuminate\Support\Facades\Config;

$zemm_unique_namespace = config('ZECMM.controllers.namespace') . '\\';

Route::get('/', $zemm_unique_namespace . 'DashboardController@index');
Route::resource('/email_services/{type}/services', $zemm_unique_namespace . 'EmailServiceController');