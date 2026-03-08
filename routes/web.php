<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ProfileController;
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
        'active_borrows' => Borrow::whereHas('items', function($query) {
            $query->whereNull('returned_at');
        })->count(),
        'overdue_items' => BorrowItem::whereNull('returned_at')
            ->whereHas('borrow', function($query) {
                $query->where('due_date', '<', now());
            })
            ->count(),
    ];
    
    $books = Book::with('authors')->get();
    
    return view('public-dashboard', compact('stats', 'books'));
})->name('home');

Route::post('/public-borrow', [BorrowController::class, 'storePublic'])->name('public.borrow');

Route::get('/my-books', function (Request $request) {
    $identifier = trim((string) $request->query('identifier', ''));
    $student = null;
    $borrows = collect();

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

// Admin routes - authentication required
Route::middleware(['auth'])->group(function () {

    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        $stats = [
            'students' => Student::count(),
            'authors' => Author::count(),
            'books' => Book::count(),
            'total_copies' => Book::sum('total_copies'),
            'available_copies' => Book::sum('available_copies'),
            'borrowed_books' => Book::sum('total_copies') - Book::sum('available_copies'),
            'active_borrows' => Borrow::whereHas('items', function($query) {
                $query->whereNull('returned_at');
            })->count(),
            'overdue_items' => BorrowItem::whereNull('returned_at')
                ->whereHas('borrow', function($query) {
                    $query->where('due_date', '<', now());
                })
                ->count(),
        ];
        
        return view('admin-dashboard', compact('stats'));
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD modules
    Route::resource('students', StudentController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);
    
    // Borrowing and returns
    Route::get('/borrows', [BorrowController::class, 'index'])->name('borrows.index');
    Route::get('/borrows/create', [BorrowController::class, 'create'])->name('borrows.create');
    Route::post('/borrows', [BorrowController::class, 'store'])->name('borrows.store');
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
