<?php

return [
    App\Providers\AppServiceProvider::class,
    MercadoPago\Client\Common\RequestOptions::class,
    MercadoPago\Client\Payment\PaymentClient::class,
    MercadoPago\Exceptions\MPApiException::class,
    MercadoPago\MercadoPagoConfig::class,
];
