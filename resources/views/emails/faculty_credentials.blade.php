<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EdFlow Faculty Account Approved</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0;background-color:#0f172a;font-family:'Plus Jakarta Sans',Arial,-apple-system,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#0f172a;padding:40px 16px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 25px 50px -12px rgba(0,0,0,0.35);">

                    <!-- Header with EdFlow Deep Navy & Orange Accent -->
                    <tr>
                        <td style="background:linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #1e3a8a 100%);padding:44px 36px 36px;text-align:center;border-bottom:4px solid #f97316;">
                            <div style="display:inline-block;background:rgba(255,255,255,0.08);backdrop-filter:blur(8px);border-radius:18px;padding:12px 20px;margin-bottom:20px;border:1px solid rgba(255,255,255,0.15);">
                                <span style="font-size:30px;">👨‍🏫</span>
                            </div>
                            <div style="margin-bottom:12px;">
                                <span style="display:inline-block;background:#10b981;color:#ffffff;font-size:12px;font-weight:800;letter-spacing:1px;text-transform:uppercase;padding:6px 16px;border-radius:9999px;">
                                    ✓ Faculty Account Approved
                                </span>
                            </div>
                            <h1 style="margin:0;color:#ffffff;font-size:26px;font-weight:800;letter-spacing:-0.5px;line-height:1.25;">
                                Welcome to EdFlow Faculty!
                            </h1>
                            <p style="margin:10px 0 0;color:#94a3b8;font-size:15px;font-weight:500;">
                                Educator Network &amp; Academic Management Portal
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding:36px 32px 28px;">

                            <p style="color:#1e293b;font-size:16px;line-height:1.6;margin:0 0 16px;">
                                Dear <strong>{{ $data['name'] }}</strong>,
                            </p>
                            <p style="color:#475569;font-size:15px;line-height:1.7;margin:0 0 28px;">
                                Congratulations! Your Faculty/Instructor application has been reviewed and <strong style="color:#0f172a;">officially approved</strong>. Your EdFlow Faculty account has been created and is ready for use.
                            </p>

                            <!-- Credentials Box -->
                            <div style="background:#f8fafc;border:2px solid #e2e8f0;border-radius:18px;padding:26px;margin:0 0 24px;">
                                <div style="display:flex;align-items:center;margin-bottom:18px;border-bottom:1px solid #e2e8f0;padding-bottom:12px;">
                                    <span style="font-size:13px;font-weight:800;color:#0f172a;text-transform:uppercase;letter-spacing:1px;">
                                        🔐 Login Details
                                    </span>
                                </div>

                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding:10px 0;border-bottom:1px solid #edf2f7;">
                                            <span style="font-size:12px;color:#64748b;font-weight:700;display:block;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">Email (Username)</span>
                                            <span style="font-size:15px;color:#0f172a;font-weight:700;">{{ $data['email'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 0;border-bottom:1px solid #edf2f7;">
                                            <span style="font-size:12px;color:#64748b;font-weight:700;display:block;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">Date of Birth</span>
                                            <span style="font-size:15px;color:#0f172a;font-weight:700;font-family:monospace;">{{ $data['dob_display'] ?? 'N/A' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:12px 0;border-bottom:1px solid #edf2f7;background:#fff7ed;border-radius:10px;padding-left:12px;padding-right:12px;margin-top:6px;">
                                            <span style="font-size:12px;color:#c2410c;font-weight:800;display:block;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">Initial Login Password</span>
                                            <span style="font-size:20px;color:#ea580c;font-weight:800;font-family:monospace;letter-spacing:2px;display:inline-block;background:#ffffff;padding:6px 14px;border-radius:8px;border:1px solid #fed7aa;">
                                                {{ $data['password'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 0;border-bottom:1px solid #edf2f7;">
                                            <span style="font-size:12px;color:#64748b;font-weight:700;display:block;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">Employee ID</span>
                                            <span style="font-size:15px;color:#0f172a;font-weight:700;font-family:monospace;">{{ $data['employee_id'] }}</span>
                                        </td>
                                    </tr>
                                    @if(!empty($data['department']))
                                    <tr>
                                        <td style="padding:10px 0;border-bottom:1px solid #edf2f7;">
                                            <span style="font-size:12px;color:#64748b;font-weight:700;display:block;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">Department</span>
                                            <span style="font-size:14px;color:#334155;font-weight:700;">{{ $data['department'] }}</span>
                                        </td>
                                    </tr>
                                    @endif
                                    @if(!empty($data['subjects']))
                                    <tr>
                                        <td style="padding:10px 0;border-bottom:1px solid #edf2f7;">
                                            <span style="font-size:12px;color:#64748b;font-weight:700;display:block;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">Subjects</span>
                                            <span style="font-size:14px;color:#334155;font-weight:600;">{{ $data['subjects'] }}</span>
                                        </td>
                                    </tr>
                                    @endif
                                    @if(!empty($data['application_id']))
                                    <tr>
                                        <td style="padding:10px 0;">
                                            <span style="font-size:12px;color:#64748b;font-weight:700;display:block;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">Application ID</span>
                                            <span style="font-size:14px;color:#334155;font-weight:700;font-family:monospace;">{{ $data['application_id'] }}</span>
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </div>

                            <!-- Explicit DOB Password Rule Explanation Box -->
                            <div style="background:#eff6ff;border-left:4px solid #2563eb;border-radius:10px;padding:16px 18px;margin:0 0 24px;">
                                <p style="margin:0;font-size:13px;color:#1e40af;line-height:1.6;">
                                    💡 <strong>Password Format Notice:</strong> Your initial password is your date of birth in <strong>DDMMYYYY</strong> format (leading zeros included). For example, if your DOB is <code>{{ $data['dob_display'] ?? '15-08-1995' }}</code>, your initial password is <code>{{ $data['password'] }}</code>.
                                </p>
                            </div>

                            <!-- Security Notice -->
                            <div style="background:#fffbeb;border-left:4px solid #f59e0b;border-radius:10px;padding:16px 18px;margin:0 0 28px;">
                                <p style="margin:0;font-size:13px;color:#92400e;line-height:1.6;">
                                    ⚠️ <strong>Security Recommendation:</strong> For your account security, please log in and change your password to a strong personal password immediately after your first login.
                                </p>
                            </div>

                            <!-- Action CTA Button -->
                            <div style="text-align:center;margin:0 0 32px;">
                                <a href="{{ $data['login_url'] ?? route('login') }}" style="display:inline-block;background:linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);color:#ffffff;text-decoration:none;font-weight:800;font-size:16px;padding:16px 44px;border-radius:12px;box-shadow:0 10px 25px -5px rgba(15,23,42,0.4);letter-spacing:-0.2px;border:1px solid #1e293b;">
                                    🚀 Access Faculty Dashboard
                                </a>
                            </div>

                            <p style="color:#64748b;font-size:13px;line-height:1.6;margin:0;text-align:center;">
                                Having trouble logging in? Contact the EdFlow administrator for assistance.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:24px 32px;text-align:center;">
                            <p style="margin:0 0 6px;font-size:13px;font-weight:800;color:#0f172a;">EdFlow Smart Campus System</p>
                            <p style="margin:0;font-size:12px;color:#94a3b8;">This is an automated administrative notification. Please do not reply directly to this email.</p>
                            <p style="margin:8px 0 0;font-size:11px;color:#cbd5e1;">&copy; {{ date('Y') }} EdFlow. All rights reserved.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
