<?php

use App\Http\Controllers\Emp\Retired\RetiredEmployeeController;
use Illuminate\Support\Facades\Route;

/** *************************************************************************************************************** */
//  Retired - Employees Route from EMP
/** *************************************************************************************************************** */

// Manage Routes
Route::middleware(['permission:emp_retired_employee_manage'])->group(function () {
    // CREATE route
    Route::get('retired-employees/create', [RetiredEmployeeController::class, 'create'])->name('retired-employees.create');
    Route::post('retired-employees', [RetiredEmployeeController::class, 'store'])->name('retired-employees.store');

    // EDIT route
    Route::get('retired-employees/{retiredEmployee}/edit', [RetiredEmployeeController::class, 'edit'])->name('retired-employees.edit');
    Route::put('retired-employees/{retiredEmployee}', [RetiredEmployeeController::class, 'update'])->name('retired-employees.update');
    Route::delete('retired-employees/{retiredEmployee}', [RetiredEmployeeController::class, 'destroy'])->name('retired-employees.destroy');
});

// Additional routes
Route::middleware(['permission:emp_retired_employee_manage|emp_retired_employee_verify'])->group(function () {
    // Verify Routes
    Route::match(['GET', 'PUT'],'retired-employees/{retiredEmployee}/verify', [RetiredEmployeeController::class, 'verify'])->name('retired-employees.verify');
});

// READ-only routes
Route::middleware(['permission:emp_retired_employee_read|emp_retired_employee_manage|emp_retired_employee_verify'])->group(function () {
    Route::get('retired-employees', [RetiredEmployeeController::class, 'index'])->name('retired-employee.index');
    Route::get('retired-employees/{retiredEmployee}', [RetiredEmployeeController::class, 'show'])->name('retired-employee.show');
});

/** *************************************************************************************************************** */