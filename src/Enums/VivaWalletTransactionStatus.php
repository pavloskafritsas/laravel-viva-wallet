<?php

namespace Deyjandi\VivaWallet\Enums;

/**
 * Transaction Status ID parameter.
 *
 * @see https://developer.vivawallet.com/integration-reference/response-codes/#statusid-parameter
 */
enum VivaWalletTransactionStatus: string
{
    case PaymentUnsuccessful = 'E';
    case PaymentPending = 'A';
    case Disputed = 'M';
    case DisputeAwaitingResponse = 'MA';
    case DisputeInProgress = 'MI';
    case DisputeLost = 'ML';
    case DisputeWon = 'MW';
    case SuspectedDispute = 'MS';
    case Cancelled = 'X';
    case FullyOrPartiallyRefunded = 'R';
    case PaymentSuccessful = 'F';

    public function description(): string
    {
        return match ($this) {
            self::PaymentUnsuccessful => 'The transaction was not completed because of an error (PAYMENT UNSUCCESSFUL).',
            self::PaymentPending => 'The transaction is in progress (PAYMENT PENDING).',
            self::Disputed => 'The cardholder has disputed the transaction with the issuing Bank.',
            self::DisputeAwaitingResponse => 'Dispute Awaiting Response.',
            self::DisputeInProgress => 'Dispute in Progress.',
            self::DisputeLost => 'A disputed transaction has been refunded (Dispute Lost).',
            self::DisputeWon => 'Dispute Won',
            self::SuspectedDispute => 'Suspected Dispute.',
            self::Cancelled => 'The transaction was cancelled by the merchant.',
            self::FullyOrPartiallyRefunded => 'The transaction has been fully or partially refunded.',
            self::PaymentSuccessful => 'The transaction has been completed successfully (PAYMENT SUCCESSFUL).',
        };
    }
}
