<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $studentEnabled = Setting::get('student_registration_enabled', true);
        $facultyEnabled = Setting::get('faculty_registration_enabled', true);

        return view('admin.settings.index', compact('studentEnabled', 'facultyEnabled'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'required|boolean'
        ]);

        Setting::set($request->key, $request->value);

        return response()->json(['success' => true, 'message' => 'Settings updated successfully']);
    }
}
