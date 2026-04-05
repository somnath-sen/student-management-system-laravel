<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to EdFlow – Faculty Account Ready</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0;background-color:#f0f4ff;font-family:'Plus Jakarta Sans',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0f4ff;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:24px;overflow:hidden;box-shadow:0 20px 60px rgba(99,102,241,0.12);">

                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);padding:48px 40px;text-align:center;">
                            <div style="display:inline-block;background:rgba(255,255,255,0.15);backdrop-filter:blur(10px);border-radius:20px;padding:16px 24px;margin-bottom:24px;border:1px solid rgba(255,255,255,0.2);">
                                <span style="font-size:32px;">🎓</span>
                            </div>
                            <h1 style="margin:0;color:#ffffff;font-size:28px;font-weight:800;letter-spacing:-0.5px;line-height:1.2;">Your Faculty Account is Ready!</h1>
                            <p style="margin:12px 0 0;color:rgba(255,255,255,0.8);font-size:15px;font-weight:500;">Welcome to the EdFlow Educator Network</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:40px;">

                            <p style="color:#374151;font-size:16px;line-height:1.7;margin:0 0 24px;">
                                Dear <strong>{{ $data['name'] }}</strong>,
                            </p>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 32px;">
                                Congratulations! The EdFlow administration team has reviewed and <strong style="color:#4f46e5;">approved your faculty application</strong>. Your instructor account has been created and you can now access the platform.
                            </p>

                            <!-- Credentials Card -->
                            <div style="background:linear-gradient(135deg,#eef2ff 0%,#f5f3ff 100%);border:1px solid #c7d2fe;border-radius:16px;padding:28px;margin:0 0 32px;">
                                <p style="margin:0 0 20px;font-size:13px;font-weight:700;color:#6366f1;text-transform:uppercase;letter-spacing:1px;">🔐 Your Login Credentials</p>

                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="padding:10px 0;border-bottom:1px solid #e0e7ff;">
                                            <span style="font-size:13px;color:#6b7280;font-weight:600;display:block;margin-bottom:2px;">Employee ID</span>
                                            <span style="font-size:16px;color:#1e1b4b;font-weight:800;font-family:monospace;">{{ $data['employee_id'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 0;border-bottom:1px solid #e0e7ff;">
                                            <span style="font-size:13px;color:#6b7280;font-weight:600;display:block;margin-bottom:2px;">Email (Username)</span>
                                            <span style="font-size:16px;color:#1e1b4b;font-weight:800;">{{ $data['email'] }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px 0;">
                                            <span style="font-size:13px;color:#6b7280;font-weight:600;display:block;margin-bottom:2px;">Temporary Password</span>
                                            <span style="font-size:18px;color:#4f46e5;font-weight:800;font-family:monospace;letter-spacing:2px;background:#fff;padding:6px 14px;border-radius:8px;border:1px dashed #a5b4fc;display:inline-block;">{{ $data['password'] }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Security Notice -->
                            <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:16px 20px;margin:0 0 32px;">
                                <p style="margin:0;font-size:13px;color:#92400e;font-weight:600;">
                                    ⚠️ <strong>Important:</strong> Please change your password immediately after your first login for security purposes.
                                </p>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align:center;margin:0 0 32px;">
                                <a href="{{ $data['login_url'] }}" style="display:inline-block;background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);color:#ffffff;text-decoration:none;font-weight:800;font-size:16px;padding:16px 48px;border-radius:14px;box-shadow:0 8px 20px rgba(79,70,229,0.3);letter-spacing:-0.2px;">
                                    🚀 Access My Dashboard
                                </a>
                            </div>

                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 8px;">
                                From your teacher dashboard, you can:
                            </p>
                            <ul style="color:#374151;font-size:14px;line-height:2;padding-left:20px;margin:0 0 32px;">
                                <li>View your assigned subjects and student lists</li>
                                <li>Mark student attendance</li>
                                <li>Enter and manage exam marks</li>
                                <li>Send broadcast messages to students</li>
                                <li>Access performance analytics</li>
                            </ul>

                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0;">
                                Welcome aboard, and we look forward to your contributions to EdFlow! 🌟
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:24px 40px;text-align:center;">
                            <p style="margin:0 0 6px;font-size:13px;font-weight:700;color:#4f46e5;">EdFlow — Student Management System</p>
                            <p style="margin:0;font-size:12px;color:#94a3b8;">This is an automated email. Please do not reply directly.</p>
                            <p style="margin:8px 0 0;font-size:11px;color:#cbd5e1;">© {{ date('Y') }} EdFlow. All rights reserved.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
