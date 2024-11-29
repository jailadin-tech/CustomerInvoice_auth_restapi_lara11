<?php

namespace App\Http\Controllers\Api\V1;

use App\Filter\V1\InvoiceQueryFilter;
use App\Helper\Api\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\BulkStoreInvoiceRequest;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterItems = new InvoiceQueryFilter();
        $queryItems = $filterItems->transform($request); // O/p: [['name','=','jai'],['amount','>','100']]
        if (count($queryItems) == 0) {
            return new InvoiceCollection(Invoice::paginate());
        } else {
            $customers = Invoice::where($queryItems)->paginate();
            // Appending query params to pagination url ( V1/invoices?page=17 append changes to V1/invoices?name[eq]=jai&page=17)
            return new InvoiceCollection($customers->appends($request->query()));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    public function bulkStore(BulkStoreInvoiceRequest $request)
    {
        try {
            // Remove the unwanted extra manipulated api keys
            $bulk = collect($request->all())->map(function ($arr, $key) {
                return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']);
            });
            $store = Invoice::insert($bulk->toArray());
            if ($store) {
                return ResponseHelper::success(message: "Bulk data store completed", statusCode: 400);
            }
            return ResponseHelper::error(message: "Bulk failed  ", statusCode: 400);
        } catch (\Throwable $th) {
            return ResponseHelper::error(message: "Failed to bulk data store due to some exception : " . $th->getMessage(),  statusCode: 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
