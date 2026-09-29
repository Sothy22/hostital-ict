<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVitalSignRequest;
use App\Models\VitalSign;

class VitalSignController extends Controller
{
    // GET all vital signs
    public function index()
    {
        $vitalSigns = VitalSign::with([
            'patient',
            'staff'
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $vitalSigns
        ]);
    }


    // POST create vital sign
    public function store(StoreVitalSignRequest $request)
    {
        $vitalSign = VitalSign::create($request->validated());

        return response()->json([
            'message' => 'Vital sign created successfully',
            'data' => $vitalSign
        ], 201);
    }

    // UPDATE vital sign
    public function update(StoreVitalSignRequest $request, $id)
    {
        $vitalSign = VitalSign::find($id);

        if (!$vitalSign) {
            return response()->json([
                'message' => 'Vital sign not found'
            ], 404);
        }

        $vitalSign->update(
            $request->validated()
        );

        return response()->json([
            'message' => 'Vital sign updated successfully',
            'data' => $vitalSign
        ]);
    }


    // DELETE vital sign
    public function destroy($id)
    {
        $vitalSign = VitalSign::find($id);

        if (!$vitalSign) {
            return response()->json([
                'message' => 'Vital sign not found'
            ], 404);
        }

        $vitalSign->delete();

        return response()->json([
            'message' => 'Vital sign deleted successfully'
        ]);
    }
}
