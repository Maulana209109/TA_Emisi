<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmissionWebController;
use App\Http\Controllers\KpiReportExportController;

// ── Tamu (belum login) ──────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/',        [AuthController::class, 'showLogin'])->name('home');
    Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',  [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// ── Logout (semua user yang sudah login) ────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ── Admin ───────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Balanced Scorecard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard/refresh', [KpiReportExportController::class, 'refresh'])->name('dashboard.refresh');
        Route::get('/dashboard/export', [KpiReportExportController::class, 'csv'])->name('dashboard.export');
        Route::get('/dashboard/report', [KpiReportExportController::class, 'report'])->name('dashboard.report');

        // User Management
        Route::get('/users',         [AdminController::class, 'userIndex'])->name('users.index');
        Route::post('/users',        [AdminController::class, 'userStore'])->name('users.store');
        Route::put('/users/{id}',    [AdminController::class, 'userUpdate'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'userDestroy'])->name('users.destroy');

        // Category Management
        Route::get('/categories',         [AdminController::class, 'categoryIndex'])->name('categories.index');
        Route::post('/categories',        [AdminController::class, 'categoryStore'])->name('categories.store');
        Route::put('/categories/{id}',    [AdminController::class, 'categoryUpdate'])->name('categories.update');
        Route::delete('/categories/{id}', [AdminController::class, 'categoryDestroy'])->name('categories.destroy');

        // Emission Factors Management
        Route::get('/factors',         [AdminController::class, 'factorIndex'])->name('factors.index');
        Route::post('/factors',        [AdminController::class, 'factorStore'])->name('factors.store');
        Route::put('/factors/{id}',    [AdminController::class, 'factorUpdate'])->name('factors.update');
        Route::delete('/factors/{id}', [AdminController::class, 'factorDestroy'])->name('factors.destroy');
    });

// ── User biasa ───────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:user'])->group(function () {

    // user.dashboard → redirect langsung ke emission.dashboard
    Route::get('/user/dashboard', function () {
        return redirect()->route('emission.dashboard');
    })->name('user.dashboard');

    // Dashboard & Input Emisi
    Route::get('/emission/dashboard', [EmissionWebController::class, 'dashboard'])->name('emission.dashboard');
    Route::get('/emission/input',     [EmissionWebController::class, 'create'])->name('emission.create');
    Route::post('/emission/input',    [EmissionWebController::class, 'store'])->name('emission.store');
    Route::get('/emission/history',   [EmissionWebController::class, 'history'])->name('emission.history');
});
