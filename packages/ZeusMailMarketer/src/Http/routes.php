<?php

use Illuminate\Support\Facades\Config;

$zemm_unique_namespace = config('ZECMM.controllers.namespace') . '\\';

// RomanCamp.extention.zeus-mail-marketer.

Route::get('/', $zemm_unique_namespace . 'DashboardController@index');
Route::resource('/email_services/services', $zemm_unique_namespace . 'EmailServiceController');