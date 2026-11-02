<?php

namespace App\Http\Controllers\Layout;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function home()
    {
        return view('index');
    }

    public function about()
    {
        return view('about_us');
    }
    public function contact(Request $request)
    {
        if (!Auth::guard('web')->check()) {
            session()->put('url.intended', $request->fullUrl());
        }

        $doctor = $request->filled('doctor')
            ? User::find($request->query('doctor'))
            : User::where('role', 'doctor')->first();

        if (!$doctor || !$doctor->isDoctor()) {
            $doctor = null;
        }

        $patientHistory = $doctor
            ? Appointment::where('staff_id', $doctor->getKey())->count()
            : 0;

        $user = Auth::guard('web')->user();
        $patient = $user
            ? Patient::where('user_id', $user->_id)->first()
            : null;

        return view('contact', compact('doctor', 'patientHistory', 'patient'));
    }
    public function contact_us()
    {
        return view('contact_us');
    }
    public function department()
    {
        $departments = User::with('department')->where('role', 'department_head')->get();

        return view('department', compact('departments'));
    }
    public function doctor()
    {
        $doctors = User::with('department')->where('role', 'doctor')->get();

        return view('doctors', compact('doctors'));
    }
    public function storeAppointment(Request $request)
    {
        $user = Auth::guard('web')->user();

        if (!$user || $user->role !== 'patient') {
            session()->put('url.intended', url()->previous());
            return redirect()->route('login')->with(
                'appointment_login_required',
                'Please login with a patient account to book an appointment.'
            );
        }

        $validated = $request->validate([
            'staff_id' => ['required', 'string'],
            'department_id' => ['nullable', 'string'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'patient_type' => ['required', Rule::in(['new', 'old'])],
            'phone' => ['required', 'string', 'max:30'],
            'full_name' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $doctor = User::find($validated['staff_id']);
        if (!$doctor || !$doctor->isDoctor()) {
            return back()->withErrors(['staff_id' => 'Please select a valid doctor.'])->withInput();
        }

        $department = Department::find($validated['department_id']);
        $patient = Patient::where('user_id', $user->_id)->first();

        if ($validated['patient_type'] === 'old' && !$patient) {
            return back()
                ->withErrors(['patient_type' => 'No previous patient record was found for this account. Select New Patient instead.'])
                ->withInput();
        }

        if (!$patient) {
            $patient = Patient::create([
                'full_name' => $validated['full_name'] ?: $user->name,
                'dob' => $user->date_of_birth,
                'gender' => $user->gender,
                'phone' => $validated['phone'],
                'address' => $user->address ?? '',
                'user_id' => $user->_id,
            ]);
        } else {
            $patientData = ['phone' => $validated['phone']];
            if ($validated['patient_type'] === 'new' && !empty($validated['full_name'])) {
                $patientData['full_name'] = $validated['full_name'];
            }
            $patient->update($patientData);
        }

        $appointmentDate = Carbon::createFromFormat(
            'Y-m-d H:i',
            $validated['appointment_date'].' '.$validated['appointment_time'],
            config('app.timezone')
        );

        Appointment::create([
            'patient_id' => $patient->_id,
            'staff_id' => $doctor->_id,
            'department_id' => $validated['department_id'],
            'appointment_date' => $appointmentDate,
            'purpose' => $department ? $department->name : ($doctor->specialization ?? 'General consultation'),
            'notes' => $validated['notes'] ?? null,
            'patient_type' => $validated['patient_type'],
            'status' => 'Scheduled',
        ]);

        return back()->with('success', 'Your appointment has been booked successfully.');
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        return back()->with(
            'success',
            'Your message has been sent successfully!'
        );
    }
}
