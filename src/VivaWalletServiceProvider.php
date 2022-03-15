<?php

namespace Deyjandi\VivaWallet;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Deyjandi\VivaWallet\Commands\VivaWalletCommand;

class VivaWalletServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-viva-wallet')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-viva-wallet_table')
            ->hasCommand(VivaWalletCommand::class);
    }
}
