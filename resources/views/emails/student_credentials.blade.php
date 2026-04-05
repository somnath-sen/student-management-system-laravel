<!DOCTYPE html>
<html>
<head>
    <title>Your Student Account Details</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eaeaea; border-radius: 10px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="color: #4f46e5;">Welcome to EdFlow!</h2>
        </div>
        
        <p>Dear {{ $user->name }},</p>
        <p>Congratulations! Your registration for the <strong>{{ $registration->course }}</strong> program has been approved.</p>
        
        <div style="background-color: #f8fafc; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #1e293b;">Your Login Credentials:</h3>
            <p><strong>Email/Username:</strong> {{ $user->email }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
            @if($registration->roll)
                <p><strong>Roll Number:</strong> {{ $registration->roll }}</p>
            @endif
        </div>
        
        <p>Please log in to your account and change your password as soon as possible.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/login') }}" style="background-color: #4f46e5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Login Now</a>
        </div>
        
        <p style="font-size: 12px; color: #64748b; text-align: center; margin-top: 40px;">
            If you have any questions, please contact the administration.<br>
            &copy; {{ date('Y') }} EdFlow Student Management System.
        </p>
    </div>
</body>
</html>
