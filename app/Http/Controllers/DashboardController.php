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
        $userId = auth()->id();
        $currentMonth = Carbon::now()->format('Y-m');
        $today = Carbon::now();

        // 1. Total Spent This Month (User-specific)
        $totalSpent = Expense::where('user_id', $userId)
                             ->where('date', 'like', "$currentMonth%")
                             ->sum('amount');

        // 2. Budget for This Month (Assuming one budget per user)
        $budget = Budget::where('user_id', $userId)->latest()->first();

        // 3. Remaining Balance
        $remainingBalance = ($budget->monthly_budget ?? 0) - $totalSpent;

        // 4. Daily Avg Spending
        $daysSoFar = $today->day;
        $dailyAvg = $daysSoFar > 0 ? $totalSpent / $daysSoFar : 0;

        // 5. Spending by Category
        $categorySpending = Expense::select('category', DB::raw('SUM(amount) as total'))
            ->where('user_id', $userId)
            ->where('date', 'like', "$currentMonth%")
            ->groupBy('category')
            ->pluck('total', 'category');

        // 6. Recent Expenses (latest 5)
        $recentExpenses = Expense::where('user_id', $userId)
                                 ->where('date', 'like', "$currentMonth%")
                                 ->orderBy('date', 'desc')
                                 ->limit(5)
                                 ->get();

        // 7. Weekly Spending (Last 7 days bar chart)
        $weeklySpendingRaw = Expense::select(
                DB::raw('DATE(date) as day'),
                DB::raw('SUM(amount) as total')
            )
            ->where('user_id', $userId)
            ->whereBetween('date', [
                $today->copy()->subDays(6)->startOfDay(),
                $today->copy()->endOfDay()
            ])
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        $weeklySpending = [
            'labels' => [],
            'data' => []
        ];

        $start = $today->copy()->subDays(6);
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
