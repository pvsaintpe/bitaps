<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

class QrCode extends Object
{
    public $message;
    public $qrcode;

    /**
     * @param int $amount
     * @param string $label
     * @param string $message
     * @return string
     */
    public function getQrCodePng($amount = null, $label = null, $message = null)
    {
        return BitAps::getQRCodePng($this->message, $amount, $label, $message);
    }
}