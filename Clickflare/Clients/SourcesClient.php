<?php

namespace App\Services\Clickflare\Clients;

use App\Services\Clickflare\Contracts\ClickFlareApiClient;

class SourcesClient extends ClickFlareApiClient
{
    public function endpointKey(): string
    {
        return 'sources_info';
    }
}
