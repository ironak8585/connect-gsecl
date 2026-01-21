<?php

use App\Http\Controllers\Admin\EurjaDepartmentController;
use App\Http\Controllers\Admin\EurjaEmployeeController;
use App\Http\Controllers\Admin\MasterEmployeeImportController;
use App\Http\Controllers\Admin\MyProfileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Models\Admin\EurjaEmployee;
use App\Models\Employee\Employee;
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

// EUrja Employee 
// Route::middleware(['role:SUPER_ADMIN|ADMIN', 'permission:admin_eurja_employee_sync'])->group(function () {
//     Route::get('eurja-employees/sync', [EurjaEmployeeController::class, 'sync'])->name('eurja-employees.sync');
// });
// Route::middleware(['role:SUPER_ADMIN|ADMIN', 'permission:admin_eurja_employee_manage'])->group(function () {
//     Route::get('eurja-employees/clear', [EurjaEmployeeController::class, 'clear'])->name('eurja-employees.clear');
//     Route::resource('eurja-employees', EurjaEmployeeController::class)->except(['index', 'show']);
// });
// Route::middleware(['role:SUPER_ADMIN|ADMIN', 'permission:admin_eurja_employee_read'])->group(function () {
//     Route::resource('eurja-employees', EurjaEmployeeController::class)->only(['index', 'show']);
// });


// This is the cleanest way, but affects ALL routes that use the MasterEmployee model name
Route::model('eurja_employee', EurjaEmployee::class);

Route::middleware(['role:SUPER_ADMIN|ADMIN', 'permission:admin_eurja_employee_sync'])->group(function () {
    Route::get('eurja-employees/sync', [EurjaEmployeeController::class, 'sync'])->name('eurja-employees.sync');
});

// read routes
Route::middleware(['permission:admin_eurja_employee_read'])->group(function () {
    Route::resource('eurja-employees', EurjaEmployeeController::class)->only(['index', 'show']);
});

// manage routes
Route::middleware(['permission:admin_eurja_employee_manage|admin_eurja_employee_read'])->group(function () {
    Route::resource('eurja-employees', EurjaEmployeeController::class)->except(['index', 'show']);
});

// This is the cleanest way, but affects ALL routes that use the MasterEmployee model name
Route::model('employee', Employee::class);

Route::middleware(['role:SUPER_ADMIN|ADMIN', 'permission:admin_employee_sync'])->group(function () {
    Route::get('employees/sync', [EmployeeController::class, 'sync'])->name('employees.sync');
});

// read routes
Route::middleware(['permission:admin_employee_read'])->group(function () {
    Route::resource('employees', EmployeeController::class)->only(['index', 'show']);
});

// manage routes
Route::middleware(['permission:admin_employee_manage|admin_employee_read'])->group(function () {
    Route::resource('employees', EmployeeController::class)->except(['index', 'show']);
});

// Master Employee Import
Route::middleware(['role:SUPER_ADMIN|ADMIN', 'permission:master_employee_import'])->group(function () {
    Route::get('master-employees/clear', [MasterEmployeeImportController::class, 'clear'])->name('master-employees.clear');
    Route::get('master-employees/import', [MasterEmployeeImportController::class, 'import'])->name('master-employees.import');
    Route::post('master-employees/process', [MasterEmployeeImportController::class, 'process'])->name('master-employees.process');
});

// Users
Route::middleware(['permission:admin_users_manage|admin_users_read'])->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'show']);
});
Route::middleware(['permission:admin_users_manage'])->group(function () {
    Route::patch('users/{user}/restore', [UserController::class, 'restore'])
        ->name('users.restore');
    Route::resource('users', UserController::class)->except(['index', 'show']);
});

// Roles
Route::middleware(['permission:admin_roles_manage|admin_roles_read'])->group(function () {
    Route::resource('roles', RoleController::class)->only(['index', 'show']);
});
Route::middleware(['permission:admin_roles_manage'])->group(function () {
    Route::patch('roles/{role}/restore', [RoleController::class, 'restore'])
        ->name('roles.restore');
    Route::resource('roles', RoleController::class)->except(['index', 'show']);
});

// Permissions
Route::middleware(['permission:admin_permissions_manage|admin_permissions_read'])->group(function () {
    Route::resource('permissions', PermissionController::class)->only(['index', 'show']);
});
Route::middleware(['permission:admin_permissions_manage'])->group(function () {
    Route::patch('permissions/{permission}/restore', [PermissionController::class, 'restore'])
        ->name('permissions.restore');
    Route::resource('permissions', PermissionController::class)->except(['index', 'show']);
});

/**
 * MyProfile related routes
 */
Route::middleware(['permission:my_profile_manage|my_profile_read'])->group(function () {
    Route::resource('my-profile', MyProfileController::class)->only(['index', 'show']);
});
Route::middleware(['permission:my_profile_manage'])->group(function () {
    Route::get('my-profile/sync', [MyProfileController::class, 'sync'])->name('my-profile.sync');
    Route::resource('my-profile', MyProfileController::class)->except(['index', 'show']);
});

// eUrja Departments
Route::middleware(['permission:admin_eurja_departments_manage|admin_eurja_departments_read'])->group(function () {
    Route::resource('eurja_departments', EurjaDepartmentController::class)->only(['index', 'show']);
});
Route::middleware(['permission:admin_eurja_departments_manage'])->group(function () {
    Route::patch('eurja_departments/{eurjaDepartment}/restore', [EurjaDepartmentController::class, 'restore'])
        ->name('eurja_departments.restore');
    Route::resource('eurja_departments', EurjaDepartmentController::class)->except(['index', 'show']);
});
