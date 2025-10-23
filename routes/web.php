<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentProofController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WeeklyPaymentController;
use App\Http\Controllers\AuditLogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Transactions
    Route::resource('transactions', TransactionController::class);

    // Payment Proofs
    Route::resource('payment-proofs', PaymentProofController::class);
    Route::post('/payment-proofs/{paymentProof}/approve', [PaymentProofController::class, 'approve'])->name('payment-proofs.approve');
    Route::post('/payment-proofs/{paymentProof}/reject', [PaymentProofController::class, 'reject'])->name('payment-proofs.reject');

    // Weekly Payments
    Route::get('/weekly-payments', [WeeklyPaymentController::class, 'index'])->name('weekly-payments.index');
    Route::post('/weekly-payments/generate', [WeeklyPaymentController::class, 'generate'])->name('weekly-payments.generate');
    Route::patch('/weekly-payments/{weeklyPayment}/mark-paid', [WeeklyPaymentController::class, 'markAsPaid'])->name('weekly-payments.mark-paid');
    Route::patch('/weekly-payments/{weeklyPayment}/mark-unpaid', [WeeklyPaymentController::class, 'markAsUnpaid'])->name('weekly-payments.mark-unpaid');
    Route::post('/weekly-payments/approve', [WeeklyPaymentController::class, 'approvePayment'])->name('weekly-payments.approve');
    Route::post('/weekly-payments/bulk-approve', [WeeklyPaymentController::class, 'bulkApprove'])->name('weekly-payments.bulk-approve');
    Route::get('/weekly-payments/export-excel', [WeeklyPaymentController::class, 'exportExcel'])->name('weekly-payments.export-excel');

    // Settings (Only for Bendahara)
    Route::middleware('auth')->group(function () {
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('/settings/create', [SettingsController::class, 'create'])->name('settings.create');
        Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');
        Route::get('/settings/{user}/edit', [SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings/{user}', [SettingsController::class, 'update'])->name('settings.update');
        Route::delete('/settings/{user}', [SettingsController::class, 'destroy'])->name('settings.destroy');
        Route::get('/settings/{user}/reset-password', [SettingsController::class, 'resetPassword'])->name('settings.reset-password');
        Route::put('/settings/{user}/reset-password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');

        // Role Management
        Route::get('/settings/roles', [SettingsController::class, 'roles'])->name('settings.roles');
        Route::get('/settings/roles/create', [SettingsController::class, 'createRole'])->name('settings.create-role');
        Route::post('/settings/roles', [SettingsController::class, 'storeRole'])->name('settings.store-role');
        Route::get('/settings/roles/{role}/edit', [SettingsController::class, 'editRole'])->name('settings.edit-role');
        Route::put('/settings/roles/{role}', [SettingsController::class, 'updateRole'])->name('settings.update-role');
        Route::delete('/settings/roles/{role}', [SettingsController::class, 'destroyRole'])->name('settings.destroy-role');

        // Backup & Export
        Route::get('/backup', [App\Http\Controllers\BackupController::class, 'index'])->name('backup.index');
        Route::post('/backup/create', [App\Http\Controllers\BackupController::class, 'createBackup'])->name('backup.create');
        Route::get('/backup/download/{filename}', [App\Http\Controllers\BackupController::class, 'downloadBackup'])->name('backup.download');
        Route::get('/backup/export/transactions', [App\Http\Controllers\BackupController::class, 'exportTransactions'])->name('backup.export.transactions');
        Route::get('/backup/export/payment-proofs', [App\Http\Controllers\BackupController::class, 'exportPaymentProofs'])->name('backup.export.payment-proofs');
        Route::get('/backup/export/users', [App\Http\Controllers\BackupController::class, 'exportUsers'])->name('backup.export.users');
        Route::get('/backup/export/weekly-payments', [App\Http\Controllers\BackupController::class, 'exportWeeklyPayments'])->name('backup.export.weekly-payments');
        Route::get('/backup/export/all', [App\Http\Controllers\BackupController::class, 'exportAll'])->name('backup.export.all');
    });

    // Audit Logs Routes
    Route::middleware(['auth', 'can:view_audit_logs'])->group(function () {
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
    });
});

require __DIR__.'/auth.php';
