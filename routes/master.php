<?php

use App\Http\Controllers\Admin\MasterEmployeeImportController;
use App\Http\Controllers\Master\CoreDepartmentController;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\SubDepartmentController;
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


// Master Employee Import
Route::middleware(['permission:master_employee_import'])->group(function () {
    // Route::resource('users', UserController::class)->except(['index', 'show']);

    Route::get('master-employees/import', [MasterEmployeeImportController::class, 'import'])->name('master-employees.import');
    Route::post('master-employees/process', [MasterEmployeeImportController::class, 'process'])->name('master-employees.process');
});

// Master Organizations
// Route::middleware(['permission:master_organizations_read'])->group(function () {
//     Route::resource('organizations', OrganizationController::class)->except(['index', 'show']);
// });
// Route::middleware(['permission:master_organizations_manage|master_organizations_read'])->group(function () {
//     Route::patch('organizations/{organization}/restore', [OrganizationController::class, 'restore'])
//         ->name('organizations.restore');
//     Route::resource('organizations', OrganizationController::class)->only(['index', 'show']);
// });

// Master Departments
Route::middleware(['permission:master_departments_manage|master_departments_read'])->group(function () {
    Route::resource('departments', DepartmentController::class)->only(['index', 'show']);
});
Route::middleware(['permission:master_departments_manage'])->group(function () {
    Route::resource('departments', DepartmentController::class)->except(['index', 'show', 'create', 'store']);
});

// Core Departments
Route::middleware(['permission:master_core_departments_read'])->group(function () {
    Route::resource('core_departments', CoreDepartmentController::class)->except(['index', 'show']);
});
Route::middleware(['permission:master_core_departments_manage|master_core_departments_read'])->group(function () {
    Route::patch('core_departments/{coreDepartment}/restore', [CoreDepartmentController::class, 'restore'])
        ->name('core_departments.restore');
    Route::resource('core_departments', CoreDepartmentController::class)->only(['index', 'show']);
});

// Sub Departments
Route::middleware(['permission:master_sub_departments_read'])->group(function () {
    Route::resource('sub_departments', SubDepartmentController::class)->except(['index', 'show']);
});
Route::middleware(['permission:master_sub_departments_manage|master_sub_departments_read'])->group(function () {
    Route::patch('sub_departments/{subDepartment}/restore', [SubDepartmentController::class, 'restore'])
        ->name('sub_departments.restore');
    Route::resource('sub_departments', SubDepartmentController::class)->only(['index', 'show']);
});
