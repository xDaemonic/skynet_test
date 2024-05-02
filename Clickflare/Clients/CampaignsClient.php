<?php

namespace App\Services\Clickflare\Clients;

use App\Services\Clickflare\Contracts\ClickFlareApiClient;
use App\Services\Clickflare\Helpers\UrlRegistry;

class CampaignsClient extends ClickFlareApiClient
{
    protected function endpointKey(): string
    {
        return 'campaigns_info';
    }
}
