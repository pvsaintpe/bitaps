<?php

namespace bitaps\callback;

use bitaps\base\Object;
use bitaps\BitAps;

if (class_exists('\bitaps\base\Object')) {

} else {
    require_once __DIR__ . '/../base/Object.php';
    require_once __DIR__ . '/../BitAps.php';
    require_once __DIR__ . '/../response/Address.php';
    require_once __DIR__ . '/../response/AddressTransaction.php';
    require_once __DIR__ . '/../response/Block.php';
    require_once __DIR__ . '/../response/BLockSize.php';
    require_once __DIR__ . '/../response/BlockTime.php';
    require_once __DIR__ . '/../response/BlockTransaction.php';
    require_once __DIR__ . '/../response/Cheque.php';
    require_once __DIR__ . '/../response/Difficulty.php';
    require_once __DIR__ . '/../response/Fee.php';
    require_once __DIR__ . '/../response/HashRate.php';
    require_once __DIR__ . '/../response/QrCode.php';
    require_once __DIR__ . '/../response/RedeemCode.php';
    require_once __DIR__ . '/../response/SmartContract.php';
    require_once __DIR__ . '/../response/Ticker.php';
    require_once __DIR__ . '/../response/Transaction.php';
    require_once __DIR__ . '/../response/TransactionRawResult.php';
    require_once __DIR__ . '/../response/TransactionResult.php';
    require_once __DIR__ . '/../response/TxRate.php';
}

class Response extends Object
{
    public $tx_hash;
    public $address;
    public $invoice;
    public $code;
    public $amount;
    public $confirmations;
    public $payout_tx_hash;
    public $payout_miner_fee;
    public $payout_service_fee;

    /**
     * @return \bitaps\response\Transaction
     */
    public function getTransaction()
    {
        return BitAps::getTransaction($this->tx_hash);
    }

    /**
     * @return \bitaps\response\Address
     */
    public function getAddress()
    {
        return BitAps::getAddress($this->address);
    }

    /**
     * @param int $offset
     * @param string $type
     * @param string $status
     * @return \bitaps\response\AddressTransaction[]
     */
    public function getAddressTransactions($offset = 0, $type = 'all', $status = 'all')
    {
        return BitAps::getAddressTransactions($this->address, $offset, $type, $status);
    }

    /**
     * @return \bitaps\response\Transaction
     */
    public function getPayoutTransaction()
    {
        return BitAps::getTransaction($this->payout_tx_hash);
    }
}