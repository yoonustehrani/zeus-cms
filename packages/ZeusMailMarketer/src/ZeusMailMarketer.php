<?php

namespace ZeusMailMarketer;

class ZeusMailMarketer
{
    public $config;
    public function __construct()
    {
        $this->config = include(__DIR__ . "/config/zeus_mail_marketing.php");
    }
    public function register()
    {
        \Zeus::register_extention(
            'Zeus Mail Marketer',
            (new ZeusMailMarketer),
            [
                'routes_file' => __DIR__ . '/Http/routes.php',
                'route_prefix' => ['name' => 'mail-marketer', 'as' => 'zeus-mail-marketer.'],
                'menu' => [
                    'title' => 'NewsLetter',
                    'icon_class' => 'far fa-newspaper',
                    'route' => 'RomanCamp.extention.zeus-mail-marketer.',
                    'target' => '_self',
                    'children' => [
                        [
                            'title' => 'Email Services',
                            'icon_class' => 'fas fa-envelope',
                            'route' => 'RomanCamp.extention.zeus-mail-marketer.services.index'
                        ],
                        [
                            'title' => 'Email Templates',
                            'icon_class' => 'fas fa-envelope',
                            'route' => 'RomanCamp.extention.zeus-mail-marketer.templates.index'
                        ],
                    ]
                ],
            ],
        );
    }
}