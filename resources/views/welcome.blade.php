<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Lending System</title>

    <!-- Tailwind CSS (via Vite or CDN fallback) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="w-full px-6 py-4 shadow-sm bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-semibold tracking-tight">
                <i class="bi bi-book-half text-indigo-600 me-2"></i> Book Lending System
            </h1>

            <nav class="flex gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-4 py-2 text-sm font-medium rounded border border-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 text-sm font-medium rounded border border-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="flex-1 flex items-center justify-center px-6 py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div>
                <h2 class="text-4xl font-bold mb-4 leading-tight">
                    Welcome to your <span class="text-indigo-600">Digital Library</span>
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                    Manage books, track lendings, and organize your entire book collection in one place.
                    Designed for librarians, admins, and passionate readers.
                </p>

                <div class="flex gap-4">
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 text-white bg-indigo-600 rounded-lg text-sm hover:bg-indigo-700 transition">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Get Started
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-6 py-3 bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white rounded-lg text-sm hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            <i class="bi bi-person-plus me-1"></i> Register
                        </a>
                    @endif
                </div>
            </div>

           <!-- Optional Illustration -->
<div class="hidden lg:block">
    <img src="https://www.pngarts.com/files/10/Vector-Reading-Book-PNG-Image-Background.png" 
         alt="Library shelves"
         class="w-full h-auto rounded shadow-lg object-cover" loading="lazy">
</div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full text-center py-4 text-sm text-gray-500 dark:text-gray-400">
        &copy; {{ now()->year }} Book Lending System. All rights reserved.
    </footer>
</body>
</html>
