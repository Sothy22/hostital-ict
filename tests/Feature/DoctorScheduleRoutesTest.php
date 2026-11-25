<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DoctorScheduleRoutesTest extends TestCase
{
    public function test_doctor_schedule_route_uses_the_existing_role_guard(): void
    {
        $routes = Route::getRoutes();

        $doctorSchedules = $routes->getByName('doctor_schedules.index');
        $this->assertNotNull($doctorSchedules);
        $this->assertContains('auth', $doctorSchedules->getAction('middleware'));
        $this->assertContains('role:doctor', $doctorSchedules->getAction('middleware'));
    }
}
