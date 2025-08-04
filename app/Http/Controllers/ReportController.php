<?php

namespace App\Http\Controllers;

use App\Mail\ExpenseReportMail;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Budget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get all distinct categories for dropdown
        $categories = Expense::where('user_id', $user->id)
            ->select('category')
            ->distinct()
            ->pluck('category');

        // Build query with optional filters
        $query = Expense::where('user_id', $user->id);

        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Paginated result
        $expenses = $query->orderBy('date', 'desc')->paginate(10);

        // Summary data
        $totalExpenses = $query->sum('amount');
        $totalTransactions = $query->count();

        return view('report', [
            'expenses' => $expenses,
            'totalExpenses' => $totalExpenses,
            'totalTransactions' => $totalTransactions,
            'categories' => $categories,
        ]);
    }

    public function emailReport(Request $request)
{
    $user = Auth::user();

    // Apply filters
    $query = Expense::where('user_id', $user->id);
    if ($request->start_date) $query->where('date', '>=', $request->start_date);
    if ($request->end_date) $query->where('date', '<=', $request->end_date);
    if ($request->category) $query->where('category', $request->category);

    $expenses = $query->orderBy('date')->get();

    // Generate CSV
    $filename = 'expense_report_' . Str::random(8) . '.csv';
    $csvPath = storage_path("app/{$filename}");
    $handle = fopen($csvPath, 'w');
    fputcsv($handle, ['Date', 'Category', 'Amount', 'Note']);

    foreach ($expenses as $expense) {
        fputcsv($handle, [
            $expense->date,
            $expense->category,
            $expense->amount,
            $expense->note
        ]);
    }

    fclose($handle);

    // Send email using queue
    Mail::to($user->email)->queue(new ExpenseReportMail($csvPath));

    // Optional: delete later via queue cleanup, or schedule a task

    return back()->with('status', 'Report is being processed and will be emailed to you soon!');
}
}
