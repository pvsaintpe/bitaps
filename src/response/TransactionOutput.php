<?php

namespace bitaps\response;

use bitaps\base\Object;

class TransactionOutput extends Object
{
    public $output_index;
    public $amount;
    public $address;

    /**
     * @var Script[]
     */
    public $script;
}