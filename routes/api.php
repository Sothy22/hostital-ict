<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/users', [AdminController::class, 'index']);
    Route::get('/users/{id}', [AdminController::class, 'show']);
    Route::post('/users', [AdminController::class, 'store']);
    Route::put('/users/{id}', [AdminController::class, 'update']);
    Route::delete('/users/{id}', [AdminController::class, 'destroy']);
});
