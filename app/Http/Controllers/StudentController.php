<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Homepage
    public function index()
    {
        return view('Auth.lookup');
    }

    // Called when Enter is pressed
    public function check(Request $request)
    {
        $request->validate(['student_number' => 'required|string|max:50']);

        $student = Student::where('student_number', trim($request->student_number))->first();

        if (!$student) {
            return response()->json(['registered' => false]);
        }

        return response()->json([
            'registered' => true,
            'student' => [
                'last_name'      => $student->last_name,
                'first_name'     => $student->first_name,
                'student_number' => $student->student_number,
                'course'         => $student->course,
                'year_level'     => $student->year_level,
                'section'        => $student->section,
                'photo_url'      => $student->photo_url,
            ],
        ]);
    }

    // Register page (your groupmate builds this)
    public function create()
    {
        return view('Auth.StudentRegistration');
    }
}