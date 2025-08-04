<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Inter font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #111827;
            color: #d1d5db;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center py-12">
        <div class="w-full sm:max-w-md p-6 bg-gray-800 rounded-xl shadow-lg">
            <h1 class="text-2xl font-bold text-white text-center mb-6">Register an Account</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500" required autocomplete="name">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500" required autocomplete="username">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                    <input id="password" type="password" name="password"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500" required autocomplete="new-password">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm p-3 focus:ring-blue-500 focus:border-blue-500" required autocomplete="new-password">
                    @if ($errors->has('password_confirmation'))
                        <p class="mt-2 text-sm text-red-600">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a class="underline text-sm text-gray-400 hover:text-gray-200 rounded-md" href="{{ route('login') }}">
                        Already registered?
                    </a>
                    <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
