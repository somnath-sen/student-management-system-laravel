<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FacultyCredentialsMail;
use App\Models\FacultyRegistration;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FacultyRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = FacultyRegistration::query();

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()->paginate(10)->withQueryString();
        $subjects = Subject::all()->keyBy('id');
        $pendingCount = FacultyRegistration::where('status', 'pending')->count();

        return view('admin.faculty-registrations.index', compact('registrations', 'subjects', 'pendingCount'));
    }

    public function approve(Request $request, $id)
    {
        $registration = FacultyRegistration::findOrFail($id);

        if ($registration->status !== 'pending') {
            return back()->with('error', 'Only pending registrations can be approved.');
        }

        try {
            DB::beginTransaction();

            $teacherRole = Role::where('name', 'teacher')->firstOrFail();

            // Use admin-provided Employee ID or auto-generate one
            $customId = $request->filled('employee_id')
                ? 'FAC-' . strtoupper(trim($request->employee_id))
                : null;

            if ($customId) {
                // Check uniqueness of custom ID
                if (Teacher::where('employee_id', $customId)->exists()) {
                    return back()->with('error', "Employee ID \"{$customId}\" is already in use. Please choose a different one.");
                }
                $employeeId = $customId;
            } else {
                // Auto-generate unique ID
                $employeeId = 'FAC-' . strtoupper(Str::random(6));
                while (Teacher::where('employee_id', $employeeId)->exists()) {
                    $employeeId = 'FAC-' . strtoupper(Str::random(6));
                }
            }

            // Generate a secure random password
            $generatedPassword = Str::random(12);

            // Create User
            $user = User::create([
                'name'     => $registration->name,
                'email'    => $registration->email,
                'password' => Hash::make($generatedPassword),
                'role_id'  => $teacherRole->id,
            ]);

            // Create Teacher profile
            $teacher = Teacher::create([
                'user_id'       => $user->id,
                'employee_id'   => $employeeId,
                'phone'         => $registration->phone,
                'qualification' => $registration->qualification,
                'experience'    => $registration->experience,
            ]);

            // Sync subjects from registration
            $subjectIds = array_filter(explode(',', $registration->subjects));
            if (!empty($subjectIds)) {
                $teacher->subjects()->sync($subjectIds);
            }

            // Mark as approved
            $registration->update([
                'status'      => 'approved',
                'approved_at' => now(),
            ]);

            DB::commit();

            // Send credentials email
            try {
                Mail::to($registration->email)->send(new FacultyCredentialsMail([
                    'name'        => $registration->name,
                    'email'       => $registration->email,
                    'password'    => $generatedPassword,
                    'employee_id' => $employeeId,
                    'login_url'   => url('/login'),
                ]));
            } catch (\Exception $mailEx) {
                // Don't fail the whole approval if mail fails
                return back()->with('warning', 'Faculty approved successfully, but the credentials email could not be sent. Please resend manually.');
            }

            return back()->with('success', "✅ Faculty approved! Account created for {$registration->name}. Credentials sent to {$registration->email}.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Approval failed: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $registration = FacultyRegistration::findOrFail($id);

        $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);

        if ($registration->status !== 'pending') {
            return back()->with('error', 'Only pending registrations can be rejected.');
        }

        $registration->update([
            'status'        => 'rejected',
            'reject_reason' => $request->reason,
        ]);

        return back()->with('success', 'Registration has been rejected.');
    }

    public function resend($id)
    {
        $registration = FacultyRegistration::findOrFail($id);

        if ($registration->status !== 'approved') {
            return back()->with('error', 'Can only resend credentials for approved faculty.');
        }

        // Find the user account
        $user = User::where('email', $registration->email)->first();
        if (!$user) {
            return back()->with('error', 'No user account found for this registration.');
        }

        // Generate a new password and update
        $newPassword = Str::random(12);
        $user->update(['password' => Hash::make($newPassword)]);

        $teacher = Teacher::where('user_id', $user->id)->first();
        $employeeId = $teacher ? $teacher->employee_id : 'N/A';

        try {
            Mail::to($registration->email)->send(new FacultyCredentialsMail([
                'name'        => $registration->name,
                'email'       => $registration->email,
                'password'    => $newPassword,
                'employee_id' => $employeeId,
                'login_url'   => url('/login'),
            ]));
            return back()->with('success', "Credentials re-sent to {$registration->email} with a new password.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}
