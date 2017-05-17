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

/**
 * Чек (Redeem code) очень похож на обычный Биткоин кошелек.
 * Вы можете получать на его сгенерированный Биткоин адрес, проверять баланс и отправлять не обходимую вам сумму.
 *
 * Результатом выполнения являются три значения: сгенерированный адрес для приёма оплаты, код платежа и счёт.
 * Код платежа это личная информация для продавца, которая должна храниться в секрете.
 * Счёт может быть отправлен покупателю и/или будет использован для платёжной формы.
 * Чек (Redeem code) используется для погашения баланса (пересылки денег) с этого чека на любой другой адрес.
 *
 * @package response
 */
class Cheque extends Object
{
    public $address;
    public $redeem_code;
    public $invoice;

    /**
     * @return Address
     */
    public function getAddress()
    {
        return BitAps::getAddress($this->address);
    }

    /**
     * @param int $offset
     * @param string $type
     * @param string $status
     * @return mixed
     */
    public function getAddressTransactions($offset = 0, $type = 'all', $status = 'all')
    {
        return BitAps::getAddressTransactions($this->address, $offset, $type, $status);
    }

    /**
     * @return RedeemCode
     */
    public function getRedeemCode()
    {
        return BitAps::getRedeemCode($this->redeem_code);
    }

    /**
     * @param string $address
     * @param string $amount
     * @param string $fee_level
     * @param bool $custom_fee
     * @return TransactionResult
     */
    public function useRedeemCode($address, $amount = 'All avaliable', $fee_level = 'low', $custom_fee = false)
    {
        return BitAps::useRedeemCode($this->redeem_code, $address, $amount, $fee_level, $custom_fee);
    }

    /**
     * @param int $amount
     * @param string $label
     * @param string $message
     * @return QrCode
     */
    public function getQrCode($amount = null, $label = null, $message = null)
    {
        return BitAps::getQRCode($this->address, $amount, $label, $message);
    }

    /**
     * @param int $amount
     * @param string $label
     * @param string $message
     * @return string
     */
    public function getQrCodePng($amount = null, $label = null, $message = null)
    {
        return BitAps::getQRCodePng($this->address, $amount, $label, $message);
    }
}