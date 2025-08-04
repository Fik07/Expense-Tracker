@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Edit Budget</h1>

    <form method="POST" action="{{ route('budget.update', $budget->id) }}">
        @csrf
        @method('PUT')

        <!-- Month (read-only) -->
        <div class="mb-4">
            <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Month</label>
            <input type="month" id="month" name="month" value="{{ $budget->month }}"
                class="w-full mt-1 p-2 rounded-md border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white"
                readonly>
        </div>

        <!-- Monthly Budget -->
        <div class="mb-4">
            <label for="monthly_budget" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Monthly Budget</label>
            <input type="number" name="monthly_budget" id="monthly_budget" value="{{ old('monthly_budget', $budget->monthly_budget) }}"
                class="w-full mt-1 p-2 rounded-md border @error('monthly_budget') border-red-500 @else border-gray-300 dark:border-gray-700 @enderror bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                min="0" step="0.01" required>
            @error('monthly_budget')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-500 transition">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Update Budget</button>
        </div>
    </form>
</div>
@endsection
