<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

class TransactionOutput extends Object
{
    /** @var int */
    public $output_index;

    /** @var int */
    public $amount;

    /** @var array */
    public $address;

    /**
     * @var \bitaps\response\Script[]
     */
    public $script;

    /**
     * @return Address[]
     */
    public function getAddresses()
    {
        $addresses = [];
        foreach ($this->address as $address) {
            $addresses[] = BitAps::getAddress($address);
        }
        return $addresses;
    }
}