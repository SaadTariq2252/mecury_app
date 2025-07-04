<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScopedAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ScopedPathController;
use App\Http\Controllers\Admin\UserManagementController;

// Admin routes (not scoped)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        // Scoped Paths Management
        Route::get('/scoped-paths', [ScopedPathController::class, 'index'])->name('scoped-paths.index');
        Route::get('/scoped-paths/create', [ScopedPathController::class, 'create'])->name('scoped-paths.create');
        Route::post('/scoped-paths', [ScopedPathController::class, 'store'])->name('scoped-paths.store');
        Route::get('/scoped-paths/{scopedPath}', [ScopedPathController::class, 'show'])->name('scoped-paths.show');
        Route::get('/scoped-paths/{scopedPath}/edit', [ScopedPathController::class, 'edit'])->name('scoped-paths.edit');
        Route::put('/scoped-paths/{scopedPath}', [ScopedPathController::class, 'update'])->name('scoped-paths.update');
        Route::delete('/scoped-paths/{scopedPath}', [ScopedPathController::class, 'destroy'])->name('scoped-paths.destroy');
        Route::patch('/scoped-paths/{scopedPath}/toggle', [ScopedPathController::class, 'toggle'])->name('scoped-paths.toggle');
        
        // User Management
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/assign-path', [UserManagementController::class, 'assignPath'])->name('users.assign-path');
        Route::post('/users/bulk-assign', [UserManagementController::class, 'bulkAssign'])->name('users.bulk-assign');
        Route::post('/users/bulk-import', [UserManagementController::class, 'bulkImport'])->name('users.bulk-import');
    });
});

// Block root access
Route::get('/', function () {
    return view('errors.scoped-access-required');
});

// Scoped path routes
Route::middleware(['validate.scoped.path'])->group(function () {
    Route::prefix('{path}')->name('scoped.')->group(function () {
        // Authentication routes
        Route::get('/login', [ScopedAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [ScopedAuthController::class, 'login']);
        
        // Protected routes
        Route::middleware(['auth', 'enforce.scoped.auth'])->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/dashboard', [DashboardController::class, 'index']);
            Route::post('/logout', [ScopedAuthController::class, 'logout'])->name('logout');
        });
    });
});