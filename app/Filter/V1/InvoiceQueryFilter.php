<?php

namespace App\Filter\V1;

use App\Filter\ApiQueryFilters;

class InvoiceQueryFilter extends ApiQueryFilters
{


    protected $safeparms = [
        'customerId' => ['eq', 'lt', 'lte', 'gt', 'gte'],
        'amount' => ['eq', 'lt', 'lte', 'gt', 'gte'],
        'status' => ['eq'],
        'billedDate' => ['eq', 'lt', 'lte', 'gt', 'gte'],
        'paidDate' => ['eq', 'lt', 'lte', 'gt', 'gte']
    ];

    protected $columnMap = [
        'customerId' => 'customer_id',
        'billedDate' => 'billed_date',
        'paidDate' => 'paid_date'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'in' => 'in'
    ];
}
