<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Layout\HomeController;
use Illuminate\Support\Facades\Route;

// ================= Authentication =================
// page for login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

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
    Route::get('/admin', function () {
        return view('Dashboard.Admin.main_admin');
    })->name('main_admin');
});

 // ============= Doctor =============
Route::middleware(['auth'])->group(function() {
    Route::middleware(['role:doctor'])->group(function () {
        Route::get('/doctor', function () {
            return view('Dashboard.Doctor.main_doctor');
        })->name('main_doctor');

        Route::get('/patient_doctor', function () {
            return view('Dashboard.Doctor.patient_doctor');
        })->name('patient_doctor');

        Route::get('/appointment_doctor', function () {
            return view('Dashboard.Doctor.appointment_doctor');
        })->name('appointment_doctor');
    });

    // ======= for logout =========
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});






