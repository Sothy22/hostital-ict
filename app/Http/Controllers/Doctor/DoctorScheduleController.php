<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorScheduleRequest;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\User;
use App\Services\DoctorScheduleAvailability;
use Illuminate\Http\Request;
use MongoDB\Driver\Exception\BulkWriteException;

class DoctorScheduleController extends Controller
{
    public function index(Request $request)
    {
        $doctor = $request->user();
        $schedules = DoctorSchedule::where('doctor_id', $doctor->getKey())
            ->orderBy('work_date', 'desc')
            ->paginate(12);

        $today = now()->format('Y-m-d');
        $appointments = Appointment::where('staff_id', $doctor->getKey())
            ->where('status', '!=', 'Cancelled')
            ->orderBy('appointment_date')
            ->limit(8)
            ->get();

        $todayAppointments = $appointments->filter(function ($appointment) use ($today) {
            return data_get($appointment, 'appointment_date')
                && \Illuminate\Support\Carbon::parse($appointment->appointment_date)->format('Y-m-d') === $today;
        })->count();

        $thisWeekSchedules = DoctorSchedule::where('doctor_id', $doctor->getKey())
            ->where('work_date', '>=', now()->startOfWeek()->format('Y-m-d'))
            ->where('work_date', '<=', now()->endOfWeek()->format('Y-m-d'))
            ->count();

        return view('dashboard.doctor.work_schedule', compact(
            'doctor',
            'schedules',
            'appointments',
            'todayAppointments',
            'thisWeekSchedules'
        ));
    }

    public function store(StoreDoctorScheduleRequest $request)
    {
        $doctor = $request->user();
        $validated = $request->validated();

        if (DoctorSchedule::where('doctor_id', $doctor->getKey())
            ->where('work_date', $validated['work_date'])
            ->exists()) {
            return back()
                ->withErrors(['work_date' => 'A schedule for this date has already been saved.'])
                ->withInput();
        }

        try {
            DoctorSchedule::create([
                'doctor_id' => $doctor->getKey(),
                'department_id' => $doctor->department_id,
                'work_date' => $validated['work_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'break_start' => $validated['break_start'] ?? null,
                'break_end' => $validated['break_end'] ?? null,
                'duration_minutes' => (int) $validated['duration_minutes'],
                'status' => 'approved',
            ]);
        } catch (BulkWriteException $exception) {
            if ($exception->getCode() !== 11000) {
                throw $exception;
            }

            return back()
                ->withErrors(['work_date' => 'A schedule for this date has already been saved.'])
                ->withInput();
        }

        return redirect()->route('doctor_schedules.index')
            ->with('success', 'Work schedule saved and published.');
    }

    public function availability(Request $request, DoctorScheduleAvailability $availability)
    {
        $validated = $request->validate([
            'doctor_id' => ['required', 'string'],
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
        ]);

        $doctor = User::where('role', 'doctor')->find($validated['doctor_id']);
        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found.'], 404);
        }

        $schedule = DoctorSchedule::where('doctor_id', $doctor->getKey())
            ->where('work_date', $validated['date'])
            ->first();

        if (!$schedule) {
            return response()->json(['slots' => []]);
        }

        return response()->json([
            'slots' => $availability->slotsFor(
                $schedule,
                $availability->appointmentsForSchedule($schedule)
            ),
        ]);
    }
}
