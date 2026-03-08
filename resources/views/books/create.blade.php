<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Book</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('books.store') }}" class="space-y-4 rounded-xl border border-slate-200 bg-white p-6">
                @csrf

                <div>
                    <x-input-label for="title" value="Title" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" value="Description" />
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="isbn" value="ISBN" />
                        <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full" :value="old('isbn')" />
                        <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="publisher" value="Publisher" />
                        <x-text-input id="publisher" name="publisher" type="text" class="mt-1 block w-full" :value="old('publisher')" />
                        <x-input-error :messages="$errors->get('publisher')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="year_published" value="Year Published" />
                        <x-text-input id="year_published" name="year_published" type="number" min="1000" max="{{ date('Y') + 1 }}" class="mt-1 block w-full" :value="old('year_published')" />
                        <x-input-error :messages="$errors->get('year_published')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="genre" value="Genre" />
                        <x-text-input id="genre" name="genre" type="text" class="mt-1 block w-full" :value="old('genre')" />
                        <x-input-error :messages="$errors->get('genre')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="total_copies" value="Total Copies" />
                        <x-text-input id="total_copies" name="total_copies" type="number" min="0" class="mt-1 block w-full" :value="old('total_copies', 1)" required />
                        <x-input-error :messages="$errors->get('total_copies')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label value="Authors" />
                    <div class="mt-2 grid grid-cols-1 gap-2 rounded-md border border-gray-300 p-3 sm:grid-cols-2">
                        @foreach ($authors as $author)
                            <label class="flex items-center gap-2 rounded px-2 py-1 hover:bg-slate-50">
                                <input
                                    type="checkbox"
                                    name="authors[]"
                                    value="{{ $author->id }}"
                                    class="rounded border-gray-300 text-slate-900 focus:ring-slate-700"
                                    @checked(in_array($author->id, old('authors', [])))
                                >
                                <span class="text-sm text-slate-700">{{ $author->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Select one or more authors.</p>
                    <x-input-error :messages="$errors->get('authors')" class="mt-2" />
                    <x-input-error :messages="$errors->get('authors.*')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('books.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-slate-700 hover:bg-slate-50">Cancel</a>
                    <button class="rounded-md bg-slate-900 px-4 py-2 text-white hover:bg-slate-700">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
