<?php

use Deyjandi\VivaWallet\Helpers\ClientAuth;
use Deyjandi\VivaWallet\VivaWalletToken;
use Illuminate\Support\Carbon;

it(
    'can make auth header',
    fn () => expect(ClientAuth::token(VivaWalletToken::getInstance()))->toBeString()
);

it('can hit and expire from cache', function () {
    $token = VivaWalletToken::getInstance();

    expect(cache('viva_wallet_token'))->toEqual($token);

    Carbon::setTestNow(now()->addSeconds($token->getExpiresIn()));

    expect(cache('viva_wallet_token'))->toBeNull();
});
