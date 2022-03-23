<?php

namespace Deyjandi\VivaWallet;

use Deyjandi\VivaWallet\Enums\PaymentMethod;
use Deyjandi\VivaWallet\Traits\FiltersUnsetData;
use Deyjandi\VivaWallet\Traits\HasClient;
use Deyjandi\VivaWallet\Traits\HasEnv;
use InvalidArgumentException;

class Payment
{
    use FiltersUnsetData;
    use HasClient;
    use HasEnv;

    /**
     * The amount associated with this payment order. Must be a positive, non-zero number.
     * The amount will be in the currency of the merchant account using the currency's smallest unit of measurement (e.g. cents of a euro).
     *
     * @example if you want to create a payment for €100.37, you need to pass the value 10037.
     */
    private int $amount;

    /**
     * This optional parameter adds a friendly description to the payment order that you want to display to the customer on the payment form.
     * It should be a short description of the items/services being purchased.
     *
     * Although optional, it is highly recommended to provide a description for the customer,
     * so that the customer knows what he is being asked to pay for; this affects significantly the conversion rate of your online store.
     */
    private ?string $customerTrns = null;

    /**
     * Information about the customer.
     */
    private ?Customer $customer = null;

    /**
     * The time given to the customer to complete the payment.
     * If the customer does not complete the payment within this time frame, the Payment Order is automatically cancelled.
     * By using this parameter, you can define a different life span for the Payment Order.
     *
     * Value is in seconds and can be either smaller or greater than 1800 secs.
     * Use value 65535 if you want the Payment Order to never expire.
     */
    private int $paymentTimeOut = 1800;

    /**
     * This will hold the selected amount as unavailable (without the customer being charged) for a period of time.
     * No email receipt is sent out from us in this case as it is not a charge.
     * To cancel a pre-auth, use the Cancel transaction API call in the same way that you would to reverse a payment.
     * To capture a pre-auth, use the Create transaction API call in the same way that you would to create a payment.
     * The payment method needs to have support for pre-auth transactions.
     *
     * If set to true, a pre-auth transaction will be performed.
     * Pre-authorizations are not available with recurring payments or instalments.
     */

    private bool $preauth = false;

    /**
     * If this parameter is set to true, recurring payments are enabled so that the initial transaction ID
     * can be used for subsequent payments.
     *
     * The payment method needs to have support for recurring payments.
     * Recurring payments are not available with pre-authorizations or instalments.
     */
    private bool $allowRecurring = false;

    /**
     * The maximum number of installments that the customer can choose for this transaction.
     *
     * If this parameter is omitted, the customer will not see an option for paying with installments.
     * The payment method needs to have support for installments.
     * Available only to merchants set up in Greece. Instalments are not available with recurring payments or pre-authorizations.
     */
    private int $maxInstallments = 0;

    /**
     * This is equivalent to sending a payment notification from the Viva Wallet banking app.
     *
     * If you wish to create a payment order, and then send out an email to the customer to request payment,
     * rather than immediately redirect the customer to the payment page to pay now,
     * set the value to true and the system will automatically send the customer an email notification.
     */
    private bool $paymentNotification = false;

    /**
     * The tip value which is already included in the amount of the payment order and marked as tip.
     *
     * It is in the currency of the merchant account using the currency's smallest unit of measurement (e.g. cents of a euro).
     */
    private ?int $tipAmount = 0;

    /**
     * If this parameter is set to true, then any amount specified in the payment order is ignored (although still mandatory)
     * and the customer is asked to indicate the amount they will pay.
     *
     * Note that if set to true, there will not be the option to pay with certain payment methods.
     */
    private bool $disableExactAmount = false;

    /**
     * Available only to merchants set up in Greece.
     *
     * If this parameter is set to true, the customer will not have the option to pay in cash at a Viva Spot
     * and the checkout page will not display the Cash (Viva Spot) and e-banking (ΔΙΑΣ) options.
     */
    private bool $disableCash = true;

    /**
     * Available only to merchants set up in Greece, Malta and Cyprus.
     *
     * If this parameter is set to true, the customer will not have the option to pay using their
     * Viva Wallet personal accountand the checkout page will not display the Viva Wallet option.
     */
    private bool $disableWallet = true;

    /**
     * This is the code of the payment source associated with the merchant.
     *
     * If the merchant has defined multiple payment sources in their account, you need to define the
     * sourceCode parameter when creating the payment order, so that the system selects the appropriate payment source.
     */
    private string $sourceCode;

    /**
     * This can be either an ID or a short description that helps you uniquely identify the transaction in the Viva Wallet banking app.
     *
     * For example, this can be the customer order reference number.
     * After logging in, go to Sales > Sales Transactions and find the transaction.
     * Click on the Info button against the item to display the Transaction Details dialog box.
     * The contents of the merchantTrns field will be displayed on the line below the timestamp information.
     */
    private ?string $merchantTrns = null;

    /**
     * You can add several tags to a transaction that will help in grouping and filtering in the Viva Wallet banking app.
     * After logging in, go to Sales > Sales Transactions and expand the Advanced search feature.
     * In the Tags field, enter the tag(s) you want to search with, then click on the Search button.
     */
    private ?array $tags = null;

    private ?string $brandColor = null;

    private ?PaymentMethod $preselectedPaymentMethod = null;

    public function setAmount(int $amount): static
    {
        if (strlen((string) $amount) > 30) {
            throw new InvalidArgumentException('Amount length must be less than or equal to 30.');
        } elseif ($amount <= 0) {
            throw new InvalidArgumentException('Amount must be a positive, non-zero number.');
        }

        $this->amount = $amount;

        return $this;
    }

