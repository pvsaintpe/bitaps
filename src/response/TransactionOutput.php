<?php

namespace bitaps\response;

use bitaps\base\BaseObject;
use bitaps\BitAps;

class TransactionOutput extends BaseObject
{
    public $output_index;
    public $amount;
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