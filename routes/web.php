<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ProfileController;
use App\Models\Book;

Route::get('/', function () {
    $books = Book::with('authors')->get();
    return view('dashboard', compact('books'));
})->name('home');

// Public routes - no authentication required
Route::get('/dashboard', function () {
    $books = Book::with('authors')->get();
    return view('dashboard', compact('books'));
})->name('dashboard');

Route::get('/my-books', [BorrowController::class, 'myBooks'])->name('my-books');
Route::get('/borrow', [BorrowController::class, 'index'])->name('borrow.index');

// Protected routes - authentication required
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('students', StudentController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);

    // Borrow/Checkout routes
    Route::post('/books/{book}/checkout', [BorrowController::class, 'checkout'])->name('books.checkout');
    
    // API routes
    Route::get('/api/student-info', [StudentController::class, 'getStudentInfo']);
});

require __DIR__.'/auth.php';
