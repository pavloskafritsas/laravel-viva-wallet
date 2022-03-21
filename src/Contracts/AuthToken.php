<?php

namespace Deyjandi\VivaWallet\Contracts;

interface AuthToken
{
    public static function getInstance(): static;

    public function getAccessToken(): string;

    public function getTokenType(): string;
}
