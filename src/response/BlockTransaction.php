<?php

namespace bitaps\response;

use bitaps\base\BaseObject;
use bitaps\BitAps;

/**
 * Class BlockTransaction
 * @package bitaps\response
 */
class BlockTransaction extends BaseObject
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