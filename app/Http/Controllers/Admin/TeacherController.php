<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6',
            'employee_id' => 'required|string|unique:teachers,employee_id',
            'subjects'    => 'required|array|min:1',
            'subjects.*'  => 'exists:subjects,id',
        ]);

        // 1️⃣ Create user (role = teacher)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => 2, // teacher
        ]);

        // 2️⃣ Create teacher profile
        $teacher = Teacher::create([
            'user_id'     => $user->id,
            'employee_id' => $request->employee_id,
        ]);

        // 3️⃣ Assign subjects
        $teacher->subjects()->sync($request->subjects);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher added successfully!');
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
