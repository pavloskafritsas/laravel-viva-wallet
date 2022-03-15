<?php

namespace Deyjandi\VivaWallet\Commands;

use Illuminate\Console\Command;

class VivaWalletCommand extends Command
{
    public $signature = 'laravel-viva-wallet';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
