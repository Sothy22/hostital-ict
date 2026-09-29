<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmergencyContactRequest;
use App\Models\EmergencyContact;

class EmergencyContactController extends Controller
{
    public function index() {
        $emergencyContact = EmergencyContact::with('patient')->get();

        return response()->json([
            'message' => 'Get Emergency Contact Success',
            'data' => $emergencyContact
        ], 200);
    }

    public function store(StoreEmergencyContactRequest $req) {
        $emergencyContact = EmergencyContact::create(
            $req->validated()
        );

        return response()->json([
            'data' => $emergencyContact,
            'message' => 'Emergency Contact Created Success'
        ]);
    }

    public function update(StoreEmergencyContactRequest $req, $id) {
        $emergencyContact = EmergencyContact::find($id);

        if(!$emergencyContact) {
            return response()->json([
                'message' => 'Emergency Contact Not Found'
            ]);
        }

        $emergencyContact::update(
            $req->validated()
        );

        return response()->json([
            'data' => $emergencyContact,
            'message' => 'Emergency Contact Updated Success'
        ]);
    }

    public function destroy($id) {
        $emergencyContact = EmergencyContact::find($id);

        if(!$emergencyContact) {
            return response()->json([
                'message' => 'Emergency Contact Not Found'
            ]);
        }

        $emergencyContact::delete();

        return response()->json([
            'data' => $emergencyContact,
            'message' => 'Emergency Contact Deleted Success'
        ]);
    }
}
