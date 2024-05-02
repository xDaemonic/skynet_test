<?php

namespace App\Services\Clickflare\src;

use App\Services\Clickflare\Interfaces\EndpointInterface;

class Endpoint implements EndpointInterface
{
    protected string $url;
    protected string $method;

    public function __construct(string $url, string $method)
    {
        $this->url = $url;
        $this->method = $method;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
