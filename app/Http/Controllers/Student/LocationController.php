<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\TelegramService;
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

        // ── Telegram Emergency Alert ───────────────────────────────────────────
        try {
            $telegram  = app(TelegramService::class);
            $name      = $student->user->name ?? 'Unknown';
            $time      = now()->format('d M Y, h:i A');
            $lat       = $request->lat;
            $lng       = $request->lng;
            $mapsUrl   = "https://maps.google.com/?q={$lat},{$lng}";

            foreach ($student->parents as $parent) {
                if ($parent->telegram_chat_id) {
                    $telegram->sendMessage(
                        $parent->telegram_chat_id,
                        "🚨 *EMERGENCY SOS ALERT!*🚨\n\n*{$name}* has triggered an emergency SOS request.\n\n⏰ Time: *{$time}*\n📍 Location: [{$lat}, {$lng}]({$mapsUrl})\n\n*Please check immediately!*",
                        'sos',
                        'parent',
                        $parent->id
                    );
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('[SOS] Telegram dispatch failed: ' . $e->getMessage());
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