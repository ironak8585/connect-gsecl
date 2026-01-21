<?php

use Illuminate\Support\Facades\Route;

// content related route prefix
Route::prefix('content')
    ->name('content.')
    ->group(base_path('routes/app/content.php'));

// request related route prefix
Route::prefix('request')
    ->name('request.')
    ->group(base_path('routes/app/request.php'));

// location related route prefix
Route::prefix('location')
    ->name('location.')
    ->group(base_path('routes/app/location.php'));