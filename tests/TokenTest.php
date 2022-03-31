<?php

use Deyjandi\VivaWallet\Token;
use Illuminate\Support\Carbon;

it('can issue auth token', function () {
    $token = Token::getInstance();

    expect($token->getAccessToken())->toBeString();
});

it('can hit cache', function () {
    $token = Token::getInstance();

    expect(cache('viva_wallet_token'))->toEqual($token);
});

it('can expire', function () {
    $token = Token::getInstance();

    Carbon::setTestNow(now()->addSeconds($token->getExpiresIn()));

    expect($token->isExpired())->toBeTrue();

    expect(cache('viva_wallet_token'))->toBeNull();
});
