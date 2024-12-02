<?php

namespace App\Serivces;

class TransactionService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function findtransaction(int $transactionId)
    {
        return [
            'transactionId' => $transactionId,
            'amount' => 100
        ];
    }
}
