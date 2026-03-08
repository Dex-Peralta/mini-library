<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Books - Mini Library</title>
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
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">Browse</a>
                    <a href="{{ route('my-books') }}" class="text-gray-900 font-semibold border-b-2 border-gray-900 pb-1">My Books</a>
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

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">My Books</h1>
                <p class="text-gray-600">Check your active borrows and borrowing history using student number or institutional email.</p>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('my-books') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div class="md:col-span-3">
                        <label for="identifier" class="block text-sm font-medium text-gray-700 mb-2">Student Number or Email</label>
                        <input
                            id="identifier"
                            name="identifier"
                            type="text"
                            value="{{ $identifier }}"
                            placeholder="e.g., 2023-0001 or student@school.edu"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800"
                        >
                    </div>
                    <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2 rounded-lg font-medium">
                        Find My Books
                    </button>
                </form>
            </div>

            @if($identifier !== '' && !$student)
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                    No student record found for <span class="font-semibold">{{ $identifier }}</span>.
                </div>
            @endif

            @if($student)
                <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Student</h2>
                    <p class="text-gray-700 mt-2">{{ $student->name }}</p>
                    <p class="text-sm text-gray-500">{{ $student->student_number }} @if($student->email) | {{ $student->email }} @endif</p>
                </div>

                @php
                    $currentBorrows = $borrows->filter(function ($borrow) {
                        if ($borrow->isReserved()) {
                            return false;
                        }

                        return $borrow->items->contains(function ($item) {
                            return is_null($item->returned_at);
                        });
                    });
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Currently Borrowed</h3>
                        @if($currentBorrows->isEmpty())
                            <p class="text-gray-500">No active borrowed books.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($currentBorrows as $borrow)
                                    @foreach($borrow->items->whereNull('returned_at') as $item)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <p class="font-semibold text-gray-900">{{ $item->book->title ?? 'Unknown Book' }}</p>
                                            <p class="text-sm text-gray-600">Borrowed: {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('M d, Y') }}</p>
                                            <p class="text-sm text-gray-600">Due: {{ \Carbon\Carbon::parse($borrow->due_date)->format('M d, Y') }}</p>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Borrow History</h3>
                        @if($borrows->isEmpty())
                            <p class="text-gray-500">No borrowing history yet.</p>
                        @else
                            <div class="space-y-4 max-h-[520px] overflow-y-auto pr-1">
                                @foreach($borrows as $borrow)
                                    @foreach($borrow->items as $item)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <div class="flex items-center justify-between gap-2">
                                                <p class="font-semibold text-gray-900">{{ $item->book->title ?? 'Unknown Book' }}</p>
                                                @if($borrow->isReserved())
                                                    <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full">Reserved</span>
                                                @elseif($borrow->isCancelled())
                                                    <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded-full">Cancelled</span>
                                                @elseif($item->returned_at)
                                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Returned</span>
                                                @else
                                                    <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded-full">Active</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">Borrowed: {{ \Carbon\Carbon::parse($borrow->borrow_date)->format('M d, Y') }}</p>
                                            <p class="text-sm text-gray-600">Due: {{ \Carbon\Carbon::parse($borrow->due_date)->format('M d, Y') }}</p>
                                            @if($borrow->isReserved())
                                                <p class="text-sm text-purple-700">Waiting for librarian claim confirmation.</p>
                                            @elseif($borrow->isCancelled())
                                                <p class="text-sm text-gray-600">This reservation was cancelled by the librarian.</p>
                                            @endif
                                            @if($item->returned_at)
                                                <p class="text-sm text-gray-600">Returned: {{ \Carbon\Carbon::parse($item->returned_at)->format('M d, Y h:i A') }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
