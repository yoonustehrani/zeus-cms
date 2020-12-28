<?php

namespace ZeusMailMarketer\Facades;
use Illuminate\Support\Facades\Facade;

class NormalizeTagsFacade extends Facade {
    protected static function getFacadeAccessor()
    {
        return 'zeus_mail_marketer_tags';
    }
}
