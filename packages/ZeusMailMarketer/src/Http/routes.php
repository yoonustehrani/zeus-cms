<?php

use Illuminate\Support\Facades\Config;

$zemm_unique_namespace = config('ZECMM.controllers.namespace') . '\\';

Route::get('/', $zemm_unique_namespace . 'DashboardController@index');