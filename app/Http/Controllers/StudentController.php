<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Randell updated this portion | October 4, 2026 | 11:01 AM | Added: the 9 course codes the registration form can save
    private const COURSES = [
        'BTLED-HE', 'BSA', 'BSMA', 'BSBA', 'BSECE', 'BSIE', 'BSIT', 'BSP', 'BSED',
    ];

    // Homepage

    // Randell updated this portion | October 4, 2026 | 11:01 AM | Admin interface: renamed index to showLookup
    // Original: public function index()
    public function showLookup()
    {
        return view('Auth.lookup');
    }

    // Called when Enter is pressed

    // Randell updated this portion | October 4, 2026 | 11:01 AM | Admin interface: renamed check to checkStudent
    // Original: public function check(Request $request)
    public function checkStudent(Request $request)
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

    // Randell updated this portion | October 4, 2026 | 11:01 AM | Admin interface: renamed create to showRegisterForm
    // Original: public function create()
    public function showRegisterForm()
    {
        return view('Auth.StudentRegistration');
    }

    // Randell updated this portion | October 4, 2026 | 11:01 AM | Added: saves the student from the admin registration form
    public function registerStudent(Request $request)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'student_number' => 'required|string|max:50|unique:students,student_number',
            'course'         => 'required|in:' . implode(',', self::COURSES),
            'year_level'     => 'required|integer|between:1,5',
            'section'        => 'required|string|max:20',
            'photo'          => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // photo goes to storage/app/public/students (needs php artisan storage:link)
        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $photoUrl = '/storage/' . $request->file('photo')->store('students', 'public');
        }

        $student = Student::create([
            'student_number' => trim($data['student_number']),
            'first_name'     => trim($data['first_name']),
            'last_name'      => trim($data['last_name']),
            'course'         => $data['course'],
            'year_level'     => $data['year_level'],
            'section'        => trim($data['section']),
            'photo_url'      => $photoUrl,
        ]);

        return response()->json(['success' => true, 'student' => $student], 201);
    }
}
