@extends('layouts.app')

@section('content')

    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-white">Expense Report</h1>
        <p class="text-gray-400">Filter and view your detailed spending history.</p>
    </header>

    <!-- Filtering Section -->
    <div class="bg-gray-800 p-6 rounded-xl shadow-lg mb-8">
        <form action="{{ route('report') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-300">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
                </div>
                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-300">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
                </div>
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-300">Category</label>
                    <select name="category" id="category" class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Action Buttons -->
                <div class="flex items-end space-x-4">
                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Apply Filter
                    </button>
                    <a href="{{ route('report') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-300 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
            <p class="text-gray-400 text-sm">💰 Total Spent (Filtered)</p>
            <p class="text-2xl font-bold">RM {{ number_format($totalExpenses ?? 0, 2) }}</p>
        </div>
        <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
            <p class="text-gray-400 text-sm">#️⃣ Total Transactions</p>
            <p class="text-2xl font-bold">{{ $totalTransactions ?? 0 }}</p>
        </div>
        <div class="bg-gray-800 p-6 rounded-xl shadow-lg flex items-center justify-center">
             <button class="w-full inline-flex justify-center py-3 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Download Report
            </button>
        </div>
    </div>


    <!-- Transactions Table -->
    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Filtered Transactions</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="border-b border-gray-700">
                    <tr>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Amount (RM)</th>
                        <th class="py-3 px-4">Note</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses ?? [] as $expense)
                        <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                            <td class="py-3 px-4"><span class="bg-purple-900 text-purple-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">{{ $expense->category }}</span></td>
                            <td class="py-3 px-4">{{ number_format($expense->amount, 2) }}</td>
                            <td class="py-3 px-4 text-gray-400">{{ $expense->note }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-500">
                                <p>No transactions found for the selected filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            @if(isset($expenses) && $expenses->hasPages())
                {{ $expenses->links() }}
            @endif
        </div>
    </div>

@endsection
