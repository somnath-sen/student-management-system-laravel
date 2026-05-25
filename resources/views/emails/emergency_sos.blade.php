<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚨 EMERGENCY SOS – {{ $student->user->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0;background-color:#fef2f2;font-family:'Plus Jakarta Sans',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#fef2f2;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 20px 60px rgba(220,38,38,0.15);">

                    <!-- ═══ URGENT HEADER ═══ -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#dc2626 0%,#991b1b 100%);padding:48px 40px;text-align:center;">
                            <div style="display:inline-block;background:rgba(255,255,255,0.15);backdrop-filter:blur(10px);border-radius:20px;padding:16px 24px;margin-bottom:20px;border:1px solid rgba(255,255,255,0.25);">
                                <span style="font-size:36px;">🚨</span>
                            </div>
                            <h1 style="margin:0;color:#ffffff;font-size:26px;font-weight:900;letter-spacing:-0.5px;line-height:1.2;text-transform:uppercase;">
                                Emergency SOS Alert
                            </h1>
                            <p style="margin:10px 0 0;color:rgba(255,255,255,0.85);font-size:14px;font-weight:600;">
                                Your child has triggered a panic alert and needs your immediate attention
                            </p>
                        </td>
                    </tr>

                    <!-- ═══ BODY ═══ -->
                    <tr>
                        <td style="padding:40px;">

                            <!-- Alert Banner -->
                            <div style="background:#fef2f2;border:2px solid #fecaca;border-radius:14px;padding:20px 24px;margin:0 0 28px;text-align:center;">
                                <p style="margin:0 0 4px;font-size:13px;font-weight:800;color:#dc2626;text-transform:uppercase;letter-spacing:1px;">
                                    ⚠️ IMMEDIATE ACTION REQUIRED
                                </p>
                                <p style="margin:0;font-size:13px;color:#991b1b;font-weight:500;">
                                    Please try to contact your child immediately or alert authorities
                                </p>
                            </div>

                            <!-- Student Info Card -->
                            <div style="background:linear-gradient(135deg,#fff1f2 0%,#ffe4e6 100%);border:1px solid #fecdd3;border-radius:16px;padding:28px;margin:0 0 28px;">
                                <p style="margin:0 0 18px;font-size:12px;font-weight:800;color:#e11d48;text-transform:uppercase;letter-spacing:1.5px;">
                                    👤 Student Information
                                </p>

                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding:10px 0;border-bottom:1px solid #fecdd3;">
                                            <span style="font-size:12px;color:#9f1239;font-weight:600;display:block;margin-bottom:2px;">Full Name</span>
                                            <span style="font-size:17px;color:#1e1b4b;font-weight:800;">{{ $student->user->name }}</span>
                                        </td>
                                    </tr>
                                    @if($student->roll_number)
                                    <tr>
                                        <td style="padding:10px 0;border-bottom:1px solid #fecdd3;">
                                            <span style="font-size:12px;color:#9f1239;font-weight:600;display:block;margin-bottom:2px;">Roll Number</span>
                                            <span style="font-size:15px;color:#1e1b4b;font-weight:700;font-family:monospace;">{{ $student->roll_number }}</span>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($student->course)
                                    <tr>
                                        <td style="padding:10px 0;border-bottom:1px solid #fecdd3;">
                                            <span style="font-size:12px;color:#9f1239;font-weight:600;display:block;margin-bottom:2px;">Course</span>
                                            <span style="font-size:15px;color:#1e1b4b;font-weight:700;">{{ $student->course->name ?? 'N/A' }}</span>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($student->phone)
                                    <tr>
                                        <td style="padding:10px 0;border-bottom:1px solid #fecdd3;">
                                            <span style="font-size:12px;color:#9f1239;font-weight:600;display:block;margin-bottom:2px;">Phone Number</span>
                                            <span style="font-size:15px;color:#1e1b4b;font-weight:700;">
                                                <a href="tel:{{ $student->phone }}" style="color:#1e1b4b;text-decoration:none;">{{ $student->phone }}</a>
                                            </span>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td style="padding:10px 0;">
                                            <span style="font-size:12px;color:#9f1239;font-weight:600;display:block;margin-bottom:2px;">Alert Triggered At</span>
                                            <span style="font-size:15px;color:#dc2626;font-weight:800;">
                                                {{ $student->panic_triggered_at?->timezone('Asia/Kolkata')->format('l, d M Y — h:i:s A') ?? now()->timezone('Asia/Kolkata')->format('l, d M Y — h:i:s A') }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- GPS Location Card -->
                            <div style="background:linear-gradient(135deg,#f0f9ff 0%,#e0f2fe 100%);border:1px solid #bae6fd;border-radius:16px;padding:28px;margin:0 0 28px;">
                                <p style="margin:0 0 18px;font-size:12px;font-weight:800;color:#0369a1;text-transform:uppercase;letter-spacing:1.5px;">
                                    📍 Last Known GPS Location
                                </p>

                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="50%" style="padding:8px 0;">
                                            <span style="font-size:11px;color:#0c4a6e;font-weight:600;display:block;margin-bottom:2px;">Latitude</span>
                                            <span style="font-size:15px;color:#1e3a5f;font-weight:800;font-family:monospace;">{{ $student->panic_lat }}</span>
                                        </td>
                                        <td width="50%" style="padding:8px 0;">
                                            <span style="font-size:11px;color:#0c4a6e;font-weight:600;display:block;margin-bottom:2px;">Longitude</span>
                                            <span style="font-size:15px;color:#1e3a5f;font-weight:800;font-family:monospace;">{{ $student->panic_lng }}</span>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Static Map Preview -->
                                <div style="margin-top:16px;border-radius:12px;overflow:hidden;border:2px solid #bae6fd;">
                                    <a href="https://www.google.com/maps?q={{ $student->panic_lat }},{{ $student->panic_lng }}" target="_blank" style="display:block;">
                                        <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $student->panic_lat }},{{ $student->panic_lng }}&zoom=16&size=540x200&markers=color:red%7C{{ $student->panic_lat }},{{ $student->panic_lng }}&style=feature:all" 
                                             alt="Location Map" 
                                             style="width:100%;height:auto;display:block;"
                                             onerror="this.style.display='none'">
                                    </a>
                                </div>
                            </div>

                            <!-- CTA: View on Google Maps -->
                            <div style="text-align:center;margin:0 0 24px;">
                                <a href="https://www.google.com/maps?q={{ $student->panic_lat }},{{ $student->panic_lng }}" 
                                   target="_blank"
                                   style="display:inline-block;background:linear-gradient(135deg,#dc2626 0%,#991b1b 100%);color:#ffffff;text-decoration:none;font-weight:800;font-size:16px;padding:16px 48px;border-radius:14px;box-shadow:0 8px 24px rgba(220,38,38,0.35);letter-spacing:-0.2px;">
                                    📍 View Location on Google Maps
                                </a>
                            </div>

                            <!-- CTA: Call Student -->
                            @if($student->phone)
                            <div style="text-align:center;margin:0 0 32px;">
                                <a href="tel:{{ $student->phone }}" 
                                   style="display:inline-block;background:linear-gradient(135deg,#059669 0%,#047857 100%);color:#ffffff;text-decoration:none;font-weight:800;font-size:15px;padding:14px 44px;border-radius:14px;box-shadow:0 8px 20px rgba(5,150,105,0.3);">
                                    📞 Call {{ $student->user->name }} Now
                                </a>
                            </div>
                            @endif

                            <!-- Divider -->
                            <hr style="border:none;border-top:1px solid #e5e7eb;margin:28px 0;">

                            <!-- What To Do Section -->
                            <p style="margin:0 0 16px;font-size:14px;font-weight:800;color:#374151;">
                                🛡️ What should you do?
                            </p>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:8px 0;vertical-align:top;">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:28px;vertical-align:top;padding-top:2px;">
                                                    <span style="display:inline-block;width:22px;height:22px;border-radius:6px;background:#fef2f2;text-align:center;line-height:22px;font-size:11px;font-weight:800;color:#dc2626;">1</span>
                                                </td>
                                                <td style="font-size:13px;color:#374151;line-height:1.6;font-weight:500;">
                                                    <strong>Call your child immediately</strong> to confirm their safety and situation.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;vertical-align:top;">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:28px;vertical-align:top;padding-top:2px;">
                                                    <span style="display:inline-block;width:22px;height:22px;border-radius:6px;background:#fef2f2;text-align:center;line-height:22px;font-size:11px;font-weight:800;color:#dc2626;">2</span>
                                                </td>
                                                <td style="font-size:13px;color:#374151;line-height:1.6;font-weight:500;">
                                                    <strong>Click the map link above</strong> to see their exact GPS location on Google Maps.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;vertical-align:top;">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:28px;vertical-align:top;padding-top:2px;">
                                                    <span style="display:inline-block;width:22px;height:22px;border-radius:6px;background:#fef2f2;text-align:center;line-height:22px;font-size:11px;font-weight:800;color:#dc2626;">3</span>
                                                </td>
                                                <td style="font-size:13px;color:#374151;line-height:1.6;font-weight:500;">
                                                    <strong>If unreachable, call emergency services</strong> — Dial <strong style="color:#dc2626;">112</strong> (India) or local police immediately.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;vertical-align:top;">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:28px;vertical-align:top;padding-top:2px;">
                                                    <span style="display:inline-block;width:22px;height:22px;border-radius:6px;background:#fef2f2;text-align:center;line-height:22px;font-size:11px;font-weight:800;color:#dc2626;">4</span>
                                                </td>
                                                <td style="font-size:13px;color:#374151;line-height:1.6;font-weight:500;">
                                                    <strong>Contact your institution</strong> to inform campus security of the situation.
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Emergency Numbers -->
                            <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:18px 22px;margin:28px 0 0;">
                                <p style="margin:0 0 8px;font-size:12px;font-weight:800;color:#92400e;text-transform:uppercase;letter-spacing:1px;">
                                    📞 Emergency Helpline Numbers (India)
                                </p>
                                <table width="100%" cellpadding="0" cellspacing="0" style="font-size:13px;color:#78350f;">
                                    <tr>
                                        <td style="padding:4px 0;font-weight:700;" width="50%">🚔 Police: <span style="font-family:monospace;font-weight:800;">100</span></td>
                                        <td style="padding:4px 0;font-weight:700;" width="50%">🚑 Ambulance: <span style="font-family:monospace;font-weight:800;">108</span></td>
                                    </tr>
                                    <tr>
                                        <td style="padding:4px 0;font-weight:700;">🔥 Fire: <span style="font-family:monospace;font-weight:800;">101</span></td>
                                        <td style="padding:4px 0;font-weight:700;">📱 Unified: <span style="font-family:monospace;font-weight:800;">112</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding:4px 0;font-weight:700;">👩 Women Helpline: <span style="font-family:monospace;font-weight:800;">1091</span></td>
                                    </tr>
                                </table>
                            </div>

                        </td>
                    </tr>

                    <!-- ═══ FOOTER ═══ -->
                    <tr>
                        <td style="background:#fef2f2;border-top:1px solid #fecaca;padding:24px 40px;text-align:center;">
                            <p style="margin:0 0 6px;font-size:13px;font-weight:700;color:#dc2626;">EdFlow — Family Safety Tracker</p>
                            <p style="margin:0 0 4px;font-size:12px;color:#9ca3af;">This is an automated emergency alert sent from your child's EdFlow Family Tracker.</p>
                            <p style="margin:0;font-size:11px;color:#d1d5db;">© {{ date('Y') }} EdFlow Campus Management System. All rights reserved.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>