<?php

namespace Deyjandi\VivaWallet\Enums;

/**
 * @see https://developer.vivawallet.com/integration-reference/response-codes/#event-id-codes
 */
enum EventId: int
{
    case Undefined = 0;
    case Incomplete3dsFlow = 2061;
    case Failed3DSValidation = 2062;
    case PaymentsPolicyAcquiringRestriction = 2108;
    case ReferToCardIssuer = 10001;
    case InvalidMerchantNumber = 10003;
    case PickUpCard = 10004;
    case DoNotHonor = 10005;
    case GeneralError = 10006;
    case InvalidTransaction = 10012;
    case InvalidAmount = 10013;
    case InvalidCardNumber = 10014;
    case InvalidIssuer = 10015;
    case FormatError = 10030;
    case LostCard = 10041;
    case StolenCard = 10043;
    case InsufficientFunds = 10051;
    case ExpiredCard = 10054;
    case FunctionNotPermittedToCardholder = 10057;
    case FunctionNotPermittedToTerminal = 10058;
    case WithdrawalLimitExceeded = 10061;
    case RestrictedCard = 10062;
    case IssuerResponseSecurityViolation = 10063;
    case SoftDecline = 10065;
    case CallIssuer = 10070;
    case PinEntryTriesExceeded = 10075;
    case ToAccountIsInvalidOrNonExistent = 10076;
    case SystemMalfunction = 10096;
    case GenericError = 10200;
    case SoftDecline2 = 10301;

    public static function type(self $value): string
    {
        return match ($value) {
            self::Undefined => 'System',
            self::Incomplete3dsFlow => 'User',
            self::Failed3DSValidation => 'User',
            self::PaymentsPolicyAcquiringRestriction => 'System',
            self::ReferToCardIssuer => 'Issuer',
            self::InvalidMerchantNumber => 'Issuer',
            self::PickUpCard => 'Issuer',
            self::DoNotHonor => 'Issuer',
            self::GeneralError => 'Issuer',
            self::InvalidTransaction => 'Issuer',
            self::InvalidAmount => 'System',
            self::InvalidCardNumber => 'User',
            self::InvalidIssuer => 'System',
            self::FormatError => 'System',
            self::LostCard => 'Issuer',
            self::StolenCard => 'User',
            self::InsufficientFunds => 'Issuer',
            self::ExpiredCard => 'User',
            self::FunctionNotPermittedToCardholder => 'Issuer',
            self::FunctionNotPermittedToTerminal => 'Issuer',
            self::WithdrawalLimitExceeded => 'Issuer',
            self::RestrictedCard => 'Issuer',
            self::IssuerResponseSecurityViolation => 'Issuer',
            self::SoftDecline => 'Issuer',
            self::CallIssuer => 'Issuer',
            self::PinEntryTriesExceeded => 'User',
            self::ToAccountIsInvalidOrNonExistent => 'System',
            self::SystemMalfunction => 'System',
            self::GenericError => 'System',
            self::SoftDecline2 => 'Issuer',
        };
    }

    public static function explanation(self $value): string
    {
        return match ($value) {
            self::Undefined => 'Undefined.',
            self::Incomplete3dsFlow => 'Browser closed before authentication finished.',
            self::Failed3DSValidation => 'Wrong password or two-factor auth code entered.',
            self::PaymentsPolicyAcquiringRestriction => 'Payments Policy Acquiring Restriction.',
            self::ReferToCardIssuer => 'The issuing bank prevented the transaction.',
            self::InvalidMerchantNumber => 'Security violation (source is not correct issuer).',
            self::PickUpCard => 'The card has been designated as lost or stolen.',
            self::DoNotHonor => 'The issuing bank declined the transaction without an explanation.',
            self::GeneralError => 'The card issuer has declined the transaction as there is a problem with the card number.',
            self::InvalidTransaction => 'The bank has declined the transaction because of an invalid format or field. This indicates the card details were incorrect.',
            self::InvalidAmount => 'The card issuer has declined the transaction because of an invalid format or field.',
            self::InvalidCardNumber => 'The card issuer has declined the transaction as the credit card number is incorrectly entered or does not exist.',
            self::InvalidIssuer => 'The card issuer doesn\'t exist.',
            self::FormatError => 'The card issuer does not recognise the transaction details being entered. This is due to a format error.',
            self::LostCard => 'The card issuer has declined the transaction as the card has been reported lost.',
            self::StolenCard => 'The card has been designated as lost or stolen.',
            self::InsufficientFunds => 'The card has insufficient funds to cover the cost of the transaction.',
            self::ExpiredCard => 'The payment gateway declined the transaction because the expiration date is expired or does not match.',
            self::FunctionNotPermittedToCardholder => 'The card issuer has declined the transaction as the credit card cannot be used for this type of transaction.',
            self::FunctionNotPermittedToTerminal => 'The card issuer has declined the transaction as the credit card cannot be used for this type of transaction.',
            self::WithdrawalLimitExceeded => 'Exceeds withdrawal amount limit.',
            self::RestrictedCard => 'The customer\'s bank has declined their card.',
            self::IssuerResponseSecurityViolation => 'Flag raised due to security validation problem.',
            self::SoftDecline => 'The issuer requests Strong Customer Authentication. The merchant should retry the transaction after successfully authenticating customer with 3DS first.',
            self::CallIssuer => 'Contact card issuer.',
            self::PinEntryTriesExceeded => 'Allowable number of PIN tries exceeded.',
            self::ToAccountIsInvalidOrNonExistent => 'Invalid OR non-existent \"to account\" specified.',
            self::SystemMalfunction => 'A temporary error occurred during the transaction.',
            self::GenericError => 'A temporary error occurred during the transaction.',
            self::SoftDecline2 => 'The issuer requests Strong Customer Authentication. The merchant should retry the transaction after successfully authenticating customer with 3DS first.',
        };
    }
}
