@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-white">Add New Expense</h1>
        <p class="text-gray-400">Log a new transaction to keep your records up to date.</p>
    </header>

    <!-- Add Expense Form -->
    <div class="bg-gray-800 p-8 rounded-xl shadow-lg">
        <form action="{{ route('expense.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-300">Amount (RM)</label>
                    <input type="number" step="0.01" name="amount" id="amount" required
                           class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g., 15.50">
                </div>
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-300">Category</label>
                    <select name="category" id="category" required
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500">
                        <option value="" disabled selected>Select a category</option>
                        <option value="Food">Food</option>
                        <option value="Transport">Transport</option>
                        <option value="Utilities">Utilities</option>
                        <option value="Groceries">Groceries</option>
                        <option value="Entertainment">Entertainment</option>
                        <option value="Health">Health</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <!-- Date -->
                 <div>
                    <label for="date" class="block text-sm font-medium text-gray-300">Date</label>
                    <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" required
                           class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <!-- Note -->
                <div>
                    <label for="note" class="block text-sm font-medium text-gray-300">Note (Optional)</label>
                    <textarea name="note" id="note" rows="3"
                              class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="e.g., Lunch with client"></textarea>
                </div>
            </div>
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gray-600 rounded-md text-white font-semibold hover:bg-gray-500">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 rounded-md text-white font-semibold hover:bg-blue-500">Save Expense</button>
            </div>
        </form>
    </div>
</div>

@endsection
