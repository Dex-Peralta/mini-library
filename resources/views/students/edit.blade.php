<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Student</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('students.update', $student->id) }}" class="space-y-4 rounded-xl border border-slate-200 bg-white p-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="student_number" value="Student Number" />
                    <x-text-input id="student_number" name="student_number" type="text" class="mt-1 block w-full" :value="old('student_number', $student->student_number)" required />
                    <x-input-error :messages="$errors->get('student_number')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="name" value="Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $student->name)" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="college" value="College" />
                    <select id="college" name="college" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-slate-900 focus:ring-slate-900" required>
                        <option value="">Select a college</option>
                        @foreach([
                            'College of Public Administration and Governance',
                            'College of Arts and Sciences',
                            'College of Business',
                            'College of Education',
                            'College of Law',
                            'College of Nursing',
                            'College of Technologies',
                        ] as $college)
                            <option value="{{ $college }}" {{ old('college', $student->college) === $college ? 'selected' : '' }}>{{ $college }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('college')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="course" value="Course" />
                    <x-text-input id="course" name="course" type="text" class="mt-1 block w-full" :value="old('course', $student->course)" required />
                    <x-input-error :messages="$errors->get('course')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $student->email)" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="phone" value="Phone" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $student->phone)" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('students.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-slate-700 hover:bg-slate-50">Cancel</a>
                    <button class="rounded-md bg-slate-900 px-4 py-2 text-white hover:bg-slate-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
