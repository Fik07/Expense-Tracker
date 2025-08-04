<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Expense Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-gray-800 p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Login to Your Account</h2>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-500">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username"
                       class="mt-1 block w-full bg-gray-700 border border-gray-600 text-white rounded-md p-3 focus:ring focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                <input id="password" name="password" type="password"
                       required autocomplete="current-password"
                       class="mt-1 block w-full bg-gray-700 border border-gray-600 text-white rounded-md p-3 focus:ring focus:ring-blue-500 focus:border-blue-500">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-4">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500">
                <label for="remember_me" class="ml-2 text-sm text-gray-400">Remember me</label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between mb-4">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-gray-400 hover:text-gray-200 underline">Forgot your password?</a>
                @endif
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-150">
                Log in
            </button>

            <div class="text-center mt-6">
                <a href="{{ route('register') }}"
                   class="text-sm text-gray-400 hover:text-gray-200 underline">
                    Don't have an account? Register
                </a>
            </div>
        </form>
    </div>
</body>
</html>
