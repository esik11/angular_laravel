<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="antialiased bg-gray-900 text-white">
    <div class="relative flex flex-col min-h-screen justify-center items-center">
        <!-- Navbar -->
        @if (Route::has('login'))
            <div class="fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-300 hover:text-white underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-300 hover:text-white underline">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-300 hover:text-white underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <!-- Header Section -->
        <header class="text-center mt-20">
            <h1 class="text-5xl font-extrabold text-white">
                Welcome to <span class="text-red-500">{{ config('app.name', 'Laravel') }}</span>
            </h1>
        </header>

        <!-- Main Content Section -->
        <main class="flex flex-col justify-center items-center mt-12">
            <div class="bg-gray-800 rounded-lg shadow-lg p-8 max-w-4xl w-full">
                <h2 class="text-2xl font-bold text-white mb-6">About the Project</h2>
                <p class="text-gray-400 mb-4">This project is a part of the Web System Technologies course, combining Laravel and Angular to build a comprehensive social media platform.</p>
<!--                 
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-white mb-4">Technologies Used</h3>
                        <ul class="text-gray-400 list-disc ml-5">
                            <li>Laravel - Backend</li>
                            <li>Angular - Frontend</li>
                            <li>MySQL - Database</li>
                            <li>Tailwind CSS - Styling</li>
                        </ul>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-white mb-4">Project Features</h3>
                        <ul class="text-gray-400 list-disc ml-5">
                            <li>User Authentication & Profile Management</li>
                            <li>Content Posting & Interaction</li>
                            <li>Real-time Updates & Notifications</li>
                        </ul>
                    </div>
                </div>
            </div> -->
        </main>

        <!-- Footer Section -->
        <footer class="mt-12 text-center text-gray-500">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
