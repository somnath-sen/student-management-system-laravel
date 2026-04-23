<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PreferenceController extends Controller
{
    /**
     * Update the user's theme preference.
     */
    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme' => ['required', 'in:light,dark'],
        ]);

        // Store the theme preference in a cookie for 1 year (60 minutes * 24 hours * 365 days)
        $cookie = cookie('theme', $request->theme, 60 * 24 * 365);

        return response()->json(['status' => 'success', 'theme' => $request->theme])
            ->withCookie($cookie);
    }

    /**
     * Update the user's language preference.
     */
    public function updateLanguage(Request $request)
    {
        $request->validate([
            'language' => ['required', 'string', 'max:5'],
        ]);

        // Store the language preference in a cookie for 1 year
        $cookie = cookie('language', $request->language, 60 * 24 * 365);

        return response()->json(['status' => 'success', 'language' => $request->language])
            ->withCookie($cookie);
    }

    /**
     * Clear the user's preferences.
     */
    public function clearPreferences(Request $request)
    {
        return response()->json(['status' => 'success', 'message' => 'Preferences cleared'])
            ->withCookie(Cookie::forget('theme'))
            ->withCookie(Cookie::forget('language'));
    }
}
