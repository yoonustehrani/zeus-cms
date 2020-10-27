<?php

namespace Zeus\Facades;

use Illuminate\Support\Facades\Facade;

class ZeusFacade extends Facade {
    protected static function getFacadeAccessor()
    {
        return 'zeuspanel';
    }
}
