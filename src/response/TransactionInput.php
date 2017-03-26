<?php

namespace bitaps\response;

use bitaps\base\Object;

class TransactionInput extends Object
{
    /**
     * @var string
     */
    public $input_index;

    /**
     * @var string
     */
    public $sequence;

    /**
     * @var string
     */
    public $hash;

    /**
     * @var string
     */
    public $out_index;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var string
     */
    public $address;

    /**
     * @var \bitaps\response\Script[]
     */
    public $script;

    /**
     * @var \bitaps\response\Script[]
     */
    public $sig_script;

    /**
     * @var \bitaps\response\Script[]
     */
    public $redeem_script;
}