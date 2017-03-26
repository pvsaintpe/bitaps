<?php

namespace bitaps\response;

use bitaps\base\Object;

class Fee extends Object
{
    /** @var int */
    public $high;

    /** @var int */
    public $medium;

    /** @var int */
    public $low;
}