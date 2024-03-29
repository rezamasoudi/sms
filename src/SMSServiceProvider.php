<?php

namespace Masoudi\SMS;

use Illuminate\Support\ServiceProvider;
use Masoudi\SMS\Drivers\Kavenegar;

class SMSServiceProvider extends ServiceProvider
{

    protected array $drivers = [
        "kavenegar" => Kavenegar::class,
    ];

    public function register(): void
    {
        $this->app->singleton("masoudi_sms", function () {
            return new SMS($this->drivers);
        });
    }

    public function boot(): void
    {
        $this->publish();
    }

    protected function publish(): void
    {
        $this->mergeConfigFrom(__DIR__ . "/../config/sms.php", "sms");
        $this->publishes([
            __DIR__ . "/../config/sms.php" => config_path("sms.php")
        ], "masoudi-sms-config");
    }

}