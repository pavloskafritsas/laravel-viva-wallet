<?php

namespace Deyjandi\VivaWallet;

use Deyjandi\VivaWallet\Traits\HasClient;
use Deyjandi\VivaWallet\Traits\HasEnv;

class VivaWalletWebhook
{
    use HasClient, HasEnv;

    private string $api_key;

    public function __construct(array $config)
    {
        $this
            ->setEnv($config['env'])
            ->setWebhookKey($config['webhook_key']);
    }

    public function setWebhookKey(?string $webhook_key): static
    {
        $this->webhook_key = $webhook_key;

        return $this;
    }

    public function requestKey(): string
    {
        return $this->request(...$this->env->requestWebhookKey())['Key'];
    }

    public function verifyEndpointResponse(): array
    {
        if (!$this->webhookKey) {
            // @todo use custom exception class
            throw new \Exception('Webhook verification key not set.');
        }

        return ['Key' => $this->webhook_key];
    }
}
