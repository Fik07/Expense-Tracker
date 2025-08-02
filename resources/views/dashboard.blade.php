@extends('layouts.app')

@section('content')

{{-- This x-data attribute initializes Alpine.js state for the modals on this page --}}
<div x-data="{ expenseModal: false, budgetModal: false }">
    <!-- Header with Action Buttons -->
    <header class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">Dashboard</h1>
            <p class="text-gray-400">Your financial overview for August 2025.</p>
        </div>
        <div class="flex space-x-4 mt-4 sm:mt-0">
            {{-- This button opens the 'expenseModal' pop-up --}}
            <button @click="expenseModal = true" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Add Expense
            </button>
            {{-- This button opens the 'budgetModal' pop-up --}}
            <button @click="budgetModal = true" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Set Budget
            </button>
        </div>
    </header>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Stat Card: Total Spent -->
        <div class="bg-gray-800 p-6 rounded-xl shadow-lg flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
            <div class="bg-red-500 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01" /></svg>
            </div>
            <div>
                <p class="text-gray-400 text-sm">💰 Total Spent</p>
                <p class="text-2xl font-bold">RM {{ number_format($totalSpent ?? 0, 2) }}</p>
            </div>
        </div>

        <!-- Stat Card: Total Budget -->
        <div class="bg-gray-800 p-6 rounded-xl shadow-lg flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
            <div class="bg-green-500 p-3 rounded-full">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <div>
                <p class="text-gray-400 text-sm">🧮 Total Budget</p>
                <p class="text-2xl font-bold">RM {{ number_format($budget->monthly_budget ?? 0, 2) }}</p>
            </div>
        </div>

        <!-- Stat Card: Remaining Balance -->
        <div class="bg-gray-800 p-6 rounded-xl shadow-lg flex items-center space-x-4 transform hover:scale-105 transition-transform duration-300">
            <div class="bg-blue-500 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" /></svg>
            </div>
            <div>
                <p class="text-gray-400 text-sm">💡 Remaining Balance</p>
                <p class="text-2xl font-bold">RM {{ number_format($remainingBalance ?? 0, 2) }}</p>
            </div>
        </div>

        <!-- Stat Card: Daily Avg Spending -->
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

    <!-- Charts and Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">

        <!-- Pie Chart: Spending by Category -->
        <div class="lg:col-span-1 bg-gray-800 p-6 rounded-xl shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Spending by Category</h2>
            <div class="h-64 md:h-80">
                <canvas id="categoryPieChart"></canvas>
            </div>
        </div>

        <!-- Recent Expenses Table -->
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

    <!-- Bar Chart: Last 7 Days Spending -->
    <div class="bg-gray-800 p-6 rounded-xl shadow-lg mt-8">
        <h2 class="text-xl font-semibold mb-4">Spending Last 7 Days</h2>
        <div class="h-64 md:h-80">
            <canvas id="sevenDaySpendingChart"></canvas>
        </div>
    </div>

    <!-- MODALS SECTION -->

    <!-- Add Expense Modal -->
    <div x-show="expenseModal" x-cloak x-transition
         class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4"
         @keydown.escape.window="expenseModal = false">
        <div @click.away="expenseModal = false" class="bg-gray-800 rounded-xl shadow-lg p-8 w-full max-w-lg">
            <h3 class="text-2xl font-bold mb-6">Add a New Expense</h3>
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-300">Amount (RM)</label>
                        <input type="number" step="0.01" name="amount" id="amount" required class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-2">
                    </div>
                    <div>
                        <label for="exp_category" class="block text-sm font-medium text-gray-300">Category</label>
                        <select name="category" id="exp_category" required class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-2">
                            <option value="Food">Food</option>
                            <option value="Transport">Transport</option>
                            <option value="Utilities">Utilities</option>
                            <option value="Groceries">Groceries</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-300">Date</label>
                        <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" required class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-2">
                    </div>
                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-300">Note (Optional)</label>
                        <textarea name="note" id="note" rows="3" class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-2"></textarea>
                    </div>
                </div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" @click="expenseModal = false" class="px-4 py-2 bg-gray-600 rounded-md text-white">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 rounded-md text-white">Save Expense</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Set Budget Modal -->
    <div x-show="budgetModal" x-cloak x-transition
         class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4"
         @keydown.escape.window="budgetModal = false">
        <div @click.away="budgetModal = false" class="bg-gray-800 rounded-xl shadow-lg p-8 w-full max-w-lg">
            <h3 class="text-2xl font-bold mb-6">Set Your Monthly Budget</h3>
            <form action="{{ route('budget.store') }}" method="POST">
                 @csrf
                <div class="space-y-4">
                    <div>
                        <label for="monthly_budget" class="block text-sm font-medium text-gray-300">Monthly Budget (RM)</label>
                        <input type="number" step="0.01" name="monthly_budget" id="monthly_budget" value="{{ $budget->monthly_budget ?? '' }}" required class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-2">
                    </div>
                </div>
                <div class="mt-8 flex justify-end space-x-4">
                    <button type="button" @click="budgetModal = false" class="px-4 py-2 bg-gray-600 rounded-md text-white">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 rounded-md text-white">Set Budget</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
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
