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
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

        // ── DOB validation (Required before account creation) ────────────────
        if (empty($registration->date_of_birth)) {
            return back()->with('error', 'Approval cannot be completed because the applicant\'s date of birth is missing or invalid. Please update the application and try again.');
        }

        try {
            $dobCarbon = Carbon::parse((string) $registration->date_of_birth);

            if ($dobCarbon->isFuture() || $dobCarbon->year < 1900) {
                return back()->with('error', 'Approval cannot be completed because the applicant\'s date of birth is invalid. Please update the application and try again.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Approval cannot be completed because the applicant\'s date of birth is missing or invalid. Please update the application and try again.');
        }

        // ── Duplicate User check ──────────────────────────────────────────────
        if (User::where('email', $registration->email)->exists()) {
            return back()->with('error', "Approval cannot be completed because a user account with email '{$registration->email}' already exists.");
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

            // ── Password = DOB in DDMMYYYY format (e.g. 03032003) ─────────────
            $studentPassword = $dobCarbon->format('dmY');
            $dobDisplay      = $dobCarbon->format('d-m-Y');
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

            // Auto-generate roll number if not supplied (students.roll_number is NOT NULL)
            $rollNumber = $registration->roll
                ?: ('STU-' . date('Y') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT));

            // Persist the roll back to registration so the student can see it
            $registration->update(['roll' => $rollNumber]);

            // Promote/copy registration applicant photo to student profile_photo
            $profilePhoto = null;
            if (!empty($registration->photo_path)) {
                if (Storage::disk('local')->exists($registration->photo_path)) {
                    $ext = pathinfo($registration->photo_path, PATHINFO_EXTENSION) ?: 'jpg';
                    $newPath = 'profile-photos/' . Str::uuid() . '.' . $ext;
                    Storage::disk('public')->put($newPath, Storage::disk('local')->get($registration->photo_path));
                    $profilePhoto = $newPath;
                } elseif (Storage::disk('public')->exists($registration->photo_path)) {
                    $profilePhoto = $registration->photo_path;
                }
            }

            $studentProfile = Student::create([
                'user_id'       => $studentUser->id,
                'course_id'     => $courseId,
                'roll_number'   => $rollNumber,
                'phone'         => $registration->phone,
                'profile_photo' => $profilePhoto,
                'parent_name'   => $parentName,
                'blood_group'   => $registration->blood_group,
                'home_address'  => $registration->permanent_address,
            ]);

            DB::table('parent_student')->insert([
                'parent_id'  => $parentUser->id,
                'student_id' => $studentUser->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $registration->update([
                'status'      => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

            DB::commit();

            // ── Send credentials email with safe error handling ───────────────
            try {
                Mail::to($studentUser->email)->send(new StudentCredentialsMail($studentUser, $studentPassword, $registration, $dobDisplay));

                if ($parentUser->wasRecentlyCreated) {
                    Mail::to($parentUser->email)->send(new ParentCredentialsMail($parentUser, $parentPassword, $registration));
                } else {
                    Mail::to($parentUser->email)->send(new ParentCredentialsMail($parentUser, 'Your existing password', $registration));
                }
            } catch (\Exception $mailEx) {
                Log::error('Student approval credentials email failed to send: ' . $mailEx->getMessage());
                return back()->with('warning', "Student application approved and account created, but the credentials email could not be sent. Please inform the student or check mail settings. Error: " . $mailEx->getMessage());
            }

            return back()->with('success', 'Student application approved. Login credentials have been sent to the student\'s registered email address.');

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
