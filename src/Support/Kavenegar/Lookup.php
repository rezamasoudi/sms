<?php

namespace Masoudi\SMS\Support\Kavenegar;

use _PHPStan_5f1729e44\Nette\Neon\Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Masoudi\SMS\Exceptions\InvalidSettingException;

class Lookup
{
    public function __construct(protected array $settings)
    {
        //
    }

    /**
     * @throws InvalidSettingException|\Exception
     */
    public function send(string $receiver, string $template, array $tokens): array
    {
        $this->validate();
        $endpoint = Str::replace(":token", $this->settings['token'], $this->settings['lookup_url']);
        $params = [
            'receptor' => $receiver,
            'template' => $template
        ];
        $params = array_merge($params, $this->normalizeTokens($tokens));
        $result = Http::asForm()->post($endpoint, $params);
        if (!$result->successful()) {
            $result->throw();
        }
        return json_decode($result->body(), associative: true);
    }

    protected function normalizeTokens(array $tokens): array
    {
        $result = [];
        foreach ($tokens as $key => $token) {
            if (!Str::startsWith($key, '%token') || Str::startsWith($key, 'token')) {
                throw new Exception("key $key invalid, tokens array keys should starts with token or %token");
            }
            if (Str::startsWith($key, '%token')) {
                $result[ltrim($key, '%')] = $token;
                continue;
            }
            $result[$key] = $token;
        }
        return $result;
    }

    protected function validate(): void
    {
        if (!array_key_exists("token", $this->settings)) {
            throw new InvalidSettingException("token key undefined in kavenegar settings");
        }
        if (!array_key_exists("lookup_url", $this->settings)) {
            throw new InvalidSettingException("lookup_url key undefined in kavenegar settings");
        }
        if (strpos($this->settings['lookup_url'], ':token') < 0) {
            throw new InvalidSettingException("lookup_url doesn't contains :token placeholder");
        }
    }

}