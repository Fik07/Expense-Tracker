<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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

        return redirect()->route('dashboard')->with('success', 'Expense added successfully!');
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
