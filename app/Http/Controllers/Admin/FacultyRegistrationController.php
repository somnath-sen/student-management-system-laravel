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

        $request->validate([
            'employee_id' => 'nullable|string|max:50|unique:teachers,employee_id',
        ]);

        try {
            DB::beginTransaction();

            $teacherRole = Role::where('name', 'teacher')->firstOrFail();

            $password = Str::random(10);

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

            Mail::to($user->email)->send(new FacultyCredentialsMail($user, $password));

            return back()->with('success', "✅ Application approved! Faculty account created for {$registration->full_name}. Credentials sent by email.");

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
}
