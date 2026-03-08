<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Returns</h2>
            <a href="{{ route('borrows.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                View All Borrows
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

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Search Student</h3>
                    <form method="GET" action="{{ route('returns.manage') }}" class="flex gap-3">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $identifier }}"
                            placeholder="Enter Student Number or Email"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-800"
                        >
                        <button 
                            type="submit"
                            class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-2 rounded-md transition"
                        >
                            Search
                        </button>
                        @if($identifier)
                            <a 
                                href="{{ route('returns.manage') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-6 py-2 rounded-md transition"
                            >
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Results Section -->
            @if($identifier && $student)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Student Info -->
                        <div class="mb-6 pb-4 border-b">
                            <h3 class="text-lg font-semibold mb-2">Student Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-700">Name:</span>
                                    <span class="text-gray-900">{{ $student->name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Student Number:</span>
                                    <span class="text-gray-900">{{ $student->student_number }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Email:</span>
                                    <span class="text-gray-900">{{ $student->email ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Active Borrows -->
                        <h3 class="text-lg font-semibold mb-4">Currently Borrowed Books ({{ $activeItems->count() }})</h3>

                        @if($activeItems->count() > 0)
                            <form id="returnForm" method="POST" action="{{ route('returns.quick') }}">
                                @csrf
                                <div class="overflow-x-auto mb-4">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left">
                                                    <input 
                                                        type="checkbox" 
                                                        id="selectAll"
                                                        class="rounded border-gray-300 text-gray-900 focus:ring-gray-800"
                                                    >
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book Title</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author(s)</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fine</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($activeItems as $item)
                                                @php
                                                    $dueDate = \Carbon\Carbon::parse($item->borrow->due_date);
                                                @endphp
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4">
                                                        <input 
                                                            type="checkbox" 
                                                            name="items[]" 
                                                            value="{{ $item->id }}"
                                                            class="item-checkbox rounded border-gray-300 text-gray-900 focus:ring-gray-800"
                                                        >
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $item->book->title }}</div>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm text-gray-700">
                                                            {{ $item->book->authors->pluck('name')->join(', ') }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-700">
                                                        {{ \Carbon\Carbon::parse($item->borrow->borrow_date)->format('M d, Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-700">
                                                        {{ $dueDate->format('M d, Y') }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        @if($item->is_overdue)
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                Overdue ({{ $item->days_late }} days)
                                                            </span>
                                                        @else
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                                Active
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 text-sm">
                                                        @if($item->fine_preview > 0)
                                                            <span class="font-semibold text-red-600">PHP {{ number_format($item->fine_preview, 2) }}</span>
                                                        @else
                                                            <span class="text-gray-500">PHP 0.00</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-between items-center pt-4 border-t">
                                    <div class="text-sm text-gray-600">
                                        <span id="selectedCount">0</span> item(s) selected
                                    </div>
                                    <div class="flex gap-3">
                                        <button 
                                            type="button"
                                            id="returnSelectedBtn"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition disabled:opacity-50 disabled:cursor-not-allowed"
                                            disabled
                                        >
                                            Return Selected
                                        </button>
                                        <button 
                                            type="button"
                                            id="returnAllBtn"
                                            class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-2 rounded-md transition"
                                        >
                                            Return All
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>This student has no active borrowed books.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @elseif($identifier && !$student)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        <p>No student found with identifier: <strong>{{ $identifier }}</strong></p>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        <p>Enter a student number or email to view their borrowed books.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const returnSelectedBtn = document.getElementById('returnSelectedBtn');
            const returnAllBtn = document.getElementById('returnAllBtn');
            const returnForm = document.getElementById('returnForm');
            const selectedCountSpan = document.getElementById('selectedCount');

            function updateSelectedCount() {
                const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
                selectedCountSpan.textContent = checkedCount;
                returnSelectedBtn.disabled = checkedCount === 0;
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    itemCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSelectedCount();
                });
            }

            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedCount();
                    
                    // Update select all checkbox
                    const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
                    const someChecked = Array.from(itemCheckboxes).some(cb => cb.checked);
                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked = allChecked;
                        selectAllCheckbox.indeterminate = someChecked && !allChecked;
                    }
                });
            });

            if (returnSelectedBtn) {
                returnSelectedBtn.addEventListener('click', function() {
                    const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
                    if (checkedCount === 0) {
                        alert('Please select at least one book to return.');
                        return;
                    }

                    if (confirm(`Are you sure you want to return ${checkedCount} book(s)?`)) {
                        returnForm.submit();
                    }
                });
            }

            if (returnAllBtn) {
                returnAllBtn.addEventListener('click', function() {
                    itemCheckboxes.forEach(checkbox => {
                        checkbox.checked = true;
                    });
                    
                    const totalCount = itemCheckboxes.length;
                    if (confirm(`Are you sure you want to return all ${totalCount} book(s)?`)) {
                        returnForm.submit();
                    }
                });
            }
        });
    </script>
</x-app-layout>
