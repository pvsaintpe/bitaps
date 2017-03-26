<?php

namespace bitaps\response;

use bitaps\base\Object;

/**
 * Class BlockTransaction
 * @package bitaps\response
 */
class BlockTransaction extends Object
{
    public $transaction;
    public $block_data_hex;
    public $amount;
}