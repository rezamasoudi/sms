<?php
return [

    "default" => "kavenegar", // default driver

    // kavenegar
    "kavenegar" => [
        "token" => env("KAVENEGAR_TOKEN"),
        "lookup_url" => env("KAVENEGAR_LOOKUP_URL", 'https://api.kavenegar.com/v1/:token/verify/lookup.json'),
    ],

];