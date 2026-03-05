<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Course;
use App\Mail\StudentWelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Exception;

class StudentController extends Controller
{
    // List all students
    public function index()
    {
        $students = Student::with(['user', 'course'])->latest()->get();
        return view('admin.students.index', compact('students'));
    }

    // Show create form
    public function create()
    {
        $courses = Course::all();
        return view('admin.students.create', compact('courses'));
    }

    // Store student and Send Welcome Email
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6',
            'roll_number' => 'required|string|unique:students,roll_number',
            'course_id'   => 'required|exists:courses,id',
        ]);

        // 2. Create user (role = student)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => 3, // student
        ]);

        // 3. Create student profile
        $student = Student::create([
            'user_id'     => $user->id,
            'course_id'   => $request->course_id,
            'roll_number' => $request->roll_number,
        ]);

        // 4. Prepare Data for Email
        $course = Course::find($request->course_id);
        $emailData = [
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => $request->password, // Sending raw password safely via email
            'roll_number' => $request->roll_number,
            'course_name' => $course->name
        ];

        // 5. Send the Professional Mail with Error Handling
        try {
            Mail::to($request->email)->send(new StudentWelcomeMail($emailData));
            
            return redirect()
                ->route('admin.students.index')
                ->with('success', 'Student added and credentials emailed successfully!');
                
        } catch (Exception $e) {
            // If email fails, the student is still created, but we warn the admin
            return redirect()
                ->route('admin.students.index')
                ->with('warning', 'Student added, but the welcome email failed to send. Please check your mail server settings.');
        }
    }

    // Show edit form
    public function edit(Student $student)
    {
        $courses = Course::all();
        return view('admin.students.edit', compact('student', 'courses'));
    }

    // Update student
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $student->user_id,
            'roll_number' => 'required|string|unique:students,roll_number,' . $student->id,
            'course_id'   => 'required|exists:courses,id',
        ]);

        // Update user info
        $student->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Update student info
        $student->update([
            'roll_number' => $request->roll_number,
            'course_id'   => $request->course_id,
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully!');
    }

    // Delete student
    public function destroy(Student $student)
    {
        // deleting user will auto delete student (FK cascade)
        $student->user->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully!');
    }
}