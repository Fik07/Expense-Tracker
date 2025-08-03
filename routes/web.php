<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\BudgetController;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard with controller
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Report (static view)
Route::view('/report', 'report')->name('report');

// Form handling routes
Route::post('/budget', [BudgetController::class, 'store'])->name('budget.store');
Route::get('/budget/create', [ExpenseController::class, 'create'])->name('budget.create');

Route::get('/expense/create', [ExpenseController::class, 'create'])->name('expense.create');
Route::post('/expense', [ExpenseController::class, 'store'])->name('expense.store');
