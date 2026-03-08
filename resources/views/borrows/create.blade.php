<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Reservation</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('borrows.store') }}" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6">
                @csrf

                <div>
                    <x-input-label for="student_id" value="Student" />
                    <input type="hidden" id="student_id" name="student_id" value="{{ old('student_id') }}" required>
                    @php
                        $selectedStudent = old('student_id')
                            ? $students->firstWhere('id', (int) old('student_id'))
                            : null;
                        $selectedStudentLabel = $selectedStudent
                            ? ($selectedStudent->name . ' (' . $selectedStudent->student_number . ') - ' . ($selectedStudent->college ?? 'N/A') . ' / ' . $selectedStudent->course)
                            : '';
                    @endphp
                    <input
                        id="student_lookup"
                        type="text"
                        list="student-options"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-slate-900 focus:ring-slate-900"
                        placeholder="Select or type student name, student number, college, or course"
                        value="{{ $selectedStudentLabel }}"
                        autocomplete="off"
                    >
                    <datalist id="student-options">
                        @foreach ($students as $student)
                            <option
                                value="{{ $student->name }} ({{ $student->student_number }}) - {{ $student->college ?? 'N/A' }} / {{ $student->course }}"
                                data-id="{{ $student->id }}"
                            ></option>
                        @endforeach
                    </datalist>
                    <p id="student_lookup_help" class="mt-1 text-xs text-slate-500">Type to search, then pick a student from suggestions.</p>
                    <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="borrow_date" value="Borrow Date" />
                        <x-text-input id="borrow_date" name="borrow_date" type="date" class="mt-1 block w-full" :value="old('borrow_date', date('Y-m-d'))" required />
                        <x-input-error :messages="$errors->get('borrow_date')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="due_date" value="Due Date" />
                        <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full" :value="old('due_date', date('Y-m-d', strtotime('+7 days')))" required />
                        <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="books" value="Select Books" />
                    <x-text-input
                        id="book_search"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Search books by title, author, or ISBN"
                    />
                    <div class="mt-2 max-h-96 overflow-y-auto border border-gray-300 rounded-md p-4 space-y-2">
                        @if($books->count() > 0)
                            @foreach ($books as $book)
                                <label class="borrow-book-item flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-md cursor-pointer" data-search="{{ strtolower($book->title . ' ' . $book->authors->pluck('name')->join(' ') . ' ' . ($book->isbn ?? '')) }}">
                                    <input type="checkbox" name="books[]" value="{{ $book->id }}" 
                                        class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" 
                                        @checked(in_array($book->id, old('books', [])))>
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">{{ $book->title }}</div>
                                        <div class="text-sm text-gray-500">
                                            By: {{ $book->authors->pluck('name')->join(', ') }}
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            Available: {{ $book->available_copies }} / {{ $book->total_copies }}
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                            <p id="no_books_match" class="hidden text-sm text-gray-500 px-1 py-2">No books match your search.</p>
                        @else
                            <p class="text-sm text-gray-500">No books available for borrowing.</p>
                        @endif
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Select one or more books to borrow.</p>
                    <x-input-error :messages="$errors->get('books')" class="mt-2" />
                    <x-input-error :messages="$errors->get('books.*')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('borrows.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-slate-700 hover:bg-slate-50">Cancel</a>
                    <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-white hover:bg-slate-700">Create Reservation</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const studentLookup = document.getElementById('student_lookup');
            const studentIdInput = document.getElementById('student_id');
            const studentLookupHelp = document.getElementById('student_lookup_help');
            const studentMap = {};

            @foreach ($students as $student)
                studentMap["{{ strtolower($student->name . ' (' . $student->student_number . ') - ' . ($student->college ?? 'N/A') . ' / ' . $student->course) }}"] = {{ $student->id }};
            @endforeach

            const resolveStudentSelection = function () {
                if (!studentLookup || !studentIdInput) {
                    return;
                }

                const typedValue = studentLookup.value.trim().toLowerCase();
                const matchedId = studentMap[typedValue] ?? '';
                studentIdInput.value = matchedId;

                if (studentLookupHelp) {
                    if (typedValue === '' || matchedId !== '') {
                        studentLookupHelp.textContent = 'Type to search, then pick a student from suggestions.';
                        studentLookupHelp.classList.remove('text-red-600');
                        studentLookupHelp.classList.add('text-slate-500');
                    } else {
                        studentLookupHelp.textContent = 'Please choose a student from the suggestion list.';
                        studentLookupHelp.classList.remove('text-slate-500');
                        studentLookupHelp.classList.add('text-red-600');
                    }
                }
            };

            if (studentLookup) {
                studentLookup.addEventListener('input', resolveStudentSelection);
                studentLookup.addEventListener('change', resolveStudentSelection);
                resolveStudentSelection();
            }

            const bookSearch = document.getElementById('book_search');
            const bookItems = Array.from(document.querySelectorAll('.borrow-book-item'));
            const noBooksMatch = document.getElementById('no_books_match');

            if (bookSearch && bookItems.length > 0) {
                bookSearch.addEventListener('input', function () {
                    const keyword = this.value.trim().toLowerCase();
                    let visibleCount = 0;

                    bookItems.forEach((item) => {
                        const haystack = item.dataset.search || '';
                        const matches = haystack.includes(keyword);
                        item.classList.toggle('hidden', !matches);
                        if (matches) {
                            visibleCount++;
                        }
                    });

                    if (noBooksMatch) {
                        noBooksMatch.classList.toggle('hidden', visibleCount > 0);
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
