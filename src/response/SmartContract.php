<?php

namespace bitaps\response;

use bitaps\base\BaseObject;
use bitaps\BitAps;

/**
 * @package response
 */
class SmartContract extends BaseObject
{
    public $address;
    public $payment_code;
    public $invoice;
    public $currency;
    public $amount;
    public $share_type;
    public $domain;
    public $domain_hash;
    public $confirmations;
    public $callback_link;
    public $forwarding_address_primary;
    public $forwarding_address_secondary;
    public $forwarding_address_primary_share;

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
     * @param int $amount
     * @param string $label
     * @param string $message
     * @return QrCode
     */
    public function getQrCode($amount = null, $label = null, $message = null)
    {
        return BitAps::getQRCode($this->address, $amount, $label, $message);
    }

    /**
     * @param int $amount
     * @param string $label
     * @param string $message
     * @return string
     */
    public function getQrCodePng($amount = null, $label = null, $message = null)
    {
        return BitAps::getQRCodePng($this->address, $amount, $label, $message);
    }
}
