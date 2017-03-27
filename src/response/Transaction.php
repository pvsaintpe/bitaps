<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

class Transaction extends Object
{
    /** @var int */
    public $size;

    /** @var int */
    public $locktime;

    /**
     * @var \bitaps\response\TransactionInput[]
     */
    public $input;

    /** @var int */
    public $block;

    /** @var boolean */
    public $coinbase;

    /**
     * @var \bitaps\response\TransactionOutput[]
     */
    public $output;

    /** @var int */
    public $fee;

    /** @var string */
    public $hash;

    /** @var int */
    public $timestamp;

    /** @var string */
    public $data;

    /** @var string */
    public $version;

    /**
     * @return Block
     */
    public function getBlock()
    {
        return BitAps::getBlock($this->block);
    }

}