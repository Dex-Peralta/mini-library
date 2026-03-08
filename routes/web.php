<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use App\Models\Student;
use App\Models\Author;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\BorrowItem;

// Public Dashboard - accessible without login
Route::get('/', function () {
    $stats = [
        'students' => Student::count(),
        'authors' => Author::count(),
        'books' => Book::count(),
        'total_copies' => Book::sum('total_copies'),
        'available_copies' => Book::sum('available_copies'),
        'borrowed_books' => Book::sum('total_copies') - Book::sum('available_copies'),
        'borrowed_items' => BorrowItem::whereNull('returned_at')
            ->whereHas('borrow', function($query) {
                $query->where('status', Borrow::STATUS_BORROWED);
            })
            ->count(),
        'reserved_items' => BorrowItem::whereNull('returned_at')
            ->whereHas('borrow', function($query) {
                $query->where('status', Borrow::STATUS_RESERVED);
            })
            ->count(),
        'active_borrows' => Borrow::whereHas('items', function($query) {
            $query->whereNull('returned_at');
        })->where('status', Borrow::STATUS_BORROWED)->count(),
        'reserved_borrows' => Borrow::where('status', Borrow::STATUS_RESERVED)->count(),
        'overdue_items' => BorrowItem::whereNull('returned_at')
            ->whereHas('borrow', function($query) {
                $query->where('due_date', '<', now())
                    ->where('status', Borrow::STATUS_BORROWED);
            })
            ->count(),
    ];
    
    $books = Book::with('authors')->get();

    $borrowIdentifier = '';
    if (auth()->check()) {
        $user = auth()->user()->loadMissing('student');
        $borrowIdentifier = $user->student?->student_number ?? $user->student?->email ?? $user->email;
    }
    
    // Load favorite IDs for logged-in students
    $favoriteBookIds = auth()->check() && !auth()->user()->isAdmin()
        ? auth()->user()->favoriteBooks()->pluck('books.id')->toArray()
        : [];
    
    // Sort books so favorites appear first
    $books = $books->sortByDesc(function ($book) use ($favoriteBookIds) {
        return in_array($book->id, $favoriteBookIds) ? 1 : 0;
    });
    
    return view('public-dashboard', compact('stats', 'books', 'favoriteBookIds', 'borrowIdentifier'));
})->name('home');

Route::post('/public-borrow', [BorrowController::class, 'storePublic'])->name('public.borrow');

Route::get('/my-books', function (Request $request) {
    $identifier = trim((string) $request->query('identifier', ''));
    $student = null;
    $borrows = collect();

    // Auto-fill and auto-search for logged-in non-admin users.
    if ($identifier === '' && auth()->check() && !auth()->user()->isAdmin()) {
        $user = auth()->user()->loadMissing('student');
        $identifier = $user->student?->student_number ?? $user->student?->email ?? $user->email;
    }

    if ($identifier !== '') {
        $student = Student::where('student_number', $identifier)
            ->orWhere('email', $identifier)
            ->first();

        if ($student) {
            $borrows = Borrow::with(['items.book.authors'])
                ->where('student_id', $student->id)
                ->orderByDesc('borrow_date')
                ->get();
        }
    }

    return view('my-books', compact('identifier', 'student', 'borrows'));
})->name('my-books');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Role-aware dashboard entry point after login
    Route::get('/dashboard', function (Request $request) {
        return $request->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('home');
    })->name('dashboard');

    // Profile routes (shared for logged-in users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Favorite routes (for students/non-admins)
    Route::post('/books/{book}/toggle-favorite', [BookController::class, 'toggleFavorite'])->name('books.toggle-favorite');
});

// Admin-only routes
Route::middleware(['auth', 'admin'])->group(function () {

    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        $stats = [
            'users' => User::count(),
            'students' => Student::count(),
            'authors' => Author::count(),
            'books' => Book::count(),
            'total_copies' => Book::sum('total_copies'),
            'available_copies' => Book::sum('available_copies'),
            'borrowed_books' => Book::sum('total_copies') - Book::sum('available_copies'),
            'borrowed_items' => BorrowItem::whereNull('returned_at')
                ->whereHas('borrow', function($query) {
                    $query->where('status', Borrow::STATUS_BORROWED);
                })
                ->count(),
            'reserved_items' => BorrowItem::whereNull('returned_at')
                ->whereHas('borrow', function($query) {
                    $query->where('status', Borrow::STATUS_RESERVED);
                })
                ->count(),
            'active_borrows' => Borrow::whereHas('items', function($query) {
                $query->whereNull('returned_at');
            })->where('status', Borrow::STATUS_BORROWED)->count(),
            'reserved_borrows' => Borrow::where('status', Borrow::STATUS_RESERVED)->count(),
            'overdue_items' => BorrowItem::whereNull('returned_at')
                ->whereHas('borrow', function($query) {
                    $query->where('due_date', '<', now())
                        ->where('status', Borrow::STATUS_BORROWED);
                })
                ->count(),
        ];
        
        return view('admin-dashboard', compact('stats'));
    })->name('admin.dashboard');

    // CRUD modules
    Route::resource('students', StudentController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);
    
    // Borrowing and returns
    Route::get('/borrows', [BorrowController::class, 'index'])->name('borrows.index');
    Route::get('/borrows/create', [BorrowController::class, 'create'])->name('borrows.create');
    Route::post('/borrows', [BorrowController::class, 'store'])->name('borrows.store');
    Route::post('/borrows/{borrow}/confirm-claim', [BorrowController::class, 'confirmClaim'])->name('borrows.confirm-claim');
    Route::post('/borrows/{borrow}/cancel-reservation', [BorrowController::class, 'cancelReservation'])->name('borrows.cancel-reservation');
    Route::get('/borrows/{borrow}', [BorrowController::class, 'show'])->name('borrows.show');
    
    // Return routes
    Route::get('/returns/manage', [BorrowController::class, 'manageReturns'])->name('returns.manage');
    Route::post('/returns/quick', [BorrowController::class, 'quickReturn'])->name('returns.quick');
    Route::get('/borrows/{borrow}/return', [BorrowController::class, 'returnForm'])->name('borrows.return');
    Route::post('/borrows/{borrow}/return', [BorrowController::class, 'processReturn'])->name('borrows.process-return');
    
    // API routes
    Route::get('/api/student-info/{studentId}', [StudentController::class, 'getStudentInfo']);
    Route::get('/api/available-books', [BookController::class, 'getAvailableBooks']);
});

require __DIR__.'/auth.php';
