<?php

namespace App\Interfaces;

interface PaymentProcessor
{
    public function processor(array $trans);
}
