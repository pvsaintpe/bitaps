<?php

namespace bitaps\response;

use bitaps\base\Object;

class Transaction extends Object
{
    public $hash;
    public $data;
    public $coinbase;
    public $block;
    public $version;
    public $size;
    public $timestamp;

    /**
     * @var TransactionInput[]
     */
    public $inputs;

    /**
     * @var TransactionOutput[]
     */
    public $outputs;

}