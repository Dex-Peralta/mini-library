<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Library Management System') }}
            </h2>
            @guest
                <a href="{{ route('login') }}" class="bg-gray-900 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
                    Admin Login
                </a>
            @endguest
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @guest
                <!-- Public Welcome Message -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-8 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Welcome to Our Library</h3>
                        <p class="text-gray-600 mb-6">View our library statistics below. Librarians can login to manage the system.</p>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-gray-900 hover:bg-gray-700">
                            Login as Librarian
                        </a>
                    </div>
                </div>
            @endguest
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Students Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Students</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['students'] }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Authors Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Authors</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['authors'] }}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Books Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Books</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['books'] }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $stats['total_copies'] }} total copies</p>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-full">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Borrows Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Active Borrows</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['active_borrows'] }}</p>
                                @if($stats['overdue_items'] > 0)
                                    <p class="text-xs text-red-600 mt-1">{{ $stats['overdue_items'] }} overdue</p>
                                @endif
                            </div>
                            <div class="p-3 bg-orange-100 rounded-full">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Quick Actions - Admin Only -->
            @auth
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        
                        <a href="{{ route('students.index') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                            <svg class="w-10 h-10 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Students</span>
                        </a>

                        <a href="{{ route('authors.index') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition">
                            <svg class="w-10 h-10 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Authors</span>
                        </a>

                        <a href="{{ route('books.index') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition">
                            <svg class="w-10 h-10 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Books</span>
                        </a>

                        <a href="{{ route('borrows.create') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-orange-500 hover:bg-orange-50 transition">
                            <svg class="w-10 h-10 text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">New Borrow</span>
                        </a>

                        <a href="{{ route('borrows.index') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition">
                            <svg class="w-10 h-10 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Transactions</span>
                        </a>

                    </div>
                </div>
            </div>
            @endauth

            <!-- Inventory Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Inventory Status</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_copies'] }}</p>
                            <p class="text-sm text-gray-600">Total Copies</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <p class="text-2xl font-bold text-green-600">{{ $stats['available_copies'] }}</p>
                            <p class="text-sm text-gray-600">Available</p>
                        </div>
                        <div class="text-center p-4 bg-orange-50 rounded-lg">
                            <p class="text-2xl font-bold text-orange-600">{{ $stats['borrowed_books'] }}</p>
                            <p class="text-sm text-gray-600">On Loan</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
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
                    <a href="{{ route('login') }}" class="bg-gray-900 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition">Admin Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
    
    <!-- Student Profile Alert -->
    @auth
        @if(!Auth::user() || !\App\Models\Student::where('user_id', Auth::id())->exists())
        <div class="mb-8 bg-red-50 border border-red-200 rounded-lg p-4 flex items-center justify-between">
            <div>
                <p class="text-red-700 font-medium">Student record not found. Please complete your student profile first.</p>
                <p class="text-red-600 text-sm mt-1">You need to fill in your student information to check out books.</p>
            </div>
            <a href="{{ route('students.create') }}" class="ml-4 bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition whitespace-nowrap">
                Complete Profile
            </a>
        </div>
        @endif
    @endauth
    
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Browse Books</h1>
        <p class="text-gray-600 text-lg">Discover and check out books from our collection</p>
    </div>

    <!-- Search & Filter Section -->
    <div class="mb-8 flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <input 
                type="text" 
                id="searchInput"
                placeholder="Search by title or author..." 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent transition"
            >
        </div>
        <select id="genreFilter" class="px-6 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent bg-white transition">
            <option value="">All Genres</option>
            <option value="Romance">Romance</option>
            <option value="Science Fiction">Science Fiction</option>
            <option value="Fantasy">Fantasy</option>
            <option value="Classic">Classic</option>
            <option value="Mystery">Mystery</option>
            <option value="Horror">Horror</option>
            <option value="Fiction">Fiction</option>
            <option value="Magical Realism">Magical Realism</option>
            <option value="Adventure">Adventure</option>
            <option value="Historical Fiction">Historical Fiction</option>
            <option value="Gothic Fiction">Gothic Fiction</option>
            <option value="Political Satire">Political Satire</option>
        </select>
    </div>

    <!-- Book Grid -->
    @if($books->isEmpty())
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No books available</h3>
            <p class="text-gray-500">Check back later for new additions to our collection.</p>
        </div>
    @else
        <div id="bookGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($books as $book)
            <div class="bg-white rounded-xl overflow-hidden shadow-sm book-card" 
                 data-title="{{ strtolower($book->title) }}" 
                 data-author="{{ strtolower($book->authors->pluck('name')->join(', ')) }}" 
                 data-genre="{{ $book->genre ?? '' }}">
                
                <!-- Book Cover -->
                <div class="relative h-56 bg-gray-200 overflow-hidden">
                    <img 
                        src="{{ $book->cover_image ?? 'https://via.placeholder.com/300x400?text=' . urlencode($book->title) }}" 
                        alt="{{ $book->title }}"
                        class="w-full h-full object-cover"
                    >
                    
                    <!-- Availability Badge -->
                    @if($book->isAvailable())
                        <span class="absolute top-3 right-3 bg-green-500 text-white text-xs font-medium px-3 py-1 rounded-full shadow">
                            Available
                        </span>
                    @else
                        <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-medium px-3 py-1 rounded-full shadow">
                            Out of Stock
                        </span>
                    @endif
                </div>

                <!-- Book Info -->
                <div class="p-5">
                    <h3 class="font-semibold text-lg text-gray-900 mb-1 line-clamp-1">
                        {{ $book->title }}
                    </h3>

                    <p class="text-sm text-gray-600 mb-2">
                        by {{ $book->authors->pluck('name')->join(', ') ?: 'Unknown Author' }}
                    </p>

                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                        @if($book->year_published)
                            <span>{{ $book->year_published }}</span>
                            <span>•</span>
                        @endif
                        <span>{{ $book->genre ?? 'Uncategorized' }}</span>
                    </div>

                    @if($book->description)
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                        {{ $book->description }}
                    </p>
                    @endif

                    <!-- Status and Check Out Button -->
                    <div class="mb-2 flex items-center justify-between">
                        <span class="text-xs font-medium text-gray-600">
                            Status: 
                            <span class="status-text {{ $book->isAvailable() ? 'text-green-600' : 'text-red-600' }}">
                                {{ $book->getStatus() }}
                            </span>
                        </span>
                    </div>

                    @if($book->isAvailable())
                        @auth
                        <button 
                            class="w-full checkout-btn-modal bg-gray-900 hover:bg-gray-800 text-white font-medium py-2.5 rounded-lg transition duration-200 shadow-sm" 
                            data-book-id="{{ $book->id }}"
                            data-book-title="{{ $book->title }}"
                        >
                            Check Out
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="w-full block text-center bg-gray-900 hover:bg-gray-800 text-white font-medium py-2.5 rounded-lg transition duration-200 shadow-sm">
                            Check Out
                        </a>
                        @endauth
                    @else
                        <button 
                            class="w-full bg-gray-300 text-gray-600 font-medium py-2.5 rounded-lg cursor-not-allowed opacity-75" 
                            disabled
                        >
                            Not Available
                        </button>
                    @endif
                </div>

            </div>
            @endforeach
        </div>
    @endif

