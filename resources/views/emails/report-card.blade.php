<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Report Card</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2 style="color: #4F46E5; text-align: center;">EdFlow Academy</h2>
        <p>Dear Parent/Guardian,</p>
        <p>Please find attached the official report card for <strong>{{ $student->user->name }}</strong> for the current academic session.</p>
        <p>This report card includes detailed marks, grades, attendance summary, and remarks.</p>
        <p>If you have any questions or concerns regarding the performance, please feel free to contact the administration or class teacher.</p>
        <br>
        <p>Best regards,</p>
        <p><strong>Administration</strong><br>EdFlow Academy</p>
    </div>
</body>
</html>
