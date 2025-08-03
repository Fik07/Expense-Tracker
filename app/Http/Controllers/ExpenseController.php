<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:50',
            'date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        Expense::create($validated);

        return redirect()->route('dashboard')->with('success', 'Expense added successfully!');
    }

    public function create()
    {
        return view('expense.create');
    }

}
