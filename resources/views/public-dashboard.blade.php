
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
            @auth
                <div class="flex items-center gap-2">
                    <a href="{{ route('profile.edit') }}" class="border border-gray-300 hover:bg-gray-100 text-gray-900 px-4 py-2 rounded-md text-sm font-medium">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-gray-900 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}" class="border border-gray-300 hover:bg-gray-100 text-gray-900 px-4 py-2 rounded-md text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-gray-900 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Register
                    </a>
                </div>
            @endauth
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

                    <!-- Favorite Button (for logged-in students only) -->
                    @auth
                        @if(!auth()->user()->isAdmin())
                        <button 
                            class="absolute top-3 left-3 favorite-btn p-2 bg-white rounded-full shadow hover:bg-gray-100 transition" 
                            data-book-id="{{ $book->id }}"
                            title="Add to favorites"
                        >
                            <svg class="w-5 h-5 {{ in_array($book->id, $favoriteBookIds ?? []) ? 'fill-red-500 text-red-500' : 'text-gray-400' }} transition" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>
                        @endif
                    @else
                        <button 
                            class="absolute top-3 left-3 p-2 bg-white rounded-full shadow hover:bg-gray-100 transition" 
                            onclick="window.location.href='{{ route('login') }}';"
                            title="Login to add to favorites"
                        >
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    @endauth
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

<!-- Borrow Confirmation Modal -->
<div id="borrowConfirmModal" class="fixed inset-0 hidden items-center justify-center z-[60] p-4 flex flex-col pointer-events-none" style="background: rgba(0, 0, 0, 0.3); -webkit-backdrop-filter: blur(4px); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden pointer-events-auto">
        <!-- Header -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 px-6 py-8 text-center">
            <h2 class="text-2xl font-bold text-white">Confirm Book Borrow</h2>
            <p class="text-gray-300 text-sm mt-2">Review your borrowing details</p>
        </div>

        <!-- Content -->
        <div class="px-6 py-6 space-y-6">
            <!-- Details Card -->
            <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                <div class="flex justify-between items-start">
                    <span class="text-gray-600 font-medium text-sm">Student ID/Email:</span>
                    <span class="text-gray-900 font-semibold text-sm" id="confirmIdentifier">-</span>
                </div>
                <div class="h-px bg-gray-200"></div>
                <div class="flex justify-between items-start">
                    <span class="text-gray-600 font-medium text-sm">Borrow Date:</span>
                    <span class="text-gray-900 font-semibold text-sm" id="confirmBorrowDate">-</span>
                </div>
                <div class="h-px bg-gray-200"></div>
                <div class="flex justify-between items-start">
                    <span class="text-gray-600 font-medium text-sm">Due Date:</span>
                    <span class="text-gray-900 font-semibold text-sm" id="confirmDueDate">-</span>
                </div>
            </div>

            <!-- Warning Alert - Made Very Prominent -->
            <div class="rounded-xl border-2 border-red-300 bg-red-50 px-5 py-4">
                <div class="flex gap-3 items-start">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-base font-bold text-red-800">Late Return Penalty</p>
                        <p class="text-sm text-red-700 mt-2">Overdue books incur <span class="font-bold text-red-900">PHP 10/day</span> in fines.</p>
                        <p class="text-xs text-red-600 mt-2 italic">Please ensure timely return to avoid charges.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="bg-gray-100 px-6 py-4 rounded-b-2xl flex gap-3 border-t border-gray-200">
            <button type="button" id="cancelBorrowConfirmBtn" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 font-semibold py-3 rounded-lg transition duration-200 text-sm">
                Cancel
            </button>
            <button type="button" id="proceedBorrowConfirmBtn" class="flex-1 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-semibold py-3 rounded-lg transition duration-200 text-sm transform">
                Confirm & Borrow
            </button>
        </div>
    </div>
</div>