    public function setCustomerTrns(?string $customerTrns): static
    {
        if (!$customerTrns && strlen($customerTrns) > 2048) {
            throw new InvalidArgumentException('CustomerTrns length must be less than or equal to 2048.');
        }

        $this->customerTrns = $customerTrns;

        return $this;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function setPaymentTimeout(int $paymentTimeOut): static
    {
        if ($paymentTimeOut <= 0) {
            throw new InvalidArgumentException('PaymentTimeOut must be greater than 0.');
        }

        $this->paymentTimeOut = $paymentTimeOut;

        return $this;
    }

    public function setPreauth(bool $preauth): static
    {
        $this->preauth = $preauth;

        return $this;
    }

    public function setAllowRecurring(bool $allowRecurring): static
    {
        $this->allowRecurring = $allowRecurring;

        return $this;
    }

    public function setMaxInstallments(int $maxInstallments): static
    {
        if ($maxInstallments < 0 || $maxInstallments > 36) {
            throw new InvalidArgumentException('maxInstallments value must be between 0 and 36');
        }

        $this->maxInstallments = $maxInstallments;

        return $this;
    }

    public function setPaymentNotification(bool $paymentNotification): static
    {
        $this->paymentNotification = $paymentNotification;

        return $this;
    }

    public function setTipAmount(?int $tipAmount): static
    {
        if ($tipAmount && $tipAmount < 0) {
            throw new InvalidArgumentException('tipAmount value must be greater than 0.');
        } elseif ($tipAmount > $this->amount) {
            throw new InvalidArgumentException('tipAmount value cannot exceed the amount value.');
        }

        $this->tipAmount = $tipAmount;

        return $this;
    }

    public function setDisableExactAmount(bool $disableExactAmount): static
    {
        $this->disableExactAmount = $disableExactAmount;

        return $this;
    }

    public function setDisableCash(bool $disableCash): static
    {
        $this->disableCash = $disableCash;

        return $this;
    }

    public function setDisableWallet(bool $disableWallet): static
    {
        $this->disableWallet = $disableWallet;

        return $this;
    }

    public function setSourceCode(string $sourceCode): static
    {
        $this->sourceCode = $sourceCode;

        return $this;
    }

    public function setMerchantTrns(?string $merchantTrns): static
    {
        if ($merchantTrns && strlen($merchantTrns) > 2048) {
            throw new InvalidArgumentException('merchantTrns value length must be less than or equal to 2048.');
        }

        $this->merchantTrns = $merchantTrns;

        return $this;
    }

    /**
     * @param ?array<string> $tags
     */
    public function setTags(?array $tags): static
    {
        if ($tags) {
            collect($tags)->each(function (mixed $tag) {
                if (!is_string($tag)) {
                    throw new InvalidArgumentException('tags must be an array of strings.');
                }
            });
        }

        $this->tags = $tags;

        return $this;
    }

    public function setBrandColor(?string $brandColor): static
    {
        $this->brandColor = str_starts_with($brandColor, '#') ? substr($brandColor, 1) : $brandColor;

        return $this;
    }

    public function setPreselectedPaymentMethod(null|string|PaymentMethod $paymentMethod): static
    {
        if ($paymentMethod && is_string($paymentMethod)) {
            $paymentMethod = PaymentMethod::from($paymentMethod);
        }

        $this->preselectedPaymentMethod = $paymentMethod;

        return $this;
    }

    public function __construct(int $amount, ?Customer $customer = null, ?array $config = null)
    {
        $this->setAmount($amount);

        if ($customer) {
            $this->setCustomer($customer);
        }

        if ($config) {
            $this->setConfig($config);
        }
    }

    public function setConfig(array $config): static
    {
        $configPayment = $config['payment'];

        $this
            ->setEnv($config['env'])
            ->setPreauth($configPayment['preauth'])
            ->setPaymentTimeOut($configPayment['timeout'])
            ->setDisableCash($configPayment['disable_cash'])
            ->setDisableWallet($configPayment['disable_wallet'])
            ->setSourceCode($configPayment['source_code'])
            ->setBrandColor($configPayment['brand_color'])
            ->setPreselectedPaymentMethod($configPayment['preselected_method']);

        return $this;
    }

    public function getCheckoutUrl(string $orderCode): string
    {
        $checkout_url = $this->env->checkout($orderCode);

        if ($this->brandColor) {
            $checkout_url .= "&color={$this->brandColor}";
        }

        if ($this->preselectedPaymentMethod) {
            $checkout_url .= "&paymentMethod={$this->preselectedPaymentMethod->value}";
        }

        return $checkout_url;
    }

    public function createOrder(): string
    {
        return $this->request(...$this->env->createOrder($this->toArray()))['orderCode'];
    }

    public function toArray(): array
    {
        return $this->filterUnsetData([
            'amount' => $this->amount,
            'customerTrns' => $this->customerTrns,
            'customer' => $this->customer?->toArray(),
            'paymentTimeOut' => $this->paymentTimeOut,
            'preauth' => $this->preauth,
            'allowRecurring' => $this->allowRecurring,
            'maxInstallments' => $this->maxInstallments,
            'paymentNotification' => $this->paymentNotification,
            'tipAmount' => $this->tipAmount,
            'disableExactAmount' => $this->disableExactAmount,
            'disableCash' => $this->disableCash,
            'disableWallet' => $this->disableWallet,
            'sourceCode' => $this->sourceCode,
            'merchantTrns' => $this->merchantTrns,
            'tags' => $this->tags,
        ]);
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
