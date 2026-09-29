<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalRecordRequest;
use App\Models\MedicalRecord;

class MedicalRecordController extends Controller
{
    public function index() {
        $record = MedicalRecord::with(['patient', 'staff', 'prescription'])->latest()->get();

        return response()->json([
            'data' => $record,
            'message' => 'Get Medical Record Success'
        ], 200);
    }

    public function store(MedicalRecordRequest $req) {
        $record = MedicalRecord::create(
            $req->validated()
        );

        return response()->json([
            'data' => $record,
            'message' => 'Create Medical Record Success'
        ], 201);
    }

    public function update(MedicalRecordRequest $req, $id) {
        $record = MedicalRecord::find($id);

        if(!$record) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $record->update(
            $req->validated()
        );

        return response()->json([
            'data' => $record,
            'message' => 'Update Medical Record Success'
        ]);
    }

    public function destroy($id) {
        $record = MedicalRecord::find($id);

        if(!$record) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $record->delete();

         return response()->json([
            'data' => $record,
            'message' => 'Delete Medical Record Success'
        ]);
    }
}
