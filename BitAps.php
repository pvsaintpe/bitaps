<?php
/**
 * Created by PhpStorm.
 * User: pveselov
 * Date: 26.03.17
 * Time: 16:07
 */

namespace api\components;

use backend\helpers\Html;
use Yii;

/**
 * Class BitAps
 *
 * @see https://bitaps.com/ru/api
 *
 * @package api\components
 */
class BitAps
{
    /**
     * Размер комиссии сервиса:
     * @example (20000 сатоши, 0.0002 BTC, 200 XBT)
     */
    CONST COMMISSION_AMOUNT = 0.0002;

    /**
     * Комиссия не взимается с платежей менее:
     * @example (100000 сатоши, 0.001 BTC, 1000 XBT)
     */
    CONST AMOUNT_WITHOUT_COMMISSION = 0.001;

    /**
     * Минимальная сумма для процессинга платежей:
     * @example (30000 Сатоши, 0.0003 BTC, 300 XBT)
     */
    CONST AMOUNT_LIMIT = 0.0003;

    /**
     * @return array
     */
    private function getErrors()
    {
        return [
            '200' => Yii::t('errors', 'Запрос успешно выполнен'),
            '400' => Yii::t('errors', 'Неверный запрос'),
            '401' => Yii::t('errors', 'Запрос не авторизован'),
            '402' => Yii::t('errors', 'Ошибочный запрос'),
            '403' => Yii::t('errors', 'Запрещено'),
            '404' => Yii::t('errors', 'Ресурс не найден'),
            '50x' => Yii::t('errors', 'Ошибка сервера'),
        ];
    }

    /**
     * @param string $url
     * @param array $params []
     * @param array|boolean $post false
     *
     * @todo доделать обработку ошибок
     * @todo возможно GET-запросы тоже через cURL сделать
     *
     * @return mixed
     */
    private function getResponse($url, $params = [], $post = false)
    {
        $url .= (($queryString = http_build_query($params)) ? '?' . $queryString : '');

        if ($post === false) {
            $response = file_get_contents($url);
        } else {
            $post = array_filter($post, function($value) {
                return ($value === false) ? false : true;
            });

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
        }

        return json_decode($response, true);
    }

    /**
     * Создать смартконтракт (поддержание баланса на горячем кошельке):
     * Создать смартконтракт (оплата по списку получателей):
     *
     * обратный отклик на указанную ссылку (urlencoded callback - стандарт кодирования строки URL)
     * @param string {callback}	URL
     *
     * @param array $post
     *
     * число принятых подтверждений платежа в сети Биткоин (опциональное поле, по умолчанию - 3)
     * @param integer [confirmations] 0-10
     *
     * Уровень комиссии сети (Опциональное поле, по умолчанию low)
     * @param string [fee_level] high|medium|low
     *
     * @return array
     * @example array(
     *  'address'        @Bitcoin address to receive payments
     *  'payment_code'   @PaymentCode Code for sending payments
     *  'invoice'        @Invoice to view payments and transactions
     * )
     */
    public function createPaymentSmartContract($callback, $post, $confirmations = 3, $fee_level = 'low')
    {
        return $this->getResponse(
            "https://bitaps.com/api/create/payment/smartcontract/" . urlencode($callback),
            compact('confirmations', 'fee_level'),
            $post
        );
    }

    /**
     * Создать платёжный адрес:
     *
     * Биткоин адрес продавца, на который будут пересылаться деньги
     * @param string {payout_address}
     *
     * обратный отклик на указанную ссылку (urlencoded callback - стандарт кодирования строки URL)
     * @param string {callback}
     *
     * число принятых подтверждений платежа в сети Биткоин (опциональное поле, по умолчанию - 3)
     * @param integer [confirmations] 0-10
     *
     * Уровень комиссии сети (Опциональное поле, по умолчанию low)
     * @param string [fee_level] high|medium|low
     *
     * @return mixed
     * @example array(
     *  'address'        @Bitcoin address to receive payments
     *  'payment_code'   @PaymentCode Code for sending payments
     *  'invoice'        @Invoice to view payments and transactions
     * )
     */
    public function createPaymentAddress($payout_address, $callback, $confirmations = 3, $fee_level = 'low')
    {
        return $this->getResponse(
            "https://bitaps.com/api/create/payment/{$payout_address}/" . urlencode($callback),
            compact('confirmations', 'fee_level')
        );
    }

