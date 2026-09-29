<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLabTestRequest;
use App\Models\LabTest;

class LabTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labTest = LabTest::with(['staff', 'patient', 'record'])->latest()->get();

        return response()->json([
            'data' => $labTest,
            'message' => 'Get Lab Test Success'
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
    public function store(StoreLabTestRequest $request)
    {
        $labTest = LabTest::create(
            $request->validated()
        );

        return response()->json([
            'data' => $labTest,
            'message' => 'Create Lab Test Success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(LabTest $labTest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LabTest $labTest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLabTestRequest $request, $id)
    {
        $labTest = LabTest::find($id);

        if(!$labTest) {
            return response()->json([
                'message' => 'Lab Test Not Found'
            ]);
        }

        $labTest->update(
            $request->validated()
        );

        return response()->json([
            'data' => $labTest,
            'message' => 'Update Lab Test Success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $labTest = LabTest::find($id);

        if(!$labTest) {
            return response()->json([
                'message' => 'Lab Test Not Found'
            ]);
        }

        $labTest->delete();

        return response()->json([
            'message' => 'Deleted Lab Test Success'
        ]);
    }
}
