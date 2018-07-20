<?php

namespace bitaps\response;

use bitaps\base\BaseObject;

/**
 * Class Address
 * @package bitaps\response
 */
class Address extends BaseObject
{
    public $received;
    public $tx_multisig_sent;
    public $tx_invalid;
    public $tx_multisig_received;
    public $sent;
    public $tx_unconfirmed;
    public $multisig_received;
    public $pending;
    public $tx_received;
    public $tx_total;
    public $confirmed_balance;
    public $multisig_sent;
    public $tx_sent;
    public $balance;
}