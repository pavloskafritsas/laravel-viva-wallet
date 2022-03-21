<?php

namespace Deyjandi\VivaWallet\Commands;

use Deyjandi\VivaWallet\Facades\VivaWallet;
use Illuminate\Console\Command;

class RequestWebhookKey extends Command
{
    private const ENV_KEY = 'VIVA_WALLET_WEBHOOK_KEY';

    public $signature = 'viva-wallet:webhook-key {--F|force}';

    public $description = 'Request and store a new webhook verification key.';

    private string $envPath;

    public function handle(): int
    {
        $this->envPath = base_path('.env');

        if (env(self::ENV_KEY) && ! $this->option('force')) {
            if ($this->confirm('Webhook verification key already exists. Do you wish to continue?')) {
                $this->replaceEnvKey();
            } else {
                return self::FAILURE;
            }
        } else {
            $this->addKeyToEnv();
        }

        $this->comment('Webhook verification key generated successfully.');

        return self::SUCCESS;
    }

    private function replaceEnvKey(): void
    {
        file_put_contents(
            $this->envPath,
            preg_replace(
                '/(' . self::ENV_KEY . '=).*/',
                $this->generateEnvLine(),
                file_get_contents($this->envPath)
            )
        );
    }

    private function generateEnvLine(): string
    {
        return self::ENV_KEY . '=' . VivaWallet::requestWebhookKey();
    }

    private function addKeyToEnv(): void
    {
        $file = fopen($this->envPath, 'a');

        fwrite($file, $this->generateEnvLine());

        fclose($file);
    }
}
