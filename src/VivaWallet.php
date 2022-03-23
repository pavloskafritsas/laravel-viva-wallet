<?php

namespace Deyjandi\VivaWallet;

class VivaWallet
{
    private array $config;

    public function __construct()
    {
        $this->config = config('viva-wallet');
    }

    public function requestWebhookKey(): string
    {
        return (new VivaWalletWebhook($this->config))->requestKey();
    }

    public function createPaymentOrder(Payment $payment, ?Customer $customer = null): string
    {
        return $payment->getCheckoutUrl(
            $payment
                ->setConfig($this->config)
                ->setCustomer($customer)
                ->createOrder()
        );
    }

    public function retrieveTransaction(string $transactionId): array
    {
        return (new VivaWalletTransaction($this->config))->retrieve($transactionId);
    }
}
