<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', function () {
        return view('doctor.dashboard');
    })->name('doctor.dashboard');
});

Route::middleware(['auth', 'role:accountant'])->group(function () {
    Route::get('/accountant/dashboard', function () {
        return view('accountant.dashboard');
    })->name('accountant.dashboard');
});

Route::middleware(['auth', 'role:receptionist'])->group(function () {
    Route::get('/receptionist/dashboard', function () {
        return view('receptionist.dashboard');
    })->name('receptionist.dashboard');
});

Route::middleware(['auth', 'role:pharmacy'])->group(function () {
    Route::get('/pharmacy/dashboard', function () {
        return view('pharmacy.dashboard');
    })->name('pharmacy.dashboard');
});
