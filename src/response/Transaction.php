<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

if (class_exists('\bitaps\base\Object')) {

} else {
    require_once __DIR__ . '/../base/Object.php';
    require_once __DIR__ . '/../BitAps.php';
    require_once __DIR__ . '/Address.php';
    require_once __DIR__ . '/AddressTransaction.php';
    require_once __DIR__ . '/Block.php';
    require_once __DIR__ . '/BLockSize.php';
    require_once __DIR__ . '/BlockTime.php';
    require_once __DIR__ . '/BlockTransaction.php';
    require_once __DIR__ . '/Cheque.php';
    require_once __DIR__ . '/Difficulty.php';
    require_once __DIR__ . '/Fee.php';
    require_once __DIR__ . '/HashRate.php';
    require_once __DIR__ . '/QrCode.php';
    require_once __DIR__ . '/RedeemCode.php';
    require_once __DIR__ . '/SmartContract.php';
    require_once __DIR__ . '/Ticker.php';
    require_once __DIR__ . '/Transaction.php';
    require_once __DIR__ . '/TransactionRawResult.php';
    require_once __DIR__ . '/TransactionResult.php';
    require_once __DIR__ . '/TxRate.php';
    require_once __DIR__ . '/../callback/Response.php';
}

class Transaction extends Object
{
    public $size;
    public $locktime;

    /**
     * @var \bitaps\response\TransactionInput[]
     */
    public $input;
    public $block;
    public $coinbase;

    /**
     * @var \bitaps\response\TransactionOutput[]
     */
    public $output;
    public $fee;
    public $hash;
    public $timestamp;
    public $data;
    public $version;

    /**
     * @return Block
     */
    public function getBlock()
    {
        return BitAps::getBlock($this->block);
    }

}