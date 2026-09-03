<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacultyRegistration;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Role;
use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\FacultyCredentialsMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class FacultyRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = FacultyRegistration::query();

        $status = $request->input('status', 'all');
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('application_no', 'like', "%{$s}%")
                  ->orWhere('department', 'like', "%{$s}%");
            });
        }

        $registrations = $query->latest()->paginate(15)->withQueryString();
        $pendingCount  = FacultyRegistration::where('status', 'pending')->count();
        $subjects      = Subject::orderBy('name')->get();

        return view('admin.faculty-registrations.index', compact('registrations', 'pendingCount', 'subjects'));
    }

    public function show(FacultyRegistration $facultyRegistration)
    {
        $facultyRegistration->load([
            'qualifications',
            'experiences',
            'documents',
            'approvedBy',
            'rejectedBy',
            'reviewedBy',
        ]);

        $resolvedSubjects = $facultyRegistration->resolvedSubjects();

        return view('admin.faculty-registrations.show', compact('facultyRegistration', 'resolvedSubjects'));
    }

    public function approve(Request $request, $id)
    {
        $registration = FacultyRegistration::findOrFail($id);

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
            'employee_id' => 'nullable|string|max:50|unique:teachers,employee_id',
        ]);

        try {
            DB::beginTransaction();

            $teacherRole = Role::where('name', 'teacher')->firstOrFail();

            // ── Password = DOB in DDMMYYYY format (e.g. 15081995) ─────────────
            $password    = $dobCarbon->format('dmY');
            $dobDisplay  = $dobCarbon->format('d-m-Y');

            $user = User::create([
                'name'     => $registration->full_name ?: $registration->name,
                'email'    => $registration->email,
                'password' => Hash::make($password),
                'role_id'  => $teacherRole->id,
            ]);

            $employeeId = $request->filled('employee_id')
                ? $request->employee_id
                : 'FAC-' . strtoupper(Str::random(6));

            $teacher = Teacher::create([
                'user_id'       => $user->id,
                'employee_id'   => $employeeId,
                'phone'         => $registration->phone,
                'qualification' => $registration->qualification,
                'experience'    => $registration->experience,
            ]);

            // Sync subjects (backward compat — comma-separated string)
            $subjectIds = array_filter(explode(',', $registration->subjects ?? ''));
            if (!empty($subjectIds)) {
                $teacher->subjects()->sync($subjectIds);
            }

            $registration->update([
                'status'      => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

            DB::commit();

            // ── Send credentials email with safe error handling ───────────────
            try {
                $subjectList = $registration->resolvedSubjects()->pluck('name')->implode(', ');
                if (empty($subjectList) && !empty($registration->department)) {
                    $subjectList = $registration->department;
                }

                Mail::to($user->email)->send(new FacultyCredentialsMail([
                    'name'           => $registration->full_name ?: $registration->name,
                    'email'          => $user->email,
                    'employee_id'    => $employeeId,
                    'dob_display'    => $dobDisplay,
                    'password'       => $password,
                    'application_id' => $registration->application_no ?? ('EDF-FAC-' . date('Y') . '-' . str_pad($registration->id, 5, '0', STR_PAD_LEFT)),
                    'department'     => $registration->department ?? 'General',
                    'subjects'       => $subjectList ?: 'Assigned as per schedule',
                    'login_url'      => route('login'),
                ]));
            } catch (\Exception $mailEx) {
                Log::error('Faculty approval credentials email failed to send: ' . $mailEx->getMessage());
                return back()->with('warning', "Faculty application approved and account created, but the credentials email could not be sent. Please inform the faculty member or check mail settings. Error: " . $mailEx->getMessage());
            }

            return back()->with('success', 'Faculty application approved. Login credentials have been sent to the faculty member\'s registered email address.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Approval failed: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $registration = FacultyRegistration::findOrFail($id);

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

        return back()->with('success', 'Faculty registration rejected.');
    }

    public function resend($id)
    {
        $registration = FacultyRegistration::findOrFail($id);

        if ($registration->status !== 'approved') {
            return back()->with('error', 'Only approved registrations can have credentials resent.');
        }

        $user = User::where('email', $registration->email)->first();

        if (!$user) {
            return back()->with('error', 'No user account found for this faculty member.');
        }

        // ── Resend uses DOB-derived password (same rule as initial approval) ────
        if (empty($registration->date_of_birth)) {
            return back()->with('error',
                'Cannot resend credentials: the applicant\'s date of birth is missing. '
                . 'Please update the application record and try again.'
            );
        }

        try {
            $dobCarbon = Carbon::parse((string) $registration->date_of_birth);

            if ($dobCarbon->isFuture() || $dobCarbon->year < 1900) {
                return back()->with('error', 'Cannot resend credentials: the applicant\'s date of birth is invalid.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Cannot resend credentials: the applicant\'s date of birth is invalid.');
        }

        $password   = $dobCarbon->format('dmY');
        $dobDisplay = $dobCarbon->format('d-m-Y');

        // Reset password to the DOB-derived value so it stays consistent
        $user->update(['password' => Hash::make($password)]);

        // Load teacher to retrieve employee_id
        $teacher = $user->teacher;

        $subjectList = $registration->resolvedSubjects()->pluck('name')->implode(', ');
        if (empty($subjectList) && !empty($registration->department)) {
            $subjectList = $registration->department;
        }

        try {
            Mail::to($user->email)->send(new FacultyCredentialsMail([
                'name'           => $user->name,
                'email'          => $user->email,
                'employee_id'    => $teacher?->employee_id ?? 'N/A',
                'dob_display'    => $dobDisplay,
                'password'       => $password,
                'application_id' => $registration->application_no ?? ('EDF-FAC-' . date('Y') . '-' . str_pad($registration->id, 5, '0', STR_PAD_LEFT)),
                'department'     => $registration->department ?? 'General',
                'subjects'       => $subjectList ?: 'Assigned as per schedule',
                'login_url'      => route('login'),
            ]));
        } catch (\Exception $mailEx) {
            Log::error('Faculty credentials resend email failed to send: ' . $mailEx->getMessage());
            return back()->with('warning', "Password reset to date of birth, but the credentials email could not be sent. Error: " . $mailEx->getMessage());
        }

        return back()->with('success', "Credentials resent to {$registration->email}.");
    }
}
