<?php

namespace Deyjandi\VivaWallet;

use Deyjandi\VivaWallet\Commands\RequestWebhookKey;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class VivaWalletServiceProvider extends PackageServiceProvider
{
    public function boot(): void
    {
        $this->app->bind('viva-wallet', fn ($app) => new VivaWallet());

        if ($this->app->runningInConsole() || $this->app->runningUnitTests()) {

            $this->publishes([
                __DIR__ . '/../config/viva-wallet.php' => config_path('viva-wallet.php'),
            ], 'config');

            $this->commands([RequestWebhookKey::class]);
        }
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('viva-wallet')
            ->hasCommands([RequestWebhookKey::class])
            ->hasConfigFile();
    }
}
