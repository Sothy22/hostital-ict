<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\StaffController;
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
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

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
Route::get('/appointment_page', [HomeController::class, 'appointment_page'])->name('appointment_page');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/contact_us', [HomeController::class, 'contact_us'])->name('contact_us');
Route::get('/department', [HomeController::class, 'department'])->name('department');
Route::get('/doctors', [HomeController::class, 'doctor'])->name('doctors');

// ============= Admin =============
Route::middleware(['auth:admin'])->group(function() {

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
            'appointments' => Appointment::with('patient')
                ->latest('appointment_date')
                ->take(6)
                ->get(),
            'patients' => Patient::latest()
                ->take(6)
                ->get(),
        ]);
    })->name('main_admin');

    Route::get('/admin_doctor', function () {
        return view('dashboard.admin.doctor_page', [
            'doctors' => User::with('department')
                ->where('role', 'doctor')
                ->get(),
            'roles' => Role::all(),
            'departments' => Department::all(),
        ]);
    })->name('admin_doctor');

    Route::get('/admin_accountant', function () {
        return view('dashboard.admin.accountant_page', [
            'accountants' => User::with('department')
                ->where('role', 'accountant')
                ->get(),
            'roles' => Role::all(),
            'departments' => Department::all(),
        ]);
    })->name('admin_accountant');

    Route::get('/admin_pharmacy', function () {
        return view('dashboard.admin.pharmacy_page', [
            'pharmacys' => User::with('department')
                ->where('role', 'accountant')
                ->get(),
            'roles' => Role::all(),
            'departments' => Department::all(),
        ]);
    })->name('admin_pharmacy');

    Route::get('/admin_receptionist', function () {
        return view('dashboard.admin.receptionist_page', [
            'receptionists' => User::with('department')
                ->where('role', 'receptionist')
                ->get(),
            'roles' => Role::all(),
            'departments' => Department::all(),
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

Route::get('/appointment_doctor', function () {
    return view('dashboard.doctor.appointment_doctor');
})->middleware('permission:read_appointment')->name('appointment_doctor');
        // Route::get('/doctor', function () {
        //     $user = auth()->user();

        //     $totalPatients = $user->hasPermission('read_patient')
        //         ? Patient::count()
        //         : null;

        //     $appointments = $user->hasPermission('read_appointment')
        //     ? $user->appointment()
        //         ->with('patient')
        //         ->latest('appointment_date')
        //         ->take(5)
        //         ->get()
        //     : collect();

        //     $totalAppointment = $user->hasPermission('read_appointment')
        //         ? $user->appointment()->count()
        //         : 0;

        //     return view('dashboard.doctor.main_doctor', compact(
        //         'totalPatients',
        //         'totalAppointment',
        //         'appointments'
        //     ));
        // })->name('main_doctor');

Route::get('/doctor', function () {
    $user = auth('web')->user();
    $canReadAppointments = $user->hasPermission('read_appointment');

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
        ? $user->appointment()->count()
        : 0;

    return view('dashboard.doctor.main_doctor', compact(
        'totalPatients',
        'totalAppointment',
        'appointments',
        'canReadAppointments'
    ));
})->name('main_doctor');

        Route::get('/appointment_doctor', function () {
            return view('dashboard.doctor.appointment_doctor');
        })->name('appointment_doctor');

        Route::get('/patient_doctor', function () {
            return view('dashboard.doctor.patient_doctor');
        })->middleware('permission:read_patient')->name('patient_doctor');

    });

});
