<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

/**
 * Class TransactionRawResult
 * @package bitaps\response
 */
class TransactionRawResult extends Object
{
    /**
     * @var string
     */
    public $hash;

    /**
     * @var string
     */
    public $hex;

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return BitAps::getTransaction($this->hash);
    }
}