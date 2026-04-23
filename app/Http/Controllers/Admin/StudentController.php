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
use Illuminate\Support\Str; 
use Exception;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index(Request $request)
    {
        $query = Student::with(['user', 'course'])->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('roll_number', 'like', "%{$search}%");
        }

        $students = $query->get();
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.students.create', compact('courses'));
    }

    /**
     * Store a newly created student in storage with auto-generated credentials.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'roll_number' => 'required|string|unique:students,roll_number',
            'course_id'   => 'required|exists:courses,id',
        ]);

        // 2. Auto-Generate a secure randomized password
        $generatedPassword = Str::random(10);

        // 3. Create the User (Account Level)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($generatedPassword), // Securely Hashed
            'role_id'  => 3, // student role
        ]);

        // 4. Create the Student Profile (Academic Level)
        $student = Student::create([
            'user_id'     => $user->id,
            'course_id'   => $request->course_id,
            'roll_number' => $request->roll_number,
        ]);

        // 5. Prepare Data for the Welcome Email
        $course = Course::find($request->course_id);
        $emailData = [
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => $generatedPassword, // Sending raw password for first-time access
            'roll_number' => $request->roll_number,
            'course_name' => $course->name
        ];

        // 6. Queue the Welcome Email (Background Processing)
        try {
            // Using ->queue() ensures the Admin doesn't wait for the mail server to respond
            Mail::to($request->email)->queue(new StudentWelcomeMail($emailData));
            
            return redirect()
                ->route('admin.students.index')
                ->with('success', '✔ Student created successfully! Credentials have been queued for delivery.');
                
        } catch (Exception $e) {
            // Log the error if necessary and warn the admin
            return redirect()
                ->route('admin.students.index')
                ->with('warning', 'Student created, but the email delivery failed to queue. Please check mail logs.');
        }
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $courses = Course::all();
        return view('admin.students.edit', compact('student', 'courses'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $student->user_id,
            'roll_number' => 'required|string|unique:students,roll_number,' . $student->id,
            'course_id'   => 'required|exists:courses,id',
            'status'      => 'required|in:active,dropped,completed',
        ]);

        // Update User Model
        $student->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Update Student Model
        $student->update([
            'roll_number' => $request->roll_number,
            'course_id'   => $request->course_id,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        // Deleting the user will trigger cascade deletion of the student record
        $student->user->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully!');
    }
}