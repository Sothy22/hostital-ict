<?php

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

    Route::get('/admin', function () {
        return view('Dashboard.Admin.main_admin', [
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
        return view('Dashboard.Admin.doctor_page', [
            'doctors' => User::with('department')
                ->where('role', 'doctor')
                ->get(),
            'roles' => Role::all(),
            'departments' => Department::all(),
        ]);
    })->name('admin_doctor');

    Route::get('/admin_accountant', function () {
        return view('Dashboard.Admin.accountant_page', [
            'roles' => Role::all(),
            'departments' => Department::all(),
        ]);
    })->name('admin_accountant');

    Route::get('/admin_pharmacy', function () {
        return view('Dashboard.Admin.pharmacy_page', [
            'roles' => Role::all(),
            'departments' => Department::all(),
        ]);
    })->name('admin_pharmacy');

    Route::get('/admin_receptionist', function () {
        return view('Dashboard.Admin.receptionist_page', [
            'roles' => Role::all(),
            'departments' => Department::all(),
        ]);
    })->name('admin_receptionist');
    // Route::get('/add_staff', function () {
    //     return view('Dashboard.Admin.add_staff_page');
    // })->name('add_staff');

    Route::get('/permission_page', function () {
        return view('Dashboard.Admin.permission');
    })->name('permission_page');

});

 // ============= Doctor =============
Route::middleware(['auth'])->group(function() {
    Route::middleware(['role:doctor'])->group(function () {
        Route::get('/doctor', function () {
            $totalPatients = Patient::count();

            return view('Dashboard.Doctor.main_doctor', compact('totalPatients'));
        })->name('main_doctor');

        Route::get('/appointment_doctor', function () {
            return view('Dashboard.Doctor.appointment_doctor');
        })->name('appointment_doctor');

         Route::get('/patient_doctor', function () {
            return view('Dashboard.Doctor.patient_doctor');
        })->name('patient_doctor');

    });

});
