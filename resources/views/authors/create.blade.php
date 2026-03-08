<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Author</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('authors.store') }}" class="space-y-4 rounded-xl border border-slate-200 bg-white p-6">
                @csrf

                <div>
                    <x-input-label for="name" value="Author Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('authors.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-slate-700 hover:bg-slate-50">Cancel</a>
                    <button class="rounded-md bg-slate-900 px-4 py-2 text-white hover:bg-slate-700">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
