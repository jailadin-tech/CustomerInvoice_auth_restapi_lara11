<?php

namespace App\Http\Controllers\Api\V1;

use App\Filter\V1\CustomerQueryFilter;
use App\Helper\Api\ResponseHelper;
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
        $filterItems = new CustomerQueryFilter();
        $queryItems = $filterItems->transform($request); // O/p: [['name','=','jai'],['amount','>','100']]
        $customers = Customer::where($queryItems);

        // Include Related Invoice of customers data if it asked in query parameter V1/customers?includeData=invoices
        $includeReleated = $request->query('includeData');
        if ($includeReleated == "invoices") {
            // set eagarLoad to invoices, to load the invoices relation ship on customer model 
            dd($customers->with('invoices'));
            $customers = $customers->with('invoices');
        }
        return new CustomerCollection($customers->paginate()->appends($request->query()));
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
        try {
            $customer = Customer::create($request->all());
            if ($customer) {
                return new CustomerResource($customer);
            }
            return ResponseHelper::error(message: "Failed to insert data ", statusCode: 400);
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: "Failed to insert data due to some exception : " . $th->getMessage(),  statusCode: 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // Include Related Invoice of customers data if it asked in query parameter V1/customers?includeData=invoices
        $includeReleated = request()->query('includeData');
        if ($includeReleated == "invoices") {
            // Use loadMissing to load invoices if they are not already loaded
            return new CustomerResource($customer->loadMissing('invoices'));
        }
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
        try {

            if ($customer->update($request->all())) {
                return new CustomerResource($customer);
            }
            return ResponseHelper::error(message: "Failed to Update data ", statusCode: 400);
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: "Failed to Update data due to some exception : " . $th->getMessage(),  statusCode: 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
