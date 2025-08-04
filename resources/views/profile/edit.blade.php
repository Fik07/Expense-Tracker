@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="p-4 sm:p-6">
    <!-- START: Notification Dispatcher - Use data attribute to pass message to JS -->
    @if (session('status'))
        <div id="session-status" data-message="{{ addslashes(session('status')) }}"></div>
    @endif
    <!-- END: Notification Dispatcher -->

    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-6 md:p-8 rounded-xl shadow-sm">
        <div class="mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">My Profile</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update your personal information and password.</p>
        </div>

        @if(Auth::check())
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="space-y-6">
                    <!-- Profile Photo -->
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            @if (auth()->user()->photo)
                                <img class="h-20 w-20 rounded-full object-cover" src="{{ asset('storage/' . auth()->user()->photo) }}" alt="User Photo">
                            @else
                                <img class="h-20 w-20 rounded-full object-cover bg-gray-700" src="https://placehold.co/80x80/2f4172/ffffff?text=User" alt="Default Photo">
                            @endif
                        </div>
                        <div class="flex-grow">
                            <label for="photo" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Profile Photo</label>
                            <input type="file" id="photo" name="photo" class="hidden">
                            <button type="button" onclick="document.getElementById('photo').click()" class="mt-2 px-4 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm text-white hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-sm font-medium transition">
                                Change Photo
                            </button>
                            @error('photo')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Username</label>
                        <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}"
                            class="w-full bg-gray-50 dark:bg-gray-700 border @error('name') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        @error('name')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Email Address</label>
                        <input type="email" id="email" value="{{ Auth::user()->email }}" readonly
                            class="w-full bg-gray-200 dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded-md shadow-sm cursor-not-allowed">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Email address cannot be changed.</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">New Password</label>
                        <input type="password" id="password" name="password"
                            class="w-full bg-gray-50 dark:bg-gray-700 border @error('password') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Leave blank to keep current password">
                        @error('password')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700 mt-6">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 text-sm font-medium transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 text-sm font-medium transition">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        @else
            <div class="text-center text-gray-500 dark:text-gray-400">
                <p>Please log in to view your profile.</p>
                <a href="{{ route('login') }}" class="mt-4 inline-block text-indigo-600 dark:text-indigo-400 hover:underline">Login</a>
            </div>
        @endif
    </div>

    <!-- Notification container -->
    <div id="notification-container" class="fixed top-5 right-5 z-50 space-y-3 w-full max-w-xs"></div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusEl = document.getElementById('session-status');
        if (statusEl && statusEl.dataset.message) {
            showNotification('success', statusEl.dataset.message);
        }
    });

    function showNotification(type, message) {
        const container = document.getElementById('notification-container');
        const notification = document.createElement('div');
        notification.className = `p-4 rounded-lg shadow-lg flex items-start space-x-4 pointer-events-auto transition-opacity duration-300 bg-green-50 border border-green-200 dark:bg-green-900/50 dark:border-green-700 text-gray-800 dark:text-white`;
        notification.innerHTML = `
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1 text-sm font-medium">${message}</div>
            <button onclick="this.parentElement.remove()" class="p-1 text-gray-500 hover:bg-black/10 dark:hover:bg-white/10 rounded-full">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                </svg>
            </button>
        `;
        container.appendChild(notification);
        setTimeout(() => notification.remove(), 5000);
    }
</script>
@endpush
