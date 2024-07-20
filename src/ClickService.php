<?php

namespace Shoyim\Click;

use Click\Click;

class ClickService
{
    protected $click;

    public function __construct()
    {
        $config = [
            'merchant_id' => config('click.merchant_id'),
            'service_id' => config('click.service_id'),
            'secret_key' => config('click.secret_key'),
            'endpoint_url' => config('click.endpoint_url')
        ];

        $this->click = new Click($config);
    }

    public function createPayment($amount, $transactionId)
    {
        return $this->click->createInvoice($amount, $transactionId);
    }

    public function checkPaymentStatus($paymentId)
    {
        return $this->click->getInvoiceStatus($paymentId);
    }

    public function verifyPayment($request)
    {
        return $this->click->verifyPayment($request);
    }
}
