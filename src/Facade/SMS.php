<?php

namespace Masoudi\SMS\Facade;

use Illuminate\Support\Facades\Facade;

class SMS extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "masoudi_sms";
    }
}