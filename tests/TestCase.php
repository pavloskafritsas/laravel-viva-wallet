<?php

namespace Deyjandi\VivaWallet\Tests;

use Deyjandi\VivaWallet\VivaWalletServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            VivaWalletServiceProvider::class,
        ];
    }
}
