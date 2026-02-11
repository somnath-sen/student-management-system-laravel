<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DetailsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        if (! $teacher) {
            abort(403, 'Teacher profile not found.');
        }

        $subjects = $teacher->subjects;

        return view('teacher.details', compact(
            'user',
            'teacher',
            'subjects'
        ));
    }
}
