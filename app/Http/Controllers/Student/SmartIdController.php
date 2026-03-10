<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmartIdController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        return view('student.smart-id.index', compact('student'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'parent_name' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:20',
            'blood_group' => 'required|string|max:5',
            'home_address' => 'required|string',
        ]);

        $student = Auth::user()->student;
        
        $student->update([
            'parent_name' => $request->parent_name,
            'emergency_phone' => $request->emergency_phone,
            'blood_group' => $request->blood_group,
            'home_address' => $request->home_address,
        ]);

        return back()->with('success', 'Information updated! Your Smart ID Card is active.');
    }
}