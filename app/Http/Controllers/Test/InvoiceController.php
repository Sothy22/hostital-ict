<?php

namespace App\Http\Controllers\Test;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    // GET all invoices
    public function index()
    {
        $invoices = Invoice::with([
            'patient',
            'appointment',
            // 'payments'
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $invoices
        ]);
    }


    // POST create invoice
    public function store(StoreInvoiceRequest $request)
    {
        $invoice = Invoice::create(
            $request->validated()
        );

        return response()->json([
            'message' => 'Invoice created successfully',
            'data' => $invoice
        ], 201);
    }

    // UPDATE invoice
    public function update(StoreInvoiceRequest $request, $id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json([
                'message' => 'Invoice not found'
            ], 404);
        }

        $invoice::update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Invoice updated successfully',
            'data' => $invoice
        ]);
    }


    // DELETE invoice
    public function destroy($id)
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json([
                'message' => 'Invoice not found'
            ], 404);
        }

        $invoice->delete();

        return response()->json([
            'message' => 'Invoice deleted successfully'
        ]);
    }
}
