<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::post('/report/email', [ReportController::class, 'emailReport'])->name('report.email');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


    // Budget
    Route::get('/budget/create', [BudgetController::class, 'create'])->name('budget.create');
    Route::get('/budget/{id}/edit', [BudgetController::class, 'edit'])->name('budget.edit');
    Route::put('/budget/{id}', [BudgetController::class, 'update'])->name('budget.update');
    Route::post('/budget', [BudgetController::class, 'store'])->name('budget.store');

    // Expense
    Route::get('/expense/create', [ExpenseController::class, 'create'])->name('expense.create');
    Route::post('/expense', [ExpenseController::class, 'store'])->name('expense.store');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login'); // or '/'
    })->name('logout');

});

require __DIR__.'/auth.php';
