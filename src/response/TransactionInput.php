<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

class TransactionInput extends Object
{
    /**
     * @var \bitaps\response\Script[]
     */
    public $sig_script;

    /**
     * @var \bitaps\response\Script[]
     */
    public $script;

    /**
     * @var string
     */
    public $transaction_hash;

    /**
     * @var string
     */
    public $hash;

    /**
     * @var string
     */
    public $sequence;

    /**
     * @var int
     */
    public $amount;

    /**
     * @var int
     */
    public $input_index;

    /**
     * @var string
     */
    public $output_index;

    /**
     * @var string
     */
    public $out_index;

    /**
     * @var array
     */
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