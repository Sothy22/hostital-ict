<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\DoctorScheduleApprovalController;
use App\Http\Controllers\Doctor\DoctorScheduleController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Layout\HomeController;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// ================= Authentication =================
// page for login
Route::get('/login', function (Illuminate\Http\Request $request) {
    if ($request->query('redirect') === 'appointment') {
        session()->put('url.intended', route('appointment_page'));
    }

    return view('auth.login');
})->name('login');

// login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.submit');

// ======= for logout =========
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:admin,web')
    ->name('logout');

// page for forgot password
Route::get('/forgetpass', function () {
    return view('auth.forgetPassword');
})->name('forgetpass');

// Forgot password submit
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('/forget-password', 'sendResetLinkEmail')->name('password.email');
});

// page for reset password
Route::get('/resetpass', function () {
    return view('auth.resetPassword');
})->name('resetpass');

// Reset password
Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('reset-password', 'reset')->name('password.update');
});

// ================= Layout =================
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/appointment_page', [HomeController::class, 'appointment_page'])
    ->name('appointment_page');
Route::post('/appointment_page', [HomeController::class, 'storeAppointment'])
    ->name('appointment.store');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/contact_us', [HomeController::class, 'contact_us'])->name('contact_us');
Route::get('/department', [HomeController::class, 'department'])->name('department');
Route::get('/doctors', [HomeController::class, 'doctor'])->name('doctors');
Route::get('/doctor-schedule-availability', [DoctorScheduleController::class, 'availability'])
    ->name('doctor_schedules.availability');

