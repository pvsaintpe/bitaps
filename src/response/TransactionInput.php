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

class TransactionInput extends Object
{
    /**
     * @var \bitaps\response\Script[]
     */
    public $sig_script;

    /**
     * @var \bitaps\response\Script[]
     */
    public $script;

    public $transaction_hash;
    public $hash;
    public $sequence;
    public $amount;
    public $input_index;
    public $output_index;
    public $out_index;
    public $address;

    /**
     * @var \bitaps\response\Script[]
     */
    public $redeem_script;

    /**
     * @todo уточнить у BitAps какой хеш актуален
     * @return Transaction
     */
    public function getTransaction1()
    {
        return BitAps::getTransaction($this->hash);
    }

    /**
     * @todo уточнить у BitAps какой хеш актуален
     * @return Transaction
     */
    public function getTransaction2()
    {
        return BitAps::getTransaction($this->transaction_hash);
    }

    /**
     * @return Address[]
     */
    public function getAddresses()
    {
        $addresses = [];
        foreach ($this->address as $address) {
            $addresses[] = BitAps::getAddress($address);
        }
        return $addresses;
    }
}