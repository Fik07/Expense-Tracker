<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Budget;

class BudgetController extends Controller
    {
    public function store(Request $request)
    {
        $validated = $request->validate([
            'monthly_budget' => 'required|numeric|min:0',
        ]);

        $userId = Auth::id();
        $month = now()->format('Y-m');

        // Store or update budget for the current user & month
        Budget::updateOrCreate(
            ['user_id' => $userId, 'month' => $month],
            ['monthly_budget' => $validated['monthly_budget']]
        );

        return redirect()->route('dashboard')->with('success', 'Budget set successfully!');
    }
    public function create()
    {
        // Optional: preload existing budget if you're editing
        $budget = Budget::where('user_id', auth()->id())
            ->where('month', now()->format('Y-m'))
            ->first();

        return view('budget.create', compact('budget'));
    }
        // BudgetController.php
    public function edit($id)
    {
        $budget = Budget::findOrFail($id);

        // Optional: Check if the user owns this budget
        if ($budget->user_id !== auth()->id()) {
            abort(403);
        }

        return view('budget.edit', compact('budget'));
    }

    public function update(Request $request, $id)
    {
        $budget = Budget::findOrFail($id);

        if ($budget->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'monthly_budget' => 'required|numeric|min:0',
            'weekly_budget' => 'nullable|numeric|min:0',
        ]);

        $budget->update($validated);

        return redirect()->route('dashboard')->with('success', 'Budget updated successfully.');
    }
}
