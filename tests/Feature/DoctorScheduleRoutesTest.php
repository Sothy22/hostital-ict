<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DoctorScheduleRoutesTest extends TestCase
{
    public function test_doctor_and_admin_schedule_routes_use_the_existing_role_guards(): void
    {
        $routes = Route::getRoutes();

        $doctorSchedules = $routes->getByName('doctor_schedules.index');
        $adminSchedules = $routes->getByName('admin.doctor_schedules.index');
        $adminApproval = $routes->getByName('admin.doctor_schedules.approve');

        $this->assertNotNull($doctorSchedules);
        $this->assertContains('auth', $doctorSchedules->getAction('middleware'));
        $this->assertContains('role:doctor', $doctorSchedules->getAction('middleware'));

        $this->assertNotNull($adminSchedules);
        $this->assertContains('auth:admin', $adminSchedules->getAction('middleware'));

        $this->assertNotNull($adminApproval);
        $this->assertContains('auth:admin', $adminApproval->getAction('middleware'));
    }
}
