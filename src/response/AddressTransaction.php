<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

/**
 * Class AddressTransaction
 * @package bitaps\response
 */
class AddressTransaction extends Object
{
    public $timestamp;
    public $hash;
    public $data;
    public $type;
    public $status;
    public $confirmations;
    public $block;
    public $amount;

    /**
     * @return Block
     */
    public function getBlock()
    {
        return BitAps::getBlock($this->block);
    }

    /**
     * @return Transaction
     */
    public function Transaction()
    {
        return BitAps::getTransaction($this->hash);
    }
}