<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Notifications\ExpenseExceeded;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    // Show list of expenses for the logged-in user
    public function index()
    {
        $expenses = Expense::where('user_id', Auth::id())
                        ->orderByDesc('date')
                        ->get();

        return view('expense.index', compact('expenses'));
    }

    // Show the form to create a new expense
    public function create()
    {
        return view('expense.create');
    }

    // Store a new expense in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount'   => 'required|numeric|min:0.01',
            'category' => 'required|string|max:50',
            'date'     => 'required|date',
            'note'     => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        Expense::create($validated);

        // === Check budget and notify if exceeded ===
        $user = Auth::user();

        // Get total expenses for the current month
        $totalExpenses = Expense::where('user_id', $user->id)
                                ->whereMonth('date', now()->month)
                                ->whereYear('date', now()->year)
                                ->sum('amount');

        // Assume budget is stored like this (adjust if different)
        $monthlyBudget = optional($user->budget)->monthly_budget;

        // Only notify if monthly budget exists and is exceeded
        if ($monthlyBudget && $totalExpenses > $monthlyBudget) {
            $user->notify(new ExpenseExceeded($totalExpenses));
        }

        return redirect()->route('dashboard')->with('success', 'Expense added successfully!');
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:50',
            'date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ]);

        $expense = Expense::findOrFail($id);
        $expense->update($validated);

        return redirect()->route('report')->with('status', 'Expense updated successfully.');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('report')->with('status', 'Expense deleted successfully.');
    }


    // Show a specific expense, only if it belongs to the logged-in user
    public function show($id)
    {
        $expense = Expense::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        return view('expenses.show', compact('expense'));
    }
}