    /**
     * Создать чек на предъявителя
     *
     * Число принятых подтверждений платежа в сети Биткоин (опциональное поле, по умолчанию - 3)
     * @param integer [confirmations] 0-10
     *
     * @return mixed
     * @example array(
     *  'address'        @Bitcoin address to receive payments
     *  'redeem_code'    @Redeem Code for sending payments
     *  'invoice'        @Invoice to view payments and transactions
     * )
     */
    public function createRedeemCode($confirmations = 3)
    {
        return $this->getResponse(
            "https://bitaps.com/api/create/redeemcode",
            compact('confirmations')
        );
    }

    /**
     * Получить информацию по чеку (redeem code)
     *
     * Код чека (Redeem Code)
     * @param string $redeemcode
     *
     * @return array
     * @example array(
     *  'address',
     *  'balance',
     *  'pending_balance',
     *  'paid_out'
     * )
     */
    public function getRedeemCodeInfo($redeemcode)
    {
        return $this->getResponse(
            "https://bitaps.com/api/get/redeemcode/info",
            [],
            compact('redeemcode')
        );
    }

    /**
     * Выплата по чеку (Redeem code)
     *
     * Код чека (Redeem Code)
     * @param string $redeemcode
     *
     * Биткоин адрес получателя
     * @param string $address
     *
     * Укажите сумму в Сатоши или отправьте значение "All available" что бы отправить всю сумму без остатка.
     * @param float|string $amount
     *
     * уровень комиссии сети, опциональное поле, по умолчанию = "low"
     * @param string $fee_level high|medium|low
     *
     * Можно установить собственную комиссию сети в Сатоши на байт.
     * Если этот параметр присутствует, fee_level будет проигнорирован.
     * @param float|boolean $custom_fee false
     *
     * @return array
     * @example array(
     *  'tx_hash'
     * )
     */
    public function useRedeemCode($redeemcode, $address, $amount, $fee_level = 'low', $custom_fee = false)
    {
        return $this->getResponse(
            "https://bitaps.com/api/use/redeemcode",
            [],
            compact('redeemcode', 'address', 'amount', 'fee_level', 'custom_fee')
        );
    }

    /**
     * Массовые выплаты по чеку (Redeem code List)
     *
     * Код чека (Redeem Code)
     * @param string $redeemcode
     *
     * Список получатеелей (Биткоин адрес получателя, Сумма в Сатоши)
     * @param array $payment_list
     *
     * Сообщение OP_Return, максимальная длина 80 байт, опциональное поле, по умолчанию пустое
     * @param string|null $data null
     *
     * уровень комиссии сети, опциональное поле, по умолчанию = "low"
     * @param string $fee_level high|medium|low
     *
     * @return array
     * @example array(
     *  'tx_hash'
     * )
     */
    public function useRedeemCodeList($redeemcode, $payment_list, $data = null, $fee_level = 'low')
    {
        $data = bin2hex($data);

        return $this->getResponse(
            "https://bitaps.com/api/use/redeemcode/list",
            [],
            compact('redeemcode', 'payment_list', 'data', 'fee_level')
        );
    }

    /**
     * Получить информацию о транзакции
     *
     * Хэш транзакции
     * @param string $tx_hash
     *
     * @return mixed
     */
    public function getTransaction($tx_hash)
    {
        return $this->getResponse("https://bitaps.com/api/transaction/{$tx_hash}");
    }

