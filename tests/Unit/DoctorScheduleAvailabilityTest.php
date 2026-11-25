<?php

namespace Tests\Unit;

use App\Models\DoctorSchedule;
use App\Services\DoctorScheduleAvailability;
use Carbon\Carbon;
use Tests\TestCase;

class DoctorScheduleAvailabilityTest extends TestCase
{
    public function test_it_excludes_slots_that_overlap_a_break(): void
    {
        $schedule = $this->schedule([
            'start_time' => '09:00',
            'end_time' => '12:00',
            'break_start' => '10:00',
            'break_end' => '10:30',
            'duration_minutes' => 30,
        ]);

        $slots = app(DoctorScheduleAvailability::class)->slotsFor($schedule);

        $this->assertSame(
            ['09:00', '09:30', '10:30', '11:00', '11:30'],
            array_column($slots, 'time')
        );
    }

    public function test_it_excludes_booked_and_cancelled_slots_correctly(): void
    {
        $schedule = $this->schedule([
            'start_time' => '09:00',
            'end_time' => '10:30',
            'duration_minutes' => 30,
        ]);
        $appointmentDate = Carbon::createFromFormat(
            'Y-m-d H:i',
            $schedule->work_date . ' 09:15',
            config('app.timezone')
        );

        $slots = app(DoctorScheduleAvailability::class)->slotsFor($schedule, [
            [
                'appointment_date' => $appointmentDate,
                'booking_duration_minutes' => 15,
                'status' => 'Scheduled',
            ],
            [
                'appointment_date' => Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $schedule->work_date . ' 10:00',
                    config('app.timezone')
                ),
                'booking_duration_minutes' => 30,
                'status' => 'Cancelled',
            ],
        ]);

        $this->assertSame(['09:30', '10:00'], array_column($slots, 'time'));
    }

    public function test_saved_schedules_have_bookable_slots(): void
    {
        $availability = app(DoctorScheduleAvailability::class);

        foreach (['pending', 'approved', 'rejected'] as $status) {
            $schedule = $this->schedule(['status' => $status]);
            $this->assertNotEmpty($availability->slotsFor($schedule));
        }
    }

    private function schedule(array $overrides = []): DoctorSchedule
    {
        return new DoctorSchedule(array_merge([
            'work_date' => Carbon::now(config('app.timezone'))->addDay()->toDateString(),
            'start_time' => '09:00',
            'end_time' => '11:00',
            'break_start' => null,
            'break_end' => null,
            'duration_minutes' => 30,
            'status' => 'approved',
        ], $overrides));
    }
}
