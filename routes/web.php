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
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminController::class, 'userIndex'])->name('users.index');
    Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
    Route::put('/users/{id}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'userDestroy'])->name('users.destroy');

    // Category Management
    Route::get('/categories', [AdminController::class, 'categoryIndex'])->name('categories.index');
    Route::post('/categories', [AdminController::class, 'categoryStore'])->name('categories.store');
    Route::put('/categories/{id}', [AdminController::class, 'categoryUpdate'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'categoryDestroy'])->name('categories.destroy');

    // Emission Factors Management
    Route::get('/factors', [AdminController::class, 'factorIndex'])->name('factors.index');
    Route::post('/factors', [AdminController::class, 'factorStore'])->name('factors.store');
    Route::put('/factors/{id}', [AdminController::class, 'factorUpdate'])->name('factors.update');
    Route::delete('/factors/{id}', [AdminController::class, 'factorDestroy'])->name('factors.destroy');

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
