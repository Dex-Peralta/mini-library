<!DOCTYPE html>
<html>
<head>
    <title>Complete Student Profile - Mini Library</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

<!-- Navbar -->
<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-gray-900">Mini Library</a>
            </div>
            <div class="flex items-center space-x-4">
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-gray-900 font-medium transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="max-w-2xl mx-auto px-6 lg:px-8 py-12">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Complete Your Student Profile</h1>
        <p class="text-gray-600 text-lg">Fill in your student information to start borrowing books</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-md p-8">
        <form method="POST" action="{{ route('students.store') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent @error('name') border-red-500 @enderror"
                    placeholder="Enter your full name"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Student Number -->
            <div>
                <label for="student_number" class="block text-sm font-medium text-gray-700 mb-2">Student Number</label>
                <input 
                    type="text" 
                    id="student_number" 
                    name="student_number" 
                    value="{{ old('student_number') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent @error('student_number') border-red-500 @enderror"
                    placeholder="e.g., 2301107739"
                    required
                >
                @error('student_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Course -->
            <div>
                <label for="course" class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                <input 
                    type="text" 
                    id="course" 
                    name="course" 
                    value="{{ old('course') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent @error('course') border-red-500 @enderror"
                    placeholder="e.g., Bachelor of Science in Computer Science"
                    required
                >
                @error('course')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email (Optional) -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email (Optional)</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', Auth::user()->email) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent @error('email') border-red-500 @enderror"
                    placeholder="your.email@example.com"
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone (Optional) -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number (Optional)</label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    value="{{ old('phone') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-transparent @error('phone') border-red-500 @enderror"
                    placeholder="+1 (555) 123-4567"
                >
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Errors -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-red-700 font-medium">Please fix the following errors:</p>
                    <ul class="list-disc list-inside text-red-600 text-sm mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Submit Button -->
            <div class="flex gap-4 pt-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-gray-900 hover:bg-gray-800 text-white font-medium py-3 rounded-lg transition duration-200 shadow-sm"
                >
                    Complete Profile
                </button>
                <a 
                    href="{{ route('dashboard') }}" 
                    class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-900 font-medium py-3 rounded-lg transition duration-200"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <p class="text-blue-700 text-sm">
            <strong>Note:</strong> Once you complete your student profile, you'll be able to check out books from our library collection. Your student number must be unique.
        </p>
    </div>

</div>

</body>
</html>
