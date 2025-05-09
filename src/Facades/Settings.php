<?php

namespace MtSettings\LaravelSettings\Facades;

use Illuminate\Support\Facades\Facade;

class Settings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'settings';
    }
}