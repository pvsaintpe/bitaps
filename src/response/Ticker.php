<?php

namespace bitaps\response;

use bitaps\base\BaseObject;

class Ticker extends BaseObject
{
     public $usd;

    /**
     * @var \bitaps\response\FxRate[]
     */
     public $fx_rates;

     public $market;
     public $timestamp;
}