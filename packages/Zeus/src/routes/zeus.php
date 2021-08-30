<?php

use Zeus\Facades\ZeusFacade;

Route::group(['as' => 'RomanCamp.', 'middleware' => ['auth','zeus.commanders']], function () {
    $namespace_prefix = '\\' . config('ZEC.controllers.namespace') . '\\';

    Route::get('/', $namespace_prefix . 'ZeusController@index')->name('dashboard');
    Route::get('extentions', $namespace_prefix . 'ExtentionController@index');

    Route::resource('datatypes', $namespace_prefix . 'DataTypeController')->except(['show','create', 'store']);
    Route::get('datatypes/{datatype}/create', $namespace_prefix . 'DataTypeController@create')->name('datatypes.create');
    Route::post('datatypes/{datatype}/add', $namespace_prefix . 'DataTypeController@store')->name('datatypes.store');
    Route::resource('datatypes/{datatype}/datarows', $namespace_prefix . 'DataRowController');
    Route::resource('database', $namespace_prefix . 'DatabaseController')->only('index');
    Route::prefix('menu-builder')->group(function() use($namespace_prefix) {
        Route::get('/{menu}', $namespace_prefix . 'MenuBuilderController@edit')->name('menus.builder');
    });

    try {
        $data_types = ZeusFacade::model('DataType')::all();
        foreach ($data_types as $dataType) {
            $defaultController = $namespace_prefix.'ZeusBaseController';
            $campController = $dataType->controller ? \Illuminate\Support\Str::start($dataType->controller, '\\') : $defaultController;
            // Route::get($dataType->slug.'/order', $campController.'@order')->name($dataType->slug.'.order');
            // Route::post($dataType->slug.'/action', $campController.'@action')->name($dataType->slug.'.action');
            // Route::post($dataType->slug.'/order', $campController.'@update_order')->name($dataType->slug.'.update_order');
            // Route::get($dataType->slug.'/{id}/restore', $campController.'@restore')->name($dataType->slug.'.restore');
            // Route::get($dataType->slug.'/relation', $campController.'@relation')->name($dataType->slug.'.relation');
            // Route::post($dataType->slug.'/remove', $campController.'@remove_media')->name($dataType->slug.'.media.remove');
            $route = Route::resource($dataType->slug, $campController);
            if ($dataType->details && $dataType->controller && isset($dataType->details->routes)) {
                if ($dataType->details->routes->only) {
                    $route->only($dataType->details->routes->only);
                } elseif($dataType->details->routes->except) {
                    $route->except($dataType->details->routes->except);
                }
                if ($dataType->details->routes->auto) {
                    Route::resource($dataType->slug, $defaultController)->only($dataType->details->routes->auto)->parameters([$dataType->slug => 'id']);
                }
            }
            $route->parameters([$dataType->slug => 'id']);
        }
    } catch (\InvalidArgumentException $e) {
        throw new \InvalidArgumentException("Custom routes hasn't been configured because: ".$e->getMessage(), 1);
    } catch (\Exception $e) {
        // do nothing, might just be because table not yet migrated.
    }

    try {
        \Zeus::load_extentions();
        Route::group(['prefix' => 'extention', 'as' => 'extention.'], function() {
            foreach (\Zeus::get_extentions() as $extention) {
                if (isset($extention['routes_file'])) {
                    Route::group(['prefix' => $extention['routes']['name'], 'as' => $extention['routes']['as']], function() use($extention) {
                        include($extention['routes_file']);
                    });
                }
            }
        });
    } catch(\Exception $e) {

    }
});

Route::group(['prefix' => 'api/v1', 'as' => 'RomanCamp.api.', 'middleware' => ['api']], function() {
    $namespace_prefix = '\\' . config('ZEC.controllers.namespace') . '\\Api\\';
    $apiController = $namespace_prefix . 'ZeusBaseApiController';
    $data_types = ZeusFacade::model('DataType')::all();
    foreach ($data_types as $dataType) {
        // $apiController = $dataType->controller ? \Illuminate\Support\Str::start($dataType->controller, '\\') : $apiController;
        // // Route::get($dataType->slug.'/order', $apiController.'@order')->name($dataType->slug.'.order');
        // // Route::post($dataType->slug.'/action', $apiController.'@action')->name($dataType->slug.'.action');
        // // Route::post($dataType->slug.'/order', $apiController.'@update_order')->name($dataType->slug.'.update_order');
        // // Route::get($dataType->slug.'/{id}/restore', $apiController.'@restore')->name($dataType->slug.'.restore');
        // // Route::get($dataType->slug.'/relation', $apiController.'@relation')->name($dataType->slug.'.relation');
        // // Route::post($dataType->slug.'/remove', $apiController.'@remove_media')->name($dataType->slug.'.media.remove');
        $route = Route::resource($dataType->slug, $apiController);
        if ($dataType->details && $dataType->controller && isset($dataType->details->routes)) {
            if ($dataType->details->routes->only) {
                $route->only($dataType->details->routes->only);
            } elseif($dataType->details->routes->except) {
                $route->except($dataType->details->routes->except);
            }
            if ($dataType->details->routes->auto) {
                Route::resource($dataType->slug, $apiController)->only($dataType->details->routes->auto)->parameters([$dataType->slug => 'id']);
            }
        } else {
            $route->except(['create', 'edit']);
        }
        $route->parameters([$dataType->slug => 'id']);
    }
    Route::get('menus/{menu}', $namespace_prefix . 'MenuBuilderController@show')->name('menu.show');
    Route::put('menus/{menu}/items/update', $namespace_prefix . 'MenuBuilderController@updateMany')->name('menu.update');
    Route::post('menus/{menu}/items', $namespace_prefix . 'MenuBuilderController@store')->name('menu.items.store');
    Route::put('menus/{menu}/items/{menuItem}', $namespace_prefix . 'MenuBuilderController@update')->name('menu.items.update');
    Route::delete('menus/{menu}/items/{menuItem}', $namespace_prefix . 'MenuBuilderController@destroy')->name('menu.items.destroy');
    Route::resource('file-manager/files',  $namespace_prefix . 'FileManagerController')->except(['store']);
    Route::patch('file-manager/files/{file}/restore', $namespace_prefix . 'FileManagerController@restore')->name('files.restore');
    Route::post('file-manager/files/{type}/upload', $namespace_prefix . 'FileManagerController@store')->name('files.upload')->middleware('api');
});