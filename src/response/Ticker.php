<?php

namespace bitaps\response;

use bitaps\base\Object;

class Ticker extends Object
{
     public $usd;

    /**
     * @var FxRate[]
     */
     public $fx_rates;

     public $market;
     public $timestamp;
}