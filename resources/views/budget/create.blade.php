@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-white">Set Your Budget</h1>
        <p class="text-gray-400">Define your monthly spending limit.</p>
    </header>

    <!-- Set Budget Form -->
    <div class="bg-gray-800 p-8 rounded-xl shadow-lg">
        <form action="{{ route('budget.store') }}" method="POST">
             @csrf
            <div class="space-y-6">
                <div>
                    <label for="monthly_budget" class="block text-sm font-medium text-gray-300">Monthly Budget (RM)</label>
                    <input type="number" step="0.01" name="monthly_budget" id="monthly_budget"
                           value="{{ old('monthly_budget', $budget->monthly_budget ?? '') }}" required
                           class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g., 3000.00">
                </div>
                 @error('monthly_budget')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gray-600 rounded-md text-white font-semibold hover:bg-gray-500">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 rounded-md text-white font-semibold hover:bg-blue-500">Save Budget</button>
            </div>
        </form>
    </div>
</div>

@endsection
