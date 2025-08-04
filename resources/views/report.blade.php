@extends('layouts.app')

@section('content')

    <!-- START: Simple Notification Message -->
    @if (session('status'))
        <div id="status-notification" class="mb-6 p-4 rounded-xl flex items-center justify-between shadow-sm bg-green-800 border border-green-700">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-white">{{ session('status') }}</span>
            </div>
            <button onclick="document.getElementById('status-notification').remove()" class="p-1 text-gray-400 hover:bg-white/10 rounded-full">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                </svg>
            </button>
        </div>
    @endif
    <!-- END: Simple Notification Message -->

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
        <form action="{{ route('report.export') }}" method="GET">
            <!-- preserve filters -->
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            <input type="hidden" name="category" value="{{ request('category') }}">

            <button type="submit" class="w-full inline-flex justify-center py-3 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                Export to CSV
            </button>
        </form>
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
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses ?? [] as $expense)
                        <tr class="border-b border-gray-700 hover:bg-gray-700/50">
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                            <td class="py-3 px-4"><span class="bg-purple-900 text-purple-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">{{ $expense->category }}</span></td>
                            <td class="py-3 px-4">{{ number_format($expense->amount, 2) }}</td>
                            <td class="py-3 px-4 text-gray-400">{{ $expense->note }}</td>
                            <td class="py-3 px-4 flex space-x-2">
                                <a href="{{ route('expense.edit', $expense->id) }}" class="text-gray-400 hover:text-yellow-400 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                </a>
                                <form action="{{ route('expense.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
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
