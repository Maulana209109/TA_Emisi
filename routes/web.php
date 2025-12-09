<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmissionWebController;

// Route untuk Tamu (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin']); // Redirect root ke login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Route Logout (Bisa diakses semua user yg login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- GROUP ROUTE UNTUK ADMIN ---
// Menggunakan middleware 'role:admin'
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Tambahkan route admin lainnya di sini...
});

// --- GROUP ROUTE UNTUK USER BIASA ---
// Menggunakan middleware 'role:user'
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('pages.user.dashboard');
    })->name('user.dashboard');

    // Dashboard & Menu Utama
    Route::get('/emission/dashboard', [EmissionWebController::class, 'dashboard'])->name('emission.dashboard');

    // Input Data
    Route::get('/emission/input', [EmissionWebController::class, 'create'])->name('emission.create');
    Route::post('/emission/input', [EmissionWebController::class, 'store'])->name('emission.store');

    // Riwayat
    Route::get('/emission/history', [EmissionWebController::class, 'history'])->name('emission.history');

    // Tambahkan route user lainnya di sini...
});
