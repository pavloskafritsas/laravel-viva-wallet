<?php

namespace Deyjandi\VivaWallet;

use Deyjandi\VivaWallet\Traits\HasClient;
use Deyjandi\VivaWallet\Traits\HasEnv;

class VivaWalletWebhook
{
    use HasClient;
    use HasEnv;

    private string $merchantId;

    private string $apiKey;

    private ?string $webhookKey;

    public function __construct(array $config)
    {
        $this
            ->setEnv($config['env'])
            ->setMerchantId($config['merchant_id'])
            ->setApiKey($config['api_key'])
            ->setWebhookKey($config['webhook_key']);
    }

    public function setMerchantId(?string $merchantId): static
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    public function setApiKey(string $apiKey): static
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function setWebhookKey(?string $webhookKey): static
    {
        $this->webhookKey = $webhookKey;

        return $this;
    }

    public function requestKey(): string
    {
        return $this->request(
            ...$this->env->requestWebhookKey(
                $this->merchantId,
                $this->apiKey
            )
        )['Key'];
    }

    public function verifyEndpointResponse(): array
    {
        if (! $this->webhookKey) {
            // @todo use custom exception class
            throw new \Exception('Webhook verification key not set.');
        }

        return ['Key' => $this->webhookKey];
    }
}
