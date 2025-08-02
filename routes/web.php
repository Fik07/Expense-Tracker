<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::view('/dashboard', 'dashboard')->name('dashboard');

// Report Page
Route::view('/report', 'report')->name('report');

// Budget Create Page
Route::view('/budget/create', 'budget.create')->name('budget.create');

// Expense Create Page
Route::view('/expense/create', 'expense.create')->name('expense.create');

