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
    /** @var string */
    public $transaction;

    /** @var string */
    public $block_data_hex;

    /** @var int */
    public $amount;

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return BitAps::getTransaction($this->transaction);
    }
}