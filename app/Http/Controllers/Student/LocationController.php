<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        // Notice the updated path below!
        return view('student.familytracker.location', compact('student'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $student = Auth::user()->student;
        
        $student->update([
            'last_lat' => $request->lat,
            'last_lng' => $request->lng,
            'location_updated_at' => now(),
        ]);

        return back()->with('success', 'Location successfully securely transmitted!');
    }
}