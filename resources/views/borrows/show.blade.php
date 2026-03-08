<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Borrow Transaction #{{ $borrow->id }}</h2>
            <a href="{{ route('borrows.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Back to Transactions
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Transaction Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Transaction Details</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Student</p>
                            <p class="font-medium">{{ $borrow->student->name }}</p>
                            <p class="text-xs text-gray-400">{{ $borrow->student->student_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Borrow Date</p>
                            <p class="font-medium">{{ $borrow->borrow_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Due Date</p>
                            <p class="font-medium">{{ $borrow->due_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            @php
                                $totalItems = $borrow->items->count();
                                $returnedItems = $borrow->items->where('returned_at', '!=', null)->count();
                                $overdueItems = $borrow->items->filter(function($item) use ($borrow) {
                                    return !$item->returned_at && now()->greaterThan($borrow->due_date);
                                })->count();
                            @endphp
                            <p class="font-medium">
                                @if($returnedItems == $totalItems)
                                    <span class="text-green-600">Returned</span>
                                @elseif($returnedItems > 0)
                                    <span class="text-blue-600">Partially Returned</span>
                                @elseif($overdueItems > 0)
                                    <span class="text-red-600">Overdue</span>
                                @else
                                    <span class="text-yellow-600">Borrowed</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrowed Books -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Borrowed Books</h3>
                        @if($returnedItems < $totalItems)
                            <a href="{{ route('borrows.return', $borrow->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm">
                                Process Return
                            </a>
                        @endif
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($borrow->items as $item)
                            <div class="border border-gray-200 rounded-lg p-4 @if($item->returned_at) bg-gray-50 @endif">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $item->book->title }}</h4>
                                        <p class="text-sm text-gray-500">
                                            By: {{ $item->book->authors->pluck('name')->join(', ') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        @if($item->returned_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Returned
                                            </span>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $item->returned_at->format('M d, Y') }}
                                            </p>
                                            @if($item->fine > 0)
                                                <p class="text-sm font-medium text-red-600 mt-1">
                                                    Fine: PHP {{ number_format($item->fine, 2) }}
                                                </p>
                                            @endif
                                        @else
                                            @if(now()->copy()->startOfDay()->gt($borrow->due_date->copy()->startOfDay()))
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Overdue
                                                </span>
                                                @php
                                                    $daysLate = (int) $borrow->due_date->copy()->startOfDay()->diffInDays(now()->copy()->startOfDay());
                                                    $potentialFine = $daysLate * 10;
                                                @endphp
                                                <p class="text-xs text-red-600 mt-1">
                                                    {{ $daysLate }} day(s) late
                                                </p>
                                                <p class="text-sm font-medium text-red-600">
                                                    Fine: PHP {{ number_format($potentialFine, 2) }}
                                                </p>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Not Returned
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total Fines -->
                    @php
                        $totalFines = $borrow->items->sum('fine');
                    @endphp
                    @if($totalFines > 0)
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium">Total Fines:</span>
                                <span class="text-2xl font-bold text-red-600">PHP {{ number_format($totalFines, 2) }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
