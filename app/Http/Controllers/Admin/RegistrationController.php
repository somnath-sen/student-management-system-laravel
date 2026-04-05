<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentRegistration;
use App\Models\User;
use App\Models\Student;
use App\Models\Role;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentCredentialsMail;
use App\Mail\ParentCredentialsMail;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentRegistration::query();
        
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $registrations = $query->latest()->paginate(10);
        return view('admin.registrations.index', compact('registrations'));
    }

    public function approve(Request $request, $id)
    {
        $registration = StudentRegistration::findOrFail($id);
        
        if ($registration->status !== 'pending') {
            return back()->with('error', 'Only pending registrations can be approved.');
        }

        try {
            DB::beginTransaction();

            if ($request->has('roll')) {
                $registration->roll = $request->roll;
                $registration->save();
            }

            $studentRole = Role::where('name', 'student')->firstOrFail();
            $parentRole = Role::where('name', 'parent')->firstOrFail();
            
            $course = Course::where('name', $registration->course)->first();
            if (!$course) {
                // Attempt to match common acronyms to database values
                if (stripos($registration->course, 'MBA') !== false || stripos($registration->course, 'BBA') !== false) {
                    $course = Course::where('name', 'like', '%Business%')->first();
                } elseif (stripos($registration->course, 'CS') !== false || stripos($registration->course, 'Computer') !== false) {
                    $course = Course::where('name', 'like', '%Computer%')->first();
                }
                
                // Fallback to first available course if still not found
                if (!$course) {
                    $course = Course::first();
                }
            }
            $courseId = $course ? $course->id : null;

            $studentPassword = Str::random(10);
            $parentPassword = Str::random(10);

            // Create Student User
            $studentUser = User::create([
                'name' => $registration->name,
                'email' => $registration->email,
                'password' => Hash::make($studentPassword),
                'role_id' => $studentRole->id,
            ]);

            // Create Parent User (use parent email as unique identifier or check if exists)
            $parentUser = User::firstOrCreate(
                ['email' => $registration->parent_email],
                [
                    'name' => $registration->parent_name,
                    'password' => Hash::make($parentPassword),
                    'role_id' => $parentRole->id,
                ]
            );

            // Create Student Profile
            $studentProfile = Student::create([
                'user_id' => $studentUser->id,
                'course_id' => $courseId,
                'roll_number' => $registration->roll,
                'parent_name' => $registration->parent_name,
            ]);

            // Link Parent and Student
            DB::table('parent_student')->insert([
                'parent_id' => $parentUser->id,
                'student_id' => $studentProfile->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $registration->update(['status' => 'approved']);

            DB::commit();

            // Send Emails
            Mail::to($studentUser->email)->send(new StudentCredentialsMail($studentUser, $studentPassword, $registration));
            
            // Only send parent email if parent was newly created or password was regenerated
            if ($parentUser->wasRecentlyCreated) {
                Mail::to($parentUser->email)->send(new ParentCredentialsMail($parentUser, $parentPassword, $registration));
            } else {
                // You could send a different email logic here, but keeping it simple as requested
                Mail::to($parentUser->email)->send(new ParentCredentialsMail($parentUser, 'Your existing password', $registration));
            }

            return back()->with('success', 'Registration approved and accounts created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Approval failed: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $registration = StudentRegistration::findOrFail($id);
        
        $request->validate([
            'reason' => 'nullable|string|max:1000'
        ]);

        $registration->update([
            'status' => 'rejected',
            'reject_reason' => $request->reason
        ]);

        return back()->with('success', 'Registration rejected.');
    }
}
