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
    public $pending_balance;
    public $paid_out;
    public $balance;
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

    /**
     * @param $redeem_code
     * @param $amount
     * @param string $fee_level
     * @param bool $custom_fee
     * @return TransactionResult
     */
    public function useRedeemCode($redeem_code, $amount, $fee_level = 'low', $custom_fee = false)
    {
        return BitAps::useRedeemCode($redeem_code, $this->address, $amount, $fee_level, $custom_fee);
    }
}