<?php

namespace Deyjandi\VivaWallet;

use Carbon\CarbonImmutable;
use Deyjandi\VivaWallet\Contracts\AuthToken;
use Deyjandi\VivaWallet\Traits\HasClient;
use Deyjandi\VivaWallet\Traits\HasEnv;

class VivaWalletToken implements AuthToken
{
    use HasClient;
    use HasEnv;

    private const CACHE_KEY = 'viva_wallet_token';

    private string $method;

    private string $clientId;

    private string $clientSecret;

    private string $accessToken;

    private int $expiresIn;

    private string $tokenType;

    private string $scope;

    private CarbonImmutable $issuedAt;

    public function __construct(?array $config = null)
    {
        $this->setConfig($config ?? config('viva-wallet'));
    }

    public function setConfig(array $config): static
    {
        $this
            ->setEnv($config['env'])
            ->setClientId($config['client_id'])
            ->setClientSecret($config['client_secret']);

        return $this;
    }

    private function setClientId(string $clientId): static
    {
        $this->clientId = $clientId;

        return $this;
    }

    private function setClientSecret(string $clientSecret): static
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    public function getAccessToken(): string
    {
        if (empty($this->accessToken) || $this->isExpired()) {
            $this->requestToken();
        }

        return $this->accessToken;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function isExpired(): bool
    {
        return now()->gte($this->issuedAt->addSeconds($this->getExpiresIn()));
    }

    private function requestToken(): static
    {
        $response = $this->request(...$this->env->requestToken());

        $this->accessToken = $response['access_token'];
        $this->expiresIn = $response['expires_in'];
        $this->tokenType = $response['token_type'];
        $this->scope = $response['scope'];
        $this->issuedAt = CarbonImmutable::now();

        cache([static::CACHE_KEY => $this], $this->issuedAt->addSeconds($this->expiresIn - 30));

        return $this;
    }

    public static function getInstance(): static
    {
        return cache(static::CACHE_KEY) ?? (new static())->requestToken();
    }

    public function refresh(): static
    {
        return $this->requestToken();
    }
}
