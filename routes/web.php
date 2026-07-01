<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $latestPengumumans = \App\Models\Pengumuman::where('is_active', true)
                            ->latest()
                            ->take(3)
                            ->get();
    return view('welcome', compact('latestPengumumans'));
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\LaporanController;

use App\Http\Controllers\KeuanganController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified', 'check.status'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::view('/verification/notice', 'auth.verification-notice')->name('verification.notice');
});

Route::middleware(['auth', 'check.status'])->group(function () {
    Route::resource('warga', WargaController::class);
    Route::resource('pengumuman', PengumumanController::class)->except(['show']);
    
    // Keuangan
    Route::get('/keuangan/pdf', [KeuanganController::class, 'exportPdf'])->name('keuangan.pdf');
    Route::resource('keuangan', KeuanganController::class)->except(['show']);
    
    // Surat
    Route::resource('surat', SuratController::class)->except(['edit', 'update', 'destroy']);
    Route::post('/surat/{surat}/status', [SuratController::class, 'updateStatus'])->name('surat.updateStatus');
    Route::get('/surat/{surat}/pdf', [SuratController::class, 'cetakPdf'])->name('surat.cetakPdf');

    // Laporan
    Route::resource('laporan', LaporanController::class)->except(['edit', 'update', 'destroy']);
    Route::post('/laporan/{laporan}/status', [LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications/unread', [\App\Http\Controllers\NotificationController::class, 'unread'])->name('notifications.unread');
    Route::post('/notifications/mark-as-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

Route::middleware(['auth', 'role:rt,rw,admin'])->group(function () {
    Route::get('/approval', [\App\Http\Controllers\ApprovalController::class, 'index'])->name('approval.index');
    Route::post('/approval/{user}/approve', [\App\Http\Controllers\ApprovalController::class, 'approve'])->name('approval.approve');
    Route::post('/approval/{user}/reject', [\App\Http\Controllers\ApprovalController::class, 'reject'])->name('approval.reject');
});

Route::middleware(['auth', 'role:rw'])->group(function () {
    Route::resource('rt-management', \App\Http\Controllers\RtManagementController::class)->except(['show']);
});

require __DIR__.'/auth.php';
