@extends('layouts.app')

@section('content')

<!-- A simple, non-dismissible message to demonstrate how you could pass a simple message from a controller -->
@if (session('status'))
    <div class="mb-6 p-4 rounded-xl flex items-center justify-between shadow-sm bg-green-800 border border-green-700">
        <div class="flex items-center space-x-3">
            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium text-white">{{ session('status') }}</span>
        </div>
    </div>
@endif

<header class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center">
    <div>
        <h1 class="text-3xl font-bold text-white">Dashboard</h1>
        <p class="text-gray-400">Your financial overview for August 2025.</p>
    </div>
    <div class="flex space-x-4 mt-4 sm:mt-0">
        <a href="{{ route('expense.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
            Add Expense
        </a>
        <a href="{{ route('budget.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
            Set Budget
        </a>
    </div>
</header>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-gray-800 p-6 rounded-xl shadow-lg flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
        <div class="bg-red-500 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01" /></svg>
        </div>
        <div>
            <p class="text-gray-400 text-sm">💰 Total Spent</p>
            <p class="text-2xl font-bold">RM {{ number_format($totalSpent ?? 0, 2) }}</p>
        </div>
    </div>

    <!-- Total Budget Card with Edit Button -->
    <div class="bg-gray-800 p-6 rounded-xl shadow-lg flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300 relative">
        <div class="bg-green-500 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        </div>
        <div>
            <p class="text-gray-400 text-sm">🧮 Total Budget</p>
            <p class="text-2xl font-bold">RM {{ number_format($budget->monthly_budget ?? 0, 2) }}</p>
        </div>
        <!-- Edit Budget Icon -->
        @if(isset($budget) && $budget)
        <a href="{{ route('budget.edit', $budget->id) }}" class="absolute top-3 right-3 text-gray-500 hover:text-green-400 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
        </a>
        @endif
    </div>

    <div class="bg-gray-800 p-6 rounded-xl shadow-lg flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
        <div class="bg-blue-500 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" /></svg>
        </div>
        <div>
            <p class="text-gray-400 text-sm">💡 Remaining Balance</p>
            <p class="text-2xl font-bold">RM {{ number_format($remainingBalance ?? 0, 2) }}</p>
        </div>
    </div>

    <div class="bg-gray-800 p-6 rounded-xl shadow-lg flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
        <div class="bg-yellow-500 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
        </div>
        <div>
            <p class="text-gray-400 text-sm">📊 Daily Avg Spending</p>
            <p class="text-2xl font-bold">RM {{ number_format($dailyAvg ?? 0, 2) }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">

    <div class="lg:col-span-1 bg-gray-800 p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Spending by Category</h2>
        <div class="h-64 md:h-80">
            <canvas id="categoryPieChart"></canvas>
        </div>
    </div>

    <div class="lg:col-span-2 bg-gray-800 p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Recent Expenses</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="py-2 px-4">Date</th>
                        <th class="py-2 px-4">Category</th>
                        <th class="py-2 px-4">Amount (RM)</th>
                        <th class="py-2 px-4">Note</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentExpenses ?? [] as $expense)
                        <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                            <td class="py-3 px-4">{{ $expense->date->format('d M Y') }}</td>
                            <td class="py-3 px-4"><span class="bg-blue-900 text-blue-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">{{ $expense->category }}</span></td>
                            <td class="py-3 px-4">{{ number_format($expense->amount, 2) }}</td>
                            <td class="py-3 px-4 text-gray-400">{{ $expense->note }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-500">No recent expenses found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="bg-gray-800 p-6 rounded-xl shadow-lg mt-8">
    <h2 class="text-xl font-semibold mb-4">Spending Last 7 Days</h2>
    <div class="h-64 md:h-80">
        <canvas id="sevenDaySpendingChart"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- PIE CHART: SPENDING BY CATEGORY ---
        const pieCtx = document.getElementById('categoryPieChart').getContext('2d');
        const categorySpending = {{ Illuminate\Support\Js::from($categorySpending ?? []) }};
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: Object.keys(categorySpending),
                datasets: [{
                    label: 'Spending',
                    data: Object.values(categorySpending),
                    backgroundColor: ['#3B82F6', '#8B5CF6', '#F59E0B', '#10B981', '#EC4899', '#6366F1', '#F97316'],
                    borderColor: '#1f2937',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { color: '#d1d5db' } }
                }
            }
        });
        // --- BAR CHART: LAST 7 DAYS SPENDING ---
        const barCtx = document.getElementById('sevenDaySpendingChart').getContext('2d');
        const weeklySpending = {{ Illuminate\Support\Js::from($weeklySpending ?? ['labels' => [], 'data' => []]) }};
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: weeklySpending.labels,
                datasets: [{
                    label: 'Daily Spending (RM)',
                    data: weeklySpending.data,
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(255, 255, 255, 0.1)' }, ticks: { color: '#d1d5db' } },
                    x: { grid: { display: false }, ticks: { color: '#d1d5db' } }
                },
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endpush
