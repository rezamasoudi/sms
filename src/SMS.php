<?php

namespace Masoudi\SMS;

use Closure;
use Masoudi\SMS\Contracts\BaseSmsDriver;
use Masoudi\SMS\Exceptions\InvalidSettingException;

class SMS
{
    public function __construct(protected array $drivers)
    {
        //
    }

    public function driver(?Closure $callback = null, ?string $driver = null): BaseSmsDriver
    {
        $driver = $driver ?? config("sms.default");
        if (!$driver) throw new InvalidSettingException("sms driver should define in config");
        if (!array_key_exists($driver, $this->drivers)) {
            throw new InvalidSettingException("sms driver ($driver) not found.");
        }

        $driveInstance = app($this->drivers[$driver], ['settings' => config("sms.$driver", array())]);

        if ($callback) {
            call_user_func($callback, $driveInstance);
        }

        return $driveInstance;
    }

    public function register(string $name, string $driver): void
    {
        $this->drivers[$name] = $driver;
    }

}