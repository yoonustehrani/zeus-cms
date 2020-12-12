<?php

namespace ZeusMailMarketer;
use Illuminate\Support\Facades\Facade;

class ZeusMailMarketerFacade extends Facade {
    protected static function getFacadeAccessor()
    {
        return 'zeus_mail_marketer';
    }
}
