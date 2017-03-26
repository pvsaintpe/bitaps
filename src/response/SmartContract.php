<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

/**
 * @package response
 */
class SmartContract extends Object
{
    /**
     * адрес для приёма оплаты
     * @var string
     */
    public $address;

    /**
     * код платежа
     * @var string
     */
    public $payment_code;

    /**
     * счёт
     * @var string
     */
    public $invoice;

    /**
     * @return Address
     */
    public function getAddress()
    {
        return BitAps::getAddress($this->address);
    }

    /**
     * @param int $offset
     * @param string $type
     * @param string $status
     * @return mixed
     */
    public function getAddressTransactions($offset = 0, $type = 'all', $status = 'all')
    {
        return BitAps::getAddressTransactions($this->address, $offset, $type, $status);
    }

}