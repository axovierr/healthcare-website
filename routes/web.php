<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Patient\PaymentController as PatientPaymentController;
use App\Http\Controllers\Patient\ProfileController as PatientProfileController; 
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\Admin\AdminDashboardController;
// Tambahkan Import Controller Notifikasi agar lebih aman
use App\Http\Controllers\Patient\NotificationController; 
use Illuminate\Support\Facades\Route;

// Rute Default
Route::get('/', function () {
    return view('welcome');
});

// Route untuk halaman setelah registrasi
Route::get('/after-register', function () {
    return view('auth.afterregister');
})->middleware(['auth'])->name('after.register');

// Route untuk Dashboard berdasarkan Role
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isDoctor()) {
        return redirect()->route('doctor.dashboard');
    } else {
        return redirect()->route('patient.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// ====================================================
// BAGIAN PASIEN (STRUKTUR ASLI TEMANMU - GRUP 1)
// ====================================================
Route::middleware(['auth', 'role:patient'])->prefix('patient')->group(function () {
    Route::get('/dashboard', function () {
        return view('patient.dashboard');
    })->name('patient.dashboard');
    
    // Appointments
    Route::get('appointments/schedule/{doctor}', [App\Http\Controllers\Patient\AppointmentController::class, 'schedule'])
        ->name('patient.appointments.schedule');
    Route::post('appointments/book', [App\Http\Controllers\Patient\AppointmentController::class, 'book'])
        ->name('patient.appointments.book');
    Route::resource('appointments', App\Http\Controllers\Patient\AppointmentController::class)
        ->names('patient.appointments');

    // Payment flow routes
    Route::get('payments/{appointment}', [PatientPaymentController::class, 'show'])
        ->name('patient.payments.show');
    Route::post('payments/{appointment}/process', [PatientPaymentController::class, 'process'])
        ->name('patient.payments.process');
    Route::get('payments/{appointment}/waiting', [PatientPaymentController::class, 'waiting'])
        ->name('patient.payments.waiting');
    Route::get('payments/{appointment}/check-status', [PatientPaymentController::class, 'checkStatus'])
        ->name('patient.payments.check-status');
    Route::get('payments/{appointment}/success', [PatientPaymentController::class, 'success'])
        ->name('patient.payments.success');
        
    // Medical Records
    Route::get('/medical-records', [App\Http\Controllers\Patient\MedicalRecordController::class, 'index'])
        ->name('patient.medical-records.index');
        
    // --- FITUR NOTIFIKASI (SUDAH DIPASTIKAN ADA DI SINI) ---
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('patient.notifications.index');
});

// 1. Rute Admin (Dilindungi oleh role:admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('admin.dashboard');

    // Rute Resource untuk mengelola Role
    Route::resource('user-roles', App\Http\Controllers\RoleController::class)
    ->names('admin.user-roles');

    // Rute Resource untuk mengelola Pengguna
    Route::resource('users', UserController::class)
    ->names('admin.users');
    
    Route::resource('schedules', ScheduleController::class)->names('admin.schedules');
});

// 2. Rute Dokter (Dilindungi oleh role:doctor)
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Doctor\DashboardController::class, 'index'])
        ->name('doctor.dashboard');

    // Today's Appointments
    Route::get('/appointments/today', [App\Http\Controllers\Doctor\AppointmentController::class, 'today'])
        ->name('doctor.appointments.today');
    Route::get('/appointments/{appointment}/start', [App\Http\Controllers\Doctor\AppointmentController::class, 'start'])
        ->name('doctor.appointments.start');
    
    // Work Schedule
    Route::get('/schedule', [App\Http\Controllers\Doctor\ScheduleController::class, 'index'])
        ->name('doctor.schedule');
    
    // Medical Records
    Route::get('/medical-records', [App\Http\Controllers\Doctor\MedicalRecordController::class, 'index'])
        ->name('doctor.medical-records');
    
    // Patient History
    Route::get('/patient-history', [App\Http\Controllers\Doctor\PatientHistoryController::class, 'index'])
        ->name('doctor.patient-history');
});

