<?php

namespace Deyjandi\VivaWallet;

class VivaWallet
{
    public function __construct()
    {
        $this->config = config('viva-wallet');
    }

    public function requestWebhookKey(): string
    {
        return (new VivaWalletWebhook($this->config))->requestKey();
    }

    public function createPaymentOrder(VivaWalletPayment $payment, ?VivaWalletCustomer $customer = null): string
    {
        $orderCode = $payment
            ->setConfig($this->config)
            ->setCustomer($customer)
            ->createOrder();

        return $payment->getCheckoutUrl($orderCode);
    }

    public function retrieveTransaction(string $transaction_id): array
    {
        return (new VivaWalletTransaction($this->config))->retrieve($transaction_id);
    }
}
