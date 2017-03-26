<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

/**
 * Class RedeemCode
 * @package bitaps\response
 */
class RedeemCode extends Object
{
    /**
     * неподтверждённый баланс
     * @var int
     */
    public $pending_balance;

    /**
     * оплаченная сумма
     * @var int
     */
    protected $paid_out;

    /**
     * текущий баланс
     * @var int
     */
    public $balance;

    /**
     * адрес получателя
     * @var string
     */
    public $address;

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
     *
     * @return AddressTransaction[]
     */
    public function getAddressTransactions($offset = 0, $type = 'all', $status = 'all')
    {
        return BitAps::getAddressTransactions($this->address, $offset, $type, $status);
    }
}