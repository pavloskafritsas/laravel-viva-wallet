<?php

namespace Deyjandi\VivaWallet;

use Carbon\CarbonImmutable;
use Deyjandi\VivaWallet\Contracts\AuthToken;
use Deyjandi\VivaWallet\Traits\HasClient;
use Deyjandi\VivaWallet\Traits\HasEnv;
use Illuminate\Support\Facades\Cache;

class Token implements AuthToken
{
    use HasClient;
    use HasEnv;

    private static ?self $instance = null;

    private const CACHE_KEY = 'viva_wallet_token';

    private string $clientId;

    private string $clientSecret;

    private string $accessToken;

    private int $expiresIn;

    private string $tokenType;

    private string $scope;

    private CarbonImmutable $issuedAt;

    public function __construct()
    {
        $this->setConfig(config('viva-wallet'));

        self::$instance = $this;
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

    private function requestToken(): self
    {
        $response = $this->request(
            ...$this->env->requestToken(
                $this->clientId,
                $this->clientSecret
            )
        );

        $this->accessToken = $response['access_token'];
        $this->expiresIn = $response['expires_in'];
        $this->tokenType = $response['token_type'];
        $this->scope = $response['scope'];
        $this->issuedAt = CarbonImmutable::now();

        Cache::put(self::CACHE_KEY, $this, $this->issuedAt->addSeconds($this->expiresIn - 30));

        return $this;
    }

    public static function getInstance(): self
    {
        if ($instance = Cache::get(self::CACHE_KEY)) {
            return $instance;
        }

        if ($instance = self::$instance?->requestToken()) {
            return $instance;
        }

        return (new self)->requestToken();
    }

    public function refresh(): static
    {
        return $this->requestToken();
    }
}
