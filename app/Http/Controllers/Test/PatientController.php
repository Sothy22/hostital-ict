<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index() {
        $patient = Patient::with(['appointments', 'medical_record', 'medicalHistory', 'emergencyContact', ])->latest()->get();

        return response()->json([
            'data' => $patient,
            'message' => 'Get Patient Success'
        ], 200);
    }

    public function store(PatientRequest $request) {
        $patient = Patient::create(
            $request->validated()
        );

        return response()->json([
            'data' => $patient,
            'message' => 'Patient Create Success',
        ], 201);
    }

    public function update(PatientRequest $request, $id) {
        $patient = Patient::find($id);

        if(!$patient) {
            return response()->json([
                'message' => 'Patient Not Found'
            ], 404);
        }

        $patient->update(
            $request->validated()
        );

        return response()->json([
            'data' => $patient,
            'message' => 'Updated Patient Success'
        ]);
    }

    public function destroy($id) {
        $patient = Patient::find($id);

        if(!$patient) {
            return response()->json([
                'message' => 'Patient Not Found'
            ], 404);
        }

        $patient->delete();

        return response()->json([
            'data' => $patient,
            'message' => 'Delete Patient Success'
        ]);
    }
}
