<?php

namespace Masoudi\SMS\Facade;

use Illuminate\Support\Facades\Facade;
use Masoudi\SMS\Contracts\BaseSmsDriver;

/**
 * @method static BaseSmsDriver driver(?\Closure $callback = null, ?string $driver = null)
 */
class SMS extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "masoudi_sms";
    }
}