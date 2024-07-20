<?php

namespace Shoyim\Click\Facades;

use Illuminate\Support\Facades\Facade;

class Click extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'click';
    }
}
