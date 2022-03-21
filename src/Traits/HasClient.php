<?php

namespace Deyjandi\VivaWallet\Traits;

use GuzzleHttp\Client;

trait HasClient
{
    private function getClient(): Client
    {
        return new Client(config('viva-wallet.http_client'));
    }

    public function request(string $method, string $uri, array $options = []): array
    {
        return json_decode($this->getClient()->request(...func_get_args())->getBody(), true);
    }
}