// 3. Rute Pasien (GRUP 2 - STRUKTUR ASLI)
Route::middleware(['auth', 'role:patient'])->prefix('patient')->group(function () {
    // Dashboard (hanya bisa diakses jika profil sudah lengkap)
    Route::get('/dashboard', function () {
        return view('patient.dashboard');
    })->middleware('check.patient.profile')->name('patient.dashboard');

    // Profile routes
    Route::controller(PatientProfileController::class)->group(function () {
        Route::get('/profile/complete', 'complete')->name('patient.profile.complete');
        Route::post('/profile/store', 'store')->name('patient.profile.store');
        Route::get('/profile/edit', 'edit')->name('patient.profile.edit');
        Route::put('/profile/update', 'update')->name('patient.profile.update');
    });
});

// GRUP PASIEN 3 (YANG TELAH DIPERBAIKI)
// Menghapus 'patient.profile' dari middleware karena itu nama route, bukan middleware
Route::middleware(['auth', 'role:patient'])->prefix('patient')->group(function () {
    Route::get('/dashboard', function () {
        return view('patient.dashboard');
    })->name('patient.dashboard');

    // Profile routes
    Route::get('/profile/edit', [PatientProfileController::class, 'edit'])
        ->name('patient.profile.edit');
    Route::put('/profile/update', [PatientProfileController::class, 'update'])
        ->name('patient.profile.update');
    Route::get('/profile/complete', [PatientProfileController::class, 'complete'])
        ->name('patient.profile.complete');
    Route::post('/profile/store', [PatientProfileController::class, 'store'])
        ->name('patient.profile.store');
});

// GRUP PASIEN 4 (STRUKTUR ASLI)
Route::middleware(['auth', 'role:patient'])->prefix('patient')->group(function () {
    Route::get('/dashboard', function () {
        return view('patient.dashboard');
    })->name('patient.dashboard');
    
    // Profile Completion Routes
    Route::get('/profile/complete', [PatientProfileController::class, 'complete'])->name('patient.profile.complete');
    Route::post('/profile/store', [PatientProfileController::class, 'store'])->name('patient.profile.store');
});


// Rute Profile (Tetap dipertahankan)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes for doctor session management
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('doctors/{doctor}/sessions', [\App\Http\Controllers\Admin\DoctorSessionController::class, 'index'])->name('doctors.sessions.index');
    Route::get('doctors/{doctor}/sessions/create', [\App\Http\Controllers\Admin\DoctorSessionController::class, 'create'])->name('doctors.sessions.create');
    Route::post('doctors/{doctor}/sessions', [\App\Http\Controllers\Admin\DoctorSessionController::class, 'store'])->name('doctors.sessions.store');
    Route::post('doctors/{doctor}/sessions/generate', [\App\Http\Controllers\Admin\DoctorSessionController::class, 'generate'])->name('doctors.sessions.generate');
    Route::delete('doctors/{doctor}/sessions/{session}', [\App\Http\Controllers\Admin\DoctorSessionController::class, 'destroy'])->name('doctors.sessions.destroy');

    // Admin: Doctor list & fee management
    Route::get('doctors', [\App\Http\Controllers\Admin\DoctorController::class, 'index'])->name('admin.doctors.index');
    Route::get('doctors/{doctor}/edit', [\App\Http\Controllers\Admin\DoctorController::class, 'edit'])->name('admin.doctors.edit');
    Route::put('doctors/{doctor}', [\App\Http\Controllers\Admin\DoctorController::class, 'update'])->name('admin.doctors.update');
});

// Patient booking and payment routes
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
});

// Payment provider webhook
Route::post('/payments/webhook', [PaymentWebhookController::class, 'handle'])->name('payments.webhook');

use App\Http\Controllers\MedicalRecordController;

Route::middleware(['auth'])->group(function () {
    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
});

Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/appointments/{appointment}/medical-record/create', [MedicalRecordController::class, 'create'])->name('doctor.medical-records.create');
    Route::post('/appointments/{appointment}/medical-record', [MedicalRecordController::class, 'store'])->name('doctor.medical-records.store');
    
    // Edit Medical Record
    Route::get('/medical-records/{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('medical-records.edit');
    Route::put('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('medical-records.update');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Ganti DashboardController dengan AdminDashboardController
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard'); 
});

require __DIR__.'/auth.php';