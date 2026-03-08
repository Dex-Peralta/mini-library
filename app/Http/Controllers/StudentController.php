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

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Student created successfully!');
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

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Student::destroy($id);
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }

    /**
     * Get student info by ID (API endpoint)
     */
    public function getStudentInfo($studentId)
    {
        $student = Student::find($studentId);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'student' => $student
        ]);
    }
}