<?php

namespace App\Services\Clickflare\Interfaces;

interface EndpointInterface
{
    public function getUrl(): string;

    public function getMethod(): string;
}
