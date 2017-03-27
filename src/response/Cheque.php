<?php

namespace bitaps\response;

use bitaps\base\Object;
use bitaps\BitAps;

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
    /**
     * адрес для приёма оплаты
     * @var string
     */
    public $address;

    /**
     * код платежа
     * @var string
     */
    public $redeem_code;

    /**
     * счёт
     * @var string
     */
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
     * @return QrCode
     */
    public function getQrCode()
    {
        return BitAps::getQRCode($this->address);
    }

    /**
     * @return string
     */
    public function getQrCodePng()
    {
        return BitAps::getQRCodePng($this->address);
    }
}