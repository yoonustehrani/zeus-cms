<?php

namespace Zeus;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class ZeusPanelServiceProvider extends ServiceProvider {
    protected $mainpath = __DIR__ . DIRECTORY_SEPARATOR;
    public $configpath;
    public $resourcepath;
    public $migrations;

    public function boot()
    {
        $resourcepath = $this->mainpath . 'resources/';
        $files = scandir($this->mainpath . 'migrations');
        $migrations = [];
        for ($i=2; $i < count($files); $i++) {
            $migrations[ __DIR__ . '/migrations/' . $files[$i]] = database_path('migrations') . '/' . $files[$i];
        }
        $this->loadViewsFrom($resourcepath . 'views', 'ZEV');
        $this->loadTranslationsFrom($resourcepath . 'lang', 'ZEL');
        $this->publishes($migrations, 'migrations');
        // $this->publishes($this->migrations, 'models');
    }
    public function register()
    {
        $this->configpath = $this->mainpath . 'config/zeus.php';
        $this->app->bind('zeuspanel', function($app){
            return new ZeusPanel;
        });
        $this->mergeConfigFrom($this->configpath, 'ZEC');
    }
}
