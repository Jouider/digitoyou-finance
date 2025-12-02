<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnualReportController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfitDistributionController;
use App\Http\Controllers\ProjectPaymentController;
use App\Http\Controllers\FundMovementController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/annual-report', [AnnualReportController::class, 'index'])->name('annual-report');

    Route::resource('clients', ClientController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('profit-distributions', ProfitDistributionController::class);
    Route::resource('project-payments', ProjectPaymentController::class);
    Route::resource('fund-movements', FundMovementController::class);
    Route::post('/fund-movements/transfer', [FundMovementController::class, 'transfer'])->name('fund-movements.transfer');
});
