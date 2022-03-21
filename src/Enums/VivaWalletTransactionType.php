<?php

namespace Deyjandi\VivaWallet\Enums;

/**
 * TransactionTypeId parameter.
 *
 * The transaction type is identified by the TransactionTypeId parameter returned in the response body.
 * It is relevant in the context of the Retrieve transactions API call and webhooks for payments only.
 *
 * @see https://developer.vivawallet.com/integration-reference/response-codes/#transactiontypeid-parameter
 */
enum VivaWalletTransactionType: int
{
    case CardCapture = 0;
    case CardPreAuth = 1;
    case CardRefund = 4;
    case CardCharge = 5;
    case CardChargeInstallments = 6;
    case CardVoid = 7;
    case CardOriginalCredit = 8;
    case WalletCharge = 9;
    case WalletRefund = 11;
    case CardRefundClaimed = 13;
    case Dias = 15;
    case Cash = 16;
    case CashRefund = 17;
    case CardRefundInstallments = 18;
    case CardPayout = 19;
    case AlipayCharge = 20;
    case AlipayRefund = 21;
    case CardManualCashDisbursement = 22;
    case IdealCharge = 23;
    case IdealRefund = 24;
    case P24Charge = 25;
    case P24Refund = 26;
    case BlikCharge = 27;
    case BlikRefund = 28;
    case PayuCharge = 29;
    case PayuRefund = 30;
    case CardWithdrawal = 31;
    case MultibancoCharge = 32;
    case MultibancoRefund = 33;
    case giropayCharge = 34;
    case giropayRefund = 35;
    case SofortCharge = 36;
    case SofortRefund = 37;
    case EpsCharge = 38;
    case EpsRefund = 39;
    case WechatPayCharge = 40;
    case WechatPayRefund = 41;
    case BitPayCharge = 42;
    case BitPayRefund = 43;
    case PaypalCharge = 48;
    case PaypalRefund = 49;
    case PayconiqCharge = 58;
    case PayconiqRefund = 59;
    case TrustlyCharge = 50;
    case TrustlyRefund = 51;
}
