<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Library Admin Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <p class="text-sm text-slate-500">Librarian Accounts</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['users'] }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <p class="text-sm text-slate-500">Students</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['students'] }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <p class="text-sm text-slate-500">Books</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['books'] }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <p class="text-sm text-slate-500">Authors</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['authors'] }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <p class="text-sm text-slate-500">Available Inventory</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['available_books'] }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5">
                    <p class="text-sm text-slate-500">Active Borrowed Books</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['active_borrow_items'] }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 sm:col-span-2">
                    <p class="text-sm text-slate-500">Total Computed Fines</p>
                    <p class="mt-2 text-3xl font-bold text-rose-700">PHP {{ number_format($stats['total_fines'], 2) }}</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
