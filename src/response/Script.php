<?php

namespace bitaps\response;

use bitaps\base\Object;

class Script extends Object
{
    /** @var string */
    public $type;

    /** @var string */
    public $hex;

    /** @var string */
    public $asm;

    /** @var string */
    public $pettern;
}