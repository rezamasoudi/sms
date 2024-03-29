<?php

namespace Masoudi\SMS\Contracts;

abstract class BaseSmsDriver
{
    public function __construct(protected array $settings)
    {
        //
    }
}