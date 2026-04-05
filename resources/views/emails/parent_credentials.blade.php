<!DOCTYPE html>
<html>
<head>
    <title>Your Parent Account Details</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eaeaea; border-radius: 10px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="color: #4f46e5;">Welcome to EdFlow Parent Portal</h2>
        </div>
        
        <p>Dear {{ $user->name }},</p>
        <p>Your child, <strong>{{ $registration->name }}</strong>, has been successfully registered in the <strong>{{ $registration->course }}</strong> program.</p>
        <p>A parent account has been created for you to monitor their academic progress, attendance, and results.</p>
        
        <div style="background-color: #f8fafc; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #1e293b;">Your Login Credentials:</h3>
            <p><strong>Email/Username:</strong> {{ $user->email }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
            @if($password === 'Your existing password')
                <p><small>(Use the password you previously set for your account. If you forgot it, please use the reset password page).</small></p>
            @endif
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" style="background-color: #4f46e5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Login to Parent Portal</a>
        </div>
        
        <p style="font-size: 12px; color: #64748b; text-align: center; margin-top: 40px;">
            If you have any questions, please contact the administration.<br>
            &copy; {{ date('Y') }} EdFlow Student Management System.
        </p>
    </div>
</body>
</html>
