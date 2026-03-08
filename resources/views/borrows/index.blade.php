<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Borrow Transactions</h2>
            <a href="{{ route('borrows.create') }}" class="bg-gray-900 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                New Borrow
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    @if($borrows->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Books</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($borrows as $borrow)
                                        @php
                                            $totalItems = $borrow->items->count();
                                            $returnedItems = $borrow->items->where('returned_at', '!=', null)->count();
                                            $overdueItems = $borrow->items->filter(function($item) use ($borrow) {
                                                return !$item->returned_at && now()->greaterThan($borrow->due_date);
                                            })->count();
                                            
                                            if ($returnedItems == $totalItems) {
                                                $status = 'Returned';
                                                $statusClass = 'bg-green-100 text-green-800';
                                            } elseif ($returnedItems > 0) {
                                                $status = 'Partially Returned';
                                                $statusClass = 'bg-blue-100 text-blue-800';
                                            } elseif ($overdueItems > 0) {
                                                $status = 'Overdue';
                                                $statusClass = 'bg-red-100 text-red-800';
                                            } else {
                                                $status = 'Borrowed';
                                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                            }
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $borrow->id }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <div>{{ $borrow->student->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $borrow->student->student_number }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $totalItems }} book(s)
                                                @if($returnedItems > 0)
                                                    <br><span class="text-xs">({{ $returnedItems }} returned)</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $borrow->borrow_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $borrow->due_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                    {{ $status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('borrows.show', $borrow->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                                @if($returnedItems < $totalItems)
                                                    <a href="{{ route('borrows.return', $borrow->id) }}" class="text-green-600 hover:text-green-900">Return</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No transactions</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new borrow transaction.</p>
                            <div class="mt-6">
                                <a href="{{ route('borrows.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-900 hover:bg-gray-700">
                                    New Borrow
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
