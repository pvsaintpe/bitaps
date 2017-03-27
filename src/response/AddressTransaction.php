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
    /** @var int */
    public $timestamp;

    /** @var string */
    public $hash;

    /** @var string */
    public $data;

    /** @var string */
    public $type;

    /** @var string */
    public $status;

    /** @var int */
    public $confirmations;

    /** @var int */
    public $block;

    /** @var int */
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