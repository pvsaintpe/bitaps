<?php

namespace bitaps\response;

use bitaps\base\BaseObject;
use bitaps\BitAps;

class TransactionInput extends BaseObject
{
    /**
     * @var \bitaps\response\Script[]
     */
    public $sig_script;

    /**
     * @var \bitaps\response\Script[]
     */
    public $script;

    public $transaction_hash;
    public $hash;
    public $sequence;
    public $amount;
    public $input_index;
    public $output_index;
    public $out_index;
    public $address;

    /**
     * @var \bitaps\response\Script[]
     */
    public $redeem_script;

    /**
     * @todo уточнить у BitAps какой хеш актуален
     * @return Transaction
     */
    public function getTransaction1()
    {
        return BitAps::getTransaction($this->hash);
    }

    /**
     * @todo уточнить у BitAps какой хеш актуален
     * @return Transaction
     */
    public function getTransaction2()
    {
        return BitAps::getTransaction($this->transaction_hash);
    }

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