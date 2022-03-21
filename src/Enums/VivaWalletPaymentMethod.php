<?php

namespace Deyjandi\VivaWallet\Enums;

enum VivaWalletPaymentMethod: int
{
    case CreditCard = 0;
    case PayPal     = 23;
    case EBanking   = 4;
    case Cash       = 3;
    case BitPay     = 19;
    case EPS        = 17;
    case giropay    = 15;
    case iDEAL      = 10;
    case Multibanco = 14;
    case P24        = 11;
    case PayU       = 13;
    case Sofort     = 16;
    case WeChatPay  = 18;
    case Payconiq   = 28;
    case BLIK       = 12;
    case Trustly    = 24;
}
