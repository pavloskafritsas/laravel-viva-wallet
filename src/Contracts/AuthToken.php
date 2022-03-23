<?php

namespace Deyjandi\VivaWallet\Contracts;

interface AuthToken
{
    public static function getInstance(): self;

    public function getAccessToken(): string;

    public function getTokenType(): string;

    public function refresh(): self;
}
