<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmartIdController extends Controller
{
    /**
     * Resolve the best URL base for QR codes.
     * Uses the incoming request host so it works from XAMPP, artisan serve,
     * or any port — and the phone only needs to be on the same Wi-Fi.
     */
    private function resolveQrBaseUrl(Request $request): string
    {
        // If APP_URL is set to a real host/IP (not localhost/127), use it.
        $appUrl = config('app.url');
        $parsed = parse_url($appUrl);
        $host   = $parsed['host'] ?? 'localhost';

        if (!in_array($host, ['localhost', '127.0.0.1', '::1'])) {
            return rtrim($appUrl, '/');
        }

        // Otherwise detect the machine's LAN IP from the active network interface.
        $lanIp = $this->detectLanIp();
        $port  = $request->getPort();
        $scheme = $request->getScheme();

        // Only include port when it is non-standard.
        $portSuffix = '';
        if (($scheme === 'http' && $port !== 80) || ($scheme === 'https' && $port !== 443)) {
            $portSuffix = ':' . $port;
        }

        return $scheme . '://' . $lanIp . $portSuffix;
    }

    /**
     * Detect the machine's real Wi-Fi LAN IP address.
     *
     * Strategy:
     *  1. Collect all LAN-range IPs from the hostname.
     *  2. Skip "gateway-style" IPs that end in .1  (hotspot adapters like
     *     192.168.145.1, VMware adapters like 192.168.207.1 always self-assign .1).
     *  3. Return the first remaining candidate — that's the real Wi-Fi NIC.
     *  4. If everything ends in .1, fall back to the first LAN IP found.
     *  5. Last resort: 127.0.0.1.
     */
    private function detectLanIp(): string
    {
        $hostname  = gethostname();
        $addresses = gethostbynamel($hostname) ?: [];

        $lanIps = array_filter($addresses, function ($addr) {
            return str_starts_with($addr, '192.168.')
                || str_starts_with($addr, '10.')
                || (str_starts_with($addr, '172.') && (int) explode('.', $addr)[1] >= 16 && (int) explode('.', $addr)[1] <= 31);
        });

        // Prefer IPs that do NOT end in .1 (real Wi-Fi adapters)
        $preferred = array_filter($lanIps, fn($ip) => !str_ends_with($ip, '.1'));

        if (!empty($preferred)) {
            return array_values($preferred)[0];
        }

        // All IPs end in .1 — just return the first LAN one
        if (!empty($lanIps)) {
            return array_values($lanIps)[0];
        }

        return '127.0.0.1';
    }

    public function index(Request $request)
    {
        $student = Auth::user()->student;
        $baseUrl = $this->resolveQrBaseUrl($request);
        $verifyUrl = $baseUrl . '/verify/student/' . $student->id;
        return view('student.smart-id.index', compact('student', 'verifyUrl', 'baseUrl'));
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