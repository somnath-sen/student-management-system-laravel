<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use App\Mail\TeacherWelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str; 
use Exception;

class TeacherController extends Controller
{
    // List teachers
    public function index()
    {
        $teachers = Teacher::with(['user', 'subjects'])->latest()->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    // Show create form
    public function create()
    {
        $subjects = Subject::all();
        return view('admin.teachers.create', compact('subjects'));
    }

    // Store teacher
    public function store(Request $request)
    {
        // 1. Validation (No password required from Admin, but MUST require subjects)
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'employee_id' => 'required|string|unique:teachers,employee_id',
            'subjects'    => 'required|array|min:1',
            'subjects.*'  => 'exists:subjects,id',
        ]);

        // 2. Auto-Generate a secure randomized password
        $generatedPassword = Str::random(10);

        // 3. Create the User (Role 2 is typically Teacher)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($generatedPassword),
            'role_id'  => 2, // teacher role
        ]);

        // 4. Create the Teacher Profile
        $teacher = Teacher::create([
            'user_id'     => $user->id,
            'employee_id' => $request->employee_id,
        ]);

        // 5. Assign subjects to the teacher using the Pivot Table
        $teacher->subjects()->sync($request->subjects);

        // 6. Prepare Data for the Welcome Email
        $emailData = [
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => $generatedPassword, // Sending raw password
            'employee_id' => $request->employee_id,
        ];

        // 7. Queue the Welcome Email
        try {
            Mail::to($request->email)->queue(new TeacherWelcomeMail($emailData));
            
            return redirect()
                ->route('admin.teachers.index')
                ->with('success', '✔ Teacher created successfully! Credentials have been queued for delivery.');
                
        } catch (Exception $e) {
            return redirect()
                ->route('admin.teachers.index')
                ->with('warning', 'Teacher created, but the email delivery failed to queue. Please check mail settings.');
        }
    }

    // Show edit form
    public function edit(Teacher $teacher)
    {
        $subjects = Subject::all();
        return view('admin.teachers.edit', compact('teacher', 'subjects'));
    }

    // Update teacher
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $teacher->user_id,
            'employee_id' => 'required|string|unique:teachers,employee_id,' . $teacher->id,
            'subjects'    => 'required|array|min:1',
        ]);

        // Update user info
        $teacher->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Update teacher info
        $teacher->update([
            'employee_id' => $request->employee_id,
        ]);

        // Sync subjects
        $teacher->subjects()->sync($request->subjects);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher updated successfully!');
    }

    // Delete teacher
    public function destroy(Teacher $teacher)
    {
        // Deleting user will cascade delete teacher + pivot
        $teacher->user->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher deleted successfully!');
    }
}