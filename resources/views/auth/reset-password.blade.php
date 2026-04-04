<x-guest-layout>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Outfit', sans-serif; min-height: 100vh; overflow: hidden; }

    .rp-wrapper { display: flex; min-height: 100vh; width: 100%; }

    /* ===== LEFT BRAND PANEL ===== */
    .brand-panel {
        flex: 1; position: relative;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        padding: 3rem; overflow: hidden;
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
    }
    .brand-panel::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(-45deg, #6366f1, #8b5cf6, #ec4899, #f43f5e, #f97316, #8b5cf6, #6366f1);
        background-size: 400% 400%; animation: gradientShift 10s ease infinite; opacity: 0.18; z-index: 0;
    }
    @keyframes gradientShift { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }

    .ring { position: absolute; border-radius: 50%; border: 2px solid rgba(255,255,255,0.06); animation: ringPulse 6s ease-in-out infinite; }
    .ring-1 { width: 320px; height: 320px; top:-100px; left:-100px; }
    .ring-2 { width: 520px; height: 520px; top:-180px; left:-180px; animation-delay:1s; border-color:rgba(139,92,246,0.12); }
    .ring-3 { width: 260px; height: 260px; bottom:-80px; right:-80px; animation-delay:2s; border-color:rgba(236,72,153,0.12); }
    .ring-4 { width: 460px; height: 460px; bottom:-160px; right:-160px; animation-delay:1.5s; }
    @keyframes ringPulse { 0%,100%{transform:scale(1);opacity:.6} 50%{transform:scale(1.05);opacity:1} }

    .orb { position: absolute; border-radius: 50%; filter: blur(60px); animation: orbFloat 8s ease-in-out infinite alternate; z-index: 0; }
    .orb-1 { width:300px;height:300px;background:rgba(99,102,241,0.45);top:5%;left:5%;animation-duration:9s; }
    .orb-2 { width:250px;height:250px;background:rgba(236,72,153,0.35);bottom:10%;right:5%;animation-duration:11s;animation-delay:2s; }
    .orb-3 { width:170px;height:170px;background:rgba(52,211,153,0.28);top:50%;left:40%;animation-duration:7s;animation-delay:4s; }
    @keyframes orbFloat { from{transform:translateY(0) translateX(0)} to{transform:translateY(-40px) translateX(18px)} }

    .brand-content { position: relative; z-index: 1; text-align: center; color: white; }

    /* Shield lock icon */
    .shield-icon-wrap {
        width: 90px; height: 90px;
        background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
        border-radius: 32px; display: flex; align-items: center; justify-content: center;
        font-size: 2.4rem; margin: 0 auto 1.5rem;
        backdrop-filter: blur(10px);
        box-shadow: 0 0 40px rgba(52,211,153,0.45), 0 20px 40px rgba(0,0,0,0.3);
        animation: shieldPulse 3s ease-in-out infinite;
    }
    @keyframes shieldPulse {
        0%,100%{transform:scale(1);box-shadow:0 0 30px rgba(52,211,153,0.4);}
        50%{transform:scale(1.08);box-shadow:0 0 60px rgba(99,102,241,0.5);}
    }

    .brand-name { font-size:2.8rem;font-weight:900;letter-spacing:-0.03em; background:linear-gradient(90deg,#fff 0%,#a5f3fc 50%,#c4b5fd 100%); -webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:0.5rem; }
    .brand-sub { font-size:1.1rem;font-weight:700;color:rgba(255,255,255,0.55);margin-bottom:0.5rem; }
    .brand-tagline { font-size:0.88rem;color:rgba(255,255,255,0.4);max-width:270px;margin:0 auto 2.5rem;line-height:1.7; }

    /* Security tips */
    .tips-list { display:flex;flex-direction:column;gap:0.85rem;align-items:flex-start;max-width:280px;margin:0 auto; }
    .tip-item {
        display:flex;align-items:center;gap:12px;
        background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);
        border-radius:14px;padding:0.75rem 1rem;width:100%;
        transition:all 0.3s;
    }
    .tip-item:hover { background:rgba(255,255,255,0.13);transform:translateX(4px); }
    .tip-icon { font-size:1rem;width:32px;height:32px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .tip-text { font-size:0.8rem;font-weight:600;color:rgba(255,255,255,0.7);line-height:1.4; }

    /* Password strength indicator in side */
    .strength-preview {
        display:flex;gap:4px;margin-top:2rem;justify-content:center;
    }
    .strength-bar { width:36px;height:5px;border-radius:99px;background:rgba(255,255,255,0.15); }
    .strength-bar.s1 { background:#f43f5e; }
    .strength-bar.s2 { background:#f97316; }
    .strength-bar.s3 { background:#fbbf24; }
    .strength-bar.s4 { background:#34d399; }

    .badge-strip {
        position:absolute;bottom:2rem;left:0;right:0;
        display:flex;justify-content:center;gap:0.6rem;flex-wrap:wrap;padding:0 2rem;z-index:1;
    }
    .badge-chip {
        display:inline-flex;align-items:center;gap:6px;
        background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);
        border-radius:99px;padding:0.35rem 0.9rem;
        font-size:0.72rem;font-weight:600;color:rgba(255,255,255,0.65);
    }
    .badge-dot { width:6px;height:6px;border-radius:50%;animation:dotPulse 2s ease-in-out infinite; }
    @keyframes dotPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.7)} }

    /* ===== RIGHT FORM PANEL ===== */
    .form-panel {
        width:520px;flex-shrink:0;
        display:flex;flex-direction:column;align-items:center;justify-content:center;
        padding:2.5rem;background:#f8faff;position:relative;overflow:hidden;
    }
    .form-panel::before {
        content:'';position:absolute;top:0;left:0;right:0;height:4px;
        background:linear-gradient(90deg,#6366f1,#ec4899,#34d399,#6366f1);
        background-size:200% 100%;animation:barSlide 3s linear infinite;
    }
    @keyframes barSlide { 0%{background-position:0% 50%} 100%{background-position:200% 50%} }

    .form-inner { width:100%;max-width:400px;animation:slideIn .7s cubic-bezier(.22,1,.36,1) forwards; }
    @keyframes slideIn { from{opacity:0;transform:translateX(30px)} to{opacity:1;transform:translateX(0)} }

    .back-link {
        display:inline-flex;align-items:center;gap:7px;
        font-size:0.82rem;font-weight:700;color:#6366f1;text-decoration:none;
        margin-bottom:1.75rem;padding:0.4rem 0.8rem;
        background:rgba(99,102,241,0.08);border-radius:99px;border:1px solid rgba(99,102,241,0.2);
        transition:all 0.2s;
    }
    .back-link:hover { background:rgba(99,102,241,0.15);transform:translateX(-3px); }

    .form-heading { margin-bottom:1.75rem; }
    .form-heading .badge {
        display:inline-flex;align-items:center;gap:6px;
        background:linear-gradient(135deg,#d1fae5,#a7f3d0);
        border:1px solid #6ee7b7;border-radius:99px;
        padding:0.3rem 0.85rem;font-size:0.72rem;font-weight:800;color:#065f46;
        text-transform:uppercase;letter-spacing:0.1em;margin-bottom:1rem;
    }
    .form-heading h1 { font-size:1.9rem;font-weight:900;color:#0f172a;letter-spacing:-0.03em;line-height:1.2;margin-bottom:0.4rem; }
    .form-heading p { font-size:0.88rem;color:#64748b;font-weight:500; }

    /* Field */
    .field-label { display:block;font-size:0.72rem;font-weight:800;color:#475569;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:0.5rem; }
    .input-wrap { position:relative;margin-bottom:1.1rem; }
    .input-icon-left { position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:0.9rem;pointer-events:none;transition:color .3s;z-index:1; }
    .prem-input {
        width:100%;padding:0.9rem 1rem 0.9rem 2.75rem;
        border-radius:14px;border:1.5px solid #e2e8f0;
        background:white;font-family:'Outfit',sans-serif;
        font-size:0.95rem;font-weight:500;color:#0f172a;outline:none;
        transition:all .3s cubic-bezier(.4,0,.2,1);box-shadow:0 1px 3px rgba(0,0,0,0.04);
    }
    .prem-input::placeholder { color:#cbd5e1; }
    .prem-input:focus { border-color:#6366f1;box-shadow:0 0 0 4px rgba(99,102,241,.12),0 4px 12px rgba(99,102,241,.08);transform:translateY(-1px); }
    .input-wrap:focus-within .input-icon-left { color:#6366f1; }
    .pw-toggle { position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;font-size:0.9rem;padding:4px;transition:color .2s; }
    .pw-toggle:hover { color:#6366f1; }
    .field-error { color:#f43f5e;font-size:0.75rem;font-weight:700;margin-top:4px;margin-bottom:8px; }

    /* Strength meter */
    .strength-meter { margin-bottom:1.1rem; }
    .meter-track { display:flex;gap:4px;margin-top:8px;margin-bottom:4px; }
    .meter-seg { flex:1;height:4px;border-radius:99px;background:#e2e8f0;transition:background .3s; }
    .meter-seg.weak   { background:#f43f5e; }
    .meter-seg.fair   { background:#f97316; }
    .meter-seg.good   { background:#fbbf24; }
    .meter-seg.strong { background:#34d399; }
    .meter-label { font-size:0.72rem;font-weight:700;color:#94a3b8;text-align:right; }

    /* Submit */
    .submit-btn {
        width:100%;padding:1rem;border:none;border-radius:14px;
        font-family:'Outfit',sans-serif;font-size:1rem;font-weight:800;color:white;
        cursor:pointer;position:relative;overflow:hidden;
        transition:all .3s cubic-bezier(.25,1,.5,1);
        background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 50%,#34d399 100%);
        box-shadow:0 10px 25px rgba(99,102,241,.35);
    }
    .submit-btn::before { content:'';position:absolute;inset:0;background:linear-gradient(135deg,#4f46e5,#7c3aed,#059669);opacity:0;transition:opacity .3s; }
    .submit-btn:hover { transform:translateY(-2px);box-shadow:0 16px 35px rgba(99,102,241,.45); }
    .submit-btn:hover::before { opacity:1; }
    .submit-btn:active { transform:translateY(0) scale(.98); }
    .submit-btn span { position:relative;z-index:1;display:flex;align-items:center;justify-content:center;gap:8px; }
    .btn-icon { transition:transform .3s; }
    .submit-btn:hover .btn-icon { transform:translateX(4px); }

    .bottom-link { text-align:center;margin-top:1.25rem;font-size:0.88rem;font-weight:600;color:#64748b; }
    .bottom-link a { color:#6366f1;font-weight:800;text-decoration:none; }
    .bottom-link a:hover { text-decoration:underline; }

    .anim-item { opacity:0;animation:fadeUp .6s cubic-bezier(.22,1,.36,1) forwards; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
    .d1{animation-delay:.05s} .d2{animation-delay:.15s} .d3{animation-delay:.25s}
    .d4{animation-delay:.35s} .d5{animation-delay:.45s} .d6{animation-delay:.55s} .d7{animation-delay:.65s}

    @media(max-width:768px){ .brand-panel{display:none} .form-panel{width:100%;padding:2rem 1.5rem} }
</style>

<div class="rp-wrapper">

    <!-- ===== LEFT BRAND PANEL ===== -->
    <div class="brand-panel">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="ring ring-1"></div>
        <div class="ring ring-2"></div>
        <div class="ring ring-3"></div>
        <div class="ring ring-4"></div>

        <div class="brand-content">
            <div class="shield-icon-wrap">
                <i class="fa-solid fa-shield-halved" style="color:white;"></i>
            </div>
            <div class="brand-name">EdFlow</div>
            <div class="brand-sub">Set New Password</div>
            <p class="brand-tagline">Create a strong, unique password to keep your account safe and secure.</p>

            <div class="tips-list">
                <div class="tip-item">
                    <div class="tip-icon" style="background:rgba(99,102,241,0.25)"><i class="fa-solid fa-check" style="color:#a5b4fc;font-size:.8rem;"></i></div>
                    <div class="tip-text">At least 8 characters long</div>
                </div>
                <div class="tip-item">
                    <div class="tip-icon" style="background:rgba(236,72,153,0.25)"><i class="fa-solid fa-check" style="color:#f9a8d4;font-size:.8rem;"></i></div>
                    <div class="tip-text">Mix uppercase, lowercase &amp; numbers</div>
                </div>
                <div class="tip-item">
                    <div class="tip-icon" style="background:rgba(52,211,153,0.25)"><i class="fa-solid fa-check" style="color:#6ee7b7;font-size:.8rem;"></i></div>
                    <div class="tip-text">Add a special character (!@#$)</div>
                </div>
                <div class="tip-item">
                    <div class="tip-icon" style="background:rgba(251,191,36,0.25)"><i class="fa-solid fa-check" style="color:#fde68a;font-size:.8rem;"></i></div>
                    <div class="tip-text">Avoid using your name or email</div>
                </div>
            </div>

            <div class="strength-preview">
                <div class="strength-bar s1"></div>
                <div class="strength-bar s2"></div>
                <div class="strength-bar s3"></div>
                <div class="strength-bar s4"></div>
            </div>
        </div>

        <div class="badge-strip">
            <div class="badge-chip"><span class="badge-dot" style="background:#4ade80;"></span>256-bit Encrypted</div>
            <div class="badge-chip"><span class="badge-dot" style="background:#818cf8;"></span>Secure Reset</div>
            <div class="badge-chip"><span class="badge-dot" style="background:#f472b6;"></span>Protected Account</div>
        </div>
    </div>

    <!-- ===== RIGHT FORM PANEL ===== -->
    <div class="form-panel">
        <div class="form-inner">

            <a href="{{ route('login') }}" class="back-link anim-item d1">
                <i class="fa-solid fa-arrow-left"></i> Back to Login
            </a>

            <div class="form-heading anim-item d2">
                <div class="badge"><i class="fa-solid fa-lock-open"></i> New Password</div>
                <h1>Reset your<br>password 🔐</h1>
                <p>Choose a strong new password for your EdFlow account.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" id="reset-form" class="{{ $errors->any() ? 'animate-shake' : '' }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- Email --}}
                <div class="anim-item d3">
                    <label class="field-label">Email Address</label>
                    <div class="input-wrap">
                        <input id="email" type="email" name="email" class="prem-input"
                               value="{{ old('email', $request->email) }}"
                               placeholder="your@edflow.com" required autofocus autocomplete="username">
                        <i class="fa-solid fa-envelope input-icon-left"></i>
                    </div>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- New Password --}}
                <div class="anim-item d4">
                    <label class="field-label">New Password</label>
                    <div class="input-wrap">
                        <input id="password" type="password" name="password" class="prem-input"
                               placeholder="Min. 8 characters" required autocomplete="new-password"
                               style="padding-right:3rem;" oninput="checkStrength(this.value)">
                        <i class="fa-solid fa-lock input-icon-left"></i>
                        <button type="button" class="pw-toggle" onclick="togglePw('password','eye1')">
                            <i class="fa-regular fa-eye" id="eye1"></i>
                        </button>
                    </div>
                    {{-- Strength meter --}}
                    <div class="strength-meter">
                        <div class="meter-track">
                            <div class="meter-seg" id="seg1"></div>
                            <div class="meter-seg" id="seg2"></div>
                            <div class="meter-seg" id="seg3"></div>
                            <div class="meter-seg" id="seg4"></div>
                        </div>
                        <div class="meter-label" id="strength-label">Enter a password</div>
                    </div>
                    @error('password')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                {{-- Confirm Password --}}
                <div class="anim-item d5">
                    <label class="field-label">Confirm Password</label>
                    <div class="input-wrap">
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               class="prem-input" placeholder="Re-enter new password"
                               required autocomplete="new-password" style="padding-right:3rem;">
                        <i class="fa-solid fa-shield-check input-icon-left"></i>
                        <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation','eye2')">
                            <i class="fa-regular fa-eye" id="eye2"></i>
                        </button>
                    </div>
                    @error('password_confirmation')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="anim-item d6">
                    <button type="submit" class="submit-btn" id="submit-btn">
                        <span>
                            <i class="fa-solid fa-check-circle"></i>
                            Reset Password
                            <i class="fa-solid fa-arrow-right btn-icon"></i>
                        </span>
                    </button>
                </div>
            </form>

            <div class="bottom-link anim-item d7">
                Remembered it? <a href="{{ route('login') }}">Sign in instead →</a>
            </div>

        </div>
    </div>

</div>

<script>
    function togglePw(fieldId, eyeId) {
        const f = document.getElementById(fieldId);
        const e = document.getElementById(eyeId);
        if (!f) return;
        f.type = f.type === 'password' ? 'text' : 'password';
        e.classList.toggle('fa-eye'); e.classList.toggle('fa-eye-slash');
    }

    function checkStrength(val) {
        const segs  = ['seg1','seg2','seg3','seg4'];
        const label = document.getElementById('strength-label');
        const classes = ['weak','fair','good','strong'];
        const labels  = ['Too weak','Fair','Good','Strong 🔒'];
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        segs.forEach((id, i) => {
            const el = document.getElementById(id);
            el.className = 'meter-seg';
            if (i < score) el.classList.add(classes[score - 1]);
        });
        label.textContent = val.length === 0 ? 'Enter a password' : labels[score - 1] ?? 'Too weak';
    }

    document.getElementById('reset-form')?.addEventListener('submit', function () {
        const btn = document.getElementById('submit-btn');
        btn.innerHTML = '<span><i class="fa-solid fa-circle-notch fa-spin"></i> Resetting…</span>';
        btn.style.opacity = '0.85'; btn.disabled = true;
    });
</script>

</x-guest-layout>