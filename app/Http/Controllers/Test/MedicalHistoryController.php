<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalHistoryRequest;
use App\Models\MedicalHistory;

class MedicalHistoryController extends Controller
{
    public function index () {
        $history = MedicalHistory::with(['patient'])->latest()->get();

        return response()->json([
            'data' => $history,
            'message' => 'Get Medical History Success'
        ], 200);
    }

    public function store (MedicalHistoryRequest $req) {
        $data = $req->validated();

        $history = MedicalHistory::firstOrNew([
            'patient_id' => $data['patient_id'],
        ]);

        $history->fill([
            'past_diseases' => $data['past_diseases'] ?? null,
            'previous_surgeries' => $data['previous_surgeries'] ?? null,
            'allergies' => $data['allergies'] ?? null,
            'chronic_conditions' => $data['chronic_conditions'] ?? null,
            'last_updated' => now(),
        ]);

        $wasRecentlyCreated = $history->exists === false;
        $history->save();

        return response()->json([
            'data' => $history,
            'message' => $wasRecentlyCreated
                ? 'Create Medical History Success'
                : 'Medical History Already Exists; Updated Successfully'
        ], $wasRecentlyCreated ? 201 : 200);
    }

    public function update (MedicalHistoryRequest $req, $id) {
        $history = MedicalHistory::find($id);

        if(!$history) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $history->update(
            $req->validated()
        );

        return response()->json([
            'data' => $history,
            'message' => 'Update Medical History Success'
        ], );
    }

    public function destroy ($id) {
        $history = MedicalHistory::find($id);

        if(!$history) {
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $history->delete();

        return response()->json([
            'data' => $history,
            'message' => 'Delete Medical History Success'
        ], );
    }
}
