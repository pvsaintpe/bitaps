<?php

namespace bitaps\response;

use bitaps\base\Object;

class QrCode extends Object
{
    /** @var string */
    public $message;

    /** @var string */
    public $qrcode;
}