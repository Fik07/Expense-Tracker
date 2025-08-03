<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;

class BudgetController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'monthly_budget' => 'required|numeric|min:0',
        ]);

        // Optional: Replace existing budget for current month
        Budget::updateOrCreate(
            ['month' => now()->format('Y-m')],
            ['monthly_budget' => $validated['monthly_budget']]
        );

        return redirect()->route('dashboard')->with('success', 'Budget set successfully!');
    }
    public function create()
    {
        return view('budget.create');
    }
}
