<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

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
            Student::create([
                'name' => $request->name,
                'student_number' => $request->student_number,
                'course' => $request->course
            ]);

            return redirect('/students');
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

    $student->update([
        'name' => $request->name,
        'student_number' => $request->student_number,
        'course' => $request->course
    ]);

    return redirect('/students');
}

    /**
     * Remove the specified resource from storage.
     */
        public function destroy($id)
        {
            Student::destroy($id);
            return redirect('/students');
        }
}
