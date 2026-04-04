<x-guest-layout>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Outfit', sans-serif; min-height: 100vh; overflow: hidden; }

    .ve-wrapper { display: flex; min-height: 100vh; width: 100%; }

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

    .ring { position:absolute;border-radius:50%;border:2px solid rgba(255,255,255,.06);animation:ringPulse 6s ease-in-out infinite; }
    .ring-1{width:320px;height:320px;top:-100px;left:-100px}
    .ring-2{width:520px;height:520px;top:-180px;left:-180px;animation-delay:1s;border-color:rgba(139,92,246,.12)}
    .ring-3{width:260px;height:260px;bottom:-80px;right:-80px;animation-delay:2s;border-color:rgba(236,72,153,.12)}
    .ring-4{width:460px;height:460px;bottom:-160px;right:-160px;animation-delay:1.5s}
    @keyframes ringPulse{0%,100%{transform:scale(1);opacity:.6}50%{transform:scale(1.05);opacity:1}}

    .orb{position:absolute;border-radius:50%;filter:blur(60px);animation:orbFloat 8s ease-in-out infinite alternate;z-index:0}
    .orb-1{width:300px;height:300px;background:rgba(99,102,241,.45);top:5%;left:5%;animation-duration:9s}
    .orb-2{width:250px;height:250px;background:rgba(236,72,153,.35);bottom:10%;right:5%;animation-duration:11s;animation-delay:2s}
    .orb-3{width:170px;height:170px;background:rgba(251,191,36,.28);top:50%;left:40%;animation-duration:7s;animation-delay:4s}
    @keyframes orbFloat{from{transform:translateY(0) translateX(0)}to{transform:translateY(-40px) translateX(18px)}}

    .brand-content{position:relative;z-index:1;text-align:center;color:white}

    /* Animated envelope icon */
    .envelope-wrap {
        width:90px;height:90px;
        background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);
        border-radius:32px;display:flex;align-items:center;justify-content:center;
        font-size:2.5rem;margin:0 auto 1.5rem;
        backdrop-filter:blur(10px);
        box-shadow:0 0 40px rgba(236,72,153,.4),0 20px 40px rgba(0,0,0,.3);
        animation:envelopeBounce 2.5s ease-in-out infinite;
    }
    @keyframes envelopeBounce {
        0%,100%{transform:translateY(0) rotate(-3deg);}
        50%{transform:translateY(-10px) rotate(3deg);}
    }

    /* Open envelope flap animation helper */
    .flap-icon { transition: transform .4s; display:inline-block; }

    .brand-name{font-size:2.8rem;font-weight:900;letter-spacing:-.03em;background:linear-gradient(90deg,#fff 0%,#fbcfe8 50%,#c4b5fd 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:.5rem}
    .brand-sub{font-size:1.1rem;font-weight:700;color:rgba(255,255,255,.55);margin-bottom:.5rem}
    .brand-tagline{font-size:.88rem;color:rgba(255,255,255,.4);max-width:270px;margin:0 auto 2.5rem;line-height:1.7}

    /* Timeline steps */
    .timeline{display:flex;flex-direction:column;gap:0;align-items:flex-start;max-width:270px;margin:0 auto;position:relative}
    .timeline::before{content:'';position:absolute;left:15px;top:20px;bottom:20px;width:2px;background:linear-gradient(to bottom,rgba(139,92,246,.5),rgba(236,72,153,.5));border-radius:99px}
    .tl-item{display:flex;align-items:flex-start;gap:14px;padding:.65rem 0;position:relative;z-index:1}
    .tl-dot{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:900;flex-shrink:0;box-shadow:0 0 12px rgba(0,0,0,.3)}
    .tl-text{font-size:.82rem;font-weight:600;color:rgba(255,255,255,.7);line-height:1.4;padding-top:6px}

    .badge-strip{position:absolute;bottom:2rem;left:0;right:0;display:flex;justify-content:center;gap:.6rem;flex-wrap:wrap;padding:0 2rem;z-index:1}
    .badge-chip{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:99px;padding:.35rem .9rem;font-size:.72rem;font-weight:600;color:rgba(255,255,255,.65)}
    .badge-dot{width:6px;height:6px;border-radius:50%;animation:dotPulse 2s ease-in-out infinite}
    @keyframes dotPulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.7)}}

    /* ===== RIGHT PANEL ===== */
    .form-panel{
        width:500px;flex-shrink:0;
        display:flex;flex-direction:column;align-items:center;justify-content:center;
        padding:2.5rem;background:#f8faff;position:relative;overflow:hidden;
    }
    .form-panel::before{
        content:'';position:absolute;top:0;left:0;right:0;height:4px;
        background:linear-gradient(90deg,#6366f1,#ec4899,#fbbf24,#6366f1);
        background-size:200% 100%;animation:barSlide 3s linear infinite;
    }
    @keyframes barSlide{0%{background-position:0% 50%}100%{background-position:200% 50%}}

    .form-inner{width:100%;max-width:390px;animation:slideIn .7s cubic-bezier(.22,1,.36,1) forwards}
    @keyframes slideIn{from{opacity:0;transform:translateX(30px)}to{opacity:1;transform:translateX(0)}}

    /* Main verify card */
    .verify-card{
        background:white;border-radius:24px;padding:2.5rem;
        border:1.5px solid #e2e8f0;
        box-shadow:0 20px 50px rgba(99,102,241,.08),0 4px 12px rgba(0,0,0,.04);
        text-align:center;margin-bottom:1.5rem;position:relative;overflow:hidden;
    }
    .verify-card::before{
        content:'';position:absolute;top:0;left:0;right:0;height:3px;
        background:linear-gradient(90deg,#6366f1,#ec4899,#fbbf24);
    }

    .envelope-big{
        width:80px;height:80px;border-radius:24px;
        background:linear-gradient(135deg,#ede9fe,#fce7f3);
        border:2px solid #ddd6fe;
        display:flex;align-items:center;justify-content:center;
        font-size:2rem;margin:0 auto 1.5rem;
        animation:bigBounce 2.5s ease-in-out infinite;
        box-shadow:0 8px 24px rgba(139,92,246,.2);
    }
    @keyframes bigBounce{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}

    .verify-title{font-size:1.6rem;font-weight:900;color:#0f172a;letter-spacing:-.02em;margin-bottom:.5rem}
    .verify-desc{font-size:.88rem;color:#64748b;line-height:1.7;font-weight:500;max-width:300px;margin:0 auto}

    /* Success alert */
    .success-alert{
        display:flex;gap:10px;align-items:flex-start;
        background:linear-gradient(135deg,rgba(240,253,244,1),rgba(236,253,245,1));
        border:1.5px solid #86efac;border-radius:14px;
        padding:1rem;margin-bottom:1.25rem;text-align:left;
    }
    .success-alert i{color:#16a34a;font-size:1rem;margin-top:1px;flex-shrink:0}
    .success-alert p{font-size:.83rem;color:#166534;font-weight:600;line-height:1.5}

    /* Resend button */
    .resend-btn{
        width:100%;padding:1rem;border:none;border-radius:14px;
        font-family:'Outfit',sans-serif;font-size:1rem;font-weight:800;color:white;cursor:pointer;
        position:relative;overflow:hidden;transition:all .3s cubic-bezier(.25,1,.5,1);
        background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 50%,#ec4899 100%);
        box-shadow:0 10px 25px rgba(99,102,241,.35);
    }
    .resend-btn::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,#4f46e5,#7c3aed,#db2777);opacity:0;transition:opacity .3s}
    .resend-btn:hover{transform:translateY(-2px);box-shadow:0 16px 35px rgba(99,102,241,.45)}
    .resend-btn:hover::before{opacity:1}
    .resend-btn:active{transform:scale(.98)}
    .resend-btn span{position:relative;z-index:1;display:flex;align-items:center;justify-content:center;gap:8px}
    .btn-icon-r{transition:transform .3s}
    .resend-btn:hover .btn-icon-r{transform:translateX(3px)}

    /* Logout btn */
    .logout-btn{
        width:100%;padding:.8rem;border:1.5px solid #fecaca;border-radius:14px;
        background:rgba(254,242,242,1);font-family:'Outfit',sans-serif;
        font-size:.88rem;font-weight:700;color:#dc2626;cursor:pointer;
        display:flex;align-items:center;justify-content:center;gap:8px;
        transition:all .25s;margin-top:.75rem;
    }
    .logout-btn:hover{background:#fee2e2;border-color:#fca5a5;transform:translateY(-1px)}

    /* Tips row */
    .tips-row{display:grid;grid-template-columns:1fr 1fr;gap:.6rem;margin-top:.75rem}
    .tip-chip{
        display:flex;align-items:center;gap:8px;
        background:#f8faff;border:1px solid #e2e8f0;border-radius:12px;padding:.6rem .8rem;
        font-size:.73rem;font-weight:600;color:#475569;
    }
    .tip-chip i{font-size:.8rem}

    .anim-item{opacity:0;animation:fadeUp .6s cubic-bezier(.22,1,.36,1) forwards}
    @keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
    .d1{animation-delay:.05s}.d2{animation-delay:.15s}.d3{animation-delay:.25s}
    .d4{animation-delay:.35s}.d5{animation-delay:.45s}.d6{animation-delay:.55s}

    @media(max-width:768px){.brand-panel{display:none}.form-panel{width:100%;padding:2rem 1.5rem}}
</style>

<div class="ve-wrapper">

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
            <div class="envelope-wrap">
                <i class="fa-solid fa-envelope-open-text" style="color:white;"></i>
            </div>
            <div class="brand-name">EdFlow</div>
            <div class="brand-sub">Email Verification</div>
            <p class="brand-tagline">One quick step to confirm your identity and unlock full access to your campus dashboard.</p>

            <!-- Timeline -->
            <div class="timeline">
                <div class="tl-item">
                    <div class="tl-dot" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">1</div>
                    <div class="tl-text">Check your registered email inbox</div>
                </div>
                <div class="tl-item">
                    <div class="tl-dot" style="background:linear-gradient(135deg,#ec4899,#f43f5e);">2</div>
                    <div class="tl-text">Click the verification link we sent you</div>
                </div>
                <div class="tl-item">
                    <div class="tl-dot" style="background:linear-gradient(135deg,#fbbf24,#f97316);">3</div>
                    <div class="tl-text">Get instant access to your EdFlow dashboard</div>
                </div>
            </div>
        </div>

        <div class="badge-strip">
            <div class="badge-chip"><span class="badge-dot" style="background:#4ade80;"></span>Secure Verification</div>
            <div class="badge-chip"><span class="badge-dot" style="background:#818cf8;"></span>Link expires in 60 min</div>
            <div class="badge-chip"><span class="badge-dot" style="background:#fbbf24;"></span>Check spam folder</div>
        </div>
    </div>

    <!-- ===== RIGHT PANEL ===== -->
    <div class="form-panel">
        <div class="form-inner">

            <!-- Main card -->
            <div class="verify-card anim-item d1">
                <div class="envelope-big">✉️</div>
                <div class="verify-title">Check your inbox! 📬</div>
                <p class="verify-desc">
                    Thanks for joining EdFlow! We've sent a verification link to your email address. Please click it to activate your account.
                </p>
            </div>

            <!-- Success alert -->
            @if (session('status') == 'verification-link-sent')
                <div class="success-alert anim-item d2">
                    <i class="fa-solid fa-circle-check"></i>
                    <p>A fresh verification link has been sent to your registered email address. Please check your inbox (and spam folder).</p>
                </div>
            @endif

            <!-- Resend form -->
            <form method="POST" action="{{ route('verification.send') }}" id="resend-form" class="anim-item d3">
                @csrf
                <button type="submit" class="resend-btn" id="resend-btn">
                    <span>
                        <i class="fa-solid fa-paper-plane"></i>
                        Resend Verification Email
                        <i class="fa-solid fa-arrow-right btn-icon-r"></i>
                    </span>
                </button>
            </form>

            <!-- Tips row -->
            <div class="tips-row anim-item d4">
                <div class="tip-chip"><i class="fa-solid fa-inbox" style="color:#6366f1;"></i> Check inbox</div>
                <div class="tip-chip"><i class="fa-solid fa-triangle-exclamation" style="color:#f97316;"></i> Check spam</div>
                <div class="tip-chip"><i class="fa-solid fa-clock" style="color:#ec4899;"></i> Expires in 60m</div>
                <div class="tip-chip"><i class="fa-solid fa-rotate" style="color:#34d399;"></i> Can resend</div>
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="anim-item d5">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Sign Out &amp; Use Different Account
                </button>
            </form>

        </div>
    </div>

</div>

<script>
    document.getElementById('resend-form')?.addEventListener('submit', function () {
        const btn = document.getElementById('resend-btn');
        btn.innerHTML = '<span><i class="fa-solid fa-circle-notch fa-spin"></i> Sending…</span>';
        btn.style.opacity = '0.85'; btn.disabled = true;
    });
</script>

</x-guest-layout>