<?php

namespace bitaps\callback;

use bitaps\base\Object;
use bitaps\BitAps;

class Response extends Object
{
    public $tx_hash;
    public $address;
    public $invoice;
    public $code;
    public $amount;
    public $confirmations;
    public $payout_tx_hash;
    public $payout_miner_fee;
    public $payout_service_fee;

    /**
     * @return \bitaps\response\Transaction
     */
    public function getTransaction()
    {
        return BitAps::getTransaction($this->tx_hash);
    }

    /**
     * @return \bitaps\response\Address
     */
    public function getAddress()
    {
        return BitAps::getAddress($this->address);
    }

    /**
     * @param int $offset
     * @param string $type
     * @param string $status
     * @return \bitaps\response\AddressTransaction[]
     */
    public function getAddressTransactions($offset = 0, $type = 'all', $status = 'all')
    {
        return BitAps::getAddressTransactions($this->address, $offset, $type, $status);
    }

    /**
     * @return \bitaps\response\Transaction
     */
    public function getPayoutTransaction()
    {
        return BitAps::getTransaction($this->payout_tx_hash);
    }
}