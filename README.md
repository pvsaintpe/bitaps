BitAps Component for https://bitaps.com/api
================================

Installation
------------

Please add this section into composer.json:

    "require": {
        "pvsaintpe/bitaps": "1.0.*"
    }

Usage
-----

If you want to create payment cheque, use this construction:

    PHP:
    <?php
        use bitaps\BitAps;
        
        $paymentCheque = BitAps::createCheque(3);
        
        $address = $paymentCheque->address;
        $invoice = $paymentCheque->invoice;
        $redeemCode = $paymentCheque->redeem_code;
    ?>

If you want to use the address or code immediately, use the following methods:

    PHP:
    <?php
        ...
        
        $address = 'a4dsdfs4TYYY323sdrssdfsdfsdfsdf';
        $txResult = $paymentCheque->useRedeemCode($address, $amount, 'low');
        
        $transactionInfo = $txResult->getTransaction();
    ?>