<?php

namespace Deyjandi\VivaWallet\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Deyjandi\VivaWallet\VivaWallet
 */
class VivaWallet extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'viva-wallet';
    }
}
