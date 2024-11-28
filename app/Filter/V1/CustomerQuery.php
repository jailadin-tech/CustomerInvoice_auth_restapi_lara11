<?php

namespace App\Filter\V1;

use Illuminate\Http\Request;

class CustomerQuery
{
    protected $safeparms = [
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'postalCode' => ['eq', 'lt', 'gt'],
    ];

    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'in' => 'in'
    ];

    public function transform(Request $request): array
    {
        $eloQuery = [];
        foreach ($this->safeparms as $param => $operators) {
            $queryColumn = $request->query($param); // is this Param in request query
            if (!isset($queryColumn)) {
                continue;
            }
            $filterColumn = $this->columnMap[$param] ?? $param;
            foreach ($operators as $operator) {
                if (isset($queryColumn[$operator])) {
                    $eloQuery[] = [$filterColumn, $this->operatorMap[$operator], $queryColumn[$operator]]; //[[column,operatopr,value]]
                }
            }
        }
        return $eloQuery;
    }
}
