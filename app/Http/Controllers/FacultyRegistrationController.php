<?php

namespace App\Http\Controllers;

use App\Models\FacultyRegistration;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class FacultyRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|string|max:20',
            'subjects'      => 'required|array|min:1',
            'subjects.*'    => 'exists:subjects,id',
            'qualification' => 'required|string|max:255',
            'experience'    => 'nullable|string|max:255',
            'department'    => 'nullable|string|max:255',
        ]);

        // Prevent duplicate registrations
        $existingReg = FacultyRegistration::where('email', $validated['email'])
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingReg) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'An application with this email already exists. Please contact admin if you need assistance.']);
        }

        // Also check if already a user
        if (User::where('email', $validated['email'])->exists()) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'An account with this email already exists. Please login instead.']);
        }

        FacultyRegistration::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'phone'         => $validated['phone'],
            'subjects'      => implode(',', $validated['subjects']),
            'qualification' => $validated['qualification'],
            'experience'    => $validated['experience'] ?? null,
            'department'    => $validated['department'] ?? null,
            'status'        => 'pending',
        ]);

        return redirect('/register/teacher')
            ->with('success', 'Your faculty application has been submitted successfully! You will receive login credentials via email upon approval.');
    }
}
