<?php

use Deyjandi\VivaWallet\Facades\VivaWallet;
use Deyjandi\VivaWallet\Payment;

it('can create payment order', function () {
    expect(
        VivaWallet::createPaymentOrder(new Payment(1000))
    )->toBeString();
});

it('can request webhook verification key', function () {
    expect(VivaWallet::requestWebhookKey())->toBeString();
});
