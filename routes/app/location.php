<?php

use App\Http\Controllers\Location\LocationController;
use Illuminate\Support\Facades\Route;

/** *************************************************************************************************************** */
//  LOCATION REFERENCE CODE - STARTS
/** *************************************************************************************************************** */

// Manage Level Routes
// Route::middleware(['role:SUPER_ADMIN|ADMIN', 'permission:app_content_circular_manage'])->group(function () {
//     // CREATE route
//     Route::get('circulars/create', [CircularController::class, 'create'])->name('circulars.create');
//     Route::post('circulars', [CircularController::class, 'store'])->name('circulars.store');
    
//     // EDIT route
//     Route::get('circulars/{circular}/edit', [CircularController::class, 'edit'])->name('circulars.edit');
//     Route::put('circulars/{circular}', [CircularController::class, 'update'])->name('circulars.update');
//     Route::delete('circulars/{circular}', [CircularController::class, 'destroy'])->name('circulars.destroy');

//     // restore & force delete
//     Route::patch('circulars/{circular}/restore', [CircularController::class, 'restore'])->name('circulars.restore');
//     Route::delete('circulars/{id}/force', [CircularController::class, 'forceDelete'])->name('circulars.forceDelete');
// });


// READ-only routes
Route::middleware(['role:SUPER_ADMIN|ADMIN', 'permission:app_location_locations_read'])->group(function () {
    Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
    
    // SHOW route
    Route::get('locations/{location}', [LocationController::class, 'show'])->name('locations.show');
});

/** *************************************************************************************************************** */
//  CONTENT REFERENCE CODE - ENDS
/** *************************************************************************************************************** */
