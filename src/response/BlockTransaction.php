<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

/**
 * Class BlockTransaction
 * @package bitaps\response
 */
class BlockTransaction extends Object
{
    public $transaction;
    public $block_data_hex;
    public $amount;

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return BitAps::getTransaction($this->transaction);
    }
}