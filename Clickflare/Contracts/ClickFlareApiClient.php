<?php

namespace App\Services\Clickflare\Contracts;

use App\Services\Clickflare\Helpers\UrlRegistry;
use App\Services\Clickflare\Interfaces\ClientInterface;
use App\Services\Clickflare\Interfaces\EndpointInterface;
use Illuminate\Support\Facades\Http;
use Spatie\LaravelIgnition\Exceptions\InvalidConfig;

abstract class ClickFlareApiClient implements ClientInterface
{
    /** @var string|null API key */
    private ?string $api_key = null;
    protected array $default_options = [];

    abstract protected function endpointKey(): string;

    /**
     * @param array $options
     * @return array
     * @throws \Spatie\LaravelIgnition\Exceptions\InvalidConfig
     */
    public function getData(array $options = []): array
    {
        $endpoint = $this->getEndpoint();
        return ($endpoint) ? $this->request($endpoint, $options) : [];
    }

    /**
     * Get api key string.
     *
     * @return string
     * @throws \Spatie\LaravelIgnition\Exceptions\InvalidConfig
     */
    protected function getApiKey(): string
    {
        if (!$this->api_key) {
            $this->api_key =  env('API_KEY');
            if (!$this->api_key) throw new InvalidConfig('Put API_KEY to .env');
        }
        return $this->api_key;
    }

    /**
     * Get api's endpoint object.
     *
     * @return \App\Services\Clickflare\Interfaces\EndpointInterface|null
     */
    protected function getEndpoint(): ?EndpointInterface
    {
        return UrlRegistry::getEndpoint($this->endpointKey());
    }

    /**
     * @param array $options
     * @return array
     */
    protected function makeOptions(array $options): array
    {
        return array_merge($this->default_options, $options);
    }

    /**
     * Make request to CF api.
     *
     * @param \App\Services\Clickflare\Interfaces\EndpointInterface $endpoint
     * @param array $options
     * @return array
     * @throws \Spatie\LaravelIgnition\Exceptions\InvalidConfig
     * @throws \Exception
     */
    protected function request(EndpointInterface $endpoint, array $options): array
    {
        $response = Http::withHeaders(['Api-Key' => $this->getApiKey()])
            ->withBody(json_encode($options))
            ->send(
                $endpoint->getMethod(),
                $endpoint->getUrl()
            );

        if ($response->status() !== 200) return [];

        return $response->json();
    }

}
