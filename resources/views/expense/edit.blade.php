@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-4 sm:p-6">
    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-white">Edit Expense</h1>
            <p class="text-gray-400">Update the details for your expense.</p>
        </header>

        <!-- The $expense object would be passed from the controller -->
        <form action="{{ route('expense.update', $expense->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-300">Amount (RM)</label>
                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $expense->amount) }}" required class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-300">Category</label>
                    <select name="category" id="category" required class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
                        <option value="">Select a category</option>
                        <!-- Assumed categories array would be passed from the controller -->
                        @foreach(['Food', 'Transport', 'Entertainment', 'Utilities', 'Groceries','Entertainment', 'Health', 'Other'] as $category)
                            <option value="{{ $category }}" {{ old('category', $expense->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-300">Date</label>
                    <input type="date" name="date" id="date" value="{{ old('date', \Carbon\Carbon::parse($expense->date)->format('Y-m-d')) }}" required class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
                </div>

                <!-- Note -->
                <div>
                    <label for="note" class="block text-sm font-medium text-gray-300">Note</label>
                    <textarea name="note" id="note" rows="3" class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">{{ old('note', $expense->note) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-300 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Expense
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
