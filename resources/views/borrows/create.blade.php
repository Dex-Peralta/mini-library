<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Borrow Transaction</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('borrows.store') }}" class="space-y-6 rounded-xl border border-slate-200 bg-white p-6">
                @csrf

                <div>
                    <x-input-label for="student_id" value="Student" />
                    <select id="student_id" name="student_id" class="mt-1 block w-full rounded-md border-gray-300" required>
                        <option value="">Select a student</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                {{ $student->name }} ({{ $student->student_number }})
                            </option>
                        @endforeach
                    </select>
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
                    <div class="mt-2 max-h-96 overflow-y-auto border border-gray-300 rounded-md p-4 space-y-2">
                        @if($books->count() > 0)
                            @foreach ($books as $book)
                                <label class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-md cursor-pointer">
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
                    <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-white hover:bg-slate-700">Create Borrow</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
