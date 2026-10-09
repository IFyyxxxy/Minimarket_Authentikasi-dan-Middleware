<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route untuk login (bisa diakses publik)
Route::post('/login', [AuthController::class, 'login']);

// Route yang dilindungi middleware Sanctum (wajib pakai token)
Route::middleware('auth:sanctum')->group(function () {
    
    // Mengambil data user yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route untuk logout
    Route::post('/logout', [AuthController::class, 'logout']);
});