    /**
     * Получить сырую транзакцию
     *
     * Хэш транзакции
     * @param string $tx_hash
     *
     * @return mixed
     * @example array (
     *   'hash',
     *   'hex'
     * )
     */
    public function getRawTransaction($tx_hash)
    {
        return $this->getResponse("https://bitaps.com/api/raw/transaction/{$tx_hash}");
    }

    /**
     * Получить информацию о транзакции
     *
     * Сжатый или несжатый адрес.
     * @param string $address
     *
     * @return mixed
     * @example array(
     *   'balance',
     *   'confirmed_balance',
     *   'received',
     *   'sent',
     *   'pending',
     *   'multisig_received',
     *   'multisig_sent',
     *   'tx_received',
     *   'tx_sent',
     *   'tx_multisig_received',
     *   'tx_multisig_sent',
     *   'tx_unconfirmed',
     *   'tx_invalid'
     * )
     */
    public function getAddress($address)
    {
        return $this->getResponse("https://bitaps.com/api/address/" . $address);
    }

    /**
     * Получить список транзакций по адресу
     *
     * Bitcoin address
     * @param $address
     *
     * Отступ в списке. Возвращается только 100 записей.
     * опциональное поле, offset list, response records limit 100, По умолчанию 0
     * @param int $offset 0
     *
     * Тип транзакции.
     * Варианты: all (все), sent (отправленные), received (полученные), multisig (мульти-подпись)
     * опциональное поле, transactions type, По умолчанию all
     * @param string $type
     *
     * Текущий статус транзакции.
     * Варианты: all (все), confirmed (подтверждённые), unconfirmed (неподтверждённые), invalid (недействительные).
     * опциональное поле, transactions status, По умолчанию all
     * @param string $status
     *
     * @return mixed
     * @example [
     *      [
     *          'timestamp',
     *          'hash',
     *          'data',
     *          'type',
     *          'status',
     *          'confirmations',
     *          'block',
     *          'amount'
     *      ],
     *      ...
     * ]
     */
    public function getAddressTransactions($address, $offset = 0, $type = 'all', $status = 'all')
    {
        return $this->getResponse(
            "https://bitaps.com/api/address/transactions/{$address}/{$offset}/{$type}/{$status}"
        );
    }

    /**
     * Получить текущую сложность Биткоин сети
     *
     * @return mixed
     * @example array (
     *  'difficulty'
     * )
     */
    public function getDifficulty()
    {
        return $this->getResponse("https://bitaps.com/api/difficulty");
    }

    /**
     * Получить хэшрейт Биткоин сети за последние 24 часа
     *
     * @return mixed
     * @example array (
     *  'hashrate'
     * )
     */
    public function getHashRate()
    {
        return $this->getResponse("https://bitaps.com/api/hashrate");
    }

    /**
     * Получить среднее время выхода блока за последние 24 часа
     *
     * @return mixed
     * @example array (
     *  'blocktime'
     * )
     */
    public function getBlockTime()
    {
        return $this->getResponse("https://bitaps.com/api/blocktime");
    }

    /**
     * Получить средний размер блока за последние 24 часа
     *
     * @return mixed
     * @example array (
     *  'blocksize'
     * )
     */
    public function getBlockSize()
    {
        return $this->getResponse("https://bitaps.com/api/blocksize");
    }

    /**
     * Получить среднее количество транзакций в секунду за последние 24 часа
     *
     * @return mixed
     * @example array (
     *  'txrate'
     * )
     */
    public function getTxRate()
    {
        return $this->getResponse("https://bitaps.com/api/txrate");
    }

    /**
     * Получить три варианта стоимости комиссии сети
     *
     * @return mixed
     * @example array (
     *  'high',
     *  'medium',
     *  'low'
     * )
     */
    public function getFee()
    {
        return $this->getResponse("https://bitaps.com/api/fee");
    }

