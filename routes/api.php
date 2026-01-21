<?php

use App\Http\Controllers\Api\AuthProxyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/intranet/eurja/login', function () {
    return response()->json([
        'message' => 'Method Not Allowed. Please use POST.'
    ], 405);
});

Route::post('/intranet/eurja/login', [AuthProxyController::class, 'login']);

Route::get('/test', function () {
    return "test";
});

// Route::middleware('auth:sanctum')->group(function () {
//     // Define your authenticated routes here
//     Route::get('/authenticated-route', function () {
//         return "This is an authenticated route.";
//     });
// });