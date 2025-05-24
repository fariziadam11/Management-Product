<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportImportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public landing page
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Auth::routes();

// Protected routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Profile
    Route::get('/profile', function () {
        return view('users.profile', ['user' => Auth::user()]);
    })->name('profile');

    // Change user password
    Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password');

    // Role management
    Route::resource('roles', RoleController::class);

    // User management (only accessible to administrators)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Categories
    Route::resource('categories', CategoryController::class);

    // Products
    Route::resource('products', ProductController::class);

    // Product Reviews
    Route::resource('reviews', ProductReviewController::class);

    // Audits
    Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');
    Route::get('/audits/export', [AuditController::class, 'export'])->name('audits.export');
    Route::get('/audits/{audit}', [AuditController::class, 'show'])->name('audits.show');
    Route::get('/audits/{type}/{id}', [AuditController::class, 'showForModel'])->name('audits.model');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'dashboard'])->name('analytics.dashboard');

    // Export/Import
    Route::get('/export/{type}', [ExportImportController::class, 'showExportForm'])->name('export.form');
    Route::post('/export/{type}', [ExportImportController::class, 'export'])->name('export.process');
    Route::get('/download/{fileName}', [ExportImportController::class, 'download'])->name('export.download');

    // Direct export routes for specific types
    Route::get('/export-users', function() { return redirect()->route('export.form', ['type' => 'users']); })->name('export.users');

    // Direct import routes for specific types
    Route::get('/import-users', function() { return redirect()->route('import.form', ['type' => 'users']); })->name('users.import.form');

    Route::get('/import/{type}', [ExportImportController::class, 'showImportForm'])->name('import.form');
    Route::post('/import/{type}', [ExportImportController::class, 'import'])->name('import.process');
    Route::get('/import/sample-template/{type}/{format}', [ExportImportController::class, 'getSampleTemplate'])->name('import.sample-template');
    Route::get('/import/download-log/{id}', [ExportImportController::class, 'downloadImportLog'])->name('import.download-log');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationsController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [\App\Http\Controllers\NotificationsController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationsController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
});

// Redirect /home to /dashboard for compatibility
Route::redirect('/home', '/dashboard');
