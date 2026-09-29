<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePrescriptionRequest;
use App\Models\Prescription;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prescription = Prescription::with(['patient', 'medicalRecord'])->latest()->get();

        return response()->json([
            'data' => $prescription,
            'message' => 'Get Prescription Success'
        ]);
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
    public function store(StorePrescriptionRequest $request)
    {
        $prescription = Prescription::create(
            $request->validated()
        );

        return response()->json([
            'data' => $prescription,
            'message' => 'Create Prescription Success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prescription $prescription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePrescriptionRequest $request, $id)
    {
        $prescription = Prescription::find($id);

        if(!$prescription) {
            return response()->json([
                'message' => 'Prescription Not Found'
            ]);
        }

        $prescription->update(
            $request->validated()
        );

        return response()->json([
            'data' => $prescription,
            'message' => 'Update Prescription Success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $prescription = Prescription::find($id);

        if(!$prescription) {
            return response()->json([
                'message' => 'Prescription Not Found'
            ]);
        }

        $prescription->delete();

        return response()->json([
            'message' => 'Deleted Prescription Success'
        ]);
    }
}
