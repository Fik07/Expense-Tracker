<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Expense Tracker - Welcome</title>

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-gray-900 text-gray-200">
    <div class="relative min-h-screen flex flex-col items-center justify-center">
        <!-- Top Navigation -->
        <div class="absolute top-0 right-0 p-6 text-right">
            @if (Route::has('login'))
                <div>
                    <a href="{{ route('login') }}" class="font-semibold text-gray-300 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-300 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto text-center p-6">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white leading-tight">
                Take Control of Your Finances
            </h1>

            <p class="mt-6 text-lg md:text-xl text-gray-400 max-w-2xl mx-auto">
                Expense Tracker helps you monitor your spending, stick to your budget, and achieve your financial goals with ease. Get clear insights with our intuitive dashboard and detailed reports.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-block px-8 py-4 text-lg font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-300">
                    Get Started for Free
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto inline-block px-8 py-4 text-lg font-bold text-white bg-gray-700 rounded-lg hover:bg-gray-600 transition-colors duration-300">
                    Login to Your Account
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="absolute bottom-4 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Expense Tracker. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
