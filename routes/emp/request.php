<?php

use App\Http\Controllers\Emp\Request\TransferController;
use Illuminate\Support\Facades\Route;

/** *************************************************************************************************************** */
//  REQUEST - TRANSFER Routes
/** *************************************************************************************************************** */

// Manage Routes
Route::middleware(['permission:emp_request_transfer_manage'])->group(function () {
    // CREATE route
    Route::get('transfers/create', [TransferController::class, 'create'])->name('transfers.create');
    Route::post('transfers', [TransferController::class, 'store'])->name('transfers.store');

    // EDIT route
    Route::get('transfers/{transfer}/edit', [TransferController::class, 'edit'])->name('transfers.edit');
    Route::put('transfers/{transfer}', [TransferController::class, 'update'])->name('transfers.update');
    Route::delete('transfers/{transfer}', [TransferController::class, 'destroy'])->name('transfers.destroy');
});

// READ-only routes
Route::middleware(['permission:emp_request_transfer_read|emp_request_transfer_manage'])->group(function () {
    Route::get('transfers', [TransferController::class, 'index'])->name('transfers.index');
    Route::get('transfers/{transfer}', [TransferController::class, 'show'])->name('transfers.show');
});

/** *************************************************************************************************************** */
