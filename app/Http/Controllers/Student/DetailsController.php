<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Student;
use App\Models\StudentRegistration;

class DetailsController extends Controller
{
    /**
     * Display the enhanced student profile.
     */
    public function index()
    {
        $user = Auth::user()->load(['gamificationStat', 'studentRegistration']);
        $student = $user->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $course  = $student->course;
        $subjects = $course ? $course->subjects : collect();
        $gamification = $user->gamificationStat;

        // Retrieve actual registration record if available
        $registration = $user->studentRegistration 
            ?? StudentRegistration::where('email', $user->email)->first();

        // Calculate real profile completion percentage based on active fields
        $fields = [
            'name'         => !empty($user->name),
            'email'        => !empty($user->email),
            'roll'         => !empty($student->roll_number),
            'course'       => !empty($student->course_id),
            'photo'        => !empty($student->profile_photo_url),
            'phone'        => !empty($student->phone),
            'blood_group'  => !empty($student->blood_group),
            'emergency'    => !empty($student->emergency_phone) || !empty($student->parent_name),
            'address'      => !empty($student->home_address),
        ];

        $completedCount = count(array_filter($fields));
        $profileCompletion = round(($completedCount / count($fields)) * 100);

        // Verification URL for Smart Campus ID
        $verifyUrl = route('verify.student', $student->id);

        return view('student.details', [
            'user'              => $user,
            'student'           => $student,
            'course'            => $course,
            'subjects'          => $subjects,
            'gamification'      => $gamification,
            'registration'      => $registration,
            'profileCompletion' => $profileCompletion,
            'verifyUrl'         => $verifyUrl,
        ]);
    }

    /**
     * Upload or update the student profile photo.
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'photo.required' => 'Please select an image file to upload.',
            'photo.image'    => 'The file must be a valid image.',
            'photo.mimes'    => 'The photo must be in JPG, JPEG, or PNG format.',
            'photo.max'      => 'The photo size may not exceed 5 MB.',
        ]);

        $student = Auth::user()->student;
        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $file = $request->file('photo');
        $ext  = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $safeFilename = Str::uuid()->toString() . '.' . $ext;

        // Store file safely in storage/app/public/profile-photos
        $path = $file->storeAs('profile-photos', $safeFilename, 'public');

        // Clean up previous custom photo if it exists on the public disk
        if ($student->profile_photo && Storage::disk('public')->exists($student->profile_photo)) {
            Storage::disk('public')->delete($student->profile_photo);
        }

        $student->update(['profile_photo' => $path]);

        if ($request->wantsJson()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Profile photo updated successfully.',
                'photo_url' => $student->profile_photo_url,
            ]);
        }

        return back()->with('success', 'Profile photo updated successfully! It is now active on your Profile and Smart Campus ID.');
    }

    /**
     * Remove the student profile photo.
     */
    public function deletePhoto(Request $request)
    {
        $student = Auth::user()->student;
        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        if ($student->profile_photo && Storage::disk('public')->exists($student->profile_photo)) {
            Storage::disk('public')->delete($student->profile_photo);
        }

        $student->update(['profile_photo' => null]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile photo removed.',
            ]);
        }

        return back()->with('success', 'Profile photo removed. Default initials avatar will be shown.');
    }

    /**
     * Serve private photo securely if stored on local disk.
     */
    public function getPhoto()
    {
        $student = Auth::user()->student;
        if (! $student) {
            abort(403);
        }

        $photoPath = $student->profile_photo ?? $student->user?->studentRegistration?->photo_path;

        if ($photoPath && Storage::disk('local')->exists($photoPath)) {
            $content  = Storage::disk('local')->get($photoPath);
            $mimeType = Storage::disk('local')->mimeType($photoPath) ?? 'image/jpeg';

            return response($content, 200, [
                'Content-Type'  => $mimeType,
                'Cache-Control' => 'private, max-age=3600',
            ]);
        }

        abort(404, 'Photo not found.');
    }
}
