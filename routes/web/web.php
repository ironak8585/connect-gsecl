<?php

use Illuminate\Support\Facades\Route;

// Content route prefix
Route::prefix('content')
    ->name('content.')
    ->group(base_path('routes/web/content.php'));

// Request route prefix
Route::prefix('request')
    ->name('request.')
    ->group(base_path('routes/web/request.php'));


