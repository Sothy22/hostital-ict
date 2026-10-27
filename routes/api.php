<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Test\AppointmentController;
use App\Http\Controllers\Test\DepartmentController;
use App\Http\Controllers\Test\EmergencyContactController;
use App\Http\Controllers\Test\InvoiceController;
use App\Http\Controllers\Test\LabTestController;
use App\Http\Controllers\Test\MedicalHistoryController;
use App\Http\Controllers\Test\MedicalRecordController;
use App\Http\Controllers\Test\PatientController;
use App\Http\Controllers\Test\PrescriptionController;
use App\Http\Controllers\Test\VitalSignController;
use Illuminate\Support\Facades\Route;

// Route::post('/login', [AuthController::class, 'apiLogin'])->name('api.login');
// Route::post('/logout', [AuthController::class, 'apiLogout'])
//     ->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'apiLogout'])
    ->middleware('auth:sanctum');

    Route::get('/users', [AdminController::class, 'index']);
    Route::get('/users/{id}', [AdminController::class, 'show']);
    Route::post('/users', [AdminController::class, 'store']);
    Route::put('/users/{id}', [AdminController::class, 'update']);
    Route::delete('/users/{id}', [AdminController::class, 'destroy']);

    // Role
    Route::apiResource('roles', RoleController::class);

    // Permissions
    Route::apiResource('permissions', PermissionController::class);

    // Role Permissions
    Route::get(
        'roles/{roleId}/permissions',
        [RolePermissionController::class, 'getRolePermissions']
    );

    Route::post(
        'roles/{roleId}/permissions',
        [RolePermissionController::class, 'store']
    );

    Route::post(
        'roles/{roleId}/permissions/multiple',
        [RolePermissionController::class, 'store']
    );

    Route::delete(
        'roles/{roleId}/permissions/{permissionId}',
        [RolePermissionController::class, 'destroy']
    );

});

// ============= role =============
// Route::prefix("role")->group(function () {
//     Route::get("/", [RoleController::class, "index"]);
//     Route::post("/", [RoleController::class, "store"]);
//     Route::put("/{id}", [RoleController::class, "update"]);
//     Route::delete("/{id}", [RoleController::class, "destroy"]);
// });

// ============= Department =============
Route::prefix("department")->group(function () {
    Route::get("/", [DepartmentController::class, "index"]);
    Route::post("/", [DepartmentController::class, "store"]);
    Route::put("/{id}", [DepartmentController::class, "update"]);
    Route::delete("/{id}", [DepartmentController::class, "destroy"]);
});


// ============= Patient =============
Route::middleware('auth:sanctum')->prefix("patient")->group(function () {
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
Route::prefix("emergency_contact")->group(function () {
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
