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

class Block extends Object
{
    public $version;
    public $previuos_block_hash;
    public $next_block_hash;
    public $height;
    public $bits;
    public $size;
    public $miner;
    public $merkleroot;
    public $transactions;
    public $hash;
    public $timestamp;
    public $nonce;
    public $coinbase;

    /**
     * @return Block
     */
    public function getPreviousBlock()
    {
        return BitAps::getBlock($this->previuos_block_hash);
    }

    /**
     * @return BlockTransaction[]
     */
    public function getTransactions()
    {
        return BitAps::getBlockTransactions($this->hash);
    }

    /**
     * @return Block
     */
    public function getNextBlock()
    {
        return BitAps::getBlock($this->next_block_hash);
    }
}