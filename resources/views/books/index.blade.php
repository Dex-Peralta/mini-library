<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Books</h2>
            <a href="{{ route('books.create') }}" class="bg-gray-900 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                Add New Book
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Mini Statistics Bar -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                <!-- Total Books -->
                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Total Books</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_books'] }}</p>
                        </div>
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Copies -->
                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Total Copies</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_copies'] }}</p>
                        </div>
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Available Copies -->
                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Available</p>
                            <p class="text-2xl font-bold text-green-600">{{ $stats['available_copies'] }}</p>
                        </div>
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Borrowed Copies -->
                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-orange-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Borrowed</p>
                            <p class="text-2xl font-bold text-orange-600">{{ $stats['borrowed_copies'] }}</p>
                        </div>
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Out of Stock -->
                <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-semibold">Out of Stock</p>
                            <p class="text-2xl font-bold text-red-600">{{ $stats['out_of_stock'] }}</p>
                        </div>
                        <div class="p-2 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Table Header -->
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">All Books</h3>
                            <p class="text-sm text-gray-500 mt-1">Showing {{ $books->count() }} {{ Str::plural('book', $books->count()) }}</p>
                        </div>
                    </div>
                    
                    @if($books->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Authors</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Genre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inventory</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($books as $book)
                                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                                                @if($book->publisher)
                                                    <div class="text-xs text-gray-500 mt-1">{{ $book->publisher }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                {{ $book->authors->pluck('name')->join(', ') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $book->isbn ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $book->year_published ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($book->genre)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($book->genre == 'Fiction' || $book->genre == 'Romance') bg-pink-100 text-pink-800
                                                        @elseif($book->genre == 'Science Fiction') bg-blue-100 text-blue-800
                                                        @elseif($book->genre == 'Fantasy') bg-purple-100 text-purple-800
                                                        @elseif($book->genre == 'Mystery' || $book->genre == 'Horror') bg-gray-100 text-gray-800
                                                        @elseif($book->genre == 'Classic') bg-amber-100 text-amber-800
                                                        @else bg-green-100 text-green-800
                                                        @endif">
                                                        {{ $book->genre }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400 text-xs">N/A</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-2">
                                                    @php
                                                        $percentage = $book->total_copies > 0 ? ($book->available_copies / $book->total_copies) * 100 : 0;
                                                    @endphp
                                                    
                                                    @if($book->available_copies == 0)
                                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Out of Stock
                                                        </span>
                                                    @elseif($percentage <= 25)
                                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                            Low Stock
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            In Stock
                                                        </span>
                                                    @endif
                                                    
                                                    <span class="text-sm font-medium text-gray-700">
                                                        {{ $book->available_copies }} / {{ $book->total_copies }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('books.edit', $book->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No books</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding a new book.</p>
                            <div class="mt-6">
                                <a href="{{ route('books.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-900 hover:bg-gray-700">
                                    Add New Book
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
