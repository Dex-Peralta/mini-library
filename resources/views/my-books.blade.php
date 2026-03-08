<!DOCTYPE html>
<html>
<head>
    <title>My Books - Mini Library</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .book-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

<!-- Navbar -->
<nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="text-xl font-semibold text-gray-900">Mini Library</span>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 transition">Browse</a>
                <a href="{{ route('my-books') }}" class="text-gray-900 font-medium border-b-2 border-gray-900 pb-1">My Books</a>
                @auth
                <a href="#" class="text-gray-600 hover:text-gray-900 transition">Admin</a>
                @endauth
            </div>

            <!-- User Profile -->
            <div class="flex items-center space-x-4">
                @auth
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="h-10 w-10 rounded-full bg-gray-800 flex items-center justify-center text-white font-semibold hover:bg-gray-700 transition">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900 font-medium transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 font-medium transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg font-medium transition">Sign Up</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
    
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">My Books</h1>
        <p class="text-gray-600 text-lg">Your borrowed books and checkout history</p>
    </div>

    @auth
        @if($currentBorrows->isEmpty())
        <!-- Empty State -->
        <div class="text-center py-16 bg-white rounded-xl shadow-sm">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No books borrowed yet</h3>
            <p class="text-gray-500 mb-6">Start exploring our collection and check out some books!</p>
            <a href="{{ route('dashboard') }}" class="inline-block bg-gray-900 hover:bg-gray-800 text-white px-6 py-2 rounded-lg font-medium transition">
                Browse Books
            </a>
        </div>
        @else

        <!-- Tabs -->
        <div class="mb-8 border-b border-gray-200">
            <div class="flex space-x-8">
                <button class="tab-btn active px-4 py-3 border-b-2 border-gray-900 text-gray-900 font-medium transition" data-tab="current">
                    Currently Borrowed
                    <span class="ml-2 bg-gray-900 text-white px-2 py-0.5 rounded-full text-xs">{{ $currentBorrows->count() }}</span>
                </button>
            </div>
        </div>

        <!-- Current Books Section -->
        <div id="current" class="tab-content">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($currentBorrows as $borrow)
                    @foreach($borrow->items as $item)
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm book-card">
                        
                        <!-- Book Cover -->
                        <div class="relative h-56 bg-gray-200 overflow-hidden">
                            <img 
                                src="{{ $item->book->cover_image ?? 'https://via.placeholder.com/300x400?text=' . urlencode($item->book->title) }}" 
                                alt="{{ $item->book->title }}"
                                class="w-full h-full object-cover"
                            >
                            
                            <!-- Due Date Badge -->
                            @php
                                $dueDate = \Carbon\Carbon::parse($borrow->due_date);
                                $daysUntilDue = now()->diffInDays($dueDate, false);
                                $isOverdue = $daysUntilDue < 0;
                                $isExpiringSoon = $daysUntilDue <= 3 && $daysUntilDue >= 0;
                            @endphp
                            
                            @if($isOverdue)
                                <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                    Overdue
                                </span>
                            @elseif($isExpiringSoon)
                                <span class="absolute top-3 right-3 bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                    Due Soon
                                </span>
                            @else
                                <span class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                    Active
                                </span>
                            @endif
                        </div>

                        <!-- Book Info -->
                        <div class="p-5">
                            <h3 class="font-semibold text-lg text-gray-900 mb-1 line-clamp-1">
                                {{ $item->book->title }}
                            </h3>

                            <p class="text-sm text-gray-600 mb-2">
                                by {{ $item->book->authors->pluck('name')->join(', ') ?: 'Unknown Author' }}
                            </p>

                            <!-- Genre and Year -->
                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                @if($item->book->year_published)
                                    <span>{{ $item->book->year_published }}</span>
                                    <span>•</span>
                                @endif
                                <span>{{ $item->book->genre ?? 'Uncategorized' }}</span>
                            </div>

                            <!-- Dates Info -->
                            <div class="bg-gray-50 rounded-lg p-3 mb-4 text-xs space-y-1">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Borrowed:</span>
                                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Due Date:</span>
                                    <span class="font-medium {{ $isOverdue ? 'text-red-600' : ($isExpiringSoon ? 'text-yellow-600' : 'text-green-600') }}">
                                        {{ \Carbon\Carbon::parse($borrow->due_date)->format('M d, Y') }}
                                    </span>
                                </div>
                                @if($isOverdue)
                                    <div class="flex justify-between text-red-600">
                                        <span>Overdue by:</span>
                                        <span class="font-bold">{{ abs($daysUntilDue) }} days</span>
                                    </div>
                                @elseif($daysUntilDue >= 0)
                                    <div class="flex justify-between text-green-600">
                                        <span>Days remaining:</span>
                                        <span class="font-bold">{{ $daysUntilDue }} days</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Return Button (Future Feature) -->
                            <button class="w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-2 rounded-lg transition duration-200 text-sm">
                                Return Book
                            </button>
                        </div>

                    </div>
                    @endforeach
                @endforeach
            </div>
        </div>

        @endif
    @else
        <!-- Not Authenticated -->
        <div class="text-center py-16 bg-white rounded-xl shadow-sm">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Please log in</h3>
            <p class="text-gray-500 mb-6">You need to log in to view your borrowed books.</p>
            <a href="{{ route('login') }}" class="inline-block bg-gray-900 hover:bg-gray-800 text-white px-6 py-2 rounded-lg font-medium transition">
                Login
            </a>
        </div>
    @endauth

</div>

<script>
    // Tab functionality
    document.querySelectorAll('.tab-btn').forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active', 'border-gray-900', 'text-gray-900', 'font-medium');
                btn.classList.add('text-gray-600');
            });
            
            // Show selected tab
            document.getElementById(tabName).style.display = 'block';
            
            // Add active class to clicked button
            this.classList.add('active', 'border-gray-900', 'text-gray-900', 'font-medium');
            this.classList.remove('text-gray-600');
        });
    });
</script>

</body>
</html>
