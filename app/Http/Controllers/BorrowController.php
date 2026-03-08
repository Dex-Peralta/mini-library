<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\BorrowItem;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Checkout a book (create a borrow record)
     */
    public function checkout(Request $request, Book $book)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to checkout books'
            ], 401);
        }

        // Check if book is available
        if (!$book->isAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'This book is out of stock'
            ], 400);
        }

        try {
            // Get the student associated with the current user
            $student = Student::where('user_id', Auth::id())->first();
            
            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student record not found. Please complete your student profile first.'
                ], 404);
            }

            // Create a borrow record
            $borrow = Borrow::create([
                'student_id' => $student->id,
                'borrow_date' => $request->input('borrow_date', now()->toDateString()),
                'due_date' => $request->input('return_date', now()->addDays(7)->toDateString())
            ]);

            // Create a borrow item record
            BorrowItem::create([
                'borrow_id' => $borrow->id,
                'book_id' => $book->id
            ]);

            // Reduce inventory count
            $book->decrement('inventory_count');

            return response()->json([
                'success' => true,
                'message' => 'Book successfully checked out',
                'data' => [
                    'book_id' => $book->id,
                    'borrow_id' => $borrow->id,
                    'status' => $book->fresh()->getStatus()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while checking out the book: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show my borrowed books
     */
    public function myBooks()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $student = Student::where('user_id', Auth::id())->first();
        
        if (!$student) {
            return view('my-books', [
                'currentBorrows' => collect(),
                'borrowHistory' => collect()
            ]);
        }

        // Get current active borrows (without return date or with future due date)
        $currentBorrows = Borrow::where('student_id', $student->id)
            ->with('items.book.authors')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('my-books', compact('currentBorrows'));
    }
}
