<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmergencySOSMail;
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

    public function panic(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $student = Auth::user()->student;

        $student->update([
            'is_panicking'       => true,
            'panic_lat'          => $request->lat,
            'panic_lng'          => $request->lng,
            'panic_triggered_at' => now(),
            // Also update regular location so map stays current
            'last_lat'           => $request->lat,
            'last_lng'           => $request->lng,
            'location_updated_at'=> now(),
        ]);

        // Send panic email to parents
        foreach ($student->parents as $parent) {
            Mail::to($parent->email)->send(new EmergencySOSMail($student));
        }

        return response()->json(['status' => 'panic_activated']);
    }

    public function cancelPanic()
    {
        $student = Auth::user()->student;

        $student->update([
            'is_panicking'       => false,
            'panic_triggered_at' => null,
        ]);

        return response()->json(['status' => 'panic_cancelled']);
    }
}