// ============= Admin =============
Route::middleware(['auth:admin'])->group(function() {

    Route::get('/admin/doctor-schedules', [DoctorScheduleApprovalController::class, 'index'])
        ->name('admin.doctor_schedules.index');
    Route::put('/admin/doctor-schedules/{schedule}', [DoctorScheduleApprovalController::class, 'update'])
        ->name('admin.doctor_schedules.update');
    Route::post('/admin/doctor-schedules/{schedule}/approve', [DoctorScheduleApprovalController::class, 'approve'])
        ->name('admin.doctor_schedules.approve');
    Route::post('/admin/doctor-schedules/{schedule}/reject', [DoctorScheduleApprovalController::class, 'reject'])
        ->name('admin.doctor_schedules.reject');

    Route::get('/add_staff', [StaffController::class, 'create'])->name('add_staff');
    Route::post('/add_staff', [StaffController::class, 'store'])->name('staff.store');
    Route::put('update_staff/{id}', [StaffController::class, 'update'])->name('update.staff');
    Route::delete('delete_staff/{id}', [StaffController::class, 'destroy'])->name('delete.staff');

    Route::get('/admin', function () {
        return view('dashboard.admin.main_admin', [
            'totalPatients' => Patient::count(),
            'totalDoctors' => User::where('role', 'doctor')->count(),
            'totalAppointments' => Appointment::count(),
            'totalStaff' => User::count(),
            'roles' => Role::all(),
            'departments' => Department::all(),
            'appointments' => Appointment::with(['patient', 'staff'])
                ->latest('appointment_date')
                ->take(6)
                ->get(),
            'patients' => Patient::latest()
                ->take(6)
                ->get(),
            'popularDoctors' => User::where('role', 'doctor')
                ->take(3)
                ->get(),
            'scheduleDoctors' => User::where('role', 'doctor')
                ->take(4)
                ->get(),
        ]);
    })->name('main_admin');

    Route::get('/admin_patients', function () {
        $patients = Patient::with([
            'user',
            'appointments.staff.department',
            'medical_record.staff.department',
            'medicalHistory',
        ])
            ->orderBy('full_name')
            ->paginate(10);

        return view('dashboard.admin.patient', compact('patients'));
    })->name('admin_patients');

    Route::post('/admin_patients', function (Request $request) {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:100'],
            'dob' => ['required', 'date', 'before_or_equal:today'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'phone' => ['required', 'string', 'max:30'],
            'blood_group' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        Patient::create($validated);

        return redirect()->route('admin_patients')
            ->with('success', 'Patient added successfully.');
    })->name('admin_patients.store');

    Route::get('/admin_appointments', function () {
        $appointments = Appointment::with(['patient.user', 'staff.department'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
        $patients = Patient::orderBy('full_name')->get();
        $doctors = User::where('role', 'doctor')->orderBy('name')->get();

        return view('dashboard.admin.appointment', compact('appointments', 'patients', 'doctors'));
    })->name('admin_appointments');

    Route::post('/admin_appointments', function (Request $request) {
        $validated = $request->validate([
            'patient_id' => ['required', 'string'],
            'staff_id' => ['required', 'string'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'purpose' => ['required', 'string', 'max:500'],
        ]);

        $patient = Patient::find($validated['patient_id']);
        if (!$patient) {
            return back()->withErrors(['patient_id' => 'Select a valid patient.'])->withInput();
        }

        $doctor = User::where('role', 'doctor')->find($validated['staff_id']);
        if (!$doctor) {
            return back()->withErrors(['staff_id' => 'Select a valid doctor.'])->withInput();
        }

        $appointmentDate = \Illuminate\Support\Carbon::createFromFormat(
            'Y-m-d H:i',
            $validated['appointment_date'] . ' ' . $validated['appointment_time'],
            config('app.timezone')
        );

        Appointment::create([
            'patient_id' => $patient->getKey(),
            'staff_id' => $doctor->getKey(),
            'department_id' => $doctor->department_id,
            'appointment_date' => $appointmentDate,
            'purpose' => $validated['purpose'],
            'patient_type' => 'old',
            'status' => 'Scheduled',
        ]);

        return redirect()->route('admin_appointments')
            ->with('success', 'Appointment created successfully.');
    })->name('admin_appointments.store');

    Route::put('/admin_appointments/{appointmentId}', function (Request $request, $appointmentId) {
        $appointment = Appointment::findOrFail($appointmentId);
        $validated = $request->validate([
            'patient_id' => ['required', 'string'],
            'staff_id' => ['required', 'string'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'purpose' => ['required', 'string', 'max:500'],
        ]);

        $patient = Patient::find($validated['patient_id']);
        if (!$patient) {
            return back()->withErrors(['patient_id' => 'Select a valid patient.'])->withInput();
        }

        $doctor = User::where('role', 'doctor')->find($validated['staff_id']);
        if (!$doctor) {
            return back()->withErrors(['staff_id' => 'Select a valid doctor.'])->withInput();
        }

        $appointmentDate = \Illuminate\Support\Carbon::createFromFormat(
            'Y-m-d H:i',
            $validated['appointment_date'] . ' ' . $validated['appointment_time'],
            config('app.timezone')
        );

        if ($appointment->getAttribute('booking_slot_key')) {
            $appointment->unset('booking_slot_key');
        }

        $appointment->update([
            'patient_id' => $patient->getKey(),
            'staff_id' => $doctor->getKey(),
            'department_id' => $doctor->department_id,
            'appointment_date' => $appointmentDate,
            'purpose' => $validated['purpose'],
        ]);

        return redirect()->route('admin_appointments')
            ->with('success', 'Appointment updated successfully.');
    })->name('admin_appointments.update');

    Route::post('/admin_appointments/{appointmentId}/cancel', function ($appointmentId) {
        $appointment = Appointment::findOrFail($appointmentId);
        $status = strtolower($appointment->status ?? '');

        if (in_array($status, ['cancelled', 'canceled'], true)) {
            return back()->with('error', 'This appointment is already cancelled.');
        }

        if (in_array($status, ['completed', 'discharged', 'checked out', 'checked_out'], true)) {
            return back()->with('error', 'Completed appointments cannot be cancelled.');
        }

        $appointment->unset('booking_slot_key');
        $appointment->update(['status' => 'Cancelled']);

        return redirect()->route('admin_appointments')
            ->with('success', 'Appointment cancelled successfully.');
    })->name('admin_appointments.cancel');

    Route::get('/admin_doctor', function () {
        return view('dashboard.admin.doctor_page', [
            'doctors' => User::with('department')
                ->where('role', 'doctor')
                ->get(),
            'roles' => Role::all(),
            'departments' => StaffController::departmentsForRole('doctor'),
            'defaultRole' => 'doctor',
        ]);
    })->name('admin_doctor');

    Route::get('/admin_accountant', function () {
        return view('dashboard.admin.accountant_page', [
            'accountants' => User::with('department')
                ->where('role', 'accountant')
                ->get(),
            'roles' => Role::all(),
            'departments' => StaffController::departmentsForRole('accountant'),
            'defaultRole' => 'accountant',
        ]);
    })->name('admin_accountant');

    Route::get('/admin_pharmacy', function () {
        return view('dashboard.admin.pharmacy_page', [
            'pharmacys' => User::with('department')
                ->where('role', 'pharmacy')
                ->get(),
            'roles' => Role::all(),
            'departments' => StaffController::departmentsForRole('pharmacy'),
            'defaultRole' => 'pharmacy',
        ]);
    })->name('admin_pharmacy');

    Route::get('/admin_receptionist', function () {
        return view('dashboard.admin.receptionist_page', [
            'receptionists' => User::with('department')
                ->where('role', 'receptionist')
                ->get(),
            'roles' => Role::all(),
            'departments' => StaffController::departmentsForRole('receptionist'),
            'defaultRole' => 'receptionist',
        ]);
    })->name('admin_receptionist');

    Route::get('/permission_page', function () {
        $staffRoles = ['doctor', 'accountant', 'pharmacy', 'receptionist'];

        $staffs = User::with('department')
            ->whereIn('role', $staffRoles)
            ->get();

        $selectedStaffId = (string) request()->query('staff_id', '');

        $selectedStaff = $staffs->first(
            fn (User $staff) => (string) $staff->getKey() === $selectedStaffId
        );

        return view('dashboard.admin.permission', [
            'staffs' => $staffs,
            'permissionGroups' => config('permissions'),
            'selectedStaff' => $selectedStaff,
            'selectedPermissions' => $selectedStaff
                ? ($selectedStaff->permissions ?? [])
                : [],
        ]);
    })->name('permission_page');

    Route::post('/assign_permissions', [
        PermissionController::class,
        'assign'
    ])->name('permissions.assign');

});

 // ============= Doctor =============
Route::middleware(['auth'])->group(function() {
    Route::middleware(['role:doctor'])->group(function () {

        Route::get('/doctor/work-schedules', [DoctorScheduleController::class, 'index'])
            ->name('doctor_schedules.index');
        Route::post('/doctor/work-schedules', [DoctorScheduleController::class, 'store'])
            ->name('doctor_schedules.store');

        Route::put('/doctor/profile', [StaffController::class, 'updateProfile'])
            ->name('doctor.profile.update');

        Route::get('/appointment_doctor', function () {
            return view('dashboard.doctor.appointment_doctor');
        })->middleware('permission:read_appointment')->name('appointment_doctor');

        Route::get('/doctor', function () {
            $user = auth('web')->user();
            $canReadAppointments = $user->hasPermission('read_appointment');
            $today = now()->startOfDay();
            $tomorrow = $today->copy()->addDay();

            $appointments = $canReadAppointments
                ? $user->appointment()
                    ->with('patient')
                    ->orderBy('appointment_date', 'asc')
                    ->take(5)
                    ->get()
                : collect();

            $totalPatients = $user->hasPermission('read_patient')
                ? Patient::count()
                : null;

            $totalAppointment = $canReadAppointments
                ? $user->appointment()
                    ->where(function ($query) use ($today, $tomorrow) {
                        $query->where(function ($dateQuery) use ($today, $tomorrow) {
                            $dateQuery->where('appointment_date', '>=', $today)
                                ->where('appointment_date', '<', $tomorrow);
                        })->orWhere(function ($dateQuery) use ($today, $tomorrow) {
                            $dateQuery->where('appointment_date', '>=', $today->format('Y-m-d H:i:s'))
                                ->where('appointment_date', '<', $tomorrow->format('Y-m-d H:i:s'));
                        });
                    })
                    ->count()
                : 0;
            $departments = Department::all();
            $departmentsById = $departments->keyBy(
                fn ($department) => (string) $department->getKey()
            );

            return view('dashboard.doctor.main_doctor', compact(
                'totalPatients',
                'totalAppointment',
                'appointments',
                'canReadAppointments',
                'departments',
                'departmentsById'
            ));
        })->name('main_doctor');

        Route::get('/appointment_doctor', function () {
            return view('dashboard.doctor.appointment_doctor');
        })->name('appointment_doctor');

        Route::get('/patient_doctor', function () {
            $doctor = auth('web')->user();
            $patients = Patient::with('user')
                ->orderBy('full_name')
                ->get();
            $appointments = $doctor->appointment()
                ->with(['patient.user', 'staff'])
                ->orderBy('appointment_date', 'desc')
                ->get();

            return view('dashboard.doctor.patient_doctor', compact('patients', 'appointments'));
        })->middleware('permission:read_patient')->name('patient_doctor');

        Route::post('/patient_doctor', function (Request $request) {
            $validated = $request->validate([
                'patient_id' => ['required', 'string'],
                'appointment_date' => ['required', 'date', 'after_or_equal:today'],
                'appointment_time' => ['required', 'date_format:H:i'],
                'purpose' => ['required', 'string', 'max:500'],
            ]);

            $patient = Patient::find($validated['patient_id']);
            if (!$patient) {
                return back()->withErrors(['patient_id' => 'Select a valid patient.'])->withInput();
            }

            $doctor = auth('web')->user();
            $appointmentDate = \Illuminate\Support\Carbon::createFromFormat(
                'Y-m-d H:i',
                $validated['appointment_date'] . ' ' . $validated['appointment_time'],
                config('app.timezone')
            );

            Appointment::create([
                'patient_id' => $patient->getKey(),
                'staff_id' => $doctor->getKey(),
                'department_id' => $doctor->department_id,
                'appointment_date' => $appointmentDate,
                'purpose' => $validated['purpose'],
                'patient_type' => 'old',
                'status' => 'Scheduled',
            ]);

            return redirect()->route('patient_doctor')
                ->with('success', 'Appointment created successfully.');
        })->middleware('permission:create_appointment')->name('patient_doctor.store');

    });

});
