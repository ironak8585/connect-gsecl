<?php

use App\Http\Controllers\Web\Request\TransferController;
use Illuminate\Support\Facades\Route;

/** *************************************************************************************************************** */
//  REQUEST - TRANSFER Routes
/** *************************************************************************************************************** */

Route::get('transfers', [TransferController::class, 'index'])->name('transfers.index');
Route::get('transfers/{transfer}', [TransferController::class, 'show'])->name('transfers.show');

/** *************************************************************************************************************** */
