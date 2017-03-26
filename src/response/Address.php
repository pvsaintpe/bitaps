<?php

namespace bitaps\response;

use bitaps\base\Object;

/**
 * Class Address
 * @package bitaps\response
 */
class Address extends Object
{
    public $balance;
    public $confirmed_balance;
    public $received;
    public $sent;
    public $pending;
    public $multisig_received;
    public $multisig_sent;
    public $tx_received;
    public $tx_sent;
    public $tx_multisig_received;
    public $tx_multisig_sent;
    public $tx_unconfirmed;
    public $tx_invalid;
}