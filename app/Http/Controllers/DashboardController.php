<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Budget;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $today = Carbon::now();

        // 1. Total Spent This Month
        $totalSpent = Expense::where('date', 'like', "$currentMonth%")
                             ->sum('amount');

        // 2. Budget for This Month (Assuming only one budget record per month)
        $budget = Budget::latest()->first(); // You can modify based on your schema

        // 3. Remaining Balance
        $remainingBalance = ($budget->monthly_budget ?? 0) - $totalSpent;

        // 4. Daily Avg Spending
        $daysSoFar = Carbon::now()->day;
        $dailyAvg = $daysSoFar > 0 ? $totalSpent / $daysSoFar : 0;

        // 5. Spending by Category
        $categorySpending = Expense::select('category', DB::raw('SUM(amount) as total'))
            ->where('date', 'like', "$currentMonth%")
            ->groupBy('category')
            ->pluck('total', 'category');

        // 6. Recent Expenses (latest 5)
        $recentExpenses = Expense::where('date', 'like', "$currentMonth%")
                                 ->orderBy('date', 'desc')
                                 ->limit(5)
                                 ->get();

        // 7. Weekly Spending (Last 7 days bar chart)
        $weeklySpendingRaw = Expense::select(
                DB::raw('DATE(date) as day'),
                DB::raw('SUM(amount) as total')
            )
            ->whereBetween('date', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        $weeklySpending = [
            'labels' => [],
            'data' => []
        ];

        $start = Carbon::now()->subDays(6);
        for ($i = 0; $i < 7; $i++) {
            $day = $start->copy()->addDays($i)->toDateString();
            $label = $start->copy()->addDays($i)->format('D');
            $weeklySpending['labels'][] = $label;
            $dayTotal = $weeklySpendingRaw->firstWhere('day', $day)->total ?? 0;
            $weeklySpending['data'][] = $dayTotal;
        }

        return view('dashboard', compact(
            'totalSpent',
            'budget',
            'remainingBalance',
            'dailyAvg',
            'categorySpending',
            'recentExpenses',
            'weeklySpending'
        ));
    }
}
