<?php

namespace App\Http\Controllers\Layout;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Services\DoctorScheduleAvailability;
use MongoDB\Driver\Exception\BulkWriteException;

class HomeController extends Controller
{
    public function home()
    {
        return view('index', [
            'happyPatients' => Patient::count(),
            'expertDoctors' => User::where('role', 'doctor')->count(),
            'departmentCount' => Department::count(),
        ]);
    }

    public function about()
    {
        return view('about_us');
    }

    public function appointment_page(Request $request)
    {
        return $this->contact($request);
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

    public function doctor ()
    {
        $doctors = User::with('department')
            ->where('role', 'doctor')
            ->get();

        $completedMeetings = Appointment::where('status', 'Completed')
            ->get(['staff_id']);

        $meetingCounts = $completedMeetings
            ->groupBy(function ($appointment) {
                return (string) $appointment->staff_id;
            })
            ->map(function ($appointments) {
                return $appointments->count();
            });

        $doctors->each(function ($doctor) use ($meetingCounts) {
            $doctor->completed_meetings_count = $meetingCounts->get(
                (string) $doctor->_id,
                0
            );
        });

        return view('doctors', compact('doctors'));
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

    public function storeAppointment(Request $request, DoctorScheduleAvailability $availability)
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

        $schedule = DoctorSchedule::where('doctor_id', $doctor->getKey())
            ->where('work_date', $validated['appointment_date'])
            ->where('status', 'approved')
            ->first();

        if (!$schedule) {
            return back()
                ->withErrors(['appointment_date' => 'The selected doctor has no approved schedule for this date.'])
                ->withInput();
        }

        $availableSlots = $availability->slotsFor(
            $schedule,
            $availability->appointmentsForSchedule($schedule)
        );
        if (!in_array($validated['appointment_time'], array_column($availableSlots, 'time'), true)) {
            return back()
                ->withErrors(['appointment_time' => 'This appointment time is no longer available. Choose another slot.'])
                ->withInput();
        }

        $appointmentDate = Carbon::createFromFormat(
            'Y-m-d H:i',
            $validated['appointment_date'].' '.$validated['appointment_time'],
            config('app.timezone')
        );

        $department = Department::find($validated['department_id']);
        $patient = Patient::where('user_id', $user->_id)->first();

        if ($validated['patient_type'] === 'old' && !$patient) {
            return back()
                ->withErrors(['patient_type' => 'No previous patient record was found for this account. Select New Patient instead.'])
                ->withInput();
        }

        $createdPatient = false;
        $patientData = [];
        if (!$patient) {
            $patient = Patient::create([
                'full_name' => $validated['full_name'] ?: $user->name,
                'dob' => $user->date_of_birth,
                'gender' => $user->gender,
                'phone' => $validated['phone'],
                'address' => $user->address ?? '',
                'user_id' => $user->_id,
            ]);
            $createdPatient = true;
        } else {
            $patientData = ['phone' => $validated['phone']];
            if ($validated['patient_type'] === 'new' && !empty($validated['full_name'])) {
                $patientData['full_name'] = $validated['full_name'];
            }
        }

        $currentSchedule = DoctorSchedule::where('_id', $schedule->getKey())
            ->where('doctor_id', $doctor->getKey())
            ->where('work_date', $validated['appointment_date'])
            ->where('status', 'approved')
            ->first();
        if (!$currentSchedule || !in_array(
            $validated['appointment_time'],
            array_column($availability->slotsFor(
                $currentSchedule,
                $availability->appointmentsForSchedule($currentSchedule)
            ), 'time'),
            true
        )) {
            if ($createdPatient) {
                $patient->delete();
            }

            return back()
                ->withErrors(['appointment_time' => 'This appointment time is no longer available. Choose another slot.'])
                ->withInput();
        }

        $appointment = new Appointment();
        $appointment->patient_id = $patient->_id;
        $appointment->staff_id = $doctor->_id;
        $appointment->department_id = $validated['department_id'];
        $appointment->appointment_date = $appointmentDate;
        $appointment->purpose = $department ? $department->name : ($doctor->specialization ?? 'General consultation');
        $appointment->notes = $validated['notes'] ?? null;
        $appointment->patient_type = $validated['patient_type'];
        $appointment->status = 'Scheduled';
        $appointment->doctor_schedule_id = $currentSchedule->getKey();
        $appointment->booking_duration_minutes = (int) $currentSchedule->duration_minutes;
        $appointment->booking_slot_key = hash(
            'sha256',
            (string) $doctor->getKey() . ':' . $validated['appointment_date'] . ':' . $validated['appointment_time']
        );

        try {
            $appointment->save();
        } catch (BulkWriteException $exception) {
            if ($createdPatient) {
                $patient->delete();
            }

            if ($exception->getCode() !== 11000) {
                throw $exception;
            }

            return back()
                ->withErrors(['appointment_time' => 'This appointment time was just booked. Choose another slot.'])
                ->withInput();
        }

        if (!$createdPatient) {
            $patient->update($patientData);
        }

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