</div>

<!-- Checkout Modal -->
<div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full">
        <!-- Modal Header -->
        <div class="bg-gray-900 text-white p-6 rounded-t-xl">
            <h2 class="text-2xl font-bold">Check Out Book</h2>
            <p id="modalBookTitle" class="text-gray-300 text-sm mt-1">Loading...</p>
        </div>

        <!-- Modal Body -->
        <div class="p-6 space-y-4">
            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input 
                    type="text" 
                    id="checkoutName" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50" 
                    readonly
                >
            </div>

            <!-- Year -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                <input 
                    type="text" 
                    id="checkoutYear" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50" 
                    readonly
                >
            </div>

            <!-- Course -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                <input 
                    type="text" 
                    id="checkoutCourse" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50" 
                    readonly
                >
            </div>

            <!-- Borrow Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Borrow Date</label>
                <input 
                    type="date" 
                    id="checkoutBorrowDate" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800"
                >
            </div>

            <!-- Return Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Return Date</label>
                <input 
                    type="date" 
                    id="checkoutReturnDate" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800"
                >
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="bg-gray-50 px-6 py-4 flex gap-3 rounded-b-xl">
            <button 
                id="cancelCheckoutBtn" 
                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 font-medium py-2 rounded-lg transition"
            >
                Cancel
            </button>
            <button 
                id="confirmCheckoutBtn" 
                class="flex-1 bg-gray-900 hover:bg-gray-800 text-white font-medium py-2 rounded-lg transition"
            >
                Confirm
            </button>
        </div>
    </div>
</div>

<script>
    // Search and Filter Functionality
    const searchInput = document.getElementById('searchInput');
    const genreFilter = document.getElementById('genreFilter');
    const bookCards = document.querySelectorAll('.book-card');
    const bookGrid = document.getElementById('bookGrid');
