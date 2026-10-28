<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController; 
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Models\User;

// Route pancingan untuk testing
Route::get('/test-order', [OrderController::class, 'store']);

Route::get('/preview-email', function () {
    $dummyUser = new \App\Models\User();
    $dummyUser->name = 'Wafi Arifin';
    return new \App\Mail\WelcomeMail($dummyUser);   

    // Mengeksekusi pengiriman email
    Mail::to($dummyUser->email)->send(new WelcomeMail($dummyUser));

    return "Email berhasil diproses! Silakan cek file storage/logs/laravel.log";
});

Route::middleware(['auth'])->group(function () {
    // Khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });

    // Khusus Kasir
    Route::middleware('role:kasir')->group(function () {
        Route::get('/kasir/dashboard', [KasirController::class, 'dashboard'])->name('kasir.dashboard');
    });
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('products', ProductController::class);
Route::get('orders/{id}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
Route::get('/produk', [ProductController::class, 'index']);
