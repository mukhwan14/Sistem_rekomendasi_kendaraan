<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Role-based Dashboards
Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Admin Resources
    Route::resource('rules', \App\Http\Controllers\RuleController::class);
    Route::resource('rule_conditions', \App\Http\Controllers\RuleConditionController::class)->only(['create', 'store', 'destroy']);
    Route::resource('rules', \App\Http\Controllers\RuleController::class);
    Route::resource('rule_conditions', \App\Http\Controllers\RuleConditionController::class)->only(['create', 'store', 'destroy']);
    Route::resource('diagnosis_questions', \App\Http\Controllers\Admin\DiagnosisQuestionController::class);
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
    
    // Monitoring & Reports
    Route::get('/consultations/export', [\App\Http\Controllers\Admin\ConsultationReportController::class, 'export'])->name('consultations.export');
    Route::get('/consultations', [\App\Http\Controllers\Admin\ConsultationReportController::class, 'index'])->name('consultations.index');
});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\UserDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/consultations', [\App\Http\Controllers\ConsultationController::class, 'index'])->name('consultation.index'); // History
    Route::get('/consultation', [\App\Http\Controllers\ConsultationController::class, 'create'])->name('consultation.create');
    Route::post('/consultation', [\App\Http\Controllers\ConsultationController::class, 'store'])->name('consultation.store');
    Route::get('/consultation/{id}', [\App\Http\Controllers\ConsultationController::class, 'show'])->name('consultation.show');
    Route::get('/consultation/{id}/pdf', [\App\Http\Controllers\ConsultationController::class, 'exportPdf'])->name('consultation.pdf'); // PDF Export
    
    // Daily Earnings / Tabungan Servis
    Route::post('/daily_earnings/reset', [\App\Http\Controllers\DailyEarningController::class, 'resetHistory'])->name('daily_earnings.reset');
    Route::resource('daily_earnings', \App\Http\Controllers\DailyEarningController::class)->only(['index', 'create', 'store']);
});

// Admin routes are now grouped above

require __DIR__.'/auth.php';
