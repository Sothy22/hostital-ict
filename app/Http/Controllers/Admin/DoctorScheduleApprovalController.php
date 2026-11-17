<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorScheduleRequest;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use MongoDB\Driver\Exception\BulkWriteException;

class DoctorScheduleApprovalController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'doctor_id' => ['nullable', 'string'],
            'work_date' => ['nullable', 'date_format:Y-m-d'],
            'status' => ['nullable', 'in:pending,approved,rejected'],
        ]);

        $doctors = User::where('role', 'doctor')->orderBy('name')->get();
        $query = DoctorSchedule::with(['doctor.department']);

        if (!empty($filters['doctor_id'])) {
            $doctor = User::where('role', 'doctor')->find($filters['doctor_id']);
            if (!$doctor) {
                return back()->withErrors(['doctor_id' => 'Select a valid doctor.']);
            }
            $query->where('doctor_id', $doctor->getKey());
        }

        if (!empty($filters['work_date'])) {
            $query->where('work_date', $filters['work_date']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $schedules = $query->orderBy('work_date', 'desc')->paginate(15)->withQueryString();

        return view('dashboard.admin.doctor_schedule_approval', compact('doctors', 'schedules', 'filters'));
    }

    public function update(StoreDoctorScheduleRequest $request, DoctorSchedule $schedule)
    {
        $validated = $request->validated();
        $doctor = User::where('role', 'doctor')->find($validated['doctor_id']);

        if (!$doctor) {
            return back()->withErrors(['doctor_id' => 'Select a valid doctor.'])->withInput();
        }

        $duplicate = DoctorSchedule::where('doctor_id', $doctor->getKey())
            ->where('work_date', $validated['work_date'])
            ->where('_id', '!=', $schedule->getKey())
            ->exists();

        if ($duplicate) {
            return back()->withErrors(['work_date' => 'This doctor already has a schedule for that date.'])->withInput();
        }

        try {
            $schedule->update([
                'doctor_id' => $doctor->getKey(),
                'department_id' => $doctor->department_id,
                'work_date' => $validated['work_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'break_start' => $validated['break_start'] ?? null,
                'break_end' => $validated['break_end'] ?? null,
                'duration_minutes' => (int) $validated['duration_minutes'],
            ]);
        } catch (BulkWriteException $exception) {
            if ($exception->getCode() !== 11000) {
                throw $exception;
            }

            return back()->withErrors(['work_date' => 'This doctor already has a schedule for that date.'])->withInput();
        }

        return redirect()->route('admin.doctor_schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function approve(DoctorSchedule $schedule)
    {
        $schedule->update([
            'status' => 'approved',
            'rejection_reason' => null,
            'reviewed_by' => auth('admin')->user()->getKey(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Doctor schedule approved.');
    }

    public function reject(Request $request, DoctorSchedule $schedule)
    {
        $validated = $request->validate([
            'reason' => ['required', 'string', 'max:500'],
        ]);

        $schedule->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['reason'],
            'reviewed_by' => auth('admin')->user()->getKey(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Doctor schedule rejected.');
    }
}
