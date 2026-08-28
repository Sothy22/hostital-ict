<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('Auth.login');
})->name('login');

Route::get('/forgetpass', function () {
    return view('Auth.forgetPassword');
})->name('forgetpass');

Route::get('/resetpass', function () {
    return view('Auth.resetPassword');
})->name('resetpass');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');

Route::middleware(['auth'])->group(function() {

    // ============= Admin =============
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', function () {
            return view('Admin.pages.main_admin');
        })->name('admin');
    });

    // ============= Doctor =============
    Route::middleware(['role:doctor'])->group(function () {
        Route::get('/doctor', function () {
            return view('Doctor.pages.main_doctor');
        })->name('doctor');
    });

    // ======= for logout =========
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});