    /**
     * Получить информацию о блоке
     *
     * Номер блока или хэш блока в блокчейн сети
     * @param integer|string $block
     *
     * @return mixed
     * @example array(
     *   'height',
     *   'hash',
     *   'previuos_block_hash',
     *   'next_block_hash',
     *   'merkleroot',
     *   'coinbase',
     *   'miner',
     *   'timestamp',
     *   'version',
     *   'transactions',
     *   'size',
     *   'bits',
     *   'nonce'
     * )
     */
    public function getBlock($block)
    {
        return $this->getResponse("https://bitaps.com/api/block/{$block}");
    }

    /**
     * Получить информацию о последнем блоке
     *
     * @return mixed
     * @example array(
     *   'height',
     *   'hash',
     *   'previuos_block_hash',
     *   'next_block_hash',
     *   'merkleroot',
     *   'coinbase',
     *   'miner',
     *   'timestamp',
     *   'version',
     *   'transactions',
     *   'size',
     *   'bits',
     *   'nonce'
     * )
     */
    public function getBlockLatest()
    {
        return $this->getResponse("https://bitaps.com/api/block/latest");
    }

    /**
     * Получить список транзакций в блоке
     *
     * Номер блока или хэш блока в блокчейн сети
     * @param integer|string $block
     *
     * @return mixed
     * @example [
     *   ['transaction', 'block_data_hex', 'amount}'],
     *   ...
     * ]
     */
    public function getBlockTransactions($block)
    {
        return $this->getResponse("https://bitaps.com/api/block/transactions/{$block}");
    }

    /**
     * Получить QR код для сообщения или адреса, в формате SVG (векторная графика) в текстовом формате base64
     *
     * кодированная строка сообщения (urlencoded) или Биткоин адрес, максимум 256 символов
     * @param string $message
     *
     * @return mixed
     * @example array(
     *    'message',
     *    'qrcode'
     * )
     */
    public function getQRCode($message)
    {
        return $this->getResponse("https://bitaps.com/api/qrcode/{$message}");
    }

    /**
     * Получить QR код для сообщения или адреса, в формате PNG
     *
     * кодированная строка сообщения (urlencoded) или Биткоин адрес, максимум 256 символов
     * @param $message
     *
     * @return string
     */
    public function getQRCodePng($message)
    {
        return Html::img("https://bitaps.com/api/qrcode/png/{$message}");
    }

    /**
     * Курс обмена
     *
     * Интерфейс возвращает текущую стоимость Биткоина по трём основным биржам:
     * Bitstamp.net, Bitfinex.com, Coinbase.com или средневзвешенный курс в Долларах США.
     * Валюты: Евро, Российский Рубль и Китайская Йена вычисляются путём умножения курса ММВБ (http://moex.com/) на курс биткоина в Долларах США.
     *
     * Биржа: bitstamp, bitfinex, coinbase, average (средневзвешенный курс)
     * По умолчанию: average
     * @param string $market
     *
     * @return mixed
     * @example array(
     *   'usd',
     *   'fx_rates' => [
     *      'eur',
     *      'rub',
     *      'cny',
     *   ],
     *   'market',
     *   'timestamp'
     * )
     */
    public function getTicker($market = 'average')
    {
        return $this->getResponse("https://bitaps.com/api/ticker/{$market}");
    }

    /**
     * Получить курс обмена Биткоина по нужной дате и времени на выбранной бирже
     *
     * Время по Unix
     * @param integer $timestamp
     *
     * Биржа: bitstamp, bitfinex, coinbase, average (средневзвешенный курс)
     * По умолчанию: average
     * @param string $market
     *
     * @return mixed
     * @example array(
     *   'usd',
     *   'fx_rates' => [
     *      'eur',
     *      'rub',
     *      'cny',
     *   ],
     *   'market',
     *   'timestamp'
     * )
     */
    public function getPriceHistory($timestamp, $market = 'average')
    {
        return $this->getResponse("https://bitaps.com/api/price/history/{$timestamp}/{$market}");
    }
}