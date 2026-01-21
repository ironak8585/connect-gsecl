<?php

use Illuminate\Support\Facades\Route;

// Request route prefix
Route::prefix('request')
    ->name('request.')
    ->group(base_path('routes/emp/request.php'));


