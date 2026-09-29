<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Test\AppointmentController;
use App\Http\Controllers\Test\EmergencyContactController;
use App\Http\Controllers\Test\InvoiceController;
use App\Http\Controllers\Test\LabTestController;
use App\Http\Controllers\Test\MedicalHistoryController;
use App\Http\Controllers\Test\MedicalRecordController;
use App\Http\Controllers\Test\PatientController;
use App\Http\Controllers\Test\PrescriptionController;
use App\Http\Controllers\Test\VitalSignController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'apiLogin'])->name('api.login');
Route::post('/logout', [AuthController::class, 'apiLogout'])
    ->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/users', [AdminController::class, 'index']);
    Route::get('/users/{id}', [AdminController::class, 'show']);
    Route::post('/users', [AdminController::class, 'store']);
    Route::put('/users/{id}', [AdminController::class, 'update']);
    Route::delete('/users/{id}', [AdminController::class, 'destroy']);
});


// ============= Patient =============
Route::prefix("patient")->group(function () {
    Route::get("/", [PatientController::class, "index"]);
    Route::post("/", [PatientController::class, "store"]);
    Route::put("/{id}", [PatientController::class, "update"]);
    Route::delete("/{id}", [PatientController::class, "destroy"]);
});

// ============= Appointment =============
Route::prefix("appointment")->group(function () {
    Route::get("/", [AppointmentController::class, "index"]);
    Route::post("/", [AppointmentController::class, "store"]);
    Route::put("/{id}", [AppointmentController::class, "update"]);
    Route::delete("/{id}", [AppointmentController::class, "destroy"]);
});

// ============= Medical Record =============
Route::prefix("medical_record")->group(function () {
    Route::get("/", [MedicalRecordController::class, "index"]);
    Route::post("/", [MedicalRecordController::class, "store"]);
    Route::put("/{id}", [MedicalRecordController::class, "update"]);
    Route::delete("/{id}", [MedicalRecordController::class, "destroy"]);
});

// ============= Medical History =============
Route::prefix("medical_history")->group(function () {
    Route::get("/", [MedicalHistoryController::class, "index"]);
    Route::post("/", [MedicalHistoryController::class, "store"]);
    Route::put("/{id}", [MedicalHistoryController::class, "update"]);
    Route::delete("/{id}", [MedicalHistoryController::class, "destroy"]);
});

// ============= Emergency Contact =============
Route::prefix("emergencyContact")->group(function () {
    Route::get("/", [EmergencyContactController::class, "index"]);
    Route::post("/", [EmergencyContactController::class, "store"]);
    Route::put("/{id}", [EmergencyContactController::class, "update"]);
    Route::delete("/{id}", [EmergencyContactController::class, "destroy"]);
});

// ============= Prescription =============
Route::prefix("prescription")->group(function () {
    Route::get("/", [PrescriptionController::class, "index"]);
    Route::post("/", [PrescriptionController::class, "store"]);
    Route::put("/{id}", [PrescriptionController::class, "update"]);
    Route::delete("/{id}", [PrescriptionController::class, "destroy"]);
});

// ============= LabTest =============
Route::prefix("labTest")->group(function () {
    Route::get("/", [LabTestController::class, "index"]);
    Route::post("/", [LabTestController::class, "store"]);
    Route::put("/{id}", [LabTestController::class, "update"]);
    Route::delete("/{id}", [LabTestController::class, "destroy"]);
});

// ============= Vital Sign =============
Route::prefix("vitalSign")->group(function () {
    Route::get("/", [VitalSignController::class, "index"]);
    Route::post("/", [VitalSignController::class, "store"]);
    Route::put("/{id}", [VitalSignController::class, "update"]);
    Route::delete("/{id}", [VitalSignController::class, "destroy"]);
});

// ============= Invoice =============
Route::prefix("invoice")->group(function () {
    Route::get("/", [InvoiceController::class, "index"]);
    Route::post("/", [InvoiceController::class, "store"]);
    Route::put("/{id}", [InvoiceController::class, "update"]);
    Route::delete("/{id}", [InvoiceController::class, "destroy"]);
});
