<?php

use Illuminate\Support\Facades\Config;

$zemm_unique_namespace = config('ZECMM.controllers.namespace') . '\\';
define('ZMM_NAMESPACE', $zemm_unique_namespace);
// RomanCamp.extention.zeus-mail-marketer.

Route::get('/', ZMM_NAMESPACE . 'DashboardController@index');
Route::resource('/subscribers', ZMM_NAMESPACE . 'SubscriberController');
Route::resource('/templates', ZMM_NAMESPACE . 'TemplateController');
Route::resource('/email_services/services', ZMM_NAMESPACE . 'EmailServiceController');