<x-guest-layout>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Outfit', sans-serif;
        min-height: 100vh;
        overflow: hidden;
    }

    .fp-wrapper {
        display: flex;
        min-height: 100vh;
        width: 100%;
        position: relative;
    }

    /* ===== LEFT BRAND PANEL ===== */
    .brand-panel {
        flex: 1;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem;
        overflow: hidden;
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
    }

    .brand-panel::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(-45deg, #6366f1, #8b5cf6, #ec4899, #f43f5e, #f97316, #8b5cf6, #6366f1);
        background-size: 400% 400%;
        animation: gradientShift 10s ease infinite;
        opacity: 0.18;
        z-index: 0;
    }
    @keyframes gradientShift {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Rings */
    .ring {
        position: absolute; border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.06);
        animation: ringPulse 6s ease-in-out infinite;
    }
    .ring-1 { width: 320px; height: 320px; top: -100px; left: -100px; }
    .ring-2 { width: 520px; height: 520px; top: -180px; left: -180px; animation-delay: 1s; border-color: rgba(139,92,246,0.12); }
    .ring-3 { width: 260px; height: 260px; bottom: -80px; right: -80px; animation-delay: 2s; border-color: rgba(236,72,153,0.12); }
    .ring-4 { width: 460px; height: 460px; bottom: -160px; right: -160px; animation-delay: 1.5s; }
    @keyframes ringPulse {
        0%, 100% { transform: scale(1); opacity: 0.6; }
        50%       { transform: scale(1.05); opacity: 1; }
    }

    /* Glowing CSS orbs */
    .orb { position: absolute; border-radius: 50%; filter: blur(60px); animation: orbFloat 8s ease-in-out infinite alternate; z-index: 0; }
    .orb-1 { width: 300px; height: 300px; background: rgba(99,102,241,0.45); top: 5%; left: 5%; animation-duration: 9s; }
    .orb-2 { width: 250px; height: 250px; background: rgba(236,72,153,0.35); bottom: 10%; right: 5%; animation-duration: 11s; animation-delay: 2s; }
    .orb-3 { width: 170px; height: 170px; background: rgba(249,115,22,0.28); top: 50%; left: 40%; animation-duration: 7s; animation-delay: 4s; }
    @keyframes orbFloat {
        from { transform: translateY(0) translateX(0); }
        to   { transform: translateY(-40px) translateX(18px); }
    }

    /* Brand content */
    .brand-content { position: relative; z-index: 1; text-align: center; color: white; }

    /* Key icon animated */
    .key-icon-wrap {
        width: 90px; height: 90px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 32px;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.4rem;
        margin: 0 auto 1.5rem;
        backdrop-filter: blur(10px);
        box-shadow: 0 0 40px rgba(139,92,246,0.5), 0 20px 40px rgba(0,0,0,0.3);
        animation: keyBreathe 3s ease-in-out infinite;
    }
    @keyframes keyBreathe {
        0%, 100% { transform: scale(1) rotate(-5deg); box-shadow: 0 0 30px rgba(99,102,241,0.4); }
        50%       { transform: scale(1.08) rotate(5deg); box-shadow: 0 0 60px rgba(236,72,153,0.5); }
    }

    .brand-name {
        font-size: 2.8rem; font-weight: 900; letter-spacing: -0.03em;
        background: linear-gradient(90deg, #fff 0%, #c4b5fd 50%, #f9a8d4 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        margin-bottom: 0.5rem;
    }
    .brand-sub {
        font-size: 1.1rem; font-weight: 700; color: rgba(255,255,255,0.55);
        margin-bottom: 0.5rem;
    }
    .brand-tagline {
        font-size: 0.88rem; color: rgba(255,255,255,0.4); font-weight: 500;
        max-width: 270px; margin: 0 auto 2.5rem; line-height: 1.7;
    }

    /* Steps guide */
    .steps-guide { display: flex; flex-direction: column; gap: 1rem; align-items: flex-start; max-width: 280px; margin: 0 auto; }
    .step-item {
        display: flex; align-items: center; gap: 12px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 16px;
        padding: 0.8rem 1.2rem;
        width: 100%;
        backdrop-filter: blur(8px);
        transition: all 0.3s;
    }
    .step-item:hover { background: rgba(255,255,255,0.13); transform: translateX(4px); }
    .step-num {
        width: 28px; height: 28px; border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #ec4899);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem; font-weight: 900; color: white; flex-shrink: 0;
    }
    .step-text { font-size: 0.82rem; font-weight: 600; color: rgba(255,255,255,0.7); line-height: 1.4; }

    /* Bottom badge strip */
    .badge-strip {
        position: absolute; bottom: 2rem; left: 0; right: 0;
        display: flex; justify-content: center; gap: 0.6rem; flex-wrap: wrap;
        padding: 0 2rem; z-index: 1;
    }
    .badge-chip {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12);
        border-radius: 99px; padding: 0.35rem 0.9rem;
        font-size: 0.72rem; font-weight: 600; color: rgba(255,255,255,0.65);
        backdrop-filter: blur(6px);
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; animation: dotPulse 2s ease-in-out infinite; }
    @keyframes dotPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.4; transform: scale(0.7); }
    }

    /* ===== RIGHT FORM PANEL ===== */
    .form-panel {
        width: 480px; flex-shrink: 0;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 2.5rem;
        background: #f8faff;
        position: relative; overflow: hidden;
    }

    /* Rainbow top bar */
    .form-panel::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
        background: linear-gradient(90deg, #6366f1, #ec4899, #f97316, #6366f1);
        background-size: 200% 100%;
        animation: barSlide 3s linear infinite;
    }
    @keyframes barSlide {
        0%   { background-position: 0% 50%; }
        100% { background-position: 200% 50%; }
    }

    .form-inner {
        width: 100%; max-width: 380px;
        animation: slideInRight 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    /* Back link */
    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        font-size: 0.82rem; font-weight: 700; color: #6366f1; text-decoration: none;
        margin-bottom: 2rem; transition: all 0.2s;
        padding: 0.4rem 0.8rem;
        background: rgba(99,102,241,0.08);
        border-radius: 99px; border: 1px solid rgba(99,102,241,0.2);
    }
    .back-link:hover { background: rgba(99,102,241,0.15); transform: translateX(-3px); }
    .back-arr { transition: transform 0.2s; }
    .back-link:hover .back-arr { transform: translateX(-3px); }

    /* Heading */
    .form-heading { margin-bottom: 2rem; }
    .form-heading .badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: linear-gradient(135deg, #ede9fe, #fce7f3);
        border: 1px solid #ddd6fe; border-radius: 99px;
        padding: 0.3rem 0.85rem;
        font-size: 0.72rem; font-weight: 800; color: #7c3aed;
        text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem;
    }
    .form-heading h1 {
        font-size: 1.9rem; font-weight: 900; color: #0f172a;
        letter-spacing: -0.03em; line-height: 1.2; margin-bottom: 0.5rem;
    }
    .form-heading p { font-size: 0.88rem; color: #64748b; font-weight: 500; line-height: 1.6; }

    /* Info box */
    .info-box {
        display: flex; gap: 10px; align-items: flex-start;
        background: linear-gradient(135deg, rgba(99,102,241,0.06), rgba(139,92,246,0.06));
        border: 1px solid rgba(99,102,241,0.2);
        border-radius: 14px; padding: 1rem 1.1rem;
        margin-bottom: 1.5rem;
    }
    .info-box i { color: #6366f1; font-size: 0.95rem; margin-top: 2px; flex-shrink: 0; }
    .info-box p { font-size: 0.82rem; color: #475569; font-weight: 500; line-height: 1.6; }

    /* Session status */
    .session-msg {
        background: #f0fdf4; border: 1px solid #86efac;
        color: #166534; font-weight: 700; font-size: 0.85rem;
        border-radius: 12px; padding: 0.75rem 1rem; margin-bottom: 1.25rem; text-align: center;
    }

    /* Input */
    .field-label {
        display: block; font-size: 0.72rem; font-weight: 800;
        color: #475569; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;
    }
    .input-wrap { position: relative; margin-bottom: 1.5rem; }
    .input-icon-left {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 0.9rem; pointer-events: none;
        transition: color 0.3s; z-index: 1;
    }
    .prem-input {
        width: 100%; padding: 0.95rem 1rem 0.95rem 2.75rem;
        border-radius: 14px; border: 1.5px solid #e2e8f0;
        background: white; font-family: 'Outfit', sans-serif;
        font-size: 0.95rem; font-weight: 500; color: #0f172a;
        outline: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .prem-input::placeholder { color: #cbd5e1; }
    .prem-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99,102,241,0.12), 0 4px 12px rgba(99,102,241,0.08);
        transform: translateY(-1px);
    }
    .input-wrap:focus-within .input-icon-left { color: #6366f1; }
    .field-error { color: #f43f5e; font-size: 0.75rem; font-weight: 700; margin-top: 4px; }

    /* Submit button */
    .submit-btn {
        width: 100%; padding: 1rem; border: none; border-radius: 14px;
        font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 800;
        color: white; cursor: pointer; position: relative; overflow: hidden;
        transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
        box-shadow: 0 10px 25px rgba(99,102,241,0.35);
    }
    .submit-btn::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(135deg, #4f46e5, #7c3aed, #db2777);
        opacity: 0; transition: opacity 0.3s;
    }
    .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 16px 35px rgba(99,102,241,0.45); }
    .submit-btn:hover::before { opacity: 1; }
    .submit-btn:active { transform: translateY(0) scale(0.98); }
    .submit-btn span { position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .btn-icon { transition: transform 0.3s; }
    .submit-btn:hover .btn-icon { transform: translateX(4px); }

    /* Back to login link */
    .login-link {
        text-align: center; margin-top: 1.5rem;
        font-size: 0.88rem; color: #64748b; font-weight: 600;
    }
    .login-link a { color: #6366f1; font-weight: 800; text-decoration: none; }
    .login-link a:hover { text-decoration: underline; color: #4f46e5; }

    /* Animations */
    .anim-item { opacity: 0; animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .d1 { animation-delay: 0.05s; }
    .d2 { animation-delay: 0.15s; }
    .d3 { animation-delay: 0.25s; }
    .d4 { animation-delay: 0.35s; }
    .d5 { animation-delay: 0.45s; }
    .d6 { animation-delay: 0.55s; }

    /* Responsive */
    @media (max-width: 768px) {
        .brand-panel { display: none; }
        .form-panel { width: 100%; padding: 2rem 1.5rem; }
    }
</style>

<div class="fp-wrapper">

    <!-- ===================== LEFT BRAND PANEL ===================== -->
    <div class="brand-panel">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="ring ring-1"></div>
        <div class="ring ring-2"></div>
        <div class="ring ring-3"></div>
        <div class="ring ring-4"></div>

        <div class="brand-content">
            <!-- Animated key icon -->
            <div class="key-icon-wrap">
                <i class="fa-solid fa-key" style="color:white;"></i>
            </div>

            <div class="brand-name">EdFlow</div>
            <div class="brand-sub">Password Recovery</div>
            <p class="brand-tagline">We'll help you get back in. It only takes a minute to reset your password.</p>

            <!-- Step guide -->
            <div class="steps-guide">
                <div class="step-item">
                    <div class="step-num">1</div>
                    <div class="step-text">Enter your registered email address</div>
                </div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <div class="step-text">Check your inbox for the reset link</div>
                </div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <div class="step-text">Click the link and set a new password</div>
                </div>
            </div>
        </div>

        <div class="badge-strip">
            <div class="badge-chip">
                <span class="badge-dot" style="background:#4ade80;"></span> Secure Delivery
            </div>
            <div class="badge-chip">
                <span class="badge-dot" style="background:#818cf8;"></span> Link expires in 60 min
            </div>
            <div class="badge-chip">
                <span class="badge-dot" style="background:#f472b6;"></span> 256-bit Encrypted
            </div>
        </div>
    </div>

    <!-- ===================== RIGHT FORM PANEL ===================== -->
    <div class="form-panel">
        <div class="form-inner">

            <!-- Back to login -->
            <a href="{{ route('login') }}" class="back-link anim-item d1">
                <i class="fa-solid fa-arrow-left back-arr"></i> Back to Login
            </a>

            <!-- Heading -->
            <div class="form-heading anim-item d2">
                <div class="badge">
                    <i class="fa-solid fa-lock-open"></i> Password Reset
                </div>
                <h1>Forgot your<br>password? 🔑</h1>
                <p>No worries! Enter your email and we'll send you a secure reset link right away.</p>
            </div>

            <!-- Info callout -->
            <div class="info-box anim-item d3">
                <i class="fa-solid fa-circle-info"></i>
                <p>We'll email you a password reset link. Please <strong>check your spam folder</strong> if you don't see it within a few minutes.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="session-msg" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}" id="reset-form">
                @csrf

                <div class="anim-item d4">
                    <label class="field-label" for="email">Email Address</label>
                    <div class="input-wrap">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="prem-input"
                            value="{{ old('email') }}"
                            placeholder="your@edflow.com"
                            required
                            autofocus
                            autocomplete="username"
                        >
                        <i class="fa-solid fa-envelope input-icon-left"></i>
                    </div>
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="anim-item d5">
                    <button type="submit" class="submit-btn" id="reset-btn">
                        <span>
                            <i class="fa-solid fa-paper-plane"></i>
                            Send Reset Link
                            <i class="fa-solid fa-arrow-right btn-icon"></i>
                        </span>
                    </button>
                </div>
            </form>

            <div class="login-link anim-item d6">
                Remembered it? <a href="{{ route('login') }}">Sign in instead →</a>
            </div>

        </div>
    </div>

</div>

<script>
    document.getElementById('reset-form')?.addEventListener('submit', function () {
        const btn = document.getElementById('reset-btn');
        btn.innerHTML = '<span><i class="fa-solid fa-circle-notch fa-spin"></i> Sending link…</span>';
        btn.style.opacity = '0.85';
        btn.disabled = true;
    });
</script>

</x-guest-layout>
