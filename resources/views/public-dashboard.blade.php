
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mini Library</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <svg class="w-7 h-7 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="font-semibold text-xl">Mini Library</span>
                </a>
                <div class="hidden sm:flex items-center gap-4 text-sm">
                    <a href="{{ route('home') }}" class="text-gray-900 font-semibold border-b-2 border-gray-900 pb-1">Browse</a>
                    <a href="{{ route('my-books') }}" class="text-gray-600 hover:text-gray-900">My Books</a>
                </div>
            </div>
            <a href="{{ route('login') }}" class="bg-gray-900 hover:bg-gray-700 text-white px-6 py-2 rounded-md">
                Admin Login
            </a>
        </div>
    </nav>

    <!-- Main Content - Browse Books -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
    
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Browse Books</h1>
        <p class="text-gray-600 text-lg">Discover and borrow books from our collection</p>
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
            <div class="bg-white rounded-xl overflow-hidden shadow-sm book-card hover:shadow-lg transition" 
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
                    @if($book->available_copies > 0)
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

                    <!-- Borrow Button -->
                    <div class="mb-2 flex items-center justify-between">
                        <span class="text-xs font-medium text-gray-600">
                            {{ $book->available_copies }} of {{ $book->total_copies }} available
                        </span>
                    </div>

                    @if($book->available_copies > 0)
                        <button 
                            class="w-full borrow-btn bg-gray-900 hover:bg-gray-800 text-white font-medium py-2.5 rounded-lg transition duration-200 shadow-sm" 
                            data-book-id="{{ $book->id }}"
                            data-book-title="{{ $book->title }}"
                        >
                            Borrow
                        </button>
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

<!-- Borrow Modal -->
<div id="borrowModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full">
        <!-- Modal Header -->
        <div class="bg-gray-900 text-white p-6 rounded-t-xl">
            <h2 class="text-2xl font-bold">Borrow Book</h2>
            <p id="modalBookTitle" class="text-gray-300 text-sm mt-1">Loading...</p>
        </div>

        <!-- Modal Body -->
        <form id="borrowForm" class="p-6 space-y-4">
            <!-- Student Number or Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Student Number or Email <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="studentIdentifier" 
                    placeholder="Enter your student number or institutional email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800"
                    required
                >
                <p class="text-xs text-gray-500 mt-1">Enter your student number or registered email address</p>
            </div>

            <!-- Borrow Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Borrow Date</label>
                <input 
                    type="date" 
                    id="borrowDate" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800"
                >
            </div>

            <!-- Due Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
                <input 
                    type="date" 
                    id="dueDate" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800"
                >
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 -mx-6 -mb-6 flex gap-3 rounded-b-xl">
                <button 
                    type="button"
                    id="cancelBorrowBtn" 
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 font-medium py-2 rounded-lg transition"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    id="confirmBorrowBtn" 
                    class="flex-1 bg-gray-900 hover:bg-gray-800 text-white font-medium py-2 rounded-lg transition"
                >
                    Confirm
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Search and Filter Functionality
    const searchInput = document.getElementById('searchInput');
    const genreFilter = document.getElementById('genreFilter');
    const bookCards = document.querySelectorAll('.book-card');
    const bookGrid = document.getElementById('bookGrid');

    function filterBooks() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedGenre = genreFilter.value.toLowerCase();

        bookCards.forEach(card => {
            const title = card.dataset.title;
            const author = card.dataset.author;
            const genre = card.dataset.genre.toLowerCase();

            const matchesSearch = title.includes(searchTerm) || author.includes(searchTerm);
            const matchesGenre = !selectedGenre || genre === selectedGenre;

            if (matchesSearch && matchesGenre) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterBooks);
    genreFilter.addEventListener('change', filterBooks);

    // Borrow Modal Logic
    const borrowModal = document.getElementById('borrowModal');
    const borrowForm = document.getElementById('borrowForm');
    const borrowButtons = document.querySelectorAll('.borrow-btn');
    const cancelBorrowBtn = document.getElementById('cancelBorrowBtn');
    const studentIdentifierInput = document.getElementById('studentIdentifier');
    const borrowDateInput = document.getElementById('borrowDate');
    const dueDateInput = document.getElementById('dueDate');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let currentBookId = null;

    // Set today as default borrow date
    borrowDateInput.valueAsDate = new Date();

    // Set due date to 14 days from today
    const dueDate = new Date();
    dueDate.setDate(dueDate.getDate() + 14);
    dueDateInput.valueAsDate = dueDate;

    borrowButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentBookId = this.dataset.bookId;
            document.getElementById('modalBookTitle').textContent = this.dataset.bookTitle;
            borrowModal.classList.remove('hidden');
        });
    });

    cancelBorrowBtn.addEventListener('click', function() {
        borrowModal.classList.add('hidden');
        borrowForm.reset();
    });

    borrowForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const identifier = studentIdentifierInput.value.trim();
        const borrowDate = borrowDateInput.value;
        const dueDate = dueDateInput.value;

        if (!identifier || !borrowDate || !dueDate || !currentBookId) {
            alert('Please fill in all fields');
            return;
        }

        try {
            const response = await fetch("{{ route('public.borrow') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    book_id: currentBookId,
                    identifier,
                    borrow_date: borrowDate,
                    due_date: dueDate,
                }),
            });

            const payload = await response.json();
            if (!response.ok) {
                const message = payload.message || Object.values(payload.errors || {}).flat()[0] || 'Borrow failed.';
                throw new Error(message);
            }

            alert(`Book borrowed successfully!\nStudent ID: ${identifier}\nBorrow Date: ${borrowDate}\nDue Date: ${dueDate}`);
            borrowModal.classList.add('hidden');
            borrowForm.reset();
            borrowDateInput.valueAsDate = new Date();
            const newDueDate = new Date();
            newDueDate.setDate(newDueDate.getDate() + 14);
            dueDateInput.valueAsDate = newDueDate;
            
            // Optionally reload to update book availability
            location.reload();
        } catch (error) {
            alert('Error processing borrow: ' + error.message);
        }
    });

    // Close modal when clicking outside
    borrowModal.addEventListener('click', function(e) {
        if (e.target === borrowModal) {
            borrowModal.classList.add('hidden');
            borrowForm.reset();
        }
    });
</script>

    </div>
</body>
</html>