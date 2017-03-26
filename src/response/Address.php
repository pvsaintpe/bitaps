<?php

namespace bitaps\response;

use bitaps\base\Object;

/**
 * Class Address
 * @package bitaps\response
 */
class Address extends Object
{
    /** @var int */
    public $received;

    /** @var int */
    public $tx_multisig_sent;

    /** @var int */
    public $tx_invalid;

    /** @var int */
    public $tx_multisig_received;

    /** @var int */
    public $sent;

    /** @var int */
    public $tx_unconfirmed;

    /** @var int */
    public $multisig_received;

    /** @var int */
    public $pending;

    /** @var int */
    public $tx_received;

    /** @var int */
    public $tx_total;

    /** @var int */
    public $confirmed_balance;

    /** @var int */
    public $multisig_sent;

    /** @var int */
    public $tx_sent;

    /** @var int */
    public $balance;
}