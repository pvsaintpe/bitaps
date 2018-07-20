<?php

namespace bitaps\response;

use bitaps\base\BaseObject;
use bitaps\BitAps;

/**
 * Class TransactionRawResult
 * @package bitaps\response
 */
class TransactionRawResult extends BaseObject
{
    public $hash;
    public $hex;

    /**
     * @return Transaction
     */
    public function getTransaction()
    {
        return BitAps::getTransaction($this->hash);
    }
}