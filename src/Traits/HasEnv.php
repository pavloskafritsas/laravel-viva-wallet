<?php

namespace Deyjandi\VivaWallet\Traits;

use Deyjandi\VivaWallet\Enums\VivaWalletEnv;

trait HasEnv
{
    private VivaWalletEnv $env;

    public function setEnv(string|VivaWalletEnv $env): static
    {
        $this->env = is_string($env) ? VivaWalletEnv::from($env) : $env;

        return $this;
    }
}
