<?php

namespace bitaps;

use bitaps\base\Object;

class Error extends Object
{
    /** @var int */
    public $error_code;

    /** @var string */
    public $message;

    /** @var string */
    public $details;
}