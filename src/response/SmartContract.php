<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

/**
 * @package response
 */
class SmartContract extends Object
{
    public $address;
    public $payment_code;
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

    /**
     * @return QrCode
     */
    public function getQrCode()
    {
        return BitAps::getQRCode($this->address);
    }

    /**
     * @return string
     */
    public function getQrCodePng()
    {
        return BitAps::getQRCodePng($this->address);
    }
}