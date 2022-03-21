<?php

namespace Deyjandi\VivaWallet;

use Deyjandi\VivaWallet\Enums\VivaWalletRequestLang;
use Deyjandi\VivaWallet\Traits\FiltersUnsetData;
use InvalidArgumentException;

/**
 * Information about the customer.
 */
class VivaWalletCustomer
{
    use FiltersUnsetData;

    private const EX_CODE = 500;
    /**
     * The customer's e-mail address, used on the payment form.
     */
    private ?string $email;

    /**
     * The customer's full name, used on the payment form.
     */
    private ?string $fullName;

    /**
     * The customer's telephone number for inclusion in the sales transaction details in the Viva Wallet banking app.
     */
    private ?string $phone;

    /**
     * The country code of the customer.
     *
     * If left unspecified it is filled with the country code of the merchant.
     * Consists of two-letter ISO 3166-1 alpha-2 country code.
     */
    private ?string $countryCode;

    /**
     * The language (culture info) of the order.
     *
     * It determines the language that Smart Checkout will appear in, and so on.
     * If left unspecified it is filled based on the countryCode property.
     */
    private ?VivaWalletRequestLang $requestLang;

    public function __construct(
        ?string $email = null,
        ?string $fullName = null,
        ?string $phone = null,
        ?string $countryCode = null,
        ?VivaWalletRequestLang $requestLang = null,
    ) {
        $this->setEmail($email)
            ->setFullName($fullName)
            ->setPhone($phone)
            ->setCountryCode($countryCode)
            ->setRequestLang($requestLang);
    }

    public function toArray(): array
    {
        return $this->filterUnsetData([
            'email' => $this->email,
            'fullName' => $this->fullName,
            'phone' => $this->phone,
            'countryCode' => $this->countryCode,
            'requestLang' => $this->requestLang,
        ]);
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function setEmail(?string $email): static
    {
        if ($email && strlen($email) > 50) {
            throw new InvalidArgumentException('Customer\'s email value must be less than 50 characters.', self::EX_CODE);
        }

        $this->email = $email;

        return $this;
    }

    public function setFullName(?string $fullName): static
    {
        if ($fullName && strlen($fullName) > 50) {
            throw new InvalidArgumentException('Customer\'s email value must be less than 50 characters.', self::EX_CODE);
        }

        $this->fullName = $fullName;

        return $this;
    }

    public function setPhone(?string $phone): static
    {
        if ($phone && strlen($phone) > 30) {
            throw new InvalidArgumentException('Customer\'s phone value must be less than 30 characters.', self::EX_CODE);
        }

        $this->phone = $phone;

        return $this;
    }

    public function setCountryCode(?string $countryCode): static
    {
        if ($countryCode && strlen($countryCode) !== 2) {
            throw new InvalidArgumentException('Customer\'s country code value is invalid.', self::EX_CODE);
        }

        $this->countryCode = $countryCode;

        return $this;
    }

    public function setRequestLang(?VivaWalletRequestLang $requestLang): static
    {
        $this->requestLang = $requestLang;

        return $this;
    }
}
