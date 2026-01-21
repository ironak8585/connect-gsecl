<?php

use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\Master2dEmployeeController;
use App\Http\Controllers\Employee\MasterEmployeeController;
use App\Http\Controllers\Employee\MasterMdEmployeeController;
use App\Models\Employee\MasterEmployee;
use Illuminate\Support\Facades\Route;

/** *************************************************************************************************************** */
/**
 * BACKUP REFERENCE CODE
 */
// Route::middleware(["role:SUPER_ADMIN", "permission:admin_permissions_manage"])->group(function () {
//     Route::resource('permissions', PermissionController::class);
// });

// Route::resource('permissions', PermissionController::class)
//     ->middleware(['role:SUPER_ADMIN', 'permission:admin_permissions_manage']);

/** *************************************************************************************************************** */
// Route for Employees View
Route::middleware(['permission:employee_employees_read'])->group(function () {
    Route::get('employees/{employee_number}/details', [EmployeeController::class, 'details'])->name('employees.details');
    Route::get('employees/search', [EmployeeController::class, 'search'])->name('employees.search');
    Route::get('employees/filter', [EmployeeController::class, 'filter'])->name('employees.filter');
    Route::resource('employees', EmployeeController::class);
});

// Routes for MD Sir and HR Head - Master MD Employees 
Route::middleware(['permission:master_md_employee_read'])->group(function () {
    Route::get('master-md-employees/{employee_number}/details', [MasterMdEmployeeController::class, 'details'])->name('master-md-employees.details');
    Route::get('master-md-employees/search', [MasterMdEmployeeController::class, 'search'])->name('master-md-employees.search');
    Route::get('master-md-employees/filter', [MasterMdEmployeeController::class, 'filter'])->name('master-md-employees.filter');
    Route::resource('master-md-employees', MasterMdEmployeeController::class);
});

Route::middleware(['permission:master_2d_employee_read'])->group(function () {

    Route::get('master-2d-employees/matrix-by-designation-organization', [Master2dEmployeeController::class, 'matrixByDesignationOrganization'])->name('master-2d-employees.matrix-by-designation-organization');

    Route::get('master-2d-employees/matrix-by-designation', [Master2dEmployeeController::class, 'matrixByDesignation'])->name('master-2d-employees.matrix-by-designation');

    Route::get('master-2d-employees/matrix-by-organization', [Master2dEmployeeController::class, 'matrixByOrganization'])->name('master-2d-employees.matrix-by-organization');

    Route::get('master-2d-employees/master-2d-employee-listing', [Master2dEmployeeController::class, 'master2dEmployeeListing'])->name('master-2d-employees.master-2d-employee-listing');

    Route::resource('master-2d-employees', Master2dEmployeeController::class)->except(['index', 'show']);
});
Route::middleware(['permission:master_2d_employee_manage|master_2d_employee_read'])->group(function () {
    Route::resource('master-2d-employees', Master2dEmployeeController::class)->only(['index', 'show']);
});

// Define the parameter binding once globally for the model
// This is the cleanest way, but affects ALL routes that use the MasterEmployee model name
Route::model('master_employee', MasterEmployee::class, function () {
    return 'employee_number';
});

// read routes
Route::middleware(['permission:master_employee_read'])->group(function () {
    Route::resource('master-employees', MasterEmployeeController::class)->only(['index', 'show']);
});

// manage routes
Route::middleware(['permission:master_employee_manage|master_employee_read'])->group(function () {
    Route::resource('master-employees', MasterEmployeeController::class)->except(['index', 'show']);
});

