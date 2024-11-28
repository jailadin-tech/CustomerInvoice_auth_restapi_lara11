<?php

namespace App\Filter;

use Illuminate\Http\Request;

/**
 * Class: Custom Class for filtering the records of  model with given  filters
 */
class ApiQueryFilters
{
    /**
     * Attribute : Allowed columns and operators(>,= ...etc) for query
     */
    protected $safeparms = [];
    /**
     * Attribute : Manipulated column names mapping to actual column name for query
     */
    protected $columnMap = [];
    /**
     * Attribute : Mapping query operator short name to actual entity symbol ex: [eq => =, lt => <]
     */
    protected $operatorMap = [];

    /**
     * Function : Generate the query filter array based on the allowed columns and query params
     * @return array QueryFiler Array like [['name','=','jai'],['amount','>','100']]
     */
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
