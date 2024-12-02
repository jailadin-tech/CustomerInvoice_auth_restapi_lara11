<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentProcessor;
use App\Serivces\TransactionService;
use App\Services\Paypal;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(private readonly Container $container) {}
    public function index()
    {
        return "transactions";
        # diff methods how to resolve the injection with using app facade or contrainer class
        // Method:1 :   dump(resolve(PaymentProcessor::class));
        // Method:2 :  dump(app()->make(PaymentProcessor::class));
        // Method:3 :  dump(app(PaymentProcessor::class));
        // Method: 4:  dump($this->container->make(PaymentProcessor::class));
    }
    public function show(int $transid,  TransactionService $transactionservice, PaymentProcessor $paymentprocess)
    {
        $transactions = $transactionservice->findtransaction($transid);
        $amt = $paymentprocess->processor($transactions);
        echo "Transaction Id: " . $transid . " Amount : " .  $amt;
    }
}
