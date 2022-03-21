<?php

namespace Deyjandi\VivaWallet\Enums;

/**
 * Electronic Commerce Indicator
 *
 * @see https://developer.vivawallet.com/integration-reference/response-codes/#electronic-commerce-indicator
 */
enum VivaWalletEci: int
{
    case Unspecified = 0;
    case Authenticated = 1;
    case No3ds = 2;
    case AttemptOrNotEnrolled = 3;
}
