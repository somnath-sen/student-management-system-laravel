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

    /* ===== FULL SCREEN WRAPPER ===== */
    .login-wrapper {
        display: flex;
        min-height: 100vh;
        width: 100%;
        position: relative;
    }

    /* ===== LEFT PANEL — BRAND SIDE ===== */
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

    /* Animated gradient layer */
    .brand-panel::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            -45deg,
            #6366f1,
            #8b5cf6,
            #ec4899,
            #f43f5e,
            #f97316,
            #8b5cf6,
            #6366f1
        );
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

    /* Decorative animated rings */
    .ring {
        position: absolute;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.06);
        animation: ringPulse 6s ease-in-out infinite;
    }
    .ring-1 { width: 300px; height: 300px; top: -80px; left: -80px; animation-delay: 0s; }
    .ring-2 { width: 500px; height: 500px; top: -150px; left: -150px; animation-delay: 1s; border-color: rgba(139,92,246,0.12); }
    .ring-3 { width: 250px; height: 250px; bottom: -60px; right: -60px; animation-delay: 2s; border-color: rgba(236,72,153,0.12); }
    .ring-4 { width: 450px; height: 450px; bottom: -130px; right: -130px; animation-delay: 1.5s; }

    @keyframes ringPulse {
        0%, 100% { transform: scale(1); opacity: 0.6; }
        50%       { transform: scale(1.05); opacity: 1; }
    }

    /* Glowing orbs — CSS only, no particles */
    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        animation: orbFloat 8s ease-in-out infinite alternate;
        z-index: 0;
    }
    .orb-1 { width: 300px; height: 300px; background: rgba(99,102,241,0.45); top: 5%; left: 5%; animation-duration: 9s; }
    .orb-2 { width: 250px; height: 250px; background: rgba(236,72,153,0.35); bottom: 10%; right: 5%; animation-duration: 11s; animation-delay: 2s; }
    .orb-3 { width: 180px; height: 180px; background: rgba(249,115,22,0.3); top: 50%; left: 40%; animation-duration: 7s; animation-delay: 4s; }

    @keyframes orbFloat {
        from { transform: translateY(0px) translateX(0px); }
        to   { transform: translateY(-40px) translateX(20px); }
    }

    /* Brand content */
    .brand-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }

    .brand-logo {
        width: 80px; height: 80px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 28px;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.2rem;
        margin: 0 auto 2rem;
        backdrop-filter: blur(10px);
        box-shadow: 0 0 40px rgba(139,92,246,0.5), 0 20px 40px rgba(0,0,0,0.3);
        animation: logoBounce 3s ease-in-out infinite;
    }
    @keyframes logoBounce {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50%       { transform: translateY(-8px) rotate(3deg); }
    }

    .brand-name {
        font-size: 3rem;
        font-weight: 900;
        letter-spacing: -0.03em;
        line-height: 1;
        background: linear-gradient(90deg, #fff 0%, #c4b5fd 50%, #f9a8d4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.75rem;
    }

    .brand-tagline {
        font-size: 1rem;
        color: rgba(255,255,255,0.6);
        font-weight: 500;
        max-width: 280px;
        margin: 0 auto 3rem;
        line-height: 1.6;
    }

    /* Stats row */
    .stats-row {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    .stat-chip {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 16px;
        padding: 0.9rem 1.3rem;
        text-align: center;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        min-width: 90px;
    }
    .stat-chip:hover {
        background: rgba(255,255,255,0.15);
        transform: translateY(-4px);
        border-color: rgba(255,255,255,0.3);
    }
    .stat-chip .num {
        font-size: 1.6rem;
        font-weight: 900;
        color: white;
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    .stat-chip .lbl {
        font-size: 0.65rem;
        font-weight: 700;
        color: rgba(255,255,255,0.5);
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    /* Floating badge strip at bottom of left panel */
    .badge-strip {
        position: absolute;
        bottom: 2rem;
        left: 0; right: 0;
        display: flex;
        justify-content: center;
        gap: 0.6rem;
        flex-wrap: wrap;
        padding: 0 2rem;
        z-index: 1;
    }
    .badge-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 99px;
        padding: 0.35rem 0.9rem;
        font-size: 0.72rem;
        font-weight: 600;
        color: rgba(255,255,255,0.7);
        backdrop-filter: blur(6px);
    }
    .badge-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        animation: dotPulse 2s ease-in-out infinite;
    }
    @keyframes dotPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.5; transform: scale(0.7); }
    }

    /* ===== RIGHT PANEL — FORM SIDE ===== */
    .form-panel {
        width: 480px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 2.5rem;
        background: #f8faff;
        position: relative;
        overflow: hidden;
    }

    /* Subtle colorful top bar */
    .form-panel::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, #6366f1, #ec4899, #f97316, #6366f1);
        background-size: 200% 100%;
        animation: barSlide 3s linear infinite;
    }
    @keyframes barSlide {
        0%   { background-position: 0% 50%; }
        100% { background-position: 200% 50%; }
    }

    .form-inner {
        width: 100%;
        max-width: 380px;
        animation: slideInRight 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    /* Welcome heading */
    .form-heading {
        margin-bottom: 2.5rem;
    }
    .form-heading .label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #ede9fe, #fce7f3);
        border: 1px solid #ddd6fe;
        border-radius: 99px;
        padding: 0.3rem 0.85rem;
        font-size: 0.72rem;
        font-weight: 800;
        color: #7c3aed;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 1rem;
    }
    .form-heading h1 {
        font-size: 2rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.03em;
        line-height: 1.15;
        margin-bottom: 0.4rem;
    }
    .form-heading p {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 500;
    }

    /* ===== INPUTS ===== */
    .field-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 0.5rem;
    }
    .input-wrap {
        position: relative;
        margin-bottom: 1.25rem;
    }
    .input-icon-left {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.9rem;
        pointer-events: none;
        transition: color 0.3s;
        z-index: 1;
    }
    .prem-input {
        width: 100%;
        padding: 0.9rem 1rem 0.9rem 2.75rem;
        border-radius: 14px;
        border: 1.5px solid #e2e8f0;
        background: white;
        font-family: 'Outfit', sans-serif;
        font-size: 0.95rem;
        font-weight: 500;
        color: #0f172a;
        outline: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .prem-input::placeholder { color: #cbd5e1; }
    .prem-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99,102,241,0.12), 0 4px 12px rgba(99,102,241,0.1);
        transform: translateY(-1px);
    }
    .prem-input:focus + .input-icon-left,
    .input-wrap:focus-within .input-icon-left {
        color: #6366f1;
    }
    .pw-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #94a3b8;
        font-size: 0.9rem;
        transition: color 0.2s;
        padding: 4px;
    }
    .pw-toggle:hover { color: #6366f1; }

    /* ===== REMEMBER / FORGOT ===== */
    .row-opts {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.75rem;
    }
    .remember-label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
        user-select: none;
    }
    .custom-check {
        width: 18px; height: 18px;
        border: 2px solid #cbd5e1;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
        background: white;
    }
    .remember-label input[type=checkbox]:checked + .custom-check {
        background: #6366f1;
        border-color: #6366f1;
    }
    .remember-label input[type=checkbox]:checked + .custom-check::after {
        content: '';
        width: 9px; height: 5px;
        border-left: 2px solid white;
        border-bottom: 2px solid white;
        transform: rotate(-45deg) translateY(-1px);
    }
    .remember-label input[type=checkbox] { display: none; }
    .forgot-link {
        font-size: 0.82rem;
        font-weight: 700;
        color: #6366f1;
        text-decoration: none;
        transition: color 0.2s;
    }
    .forgot-link:hover { color: #4f46e5; text-decoration: underline; }

    /* ===== SUBMIT BTN ===== */
    .submit-btn {
        width: 100%;
        padding: 1rem;
        border: none;
        border-radius: 14px;
        font-family: 'Outfit', sans-serif;
        font-size: 1rem;
        font-weight: 800;
        color: white;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
        background-size: 200% 200%;
        background-position: 0% 50%;
        box-shadow: 0 10px 25px rgba(99,102,241,0.35);
    }
    .submit-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #4f46e5, #7c3aed, #db2777);
        opacity: 0;
        transition: opacity 0.3s;
    }
    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 35px rgba(99,102,241,0.45);
    }
    .submit-btn:hover::before { opacity: 1; }
    .submit-btn:active { transform: translateY(0) scale(0.98); }
    .submit-btn span {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-arrow {
        transition: transform 0.3s;
        font-size: 0.85rem;
    }
    .submit-btn:hover .btn-arrow { transform: translateX(4px); }

    /* Divider */
    .divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 1.5rem 0;
        color: #cbd5e1;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .divider::before, .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    /* Role chips */
    .role-chips {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .role-chip {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        padding: 0.7rem 0.5rem;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        background: white;
        cursor: pointer;
        font-size: 0.7rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        transition: all 0.25s ease;
        user-select: none;
    }
    .role-chip i { font-size: 1.1rem; }
    .role-chip.student { --chip-color: #6366f1; }
    .role-chip.teacher { --chip-color: #ec4899; }
    .role-chip.admin   { --chip-color: #f97316; }
    .role-chip.parent  { --chip-color: #10b981; }
    .role-chip:hover {
        border-color: var(--chip-color);
        color: var(--chip-color);
        background: rgba(from var(--chip-color), 0.05);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .role-chip.active {
        border-color: var(--chip-color);
        background: var(--chip-color);
        color: white;
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }

    /* Sign up row */
    .signup-row {
        text-align: center;
        margin-top: 1.75rem;
        font-size: 0.88rem;
        font-weight: 600;
        color: #64748b;
    }
    .signup-row a {
        color: #6366f1;
        font-weight: 800;
        text-decoration: none;
        transition: color 0.2s;
    }
    .signup-row a:hover { color: #4f46e5; text-decoration: underline; }

    /* Error messages */
    .field-error { color: #f43f5e; font-size: 0.75rem; font-weight: 700; margin-top: 4px; }

    /* Session status */
    .session-msg {
        background: #f0fdf4;
        border: 1px solid #86efac;
        color: #166534;
        font-weight: 700;
        font-size: 0.85rem;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.25rem;
        text-align: center;
    }

    /* Stagger animations */
    .anim-item {
        opacity: 0;
        animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .d1 { animation-delay: 0.1s; }
    .d2 { animation-delay: 0.2s; }
    .d3 { animation-delay: 0.3s; }
    .d4 { animation-delay: 0.4s; }
    .d5 { animation-delay: 0.5s; }
    .d6 { animation-delay: 0.6s; }

    /* Responsive */
    @media (max-width: 768px) {
        .brand-panel { display: none; }
        .form-panel { width: 100%; padding: 2rem 1.5rem; }
    }
</style>

<div class="login-wrapper">

    <!-- ===================== LEFT: BRAND PANEL ===================== -->
    <div class="brand-panel">
        <!-- CSS Orbs, no particles -->
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <!-- Decorative rings -->
        <div class="ring ring-1"></div>
        <div class="ring ring-2"></div>
        <div class="ring ring-3"></div>
        <div class="ring ring-4"></div>

        <!-- Brand content -->
        <div class="brand-content">
            <div class="brand-logo">
                <i class="fa-solid fa-graduation-cap" style="color:white;"></i>
            </div>
            <div class="brand-name">EdFlow</div>
            <p class="brand-tagline">The smart campus management platform for modern institutions.</p>

            <div class="stats-row">
                <div class="stat-chip">
                    <div class="num">12K+</div>
                    <div class="lbl">Students</div>
                </div>
                <div class="stat-chip">
                    <div class="num">500+</div>
                    <div class="lbl">Teachers</div>
                </div>
                <div class="stat-chip">
                    <div class="num">98%</div>
                    <div class="lbl">Satisfaction</div>
                </div>
            </div>
        </div>

        <!-- Bottom badge strip -->
        <div class="badge-strip">
            <div class="badge-chip">
                <span class="badge-dot" style="background:#4ade80;"></span> Live Analytics
            </div>
            <div class="badge-chip">
                <span class="badge-dot" style="background:#818cf8;"></span> Gamification
            </div>
            <div class="badge-chip">
                <span class="badge-dot" style="background:#f472b6;"></span> Smart Results
            </div>
            <div class="badge-chip">
                <span class="badge-dot" style="background:#fb923c;"></span> Fee Tracking
            </div>
        </div>
    </div>

    <!-- ===================== RIGHT: FORM PANEL ===================== -->
    <div class="form-panel">
        <div class="form-inner">

            <!-- Heading -->
            <div class="form-heading anim-item d1">
                <div class="label">
                    <i class="fa-solid fa-shield-halved"></i> Secure Login
                </div>
                <h1>Welcome Back! 👋</h1>
                <p>Sign in to access your EdFlow Dashboard.</p>
            </div>

            <!-- Role selector chips -->
            <div class="role-chips anim-item d2" id="role-chips">
                <div class="role-chip student" onclick="selectRole('student',this)">
                    <i class="fa-solid fa-user-graduate" style="color:inherit;"></i>
                    Student
                </div>
                <div class="role-chip teacher" onclick="selectRole('teacher',this)">
                    <i class="fa-solid fa-chalkboard-user" style="color:inherit;"></i>
                    Teacher
                </div>
                <div class="role-chip admin" onclick="selectRole('admin',this)">
                    <i class="fa-solid fa-user-shield" style="color:inherit;"></i>
                    Admin
                </div>
                <div class="role-chip parent" onclick="selectRole('parent',this)">
                    <i class="fa-solid fa-user-group" style="color:inherit;"></i>
                    Parent
                </div>
            </div>

            <!-- Session status -->
            <x-auth-session-status class="session-msg" :status="session('status')" />

            <!-- FORM -->
            <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf

                <!-- Email -->
                <div class="anim-item d3">
                    <label class="field-label">Email Address</label>
                    <div class="input-wrap">
                        <input id="email" type="email" name="email" class="prem-input" value="{{ old('email') }}"
                               placeholder="you@edflow.com" required autofocus autocomplete="username">
                        <i class="fa-solid fa-envelope input-icon-left"></i>
                    </div>
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="anim-item d4" style="margin-top: 0.25rem;">
                    <label class="field-label">Password</label>
                    <div class="input-wrap">
                        <input id="password" type="password" name="password" class="prem-input" id="pw-field"
                               placeholder="••••••••••" required autocomplete="current-password"
                               style="padding-right: 3rem;">
                        <i class="fa-solid fa-lock input-icon-left"></i>
                        <button type="button" class="pw-toggle" onclick="togglePw()" id="pw-btn">
                            <i class="fa-regular fa-eye" id="pw-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember / forgot -->
                <div class="row-opts anim-item d5" style="margin-top: 0.75rem;">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember_me">
                        <div class="custom-check"></div>
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <!-- Submit -->
                <div class="anim-item d6">
                    <button type="submit" class="submit-btn" id="login-btn">
                        <span>
                            Log in to Dashboard
                            <i class="fa-solid fa-arrow-right btn-arrow"></i>
                        </span>
                    </button>
                </div>
            </form>

            <!-- Sign up -->
            <div class="signup-row anim-item d6">
                New to EdFlow? <a href="/register/student">Apply as Student →</a>
            </div>

        </div>
    </div>

</div>

<script>
    // Password visibility toggle
    function togglePw() {
        const field = document.getElementById('pw-field') ?? document.getElementById('password');
        const eye   = document.getElementById('pw-eye');
        if (!field) return;
        if (field.type === 'password') {
            field.type = 'text';
            eye.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            field.type = 'password';
            eye.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Role chip selector — purely cosmetic to indicate intent
    function selectRole(role, el) {
        document.querySelectorAll('.role-chip').forEach(c => c.classList.remove('active'));
        el.classList.add('active');
        // Prefill placeholder hint
        const placeholders = {
            student: 'student@edflow.com',
            teacher: 'teacher@edflow.com',
            admin:   'admin@edflow.com',
            parent:  'parent@edflow.com',
        };
        const emailInput = document.getElementById('email');
        if (emailInput && !emailInput.value) {
            emailInput.placeholder = placeholders[role] ?? 'you@edflow.com';
        }
    }

    // Submit button loading state
    document.getElementById('login-form')?.addEventListener('submit', function () {
        const btn = document.getElementById('login-btn');
        btn.innerHTML = '<span><i class="fa-solid fa-circle-notch fa-spin"></i> Signing in…</span>';
        btn.style.opacity = '0.85';
        btn.disabled = true;
    });
</script>

</x-guest-layout>