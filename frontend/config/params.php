<?php
return [
    'paypal' => [
        "mode" => 'sandbox',
        "acct1.UserName" => "revardy-facilitator_api1.gmail.com",
        "acct1.Password" => "WB2WGVAT596LN25F",
        "acct1.Signature" => "An5ns1Kso7MWUdW4ErQKJJJ4qi4-AuV7bV93e70-418N1b0gWpk-IoEY",

        'log.LogEnabled' => true,
        'log.FileName' => $_SERVER['DOCUMENT_ROOT'] . '/frontend/runtime/PayPal.log',
        'log.LogLevel' => 'FINE'
    ],
];
