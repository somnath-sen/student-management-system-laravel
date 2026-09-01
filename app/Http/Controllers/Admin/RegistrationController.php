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
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentRegistration::query()->with(['course']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('application_no', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $registrations = $query->latest()->paginate(15)->withQueryString();
        $courses        = Course::orderBy('name')->get();
        $pendingCount   = StudentRegistration::where('status', 'pending')->count();

        return view('admin.registrations.index', compact('registrations', 'courses', 'pendingCount'));
    }

    public function show(StudentRegistration $registration)
    {
        $registration->load([
            'course',
            'guardians',
            'documents',
            'approvedBy',
            'rejectedBy',
            'reviewedBy',
        ]);

        return view('admin.registrations.show', compact('registration'));
    }

    public function approve(Request $request, $id)
    {
        $registration = StudentRegistration::with(['course'])->findOrFail($id);

        if ($registration->status !== 'pending') {
            return back()->with('error', 'Only pending registrations can be approved.');
        }

        $request->validate([
            'roll' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();

            if ($request->filled('roll')) {
                $registration->roll = $request->roll;
                $registration->save();
            }

            $studentRole = Role::where('name', 'student')->firstOrFail();
            $parentRole  = Role::where('name', 'parent')->firstOrFail();

            // Prefer course_id FK, fall back to string matching (BC)
            if ($registration->course_id) {
                $course = Course::find($registration->course_id);
            } else {
                $course = Course::where('name', $registration->course)->first();
                if (!$course) {
                    if (stripos($registration->course, 'MBA') !== false || stripos($registration->course, 'BBA') !== false) {
                        $course = Course::where('name', 'like', '%Business%')->first();
                    } elseif (stripos($registration->course, 'CS') !== false || stripos($registration->course, 'Computer') !== false) {
                        $course = Course::where('name', 'like', '%Computer%')->first();
                    }
                    if (!$course) {
                        $course = Course::first();
                    }
                }
            }
            $courseId = $course?->id;

            $studentPassword = Str::random(10);
            $parentPassword  = Str::random(10);

            $studentUser = User::create([
                'name'     => $registration->full_name ?: $registration->name,
                'email'    => $registration->email,
                'password' => Hash::make($studentPassword),
                'role_id'  => $studentRole->id,
            ]);

            $parentEmail = $registration->parent_email
                ?: ($registration->primaryGuardian?->email);

            $parentName = $registration->parent_name
                ?: ($registration->primaryGuardian?->full_name ?? 'Parent');

            $parentUser = User::firstOrCreate(
                ['email' => $parentEmail],
                [
                    'name'     => $parentName,
                    'password' => Hash::make($parentPassword),
                    'role_id'  => $parentRole->id,
                ]
            );

            $studentProfile = Student::create([
                'user_id'      => $studentUser->id,
                'course_id'    => $courseId,
                'roll_number'  => $registration->roll,
                'phone'        => $registration->phone,
                'parent_name'  => $parentName,
                'blood_group'  => $registration->blood_group,
                'home_address' => $registration->permanent_address,
            ]);

            DB::table('parent_student')->insert([
                'parent_id'  => $parentUser->id,
                'student_id' => $studentProfile->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $registration->update([
                'status'      => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

            DB::commit();

            Mail::to($studentUser->email)->send(new StudentCredentialsMail($studentUser, $studentPassword, $registration));

            if ($parentUser->wasRecentlyCreated) {
                Mail::to($parentUser->email)->send(new ParentCredentialsMail($parentUser, $parentPassword, $registration));
            } else {
                Mail::to($parentUser->email)->send(new ParentCredentialsMail($parentUser, 'Your existing password', $registration));
            }

            return back()->with('success', "✅ Application approved! Accounts created for {$registration->full_name}. Credentials sent.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Approval failed: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $registration = StudentRegistration::findOrFail($id);

        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        if ($registration->status !== 'pending') {
            return back()->with('error', 'Only pending registrations can be rejected.');
        }

        $registration->update([
            'status'        => 'rejected',
            'reject_reason' => $request->reason,
            'rejected_at'   => now(),
            'rejected_by'   => Auth::id(),
        ]);

        return back()->with('success', 'Registration rejected successfully.');
    }
}
