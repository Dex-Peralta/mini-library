<!DOCTYPE html>
<html>
<head>
    <title>Mini Library</title>
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
                <a href="{{ route('dashboard') }}" class="text-gray-900 font-medium border-b-2 border-gray-900 pb-1">Browse</a>
                <a href="#" class="text-gray-600 hover:text-gray-900 transition">My Books</a>
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
                    <span class="absolute top-3 right-3 bg-green-500 text-white text-xs font-medium px-3 py-1 rounded-full shadow">
                        Available
                    </span>
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

                    <!-- Check Out Button -->
                    <button class="w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-2.5 rounded-lg transition duration-200 shadow-sm">
                        Check Out
                    </button>
                </div>

            </div>
            @endforeach
        </div>
    @endif

</div>

<script>
    // Search and Filter Functionality
    const searchInput = document.getElementById('searchInput');
    const genreFilter = document.getElementById('genreFilter');
    const bookCards = document.querySelectorAll('.book-card');
    const bookGrid = document.getElementById('bookGrid');

    function filterBooks() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedGenre = genreFilter.value;
        let visibleCount = 0;

        bookCards.forEach(card => {
            const title = card.getAttribute('data-title');
            const author = card.getAttribute('data-author');
            const genre = card.getAttribute('data-genre');

            // Check if search term matches title or author
            const matchesSearch = title.includes(searchTerm) || author.includes(searchTerm);
            
            // Check if genre matches (empty means all genres)
            const matchesGenre = selectedGenre === '' || genre === selectedGenre;

            // Show or hide the card
            if (matchesSearch && matchesGenre) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show "no results" message if no books match
        updateNoResultsMessage(visibleCount);
    }

    function updateNoResultsMessage(visibleCount) {
        let noResultsDiv = document.getElementById('noResultsMessage');
        
        if (visibleCount === 0) {
            if (!noResultsDiv) {
                noResultsDiv = document.createElement('div');
                noResultsDiv.id = 'noResultsMessage';
                noResultsDiv.className = 'col-span-full text-center py-16';
                noResultsDiv.innerHTML = `
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No books found</h3>
                    <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
                `;
                bookGrid.appendChild(noResultsDiv);
            }
        } else {
            if (noResultsDiv) {
                noResultsDiv.remove();
            }
        }
    }

    // Add event listeners
    searchInput.addEventListener('input', filterBooks);
    genreFilter.addEventListener('change', filterBooks);
</script>

</body>
</html>