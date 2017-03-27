<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

/**
 * Class TransactionResult
 * @package bitaps\response
 */
class TransactionResult extends Object
{
    /**
     * @var string
     */
    public $tx_hash;

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return BitAps::getTransaction($this->tx_hash);
    }
}