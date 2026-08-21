<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Doubt Has Been Answered — EdFlow</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { background: #F2F2F7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; padding: 32px 16px; }
    .container { max-width: 600px; margin: 0 auto; }
    .header { background: linear-gradient(135deg, #007AFF, #5AC8FA); border-radius: 20px 20px 0 0; padding: 32px 40px 28px; text-align: center; }
    .header-icon { width: 64px; height: 64px; background: rgba(255,255,255,0.25); border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
    .header-icon svg { width: 32px; height: 32px; fill: white; }
    .header h1 { color: #fff; font-size: 22px; font-weight: 700; letter-spacing: -0.5px; }
    .header p { color: rgba(255,255,255,0.85); font-size: 14px; margin-top: 6px; }
    .body { background: #fff; padding: 36px 40px; border-left: 1px solid #E5E5EA; border-right: 1px solid #E5E5EA; }
    .greeting { font-size: 16px; font-weight: 600; color: #1C1C1E; margin-bottom: 16px; }
    .intro { font-size: 14px; color: #636366; line-height: 1.65; margin-bottom: 28px; }
    .section-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #8E8E93; margin-bottom: 10px; }
    .ticket-box { background: #F2F2F7; border-radius: 14px; padding: 18px 22px; margin-bottom: 24px; }
    .ticket-subject { font-size: 15px; font-weight: 700; color: #1C1C1E; margin-bottom: 8px; }
    .ticket-question { font-size: 13px; color: #636366; line-height: 1.6; }
    .reply-box { background: linear-gradient(135deg, #F0F7FF, #E8F4FD); border: 1.5px solid #BDE0FF; border-radius: 14px; padding: 20px 24px; margin-bottom: 24px; }
    .reply-header { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
    .admin-badge { background: #007AFF; color: #fff; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 100px; }
    .reply-text { font-size: 14px; color: #1C1C1E; line-height: 1.7; }
    .status-badge { display: inline-block; padding: 6px 18px; border-radius: 100px; font-size: 12px; font-weight: 700; margin-bottom: 28px; }
    .status-solved { background: rgba(52,199,89,0.12); color: #30D158; }
    .status-in_progress { background: rgba(255,159,10,0.12); color: #FF9F0A; }
    .cta { text-align: center; margin-bottom: 28px; }
    .cta a { display: inline-block; background: #007AFF; color: #fff; text-decoration: none; padding: 14px 32px; border-radius: 14px; font-size: 14px; font-weight: 600; }
    .footer { background: #F2F2F7; border-radius: 0 0 20px 20px; border: 1px solid #E5E5EA; border-top: none; padding: 24px 40px; text-align: center; }
    .footer p { font-size: 12px; color: #8E8E93; line-height: 1.6; }
    .footer strong { color: #1C1C1E; }
</style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <div class="header-icon">
            <svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
        </div>
        <h1>Your Doubt Has Been Answered!</h1>
        <p>EdFlow Support Team has responded to your query</p>
    </div>

    <!-- Body -->
    <div class="body">
        <p class="greeting">Hello {{ $ticket->user->name ?? 'there' }},</p>
        <p class="intro">
            Great news! The EdFlow support team has reviewed your question and provided a response. 
            Please find the details below.
        </p>

        <!-- Original Question -->
        <p class="section-label">Your Original Question</p>
        <div class="ticket-box">
            <p class="ticket-subject">{{ $ticket->subject }}</p>
            <p class="ticket-question">{{ $ticket->question }}</p>
        </div>

        <!-- Admin Reply -->
        <p class="section-label">Response from EdFlow Support</p>
        <div class="reply-box">
            <div class="reply-header">
                <span class="admin-badge">EdFlow Admin</span>
                @if($ticket->replied_at)
                    <span style="font-size:12px;color:#8E8E93;">{{ $ticket->replied_at->format('d M Y, h:i A') }}</span>
                @endif
            </div>
            <p class="reply-text">{{ $ticket->admin_reply }}</p>
        </div>

        <!-- Status -->
        @if($ticket->status === 'solved')
            <span class="status-badge status-solved">✓ Marked as Solved</span>
        @else
            <span class="status-badge status-in_progress">⏳ In Progress</span>
        @endif

        <!-- CTA -->
        <div class="cta">
            <a href="{{ url('/student/dashboard') }}">View in Dashboard →</a>
        </div>

        <p style="font-size:13px;color:#636366;line-height:1.65;">
            If you have further questions, feel free to submit another doubt through the 
            <strong>Support</strong> section in your dashboard. We're always here to help!
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>EdFlow</strong> — Student Management Platform</p>
        <p style="margin-top:6px;">This email was sent because you submitted a support query. 
        Please do not reply directly to this email.</p>
    </div>
</div>
</body>
</html>
