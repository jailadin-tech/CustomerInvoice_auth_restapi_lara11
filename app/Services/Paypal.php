<?php

namespace App\Services;

use App\Interfaces\PaymentProcessor;

readonly class Paypal implements PaymentProcessor
{
    /**
     * Create a new class instance.
     */
    public function __construct(array $config = [])
    {
        return $config;
    }
    public function processor(array $trans)
    {
        return "processing Payment : " . $trans['amount'];
    }
}
