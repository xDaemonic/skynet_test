<?php

namespace App\Services\Clickflare\Helpers;

use App\Services\Clickflare\src\Endpoint;
use App\Services\Clickflare\Interfaces\EndpointInterface;

class UrlRegistry
{
    private static array $endpoints = [
        'reports' => [
            'url' => 'https://public-api.clickflare.io/api/report',
            'method' => 'POST',
        ],
        'campaigns_info' => [
            'url' => 'https://public-api.clickflare.io/api/campaigns',
            'method' => 'GET',
        ],
        'sources_info' => [
            'url' => 'https://public-api.clickflare.io/api/traffic-sources',
            'method' => 'GET',
        ]
    ];

    public static function getEndpoint(string $key): EndpointInterface
    {
        if (!array_key_exists($key, static::$endpoints)) throw new \InvalidArgumentException('Endpoint config doesnt exists!');
        $arr = static::$endpoints[$key];

        return new Endpoint($arr['url'], $arr['method']);
    }

    private function __construct()
    {
    }
    private function __clone()
    {
    }

    public function __sleep()
    {
    }

    public function __wakeup()
    {
    }
}