<!-- Custom App Notice -->
<div id="appNotice" class="fixed top-5 right-5 hidden z-[70] w-[min(92vw,24rem)] rounded-xl border shadow-lg px-4 py-3">
    <p id="appNoticeTitle" class="font-semibold text-sm"></p>
    <p id="appNoticeMessage" class="text-sm mt-1"></p>
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
    const borrowConfirmModal = document.getElementById('borrowConfirmModal');
    const cancelBorrowConfirmBtn = document.getElementById('cancelBorrowConfirmBtn');
    const proceedBorrowConfirmBtn = document.getElementById('proceedBorrowConfirmBtn');
    const confirmIdentifier = document.getElementById('confirmIdentifier');
    const confirmBorrowDate = document.getElementById('confirmBorrowDate');
    const confirmDueDate = document.getElementById('confirmDueDate');
    const appNotice = document.getElementById('appNotice');
    const appNoticeTitle = document.getElementById('appNoticeTitle');
    const appNoticeMessage = document.getElementById('appNoticeMessage');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const loggedInBorrowIdentifier = @json($borrowIdentifier ?? '');
    let currentBookId = null;
    let pendingBorrowPayload = null;
    let noticeHideTimer = null;

    function showNotice(message, type = 'info', title = null) {
        const themes = {
            success: {
                box: 'bg-emerald-50 border-emerald-300',
                title: 'text-emerald-800',
                message: 'text-emerald-700',
                defaultTitle: 'Success',
            },
            error: {
                box: 'bg-red-50 border-red-300',
                title: 'text-red-800',
                message: 'text-red-700',
                defaultTitle: 'Error',
            },
            warning: {
                box: 'bg-amber-50 border-amber-300',
                title: 'text-amber-800',
                message: 'text-amber-700',
                defaultTitle: 'Notice',
            },
            info: {
                box: 'bg-blue-50 border-blue-300',
                title: 'text-blue-800',
                message: 'text-blue-700',
                defaultTitle: 'Info',
            },
        };

        const theme = themes[type] || themes.info;
        appNotice.className = `fixed top-5 right-5 z-[70] w-[min(92vw,24rem)] rounded-xl border shadow-lg px-4 py-3 ${theme.box}`;
        appNoticeTitle.className = `font-semibold text-sm ${theme.title}`;
        appNoticeMessage.className = `text-sm mt-1 ${theme.message}`;

        appNoticeTitle.textContent = title || theme.defaultTitle;
        appNoticeMessage.textContent = message;
        appNotice.classList.remove('hidden');

        if (noticeHideTimer) {
            clearTimeout(noticeHideTimer);
        }

        noticeHideTimer = setTimeout(() => {
            appNotice.classList.add('hidden');
        }, 3500);
    }

    function applyBorrowDefaults() {
        if (loggedInBorrowIdentifier) {
            studentIdentifierInput.value = loggedInBorrowIdentifier;
        }

        borrowDateInput.valueAsDate = new Date();
        const defaultDueDate = new Date();
        defaultDueDate.setDate(defaultDueDate.getDate() + 14);
        dueDateInput.valueAsDate = defaultDueDate;
    }

    applyBorrowDefaults();

    borrowButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentBookId = this.dataset.bookId;
            document.getElementById('modalBookTitle').textContent = this.dataset.bookTitle;
            applyBorrowDefaults();
            borrowConfirmModal.classList.add('hidden');
            borrowModal.classList.remove('hidden');
        });
    });

    cancelBorrowBtn.addEventListener('click', function() {
        borrowModal.classList.add('hidden');
        borrowConfirmModal.classList.add('hidden');
        borrowForm.reset();
        applyBorrowDefaults();
    });

    borrowForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const identifier = studentIdentifierInput.value.trim();
        const borrowDate = borrowDateInput.value;
        const dueDate = dueDateInput.value;

        if (!identifier || !borrowDate || !dueDate || !currentBookId) {
            showNotice('Please complete all required fields before confirming.', 'warning', 'Missing Details');
            return;
        }

        pendingBorrowPayload = {
            book_id: currentBookId,
            identifier,
            borrow_date: borrowDate,
            due_date: dueDate,
        };

        confirmIdentifier.textContent = identifier;
        confirmBorrowDate.textContent = borrowDate;
        confirmDueDate.textContent = dueDate;
        borrowModal.classList.add('hidden');
        borrowConfirmModal.classList.remove('hidden');
    });

    cancelBorrowConfirmBtn.addEventListener('click', function() {
        borrowConfirmModal.classList.add('hidden');
        borrowModal.classList.remove('hidden');
    });

    async function submitBorrowRequest(payload) {
        if (!payload) {
            return;
        }

        proceedBorrowConfirmBtn.disabled = true;
        proceedBorrowConfirmBtn.classList.add('opacity-70', 'cursor-not-allowed');

        try {
            const response = await fetch("{{ route('public.borrow') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload),
            });

            const responseData = await response.json();
            if (!response.ok) {
                const message = responseData.message || Object.values(responseData.errors || {}).flat()[0] || 'Borrow failed.';
                throw new Error(message);
            }

            showNotice(
                `Reservation submitted. Please claim the book with the librarian to complete borrowing.`,
                'success',
                'Reservation Created'
            );
            borrowModal.classList.add('hidden');
            borrowConfirmModal.classList.add('hidden');
            borrowForm.reset();
            applyBorrowDefaults();
            
            // Reload shortly so updated availability is reflected.
            setTimeout(() => location.reload(), 850);
        } catch (error) {
            showNotice('Error processing borrow: ' + error.message, 'error', 'Borrow Failed');
        } finally {
            proceedBorrowConfirmBtn.disabled = false;
            proceedBorrowConfirmBtn.classList.remove('opacity-70', 'cursor-not-allowed');
        }
    }

    proceedBorrowConfirmBtn.addEventListener('click', function() {
        if (!pendingBorrowPayload) {
            return;
        }
        submitBorrowRequest(pendingBorrowPayload);
    });

    // Close modal when clicking outside
    borrowModal.addEventListener('click', function(e) {
        if (e.target === borrowModal) {
            borrowModal.classList.add('hidden');
            borrowConfirmModal.classList.add('hidden');
            borrowForm.reset();
            applyBorrowDefaults();
        }
    });

    borrowConfirmModal.addEventListener('click', function(e) {
        if (e.target === borrowConfirmModal) {
            borrowConfirmModal.classList.add('hidden');
        }
    });

    // Favorite Toggle Functionality
    const favoriteButtons = document.querySelectorAll('.favorite-btn');
    favoriteButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const bookId = this.dataset.bookId;
            
            try {
                const response = await fetch(`/books/${bookId}/toggle-favorite`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                const data = await response.json();
                
                if (response.status === 401) {
                    // Not logged in, redirect to login
                    window.location.href = '{{ route('login') }}';
                    return;
                }

                if (response.status === 403) {
                    showNotice('Only student accounts can favorite books.', 'warning', 'Action Not Allowed');
                    return;
                }

                if (response.ok) {
                    // Toggle the filled heart icon
                    const svg = this.querySelector('svg');
                    if (data.favorited) {
                        this.title = 'Remove from favorites';
                        svg.classList.remove('text-gray-400');
                        svg.classList.add('fill-red-500', 'text-red-500');
                    } else {
                        this.title = 'Add to favorites';
                        svg.classList.add('text-gray-400');
                        svg.classList.remove('fill-red-500', 'text-red-500');
                    }

                    // Re-sort books by favorited status
                    const cards = Array.from(document.querySelectorAll('.book-card'));
                    cards.sort((a, b) => {
                        const aFav = a.querySelector('.favorite-btn svg').classList.contains('fill-red-500') ? 1 : 0;
                        const bFav = b.querySelector('.favorite-btn svg').classList.contains('fill-red-500') ? 1 : 0;
                        return bFav - aFav;
                    });
                    
                    bookGrid.innerHTML = '';
                    cards.forEach(card => bookGrid.appendChild(card));
                } else {
                    showNotice(data.message || 'Failed to update favorite.', 'error', 'Favorite Update Failed');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotice('Error updating favorite: ' + error.message, 'error', 'Favorite Error');
            }
        });
    });
</script>

    </div>
</body>
</html>