<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\BorrowItem;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BorrowController extends Controller
{
    private const FINE_PER_DAY_PHP = 10;

    /**
     * Display all borrow transactions
     */
    public function index()
    {
        $borrows = Borrow::with(['student', 'items.book.authors'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('borrows.index', compact('borrows'));
    }

    /**
     * Show form to create new borrow
     */
    public function create()
    {
        $students = Student::all();
        $books = Book::where('available_copies', '>', 0)->with('authors')->get();
        
        return view('borrows.create', compact('students', 'books'));
    }

    /**
     * Store new borrow transaction with multiple books
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
            'books' => 'required|array|min:1',
            'books.*' => 'exists:books,id',
        ]);

        // Check if all books are available
        foreach ($validated['books'] as $bookId) {
            $book = Book::find($bookId);
            if (!$book || $book->available_copies < 1) {
                return back()->withErrors(['books' => "Book '{$book->title}' is not available."])->withInput();
            }
        }

        // Create borrow record
        $borrow = Borrow::create([
            'student_id' => $validated['student_id'],
            'borrow_date' => $validated['borrow_date'],
            'due_date' => $validated['due_date'],
        ]);

        // Create borrow items and decrease inventory
        foreach ($validated['books'] as $bookId) {
            BorrowItem::create([
                'borrow_id' => $borrow->id,
                'book_id' => $bookId,
            ]);

            // Decrease available copies
            $book = Book::find($bookId);
            $book->decreaseAvailability();
        }

        return redirect()->route('borrows.index')->with('success', 'Books borrowed successfully!');
    }

    /**
     * Show specific borrow transaction details
     */
    public function show($id)
    {
        $borrow = Borrow::with(['student', 'items.book.authors'])->findOrFail($id);
        return view('borrows.show', compact('borrow'));
    }

    /**
     * Show return form
     */
    public function returnForm($id)
    {
        $borrow = Borrow::with(['student', 'items.book'])->findOrFail($id);
        
        $finePerDay = self::FINE_PER_DAY_PHP;
        $today = Carbon::today();
        
        return view('borrows.return', compact('borrow', 'finePerDay', 'today'));
    }

    /**
     * Process return (full or partial)
     */
    public function processReturn(Request $request, $id)
    {
        $borrow = Borrow::findOrFail($id);
        
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*' => 'exists:borrow_items,id',
        ]);

        $returnedAt = now();
        $hasReturnedItems = false;

        foreach ($validated['items'] as $itemId) {
            $item = BorrowItem::find($itemId);
            
            if ($item && $item->borrow_id == $borrow->id && !$item->returned_at) {
                $daysLate = $this->calculateOverdueDays($borrow->due_date, $returnedAt);
                $fine = $daysLate * self::FINE_PER_DAY_PHP;

                // Update item
                $item->update([
                    'returned_at' => $returnedAt,
                    'fine' => $fine,
                ]);

                // Increase available copies
                $item->book->increaseAvailability();
                $hasReturnedItems = true;
            }
        }

        if ($hasReturnedItems) {
            // Keep borrow record fresh for partial/full return tracking via updated_at.
            $borrow->touch();
        }

        return redirect()->route('borrows.show', $borrow->id)
            ->with('success', 'Books returned successfully!');
    }

    /**
     * Public borrow endpoint (no login required).
     */
    public function storePublic(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'identifier' => 'required|string|max:255',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
        ]);

        $identifier = trim($validated['identifier']);

        $result = DB::transaction(function () use ($validated, $identifier) {
            $book = Book::lockForUpdate()->findOrFail($validated['book_id']);

            if ($book->available_copies < 1) {
                throw ValidationException::withMessages([
                    'book_id' => 'This book is no longer available.',
                ]);
            }

            $student = Student::where('student_number', $identifier)
                ->orWhere('email', $identifier)
                ->first();

            if (!$student) {
                $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL);
                $student = Student::create([
                    'name' => 'Student ' . $identifier,
                    'student_number' => $isEmail ? Str::before($identifier, '@') : $identifier,
                    'course' => 'Unspecified',
                    'email' => $isEmail ? $identifier : null,
                ]);
            }

            $borrow = Borrow::create([
                'student_id' => $student->id,
                'borrow_date' => $validated['borrow_date'],
                'due_date' => $validated['due_date'],
            ]);

            BorrowItem::create([
                'borrow_id' => $borrow->id,
                'book_id' => $book->id,
            ]);

            $book->decreaseAvailability();

            return [
                'student_number' => $student->student_number,
                'email' => $student->email,
            ];
        });

        return response()->json([
            'message' => 'Book borrowed successfully.',
            'student_identifier' => $identifier,
            'student_number' => $result['student_number'],
            'email' => $result['email'],
        ]);
    }

    /**
     * Show returns management page
     */
    public function manageReturns(Request $request)
    {
        $identifier = trim((string) $request->query('search', ''));
        $student = null;
        $activeItems = collect();

        if ($identifier !== '') {
            $student = Student::where('student_number', $identifier)
                ->orWhere('email', $identifier)
                ->first();

            if ($student) {
                // Get all unreturned borrow items for this student
                $activeItems = BorrowItem::with(['book.authors', 'borrow'])
                    ->whereNull('returned_at')
                    ->whereHas('borrow', function($query) use ($student) {
                        $query->where('student_id', $student->id);
                    })
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($item) {
                        $daysLate = $this->calculateOverdueDays($item->borrow->due_date, Carbon::today());
                        $item->days_late = $daysLate;
                        $item->is_overdue = $daysLate > 0;
                        $item->fine_preview = $daysLate * self::FINE_PER_DAY_PHP;

                        return $item;
                    });
            }
        }

        return view('borrows.manage-returns', compact('identifier', 'student', 'activeItems'));
    }

    /**
     * Process quick return (all or selected items)
     */
    public function quickReturn(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*' => 'exists:borrow_items,id',
        ]);

        $returnedAt = now();
        $returnedCount = 0;
        $affectedBorrows = [];

        foreach ($validated['items'] as $itemId) {
            $item = BorrowItem::with('borrow', 'book')->find($itemId);
            
            if ($item && !$item->returned_at) {
                $daysLate = $this->calculateOverdueDays($item->borrow->due_date, $returnedAt);
                $fine = $daysLate * self::FINE_PER_DAY_PHP;

                // Update item
                $item->update([
                    'returned_at' => $returnedAt,
                    'fine' => $fine,
                ]);

                // Increase available copies
                $item->book->increaseAvailability();
                $affectedBorrows[$item->borrow_id] = true;
                $returnedCount++;
            }
        }

        if (!empty($affectedBorrows)) {
            Borrow::whereIn('id', array_keys($affectedBorrows))->update(['updated_at' => now()]);
        }

        return back()->with('success', "{$returnedCount} book(s) returned successfully!");
    }

    private function calculateOverdueDays($dueDate, ?Carbon $asOf = null): int
    {
        $due = $dueDate instanceof Carbon
            ? $dueDate->copy()->startOfDay()
            : Carbon::parse($dueDate)->startOfDay();

        $reference = ($asOf ?? Carbon::today())->copy()->startOfDay();
        $days = $due->diffInDays($reference, false);

        return max(0, (int) $days);
    }
}
