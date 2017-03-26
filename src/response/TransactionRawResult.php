<?php

namespace bitaps\response;

use bitaps\base\Object;

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

}