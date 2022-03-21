<?php

namespace Deyjandi\VivaWallet\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Deyjandi\VivaWallet\VivaWalletServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            VivaWalletServiceProvider::class,
        ];
    }
}
