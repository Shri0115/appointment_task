<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to Appointment System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Styles -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
            }
        </style>
    </head>
    <body class="bg-gradient-to-r from-teal-400 via-green-500 to-blue-600 h-screen flex items-center justify-center">

        <div class="text-center p-8 bg-white bg-opacity-90 rounded-lg shadow-2xl max-w-lg mx-auto">
            <!-- Welcome Note -->
            <h1 class="text-4xl font-extrabold text-gray-800 mb-6">Welcome to Doctor Appointment System</h1>
            <p class="text-lg text-gray-700 mb-8">Please log in or register to get started.</p>

            <!-- Button Box with Shadow and Hover Effects -->
            <div class="space-y-6">
                @if (Route::has('login'))
                    @auth
                        <!-- Already logged in: No button display -->
                    @else
                        <!-- Login Button -->
                        <a href="{{ route('login') }}" 
                            class="inline-block px-8 py-4 bg-gradient-to-r from-indigo-500 to-blue-500 text-white text-lg font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-opacity-50">
                            Log In
                        </a>

                        <!-- Register Button -->
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                                class="inline-block px-8 py-4 bg-transparent text-indigo-600 text-lg font-semibold border-2 border-indigo-600 rounded-lg shadow-md transition duration-300 transform hover:scale-105 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-opacity-50">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Link Button -->
            <div class="mt-8">
                <a href="#" class="text-indigo-600 font-semibold text-lg hover:text-indigo-800 transition duration-200">
                    Learn More
                </a>
            </div>
        </div>

    </body>
</html>
