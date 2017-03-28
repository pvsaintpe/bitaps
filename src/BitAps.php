<?php

namespace bitaps;

use bitaps\callback\Response;
use bitaps\response\Address;
use bitaps\response\AddressTransaction;
use bitaps\response\Block;
use bitaps\response\BLockSize;
use bitaps\response\BlockTime;
use bitaps\response\BlockTransaction;
use bitaps\response\Cheque;
use bitaps\response\Difficulty;
use bitaps\response\Fee;
use bitaps\response\HashRate;
use bitaps\response\QrCode;
use bitaps\response\RedeemCode;
use bitaps\response\SmartContract;
use bitaps\response\Ticker;
use bitaps\response\Transaction;
use bitaps\response\TransactionRawResult;
use bitaps\response\TransactionResult;
use bitaps\response\TxRate;

/**
 * Class BitAps
 *
 * @author Veselov Pavel
 * @package bitaps\components
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
     * Обработка колбэков
     *
     * Для подтверждения ответа на наши колбэки, ваш сервер должен вернуть Invoice в ответ, в обычном текстовом формате.
     * В случае не верного ответа нашему серверу, обратный отклик будет отправлен повторно с каждым новым блоком в течение трёх дней.
     * Если ваш сервер долгое время не отвечает на отклики, то мы вправе заблокировать приём платежей для вашего сервиса.
     *
     * @param array $post
     * @return Response
     */
    public static function getCallbackResponse($post = [])
    {
        return new Response($post);
    }

    /**
     * @param string $url
     * @param array $params []
     * @param array|boolean $post false
     *
     * @return mixed|Error
     */
    public static function getResponse($url, $params = [], $post = false)
    {
        $url .= (($queryString = http_build_query($params)) ? '?' . $queryString : '');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if (is_array($post) && !empty($post)) {
            $post = array_filter($post, function ($value) {
                return ($value === false) ? false : true;
            });
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        } else {
            curl_setopt($ch, CURLOPT_POST, 0);
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        $response = json_decode($response, true);

        if ($response && is_array($response) && isset($response['error_code'])) {
            return new Error($response);
        }

        return $response;
    }

    /**
     * Создать смартконтракт (оплата по списку получателей)
     *
     * @param $callback
     * @param $payment_list
     * @param string $type
     * @param int $confirmations
     * @param string $fee_level
     *
     * @return SmartContract
     */
    public static function createSmartContractWithPaymentList(
        $callback,
        $payment_list,
        $type = 'payment_list',
        $confirmations = 3,
        $fee_level = 'low'
    )
    {
        return static::createPaymentSmartContract(
            $callback,
            compact('type', 'payment_list'),
            $confirmations,
            $fee_level
        );
    }

    /**
     * Создать смартконтракт (поддержание баланса на горячем кошельке)
     *
     * @param $callback
     * @param $hot_wallet
     * @param $cold_storage
     * @param $amount
     * @param int $confirmations
     * @param string $fee_level
     *
     * @return SmartContract
     */
    public static function createSmartContractWithHotWallet(
        $callback,
        $hot_wallet,
        $cold_storage,
        $amount,
        $confirmations = 3,
        $fee_level = 'low'
    )
    {
        return static::createPaymentSmartContract(
            $callback,
            compact('hot_wallet', 'cold_storage', 'amount'),
            $confirmations,
            $fee_level
        );
    }

    /**
     * Создать смартконтракт (поддержание баланса на горячем кошельке):
     * :
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
     * @return SmartContract
     */
    protected static function createPaymentSmartContract($callback, $post, $confirmations = 3, $fee_level = 'low')
    {
        $response = static::getResponse(
            "https://bitaps.com/api/create/payment/smartcontract/" . urlencode($callback),
            compact('confirmations', 'fee_level'),
            $post
        );

        return new SmartContract($response);
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
     * @return SmartContract
     */
    public static function createPaymentAddress($payout_address, $callback, $confirmations = 3, $fee_level = 'low')
    {
        $response = static::getResponse(
            "https://bitaps.com/api/create/payment/{$payout_address}/" . urlencode($callback),
            compact('confirmations', 'fee_level')
        );

        return new SmartContract($response);
    }

    /**
     * Создать чек на предъявителя
     *
     * Число принятых подтверждений платежа в сети Биткоин (опциональное поле, по умолчанию - 3)
     * @param integer [confirmations] 0-10
     *
     * @return Cheque
     */
    public static function createCheque($confirmations = 3)
    {
        $response = static::getResponse(
            "https://bitaps.com/api/create/redeemcode",
            compact('confirmations')
        );

        return new Cheque($response);
    }

    /**
     * Получить информацию по чеку (redeem code)
     *
     * Код чека (Redeem Code)
     * @param string $redeemcode
     *
     * @return RedeemCode
     */
    public static function getRedeemCode($redeemcode)
    {
        $response = static::getResponse(
            "https://bitaps.com/api/get/redeemcode/info",
            [],
            compact('redeemcode')
        );

        return new RedeemCode($response);
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
     * @return TransactionResult
     */
    public static function useRedeemCode($redeemcode, $address, $amount, $fee_level = 'low', $custom_fee = false)
    {
        $response = static::getResponse(
            "https://bitaps.com/api/use/redeemcode",
            [],
            compact('redeemcode', 'address', 'amount', 'fee_level', 'custom_fee')
        );

        return new TransactionResult($response);
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
     * @return TransactionResult
     */
    public static function useRedeemCodeList($redeemcode, $payment_list, $data = null, $fee_level = 'low')
    {
        $data = bin2hex($data);
        $response = static::getResponse(
            "https://bitaps.com/api/use/redeemcode/list",
            [],
            compact('redeemcode', 'payment_list', 'data', 'fee_level')
        );

        return new TransactionResult($response);
    }

    /**
     * Получить информацию о транзакции
     *
     * Хэш транзакции
     * @param string $tx_hash
     *
     * @return Transaction
     */
    public static function getTransaction($tx_hash)
    {
        $response = static::getResponse("https://bitaps.com/api/transaction/{$tx_hash}");

        return new Transaction($response);
    }

    /**
     * Получить сырую транзакцию
     *
     * Хэш транзакции
     * @param string $tx_hash
     *
     * @return TransactionRawResult
     */
    public static function getRawTransaction($tx_hash)
    {
        $response = static::getResponse("https://bitaps.com/api/raw/transaction/{$tx_hash}");

        return new TransactionRawResult($response);
    }

    /**
     * Получить информацию о транзакции
     *
     * Сжатый или несжатый адрес.
     * @param string $address
     *
     * @return Address
     */
    public static function getAddress($address)
    {
        $response = static::getResponse("https://bitaps.com/api/address/" . $address);

        return new Address($response);
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
     * @return AddressTransaction[]
     */
    public static function getAddressTransactions($address, $offset = 0, $type = 'all', $status = 'all')
    {
        $response = static::getResponse(
            "https://bitaps.com/api/address/transactions/{$address}/{$offset}/{$type}/{$status}"
        );

        $result = [];
        if ($response && is_array($response)) {
            foreach ($response as $item) {
                $result[] = new AddressTransaction($item);
            }
            return $result;
        } else {
            return $response;
        }
    }

    /**
     * Получить текущую сложность Биткоин сети
     *
     * @return Difficulty
     */
    public static function getDifficulty()
    {
        $response = static::getResponse("https://bitaps.com/api/difficulty");

        return new Difficulty($response);
    }

    /**
     * Получить хэшрейт Биткоин сети за последние 24 часа
     *
     * @return HashRate
     */
    public static function getHashRate()
    {
        $response = static::getResponse("https://bitaps.com/api/hashrate");

        return new HashRate($response);
    }

    /**
     * Получить среднее время выхода блока за последние 24 часа
     *
     * @return BlockTime
     */
    public static function getBlockTime()
    {
        $response = static::getResponse("https://bitaps.com/api/blocktime");

        return new BlockTime($response);
    }

    /**
     * Получить средний размер блока за последние 24 часа
     *
     * @return BLockSize
     */
    public static function getBlockSize()
    {
        $response = static::getResponse("https://bitaps.com/api/blocksize");

        return new BLockSize($response);
    }

    /**
     * Получить среднее количество транзакций в секунду за последние 24 часа
     *
     * @return TxRate
     */
    public static function getTxRate()
    {
        $response = static::getResponse("https://bitaps.com/api/txrate");

        return new TxRate($response);
    }

    /**
     * Получить три варианта стоимости комиссии сети
     *
     * @return Fee
     */
    public static function getFee()
    {
        $response = static::getResponse("https://bitaps.com/api/fee");

        return new Fee($response);
    }

    /**
     * Получить информацию о блоке
     *
     * Номер блока или хэш блока в блокчейн сети
     * @param integer|string $block
     *
     * @return Block
     */
    public static function getBlock($block)
    {
        $response = static::getResponse("https://bitaps.com/api/block/{$block}");

        return new Block($response);
    }

    /**
     * Получить информацию о последнем блоке
     *
     * @return Block
     */
    public static function getBlockLatest()
    {
        $response = static::getResponse("https://bitaps.com/api/block/latest");

        return new Block($response);
    }

    /**
     * Получить список транзакций в блоке
     *
     * Номер блока или хэш блока в блокчейн сети
     * @param integer|string $block
     *
     * @return BlockTransaction[]
     */
    public static function getBlockTransactions($block)
    {
        $response = static::getResponse("https://bitaps.com/api/block/transactions/{$block}");

        $result = [];
        if ($response && is_array($response)) {
            foreach ($response as $item) {
                $result[] = new BlockTransaction($item);
            }
            return $result;
        } else {
            return $response;
        }
    }

    /**
     * Получить QR код для сообщения или адреса, в формате SVG (векторная графика) в текстовом формате base64
     *
     * кодированная строка сообщения (urlencoded) или Биткоин адрес, максимум 256 символов
     * @param string $message
     *
     * @return QrCode
     */
    public static function getQRCode($message)
    {
        $response = static::getResponse("https://bitaps.com/api/qrcode/{$message}");

        return new QrCode($response);
    }

    /**
     * Получить QR код для сообщения или адреса, в формате PNG
     *
     * кодированная строка сообщения (urlencoded) или Биткоин адрес, максимум 256 символов
     * @param string $message
     *
     * @return string
     */
    public static function getQRCodePng($message)
    {
        return "https://bitaps.com/api/qrcode/png/{$message}";
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
     * @return Ticker
     */
    public static function getTicker($market = 'average')
    {
        $response = static::getResponse("https://bitaps.com/api/ticker/{$market}");

        return new Ticker($response);
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
     * @return Ticker
     */
    public static function getPriceHistory($timestamp, $market = 'average')
    {
        $response = static::getResponse("https://bitaps.com/api/price/history/{$timestamp}/{$market}");

        return new Ticker($response);
    }
}