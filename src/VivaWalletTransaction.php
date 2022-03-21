<?php

namespace Deyjandi\VivaWallet;

use Deyjandi\VivaWallet\Traits\HasClient;
use Deyjandi\VivaWallet\Traits\HasEnv;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class VivaWalletTransaction
{
    use HasClient;
    use HasEnv;

    public function __construct(array $config)
    {
        $this->setEnv($config['env']);
    }

    /**
     * Enables you to obtain detailed information about a past payment from its transaction ID.
     *
     * @see https://developer.vivawallet.com/apis-for-payments/payment-api/#tag/Transactions/paths/~1checkout~1v2~1transactions~1{transactionId}/get
     */
    public function retrieve(string $transactionId): array
    {
        if (! Uuid::isValid($transactionId)) {
            throw new InvalidArgumentException('Transaction id is invalid.');
        }

        return $this->request(...$this->env->retrieveTransaction($transactionId));
    }
}
