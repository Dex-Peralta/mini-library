<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'student_number' => 'required|string|unique:students',
            'course' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string'
        ]);

        Student::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'student_number' => $validated['student_number'],
            'course' => $validated['course'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null
        ]);

        return redirect('/dashboard')->with('success', 'Student profile created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'student_number' => 'required|string|unique:students,student_number,' . $id,
            'course' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string'
        ]);

        $student->update([
            'name' => $validated['name'],
            'student_number' => $validated['student_number'],
            'course' => $validated['course'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null
        ]);

        return redirect('/dashboard')->with('success', 'Student profile updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Student::destroy($id);
        return redirect('/students');
    }

    /**
     * Get current user's student info (API endpoint)
     */
    public function getStudentInfo()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Not authenticated'
            ], 401);
        }

        $student = Student::where('user_id', Auth::id())->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student record not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $student->id,
                'name' => $student->name,
                'student_number' => $student->student_number,
                'course' => $student->course,
                'year' => $student->course,
                'email' => $student->email,
                'phone' => $student->phone
            ]
        ]);
    }
}