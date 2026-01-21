<?php

use App\Http\Controllers\Web\Content\CircularController;
use Illuminate\Support\Facades\Route;

// READ-only routes

/** *************************************************************************************************************** */
//  CONTENT REFERENCE CODE - STARTS
/** *************************************************************************************************************** */

Route::get('circulars', [CircularController::class, 'index'])->name('circulars.index');
Route::get('circulars/{circular}', [CircularController::class, 'show'])->name('circulars.show');

/** *************************************************************************************************************** */
//  CONTENT REFERENCE CODE - ENDS
/** *************************************************************************************************************** */
