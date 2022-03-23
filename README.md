
# Implementation of Viva Wallet's API for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/deyjandi/laravel-viva-wallet.svg?style=flat-square)](https://packagist.org/packages/deyjandi/laravel-viva-wallet)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/deyjandi/laravel-viva-wallet/run-tests?label=tests)](https://github.com/deyjandi/laravel-viva-wallet/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/deyjandi/laravel-viva-wallet/Check%20&%20fix%20styling?label=code%20style)](https://github.com/deyjandi/laravel-viva-wallet/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/deyjandi/laravel-viva-wallet.svg?style=flat-square)](https://packagist.org/packages/deyjandi/laravel-viva-wallet)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.


## Installation steps

### 1. install the package via composer:

```bash
composer require deyjandi/laravel-viva-wallet
```

### 2. Publish the `config` file with:

```bash
php artisan vendor:publish --tag="viva-wallet-config"
```

### 3. Add at minimum the following to the `.env` file
```bash
VIVA_WALLET_MERCHANT_ID=<your-merchant-id>
VIVA_WALLET_API_KEY=<your-api-id>
VIVA_WALLET_CLIENT_ID=<your-smart-checkout-client-id>
VIVA_WALLET_CLIENT_SECRET=<your-smart-checkout-secret>
```
You can refer to the `./config/viva-wallet-config.php` for additional configuration options

## Usage


### Create a Payment Order using the default configuration:

```php
...
use Deyjandi\VivaWallet\Facades\VivaWallet;
use Deyjandi\VivaWallet\Payment;

...

$payment = new Payment($amount = 1000);

$checkoutUrl = VivaWallet::createPaymentOrder($payment);

...
```

### Create a Payment Order specifying every configurable option:

```php
...
use Deyjandi\VivaWallet\Enums\RequestLang;
use Deyjandi\VivaWallet\Enums\PaymentMethod;
use Deyjandi\VivaWallet\Facades\VivaWallet;
use Deyjandi\VivaWallet\Customer;
use Deyjandi\VivaWallet\Payment;

...

$customer = new Customer(
    $email = 'example@test.com',
    $fullName = 'John Doe',
    $phone = '+306987654321',
    $countryCode = 'GR',
    $requestLang = RequestLang::Greek,
);

$payment = new Payment();

$payment
    ->setAmount(2500)
    ->setCustomerTrns('short description of the items/services being purchased')
    ->setCustomer($customer)
    ->setPaymentTimeout(3600)
    ->setPreauth(false)
    ->setAllowRecurring(true)
    ->setMaxInstallments(3)
    ->setPaymentNotification(true)
    ->setTipAmount(250)
    ->setDisableExactAmount(false)
    ->setDisableCash(true)
    ->setDisableWallet(false)
    ->setSourceCode(1234)
    ->setMerchantTrns('customer order reference number')
    ->setTags(['tag-1', 'tag-2'])
    ->setBrandColor('009688')
    ->setPreselectedPaymentMethod(PaymentMethod::PayPal);

$checkoutUrl = VivaWallet::createPaymentOrder($payment);

...
```


### Request a webhook verification key:
```bash
php artisan viva-wallet:webhook-key
```
#### the webhook verification key is stored to the `.env` file automatically


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Pavlos Kafritsas](https://github.com/Deyjandi)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
