<?php

use Deyjandi\VivaWallet\VivaWalletToken;
use Illuminate\Support\Carbon;

it('can issue auth token', function () {
    $token = VivaWalletToken::getInstance();

    expect($token->getAccessToken())->toBeString();
});

it('can hit cache', function () {
    $token = VivaWalletToken::getInstance();

    expect(cache('viva_wallet_token'))->toEqual($token);
});

it('can expire', function () {
    $token = VivaWalletToken::getInstance();

    Carbon::setTestNow(now()->addSeconds($token->getExpiresIn()));

    expect($token->isExpired())->toBeTrue();

    expect(cache('viva_wallet_token'))->toBeNull();
});
