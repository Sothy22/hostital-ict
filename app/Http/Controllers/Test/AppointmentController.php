<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index() {
        $appointments = Appointment::with(['patient', 'staff'])->latest()->get();
        // $appointments = Appointment::with(['patient'])->latest()->get();

        return response()->json([
            'message' => 'Get Appointment Success',
            'data' => $appointments
        ], 200);
    }

    public function store(AppointmentRequest $req) {
        $appointment = Appointment::create(
            $req->validated()
        );

         return response()->json([
            'message' => 'Appointment created successfully.',
            'data' => $appointment
        ], 201);
    }

    public function update(AppointmentRequest $request, $id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found.'
            ], 404);
        }

        $appointment->update(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Appointment updated successfully.',
            'data' => $appointment
        ]);
    }


    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found.'
            ], 404);
        }

        $appointment->delete();

        return response()->json([
            'message' => 'Appointment deleted successfully.'
        ]);
    }

}
