<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Employee\Retired\RetiredEmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Request\RegisterController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/** for Guest Users */
Route::get('/', [ HomeController::class, 'index'])
    ->name('home');

Route::get('/send-test', function () {
    Mail::to('ironak8585@gmail.com')->send(new TestMail());
    return "Email Sent Successfully!";
});

// Retired Employees Routes

// CREATE route
Route::match(['GET', 'POST'], 'employee/retired-employees/register', [RetiredEmployeeController::class, 'register'])->name('employee.retired-employees.register');

/** for Logged User */
/** for Employee User */
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Custom Routes
/**
 * Grouping the routes in separate route files
 */
Route::group(['middleware' => ['auth']], function () {

    // Admin route prefix
    Route::prefix('admin')
        ->name('admin.')
        ->group(base_path('routes/admin.php'));

    // Master route prefix
    Route::prefix('master')
        ->name('master.')
        ->group(base_path('routes/master.php'));

    // Employee route prefix
    Route::prefix('employee')
        ->name('employee.')
        ->group(base_path('routes/employee.php'));
});

/**
 * Grouping the routes in separate route files
 */
Route::group(['middleware' => ['guest']], function () {
    // App route prefix
    Route::prefix('web')
        ->name('web.')
        ->group(base_path('routes/web/web.php'));
});

Route::group(['middleware' => ['auth']], function () {
    // App route prefix
    Route::prefix('app')
        ->name('app.')
        ->group(base_path('routes/app/app.php'));

    // Emp route prefix
    Route::prefix('emp')
        ->name('emp.')
        ->group(base_path('routes/emp/emp.php'));
});


require __DIR__ . '/auth.php';