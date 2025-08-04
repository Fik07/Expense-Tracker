<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\BudgetController;

// Welcome page (public)
Route::get('/', fn() => view('welcome'));

// Auth pages (public views, guest-only)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    // Register (optional)
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);});

// Protected routes: require login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::view('/report', 'report')->name('report');
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile.edit');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


    // Budget
    Route::get('/budget/create', [BudgetController::class, 'create'])->name('budget.create');
    Route::post('/budget', [BudgetController::class, 'store'])->name('budget.store');

    // Expense
    Route::get('/expense/create', [ExpenseController::class, 'create'])->name('expense.create');
    Route::post('/expense', [ExpenseController::class, 'store'])->name('expense.store');
});

require __DIR__.'/auth.php';
