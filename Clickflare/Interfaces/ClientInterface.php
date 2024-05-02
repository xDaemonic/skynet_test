<?php

namespace App\Services\Clickflare\Interfaces;

interface ClientInterface
{
    public function getData(array $options = []): array;
}
