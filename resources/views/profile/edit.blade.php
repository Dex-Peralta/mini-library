<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 h-16 flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <a href="{{ route('home') }}" class="flex items-center gap-2">
                            <svg class="w-7 h-7 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span class="font-semibold text-xl">Mini Library</span>
                        </a>
                        <span class="text-gray-600">My Profile</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('home') }}" class="border border-gray-300 hover:bg-gray-100 text-gray-900 px-4 py-2 rounded-md text-sm font-medium">
                            Back to Library
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-gray-900 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                <div class="py-10">
                    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">


                        <div class="p-6 sm:p-8 bg-white shadow-sm sm:rounded-lg border border-gray-100">
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        <div class="p-6 sm:p-8 bg-white shadow-sm sm:rounded-lg border border-gray-100">
                            @include('profile.partials.update-password-form')
                        </div>

                        <div class="p-6 sm:p-8 bg-white shadow-sm sm:rounded-lg border border-red-100">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
