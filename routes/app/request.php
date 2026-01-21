<?php

use App\Http\Controllers\App\Request\TransferController;
use Illuminate\Support\Facades\Route;

/** *************************************************************************************************************** */
//  REQUESTS REFERENCE CODE - STARTS
/** *************************************************************************************************************** */

// Manage Level Routes
Route::middleware(['role:SUPER_ADMIN|ADMIN', 'permission:app_request_transfer_manage'])->group(function () {
    // CREATE route
    Route::get('transfers/create', [TransferController::class, 'create'])->name('transfers.create');
    Route::post('transfers', [TransferController::class, 'store'])->name('transfers.store');
    
    // EDIT route
    Route::get('transfers/{transfer}/edit', [TransferController::class, 'edit'])->name('transfers.edit');
    Route::put('transfers/{transfer}', [TransferController::class, 'update'])->name('transfers.update');
    Route::delete('transfers/{transfer}', [TransferController::class, 'destroy'])->name('transfers.destroy');

    // restore & force delete
    Route::patch('transfers/{transfer}/restore', [TransferController::class, 'restore'])->name('transfers.restore');
    Route::delete('transfers/{id}/force', [TransferController::class, 'forceDelete'])->name('transfers.forceDelete');
});


// READ-only routes
Route::middleware(['role:SUPER_ADMIN|ADMIN', 'permission:app_content_circular_read'])->group(function () {
    Route::get('transfers', [TransferController::class, 'index'])->name('transfers.index');
    
    // SHOW route
    Route::get('transfers/{transfer}', [TransferController::class, 'show'])->name('transfers.show');
});

/** *************************************************************************************************************** */
//  REQUESTS REFERENCE CODE - ENDS
/** *************************************************************************************************************** */
