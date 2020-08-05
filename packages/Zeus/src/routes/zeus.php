<?php

Route::group(['as' => 'RomanCamp.', 'middleware' => ['auth','zeus.commanders']], function () {
    $namespace_prefix = '\\' . config('ZEC.controllers.namespace') . '\\';

    Route::get('/', $namespace_prefix . 'ZeusController@index');

    Route::resource('database', $namespace_prefix . 'DatabaseController');
});
