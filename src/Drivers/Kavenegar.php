<?php

namespace Masoudi\SMS\Drivers;

use Masoudi\SMS\Contracts\BaseSmsDriver;
use Masoudi\SMS\Exceptions\InvalidSettingException;
use Masoudi\SMS\Support\Kavenegar\Lookup;

class Kavenegar extends BaseSmsDriver
{

    /**
     * Send lookup sms
     *
     * @throws InvalidSettingException|\Exception
     */
    public function lookup(string $receiver, string $template, array $params): array
    {
        return (new Lookup($this->settings))->send($receiver, $template, $params);
    }

}