<?php

namespace App\Services\Payment;


Interface PaymentInterface
{
    public functioN __construct($GatewayId, $key, $productId);

    public function Create($paymentId);
    public function Verify($payment_id,$product_id);
}
