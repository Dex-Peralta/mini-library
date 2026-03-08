<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Process Return - Transaction #{{ $borrow->id }}</h2>
            <a href="{{ route('borrows.show', $borrow->id) }}" class="text-gray-600 hover:text-gray-900">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Student Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-2">Student Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Name</p>
                            <p class="font-medium">{{ $borrow->student->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Student Number</p>
                            <p class="font-medium">{{ $borrow->student->student_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Borrow Date</p>
                            <p class="font-medium">{{ $borrow->borrow_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Due Date</p>
                            <p class="font-medium @if($today->copy()->startOfDay()->gt($borrow->due_date->copy()->startOfDay())) text-red-600 @endif">
                                {{ $borrow->due_date->format('M d, Y') }}
                                @if($today->copy()->startOfDay()->gt($borrow->due_date->copy()->startOfDay()))
                                    ({{ (int) $borrow->due_date->copy()->startOfDay()->diffInDays($today->copy()->startOfDay()) }} days late)
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Return Form -->
            <form method="POST" action="{{ route('borrows.process-return', $borrow->id) }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @csrf
                
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Select Books to Return</h3>
                    
                    <div class="space-y-4">
                        @php
                            $hasUnreturnedItems = false;
                        @endphp
                        @foreach($borrow->items as $item)
                            @if(!$item->returned_at)
                                @php
                                    $hasUnreturnedItems = true;
                                    $daysLate = 0;
                                    $fine = 0;
                                    if($today->copy()->startOfDay()->gt($borrow->due_date->copy()->startOfDay())) {
                                        $daysLate = (int) $borrow->due_date->copy()->startOfDay()->diffInDays($today->copy()->startOfDay());
                                        $fine = $daysLate * $finePerDay;
                                    }
                                @endphp
                                <label class="flex items-start space-x-3 p-4 hover:bg-gray-50 rounded-md cursor-pointer border border-gray-200">
                                    <input type="checkbox" name="items[]" value="{{ $item->id }}" 
                                        class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" 
                                        checked>
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">{{ $item->book->title }}</div>
                                        <div class="text-sm text-gray-500">
                                            By: {{ $item->book->authors->pluck('name')->join(', ') }}
                                        </div>
                                        @if($fine > 0)
                                            <div class="mt-2 text-sm">
                                                <span class="text-red-600 font-medium">
                                                    Overdue by {{ $daysLate }} day(s) - Fine: PHP {{ number_format($fine, 2) }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="mt-2 text-sm">
                                                <span class="text-green-600">
                                                    Returned on time - No fine
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </label>
                            @endif
                        @endforeach

                        @if(!$hasUnreturnedItems)
                            <div class="text-center py-8">
                                <p class="text-gray-500">All books have been returned.</p>
                            </div>
                        @endif
                    </div>

                    @if($hasUnreturnedItems)
                        <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <h4 class="font-medium text-blue-900 mb-2">Return Information</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Fine rate: PHP {{ $finePerDay }} per day per overdue book</li>
                                <li>• You can select specific books to return or return all at once</li>
                                <li>• Inventory will be automatically updated</li>
                            </ul>
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('borrows.show', $borrow->id) }}" class="rounded-md border border-slate-300 px-4 py-2 text-slate-700 hover:bg-slate-50">Cancel</a>
                            <button type="submit" class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700">Process Return</button>
                        </div>
                    @else
                        <div class="flex justify-end mt-6">
                            <a href="{{ route('borrows.show', $borrow->id) }}" class="rounded-md border border-slate-300 px-4 py-2 text-slate-700 hover:bg-slate-50">Back to Transaction</a>
                        </div>
                    @endif
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
