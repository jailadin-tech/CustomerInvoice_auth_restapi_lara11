<?php

namespace App\Http\Controllers\Api\V1;

use App\Filter\V1\CustomerQuery;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Resources\V1\CustomerResource;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterItems = new CustomerQuery();
        $queryItems = $filterItems->transform($request); // O/p: [['name','=','jai'],['amount','>','100']]
        //dd($queryItems);
        if (count($queryItems) == 0) {
            return new CustomerCollection(Customer::paginate());
        } else {
            $query = Customer::where($queryItems);
            /*  Query debug
                // Get the raw SQL with placeholders
                $sql = $query->toSql();
                // Get the bound values
                $bindings = $query->getBindings();
                // Output the query and the bindings
                dd(vsprintf(str_replace('?', '%s', $sql), $bindings)); 
            */
            return new CustomerCollection($query->paginate());
            ///return new CustomerCollection(Customer::where($queryItems)->paginate());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
