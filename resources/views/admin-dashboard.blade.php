<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Students Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Students</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['students'] }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Authors Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Authors</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['authors'] }}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Books Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Books</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['books'] }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $stats['total_copies'] }} total copies</p>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-full">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Borrows Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Active Borrows</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['active_borrows'] }}</p>
                                @if($stats['overdue_items'] > 0)
                                    <p class="text-xs text-red-600 mt-1">{{ $stats['overdue_items'] }} overdue</p>
                                @endif
                            </div>
                            <div class="p-3 bg-orange-100 rounded-full">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                        
                        <a href="{{ route('students.index') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition">
                            <svg class="w-10 h-10 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Students</span>
                        </a>

                        <a href="{{ route('authors.index') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition">
                            <svg class="w-10 h-10 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Authors</span>
                        </a>

                        <a href="{{ route('books.index') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition">
                            <svg class="w-10 h-10 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Books</span>
                        </a>

                        <a href="{{ route('borrows.create') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-orange-500 hover:bg-orange-50 transition">
                            <svg class="w-10 h-10 text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">New Borrow</span>
                        </a>

                        <a href="{{ route('returns.manage') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-red-500 hover:bg-red-50 transition">
                            <svg class="w-10 h-10 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Manage Returns</span>
                        </a>

                        <a href="{{ route('borrows.index') }}" class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition">
                            <svg class="w-10 h-10 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Transactions</span>
                        </a>

                    </div>
                </div>
            </div>

            <!-- Inventory Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Inventory Status</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_copies'] }}</p>
                            <p class="text-sm text-gray-600">Total Copies</p>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <p class="text-2xl font-bold text-green-600">{{ $stats['available_copies'] }}</p>
                            <p class="text-sm text-gray-600">Available</p>
                        </div>
                        <div class="text-center p-4 bg-orange-50 rounded-lg">
                            <p class="text-2xl font-bold text-orange-600">{{ $stats['borrowed_books'] }}</p>
                            <p class="text-sm text-gray-600">On Loan</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
