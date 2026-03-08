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
    public function index()
    {
        $books = Book::with('authors')->get();
        
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
}
