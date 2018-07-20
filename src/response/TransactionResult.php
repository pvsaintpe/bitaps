<?php

namespace bitaps\response;

use bitaps\base\BaseObject;
use bitaps\BitAps;

/**
 * Class TransactionResult
 * @package bitaps\response
 */
class TransactionResult extends BaseObject
{
    public $tx_hash;
    public $fee;
    public $status;

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return BitAps::getTransaction($this->tx_hash);
    }
}