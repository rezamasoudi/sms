<?php

namespace Masoudi\SMS\Exceptions;

class InvalidSettingException extends \Exception
{
    public function __construct(string $message = "")
    {
        parent::__construct($message, 0, null);
    }
}