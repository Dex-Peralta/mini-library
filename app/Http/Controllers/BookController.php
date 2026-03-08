<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $books = Book::query()
            ->with('authors')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%")
                        ->orWhere('genre', 'like', "%{$search}%")
                        ->orWhere('publisher', 'like', "%{$search}%")
                        ->orWhere('year_published', 'like', "%{$search}%")
                        ->orWhereHas('authors', function ($authorQuery) use ($search) {
                            $authorQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('title')
            ->get();
        
        // Calculate statistics
        $stats = [
            'total_books' => $books->count(),
            'total_copies' => $books->sum('total_copies'),
            'available_copies' => $books->sum('available_copies'),
            'borrowed_copies' => $books->sum('total_copies') - $books->sum('available_copies'),
            'out_of_stock' => $books->where('available_copies', 0)->count(),
            'genres' => $books->whereNotNull('genre')->groupBy('genre')->map->count()->sortDesc()->take(3),
        ];
        
        return view('books.index', compact('books', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'isbn' => 'nullable|string',
            'year_published' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'genre' => 'nullable|string',
            'publisher' => 'nullable|string',
            'total_copies' => 'required|integer|min:0',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id',
        ]);

        // Set available_copies equal to total_copies initially
        $validated['available_copies'] = $validated['total_copies'];
        $validated['inventory_count'] = $validated['total_copies']; // For backward compatibility

        $book = Book::create($validated);
        $book->authors()->attach($request->authors);

        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = Book::with('authors')->findOrFail($id);
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $book = Book::with('authors')->findOrFail($id);
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'isbn' => 'nullable|string',
            'year_published' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'genre' => 'nullable|string',
            'publisher' => 'nullable|string',
            'total_copies' => 'required|integer|min:0',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id',
        ]);

        // Calculate the difference in total_copies
        $copyDifference = $validated['total_copies'] - $book->total_copies;
        $validated['available_copies'] = $book->available_copies + $copyDifference;
        $validated['inventory_count'] = $validated['total_copies']; // For backward compatibility

        $book->update($validated);
        $book->authors()->sync($request->authors);

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Book::destroy($id);
        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }

    /**
     * Get available books (API endpoint)
     */
    public function getAvailableBooks()
    {
        $books = Book::where('available_copies', '>', 0)
            ->with('authors')
            ->get()
            ->map(function ($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'authors' => $book->authors->pluck('name')->join(', '),
                    'available_copies' => $book->available_copies,
                ];
            });

        return response()->json([
            'success' => true,
            'books' => $books
        ]);
    }

    /**
     * Toggle favorite for a book (requires authentication and non-admin user)
     */
    public function toggleFavorite(Request $request, Book $book)
    {
        // Require authentication
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = auth()->user();

        // Only students (non-admin) can favorite
        if ($user->isAdmin()) {
            return response()->json(['message' => 'Only students can favorite books'], 403);
        }

        $favorite = $user->favorites()->where('book_id', $book->id)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['favorited' => false, 'message' => 'Removed from favorites']);
        } else {
            $user->favorites()->create(['book_id' => $book->id]);
            return response()->json(['favorited' => true, 'message' => 'Added to favorites']);
        }
    }
}
