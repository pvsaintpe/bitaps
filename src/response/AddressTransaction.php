<?php

namespace bitaps\response;

use bitaps\base\Object;

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
}