<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

class QrCode extends Object
{
    public $message;
    public $qrcode;

    /**
     * @return string
     */
    public function getQrCodePng()
    {
        return BitAps::getQRCodePng($this->message);
    }
}