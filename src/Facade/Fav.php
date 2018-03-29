<?php

namespace Adibnoh\Fav\Facade;

use Illuminate\Support\Facades\Facade;

class Fav extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fav';
    }
}