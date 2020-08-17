<?php

use Zeus\Facades\ZeusFacade;

Route::group(['as' => 'RomanCamp.', 'middleware' => ['auth','zeus.commanders']], function () {
    $namespace_prefix = '\\' . config('ZEC.controllers.namespace') . '\\';

    Route::get('/', $namespace_prefix . 'ZeusController@index')->name('dashboard');

    Route::get('fields', function () {
        return view('ZEV::components.pages.fields');
    });

    Route::resource('datatypes', $namespace_prefix . 'DataTypeController')->except(['create', 'store']);

    Route::get('datatypes/{datatype}/create', $namespace_prefix . 'DataTypeController@create')->name('datatypes.create');
    Route::post('datatypes/{datatype}/add', $namespace_prefix . 'DataTypeController@store')->name('datatypes.store');

    Route::resource('database', $namespace_prefix . 'DatabaseController');


    try {
        foreach (ZeusFacade::model('DataType')::all() as $dataType) {
            // print($dataType . "\n\n\n\n");
            $breadController = $dataType->controller ? \Illuminate\Support\Str::start($dataType->controller, '\\') : $namespace_prefix.'ZeusBaseController';
            // Route::get($dataType->slug.'/order', $breadController.'@order')->name($dataType->slug.'.order');
            // Route::post($dataType->slug.'/action', $breadController.'@action')->name($dataType->slug.'.action');
            // Route::post($dataType->slug.'/order', $breadController.'@update_order')->name($dataType->slug.'.update_order');
            // Route::get($dataType->slug.'/{id}/restore', $breadController.'@restore')->name($dataType->slug.'.restore');
            // Route::get($dataType->slug.'/relation', $breadController.'@relation')->name($dataType->slug.'.relation');
            // Route::post($dataType->slug.'/remove', $breadController.'@remove_media')->name($dataType->slug.'.media.remove');
            Route::resource($dataType->slug, $breadController, ['parameters' => [$dataType->slug => 'id']]);
        }
    } catch (\InvalidArgumentException $e) {
        throw new \InvalidArgumentException("Custom routes hasn't been configured because: ".$e->getMessage(), 1);
    } catch (\Exception $e) {
        // do nothing, might just be because table not yet migrated.
    }
});
