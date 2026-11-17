<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DoctorScheduleAvailability
{
    public function appointmentsForSchedule(DoctorSchedule $schedule): Collection
    {
        $timezone = config('app.timezone');
        $dayStart = Carbon::createFromFormat('Y-m-d', $schedule->work_date, $timezone)->startOfDay();
        $dayEnd = $dayStart->copy()->endOfDay();

        return Appointment::where('staff_id', $schedule->doctor_id)
            ->where(function ($query) use ($dayStart, $dayEnd, $schedule) {
                $query->whereBetween('appointment_date', [$dayStart, $dayEnd])
                    ->orWhereBetween('appointment_date', [
                        $schedule->work_date . ' 00:00:00',
                        $schedule->work_date . ' 23:59:59',
                    ]);
            })
            ->get(['appointment_date', 'status', 'booking_duration_minutes']);
    }

    public function slotsFor(DoctorSchedule $schedule, iterable $appointments = []): array
    {
        if ($schedule->status !== 'approved') {
            return [];
        }

        $timezone = config('app.timezone');
        $workStart = Carbon::createFromFormat(
            'Y-m-d H:i',
            $schedule->work_date . ' ' . $schedule->start_time,
            $timezone
        );
        $workEnd = Carbon::createFromFormat(
            'Y-m-d H:i',
            $schedule->work_date . ' ' . $schedule->end_time,
            $timezone
        );
        $duration = (int) $schedule->duration_minutes;
        $breakStart = $schedule->break_start
            ? Carbon::createFromFormat('Y-m-d H:i', $schedule->work_date . ' ' . $schedule->break_start, $timezone)
            : null;
        $breakEnd = $schedule->break_end
            ? Carbon::createFromFormat('Y-m-d H:i', $schedule->work_date . ' ' . $schedule->break_end, $timezone)
            : null;
        $now = Carbon::now($timezone);
        $slots = [];

        for (
            $slotStart = $workStart->copy();
            $slotStart->copy()->addMinutes($duration)->lte($workEnd);
            $slotStart->addMinutes($duration)
        ) {
            $slotEnd = $slotStart->copy()->addMinutes($duration);
            $crossesBreak = $breakStart && $breakEnd
                && $slotStart->lt($breakEnd)
                && $slotEnd->gt($breakStart);

            if ($slotStart->lte($now) || $crossesBreak) {
                continue;
            }

            $isBooked = false;
            foreach ($appointments as $appointment) {
                if (in_array(strtolower((string) data_get($appointment, 'status')), ['cancelled', 'canceled', 'rejected'], true)) {
                    continue;
                }

                $appointmentDate = data_get($appointment, 'appointment_date');
                if (!$appointmentDate) {
                    continue;
                }

                $appointmentStart = Carbon::parse($appointmentDate, $timezone)->setTimezone($timezone);
                if ($appointmentStart->format('Y-m-d') !== $schedule->work_date) {
                    continue;
                }

                $appointmentDuration = max(
                    1,
                    (int) (data_get($appointment, 'booking_duration_minutes') ?: $duration)
                );
                $appointmentEnd = $appointmentStart->copy()->addMinutes($appointmentDuration);

                if ($slotStart->lt($appointmentEnd) && $slotEnd->gt($appointmentStart)) {
                    $isBooked = true;
                    break;
                }
            }

            if (!$isBooked) {
                $slots[] = [
                    'time' => $slotStart->format('H:i'),
                    'label' => $slotStart->format('h:i A'),
                ];
            }
        }

        return $slots;
    }
}
