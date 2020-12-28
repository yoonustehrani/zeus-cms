<?php

namespace ZeusMailMarketer;

use Illuminate\Support\ServiceProvider;
use ZeusMailMarketer\Services\NormalizeTags;

class ZeusMailMarketerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $resourcepath = __DIR__ . DIRECTORY_SEPARATOR . 'resources/';
        $this->loadViewsFrom($resourcepath . 'views', 'ZEMMV');
    }

    public function register()
    {     
        $this->app->bind('zeus_mail_marketer', function($app) {
            return new ZeusMailMarketer;
        });
        $this->app->bind('zeus_mail_marketer_tags', function($app) {
            return new NormalizeTags;
        });
        $this->mergeConfigFrom(__DIR__ . "/config/zeus_mail_marketing.php", 'ZECMM');
    }
}