<?php

use Deyjandi\VivaWallet\Enums\PaymentMethod;

return [

    /*
    |--------------------------------------------------------------------------
    | Viva Wallet Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the target environment for every HTTP request.
    |
    | Available values: "demo" / "live".
    */
    'env' => env('VIVA_WALLET_ENV', 'live'),

    /*
    |--------------------------------------------------------------------------
    | Merchant ID
    |--------------------------------------------------------------------------
    |
    | Your merchant id value which is generated upon account creation.
    |
    | @see https://developer.vivawallet.com/getting-started/find-your-merchant-id-and-api-key/
    */
    'merchant_id' => env('VIVA_WALLET_MERCHANT_ID'),

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Your api key value.
    |
    | @see https://developer.vivawallet.com/getting-started/find-your-merchant-id-and-api-key/
    */
    'api_key' => env('VIVA_WALLET_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Client ID
    |--------------------------------------------------------------------------
    |
    | Your client id value.
    |
    | @see https://developer.vivawallet.com/getting-started/find-your-client-credentials/
    */
    'client_id' => env('VIVA_WALLET_CLIENT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Client Secret
    |--------------------------------------------------------------------------
    |
    | Your client secret value.
    |
    | @see https://developer.vivawallet.com/getting-started/find-your-client-credentials/
    */
    'client_secret' => env('VIVA_WALLET_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Webhook Verification Key
    |--------------------------------------------------------------------------
    |
    | Your webhook verification key value.
    |
    | You can request a webhook verification key by using this command:
    | `php artisan viva-wallet:request webhook-key`
    |
    | This command stores the webhook verification key in to the ".env" file.
    |
    | @see https://developer.vivawallet.com/webhooks-for-payments/setup-webhooks/#generate-a-webhook-verification-key
    */
    'webhook_key' => env('VIVA_WALLET_WEBHOOK_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Guzzle Http Client Default Options
    |--------------------------------------------------------------------------
    |
    | Here you can specify the default options for the guzzle http client.
    |
    | This value will affect every HTTP request the package makes.
    |
    | @see https://docs.guzzlephp.org/en/stable/quickstart.html#creating-a-client
    */
    'http_client' => [

        'headers' => [
            'Accept' => 'application/json',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Create Payment Order Default Options
    |--------------------------------------------------------------------------
    |
    | Here you can specify the default options for every
    | \Deyjandi\VivaWallet\Facades\VivaWallet::createPaymentOrder() request.
    |
    | @see https://developer.vivawallet.com/apis-for-payments/payment-api/#tag/Payments
    | @see https://developer.vivawallet.com/smart-checkout/smart-checkout-implementation/
    */
    'payment' => [

        'preauth' => (bool) env('VIVA_WALLET_PAYMENT_PREAUTH', false),

        'timeout' => (int) env('VIVA_WALLET_PAYMENT_TIMEOUT', 1800),

        'disable_cash' => (bool) env('VIVA_WALLET_PAYMENT_DISABLE_CASH', true),

        'disable_wallet' => (bool) env('VIVA_WALLET_DISABLE_WALLET', true),

        'source_code' => env('VIVA_WALLET_PAYMENT_SOURCE_CODE'),

        'brand_color' => env('VIVA_WALLET_PAYMENT_BRAND_COLOR', '06abc1'),

        'preselected_method' => env('VIVA_WALLET_PAYMENT_PRESELECTED_METHOD', PaymentMethod::CreditCard)

    ],
];
