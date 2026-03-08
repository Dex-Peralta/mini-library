<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Student Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(!$student)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-yellow-900 mb-2">Student Profile Not Linked</h3>
                    <p class="text-yellow-800">Your account is logged in, but no student record is linked yet. Contact an admin to link your student profile.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <p class="text-sm text-gray-500">Student Number</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $student->student_number }}</p>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <p class="text-sm text-gray-500">Active Borrowed Books</p>
                        <p class="text-2xl font-bold text-orange-600">{{ $activeItems }}</p>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <p class="text-sm text-gray-500">Total Borrow Transactions</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $borrows->count() }}</p>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">My Borrow Records</h3>
                    </div>
                    <div class="p-6">
                        @if($borrows->isEmpty())
                            <p class="text-gray-500">No borrow records found.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($borrows as $borrow)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex flex-wrap justify-between items-center mb-3">
                                            <p class="text-sm text-gray-700">Borrowed: <span class="font-medium">{{ $borrow->borrow_date->format('M d, Y') }}</span></p>
                                            <p class="text-sm text-gray-700">Due: <span class="font-medium">{{ $borrow->due_date->format('M d, Y') }}</span></p>
                                        </div>
                                        <ul class="space-y-2">
                                            @foreach($borrow->items as $item)
                                                <li class="text-sm text-gray-700 flex justify-between items-center">
                                                    <span>{{ $item->book->title }}</span>
                                                    @if($item->returned_at)
                                                        <span class="text-green-600 font-medium">Returned</span>
                                                    @else
                                                        <span class="text-yellow-600 font-medium">Active</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
