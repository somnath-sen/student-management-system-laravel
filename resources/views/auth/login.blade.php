<x-guest-layout>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style>
/* ================================================================
   RESET & BASE
   ================================================================ */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
    --navy-900:#050814;--navy-800:#080B2A;--navy-700:#0D1035;--navy-600:#11154A;
    --orange:#FF9F0A;--orange-lt:#FFB000;--orange-dk:#F97316;
    --white:#FFFFFF;--off-white:#F8FAFC;
    --text-dark:#0F172A;--text-mid:#475569;--text-soft:#64748B;
    --border:#E2E8F0;--error:#DC2626;--success:#16A34A;
}
html,body{font-family:'Outfit',sans-serif;min-height:100vh;background:var(--navy-800);overflow-x:hidden}
.ef-login-wrap{display:flex;min-height:100vh;width:100%}
.ef-brand{flex:0 0 47%;position:relative;display:flex;flex-direction:column;align-items:center;justify-content:space-between;padding:2.5rem 2.5rem 2rem;background:var(--navy-800);overflow:hidden}
.ef-brand::before{content:'';position:absolute;inset:0;z-index:0;background:radial-gradient(ellipse 70% 50% at 30% 20%,rgba(255,159,10,.09) 0%,transparent 60%),linear-gradient(160deg,var(--navy-700) 0%,var(--navy-900) 60%,#060A22 100%)}
.ef-brand::after{content:'';position:absolute;bottom:-80px;left:-80px;width:420px;height:420px;border-radius:50%;background:radial-gradient(circle,rgba(79,70,229,.18) 0%,transparent 70%);z-index:0;animation:glowPulse 6s ease-in-out infinite alternate}
@keyframes glowPulse{from{transform:scale(1);opacity:.7}to{transform:scale(1.15);opacity:1}}
.ef-ring{position:absolute;border-radius:50%;border:1px solid rgba(255,255,255,.045);z-index:0;animation:ringPulse 7s ease-in-out infinite}
.ef-ring-1{width:320px;height:320px;top:-100px;left:-100px;animation-delay:0s}
.ef-ring-2{width:520px;height:520px;top:-180px;left:-180px;animation-delay:1.5s;border-color:rgba(255,159,10,.07)}
.ef-ring-3{width:260px;height:260px;bottom:80px;right:-80px;animation-delay:3s;border-color:rgba(99,102,241,.1)}
.ef-ring-4{width:460px;height:460px;bottom:0;right:-180px;animation-delay:1s}
@keyframes ringPulse{0%,100%{transform:scale(1);opacity:.7}50%{transform:scale(1.04);opacity:1}}
.ef-orb-orange{position:absolute;top:-60px;right:-60px;width:280px;height:280px;border-radius:50%;background:radial-gradient(circle,rgba(255,159,10,.2) 0%,transparent 65%);z-index:0;filter:blur(20px);animation:orbFloat 9s ease-in-out infinite alternate}
@keyframes orbFloat{from{transform:translateY(0) translateX(0)}to{transform:translateY(20px) translateX(-15px)}}
.ef-dots{position:absolute;inset:0;background-image:radial-gradient(circle,rgba(255,255,255,.045) 1px,transparent 1px);background-size:28px 28px;z-index:0;mask-image:linear-gradient(to bottom,transparent 0%,rgba(0,0,0,.6) 30%,rgba(0,0,0,.6) 70%,transparent 100%)}
.ef-top-bar{position:relative;z-index:2;width:100%;display:flex;align-items:center;gap:12px}
.ef-logo-icon{width:46px;height:46px;border-radius:14px;background:linear-gradient(135deg,var(--orange),var(--orange-dk));display:flex;align-items:center;justify-content:center;font-size:1.25rem;color:var(--navy-800);box-shadow:0 6px 20px rgba(255,159,10,.4),0 0 0 1px rgba(255,159,10,.2);flex-shrink:0}
.ef-logo-text .ef-word{font-size:1.6rem;font-weight:900;letter-spacing:-.04em;color:var(--white);line-height:1}
.ef-logo-text .ef-word span{color:var(--orange)}
.ef-logo-text .ef-sub{font-size:.65rem;font-weight:600;color:rgba(255,255,255,.45);letter-spacing:.12em;text-transform:uppercase;margin-top:2px}
.ef-portrait-zone{position:relative;z-index:2;display:flex;flex-direction:column;align-items:center;justify-content:center;flex:1;padding:1rem 0}
.ef-portrait-glow{position:relative;display:flex;align-items:flex-end;justify-content:center}
.ef-portrait-glow::before{content:'';position:absolute;bottom:-20px;left:50%;transform:translateX(-50%);width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(255,159,10,.28) 0%,transparent 65%);filter:blur(30px);z-index:0}
.ef-portrait-glow::after{content:'';position:absolute;bottom:-30px;left:50%;transform:translateX(-50%);width:340px;height:340px;border-radius:50%;border:1.5px solid rgba(255,159,10,.12);z-index:0}
.ef-portrait-ring-2{position:absolute;bottom:-50px;left:50%;transform:translateX(-50%);width:420px;height:420px;border-radius:50%;border:1px solid rgba(255,159,10,.07);z-index:0;pointer-events:none}
.ef-portrait-img{position:relative;z-index:1;width:clamp(220px,28vw,360px);height:clamp(260px,34vw,430px);object-fit:cover;object-position:top center;border-radius:28px 28px 0 0;display:block;filter:drop-shadow(0 -10px 40px rgba(255,159,10,.35)) drop-shadow(0 20px 60px rgba(0,0,0,.6));animation:portraitRise 1s cubic-bezier(.22,1,.36,1) both}
@keyframes portraitRise{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
.ef-float-badge{position:absolute;display:flex;align-items:center;gap:7px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:12px;padding:.45rem .85rem;font-size:.7rem;font-weight:700;color:rgba(255,255,255,.8);backdrop-filter:blur(10px);z-index:3;animation:floatBadge 4s ease-in-out infinite alternate;white-space:nowrap}
.ef-badge-1{top:15%;left:-5px;animation-duration:4s;border-color:rgba(255,159,10,.25)}
.ef-badge-2{top:42%;right:-5px;animation-duration:5s;animation-delay:1s;border-color:rgba(99,102,241,.3)}
.ef-badge-3{bottom:20%;left:2%;animation-duration:4.5s;animation-delay:.5s}
@keyframes floatBadge{from{transform:translateY(0)}to{transform:translateY(-8px)}}
.ef-brand-text{position:relative;z-index:2;text-align:center;color:var(--white);padding:0 1rem;margin-top:1.5rem}
.ef-brand-text h2{font-size:clamp(.9rem,1.4vw,1.05rem);font-weight:800;color:rgba(255,255,255,.95);letter-spacing:.02em;margin-bottom:.35rem}
.ef-brand-text p{font-size:clamp(.7rem,1.1vw,.8rem);color:rgba(255,255,255,.45);max-width:300px;margin:0 auto;line-height:1.6}
.ef-caps{position:relative;z-index:2;display:flex;gap:.6rem;justify-content:center;flex-wrap:wrap;width:100%;padding:0 .5rem}
.ef-cap-card{display:flex;align-items:center;gap:7px;background:rgba(255,255,255,.055);border:1px solid rgba(255,255,255,.1);border-radius:12px;padding:.55rem .9rem;font-size:.7rem;font-weight:700;color:rgba(255,255,255,.7);backdrop-filter:blur(8px);transition:all .25s ease;cursor:default}
.ef-cap-card:hover{background:rgba(255,159,10,.1);border-color:rgba(255,159,10,.3);color:var(--orange-lt);transform:translateY(-2px)}
.ef-cap-card i{color:var(--orange);font-size:.75rem}
.ef-form-panel{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem 2.5rem;background:var(--off-white);position:relative;overflow:hidden;min-height:100vh}
.ef-form-panel::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--navy-600),var(--orange),var(--orange-dk),var(--navy-600));background-size:200% 100%;animation:barSlide 4s linear infinite}
@keyframes barSlide{0%{background-position:0% 50%}100%{background-position:200% 50%}}
.ef-form-panel::after{content:'';position:absolute;top:-100px;right:-100px;width:350px;height:350px;border-radius:50%;background:radial-gradient(circle,rgba(255,159,10,.06) 0%,transparent 65%);z-index:0;pointer-events:none}
.ef-form-inner{position:relative;z-index:1;width:100%;max-width:440px;animation:slideInForm .65s cubic-bezier(.22,1,.36,1) both}
@keyframes slideInForm{from{opacity:0;transform:translateX(24px)}to{opacity:1;transform:translateX(0)}}
.ef-secure-badge{display:inline-flex;align-items:center;gap:7px;background:linear-gradient(135deg,rgba(8,11,42,.07),rgba(255,159,10,.08));border:1px solid rgba(255,159,10,.25);border-radius:99px;padding:.35rem 1rem;font-size:.68rem;font-weight:800;color:var(--navy-600);text-transform:uppercase;letter-spacing:.12em;margin-bottom:1.1rem}
.ef-secure-badge i{color:var(--orange);font-size:.8rem}
.ef-form-head{margin-bottom:1.75rem}
.ef-form-head h1{font-size:clamp(1.7rem,2.5vw,2.1rem);font-weight:900;color:var(--text-dark);letter-spacing:-.03em;line-height:1.15;margin-bottom:.4rem}
.ef-form-head p{font-size:.88rem;color:var(--text-soft);font-weight:500}
.ef-roles{display:grid;grid-template-columns:1fr 1fr;gap:.65rem;margin-bottom:1.5rem}
.ef-role-card{display:flex;align-items:center;gap:10px;padding:.8rem 1rem;border-radius:14px;border:1.5px solid var(--border);background:var(--white);cursor:pointer;transition:all .22s cubic-bezier(.4,0,.2,1);user-select:none;outline:none;text-align:left;width:100%;font-family:'Outfit',sans-serif}
.ef-role-card:focus-visible{outline:2px solid var(--orange);outline-offset:2px}
.ef-role-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:.95rem;flex-shrink:0;transition:all .22s ease}
.ef-role-info{flex:1;min-width:0}
.ef-rn{font-size:.82rem;font-weight:800;color:var(--text-dark);line-height:1;margin-bottom:2px;transition:color .2s}
.ef-rd{font-size:.67rem;font-weight:600;color:var(--text-soft);transition:color .2s}
.ef-role-card[data-role="student"] .ef-role-icon{background:rgba(99,102,241,.1);color:#6366f1}
.ef-role-card[data-role="teacher"] .ef-role-icon{background:rgba(236,72,153,.1);color:#ec4899}
.ef-role-card[data-role="admin"] .ef-role-icon{background:rgba(255,159,10,.12);color:var(--orange)}
.ef-role-card[data-role="parent"] .ef-role-icon{background:rgba(16,185,129,.1);color:#10b981}
.ef-role-card[data-role="student"]:hover{border-color:#6366f1;box-shadow:0 4px 16px rgba(99,102,241,.12);transform:translateY(-2px)}
.ef-role-card[data-role="teacher"]:hover{border-color:#ec4899;box-shadow:0 4px 16px rgba(236,72,153,.12);transform:translateY(-2px)}
.ef-role-card[data-role="admin"]:hover{border-color:var(--orange);box-shadow:0 4px 16px rgba(255,159,10,.15);transform:translateY(-2px)}
.ef-role-card[data-role="parent"]:hover{border-color:#10b981;box-shadow:0 4px 16px rgba(16,185,129,.12);transform:translateY(-2px)}
.ef-role-card[data-role="student"].active{border-color:#6366f1;background:rgba(99,102,241,.06)}
.ef-role-card[data-role="teacher"].active{border-color:#ec4899;background:rgba(236,72,153,.06)}
.ef-role-card[data-role="admin"].active{border-color:var(--orange);background:rgba(255,159,10,.07)}
.ef-role-card[data-role="parent"].active{border-color:#10b981;background:rgba(16,185,129,.06)}
.ef-role-card[data-role="student"].active .ef-rn{color:#6366f1}
.ef-role-card[data-role="teacher"].active .ef-rn{color:#ec4899}
.ef-role-card[data-role="admin"].active .ef-rn{color:var(--orange-dk)}
.ef-role-card[data-role="parent"].active .ef-rn{color:#10b981}
.ef-field-wrap{margin-bottom:1.1rem}
.ef-label{display:block;font-size:.7rem;font-weight:800;color:var(--text-mid);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.45rem}
.ef-input-row{position:relative}
.ef-input-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:.85rem;pointer-events:none;transition:color .25s;z-index:1}
.ef-input{width:100%;padding:.875rem 1rem .875rem 2.75rem;border-radius:13px;border:1.5px solid var(--border);background:var(--white);font-family:'Outfit',sans-serif;font-size:.93rem;font-weight:500;color:var(--text-dark);outline:none;transition:all .25s cubic-bezier(.4,0,.2,1);box-shadow:0 1px 3px rgba(0,0,0,.04);-webkit-appearance:none;appearance:none}
.ef-input::placeholder{color:#c0cfe0}
.ef-input:focus{border-color:var(--orange);box-shadow:0 0 0 3px rgba(255,159,10,.15),0 2px 8px rgba(255,159,10,.08);transform:translateY(-1px)}
.ef-input-row:focus-within .ef-input-icon{color:var(--orange)}
.ef-pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;font-size:.85rem;transition:color .2s;padding:5px;border-radius:6px;line-height:1}
.ef-pw-toggle:hover{color:var(--orange)}
.ef-pw-toggle:focus-visible{outline:2px solid var(--orange)}
.ef-field-error{display:flex;align-items:center;gap:5px;color:var(--error);font-size:.73rem;font-weight:700;margin-top:5px;padding:.3rem .6rem;background:rgba(220,38,38,.06);border-radius:7px;border-left:3px solid var(--error)}
.ef-field-error i{font-size:.7rem;flex-shrink:0}
.ef-opts-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.4rem;gap:.5rem}
.ef-remember{display:flex;align-items:center;gap:9px;cursor:pointer;font-size:.83rem;font-weight:600;color:var(--text-mid);user-select:none}
.ef-remember input[type="checkbox"]{position:absolute;opacity:0;width:0;height:0}
.ef-checkbox-ui{width:18px;height:18px;border:2px solid var(--border);border-radius:6px;background:var(--white);display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .2s ease}
.ef-checkbox-ui::after{content:'';display:block;width:9px;height:5px;border-left:2px solid transparent;border-bottom:2px solid transparent;transform:rotate(-45deg) translateY(-1px);transition:all .15s ease}
.ef-remember input[type="checkbox"]:checked ~ .ef-checkbox-ui{background:var(--orange);border-color:var(--orange)}
.ef-remember input[type="checkbox"]:checked ~ .ef-checkbox-ui::after{border-left-color:white;border-bottom-color:white}
.ef-remember input[type="checkbox"]:focus-visible ~ .ef-checkbox-ui{outline:2px solid var(--orange);outline-offset:2px}
.ef-forgot{font-size:.8rem;font-weight:700;color:var(--navy-600);text-decoration:none;transition:color .2s,opacity .2s;white-space:nowrap}
.ef-forgot:hover{color:var(--orange-dk);text-decoration:underline}
.ef-recaptcha-wrap{display:flex;flex-direction:column;align-items:flex-start;margin-bottom:1.25rem;overflow:hidden}
.session-msg{background:#f0fdf4;border:1px solid #86efac;color:var(--success);font-weight:700;font-size:.83rem;border-radius:12px;padding:.7rem 1rem;margin-bottom:1.1rem;display:block}
.ef-submit-btn{width:100%;padding:1rem 1.5rem;border:none;border-radius:14px;font-family:'Outfit',sans-serif;font-size:1rem;font-weight:800;color:var(--navy-800);cursor:pointer;position:relative;overflow:hidden;transition:all .28s cubic-bezier(.25,1,.5,1);background:linear-gradient(135deg,var(--orange-lt) 0%,var(--orange) 50%,var(--orange-dk) 100%);background-size:200% 200%;background-position:0% 50%;box-shadow:0 8px 24px rgba(255,159,10,.35),0 2px 4px rgba(0,0,0,.1);letter-spacing:.01em}
.ef-submit-btn::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,var(--orange) 0%,var(--orange-dk) 60%,#ea6c00 100%);opacity:0;transition:opacity .28s}
.ef-submit-btn:hover{transform:translateY(-2px);box-shadow:0 14px 32px rgba(255,159,10,.45),0 4px 8px rgba(0,0,0,.12)}
.ef-submit-btn:hover::before{opacity:1}
.ef-submit-btn:active{transform:translateY(0) scale(.985)}
.btn-content{position:relative;z-index:1;display:flex;align-items:center;justify-content:center;gap:9px}
.btn-arrow{transition:transform .25s;font-size:.9rem}
.ef-submit-btn:hover .btn-arrow{transform:translateX(4px)}
.ef-signup-row{text-align:center;margin-top:1.5rem;font-size:.85rem;font-weight:600;color:var(--text-soft)}
.ef-signup-row a{color:var(--navy-600);font-weight:800;text-decoration:none;transition:color .2s}
.ef-signup-row a:hover{color:var(--orange-dk);text-decoration:underline}
.ef-anim{opacity:0;animation:fadeUp .55s cubic-bezier(.22,1,.36,1) forwards}
@keyframes fadeUp{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
.ef-d1{animation-delay:.08s}.ef-d2{animation-delay:.16s}.ef-d3{animation-delay:.24s}
.ef-d4{animation-delay:.32s}.ef-d5{animation-delay:.40s}.ef-d6{animation-delay:.48s}.ef-d7{animation-delay:.56s}
@media(prefers-reduced-motion:reduce){*,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}}
@media(max-width:1024px){.ef-brand{flex:0 0 42%;padding:2rem 1.5rem 1.5rem}.ef-badge-1,.ef-badge-2,.ef-badge-3{display:none}.ef-portrait-img{width:clamp(200px,26vw,300px);height:clamp(240px,32vw,360px)}.ef-form-panel{padding:1.5rem}}
@media(max-width:768px){html,body{background:var(--off-white)}.ef-login-wrap{flex-direction:column;min-height:100vh}.ef-brand{flex:none;width:100%;min-height:auto;padding:1.5rem 1.5rem 0;justify-content:flex-start;align-items:center;gap:0}.ef-brand::after{display:none}.ef-ring,.ef-orb-orange,.ef-dots{opacity:.5}.ef-top-bar{justify-content:center;margin-bottom:1.25rem}.ef-portrait-zone{flex:none;padding:0}.ef-portrait-glow::before,.ef-portrait-glow::after,.ef-portrait-ring-2{display:none}.ef-portrait-img{width:130px;height:155px;border-radius:20px 20px 0 0;filter:drop-shadow(0 -6px 20px rgba(255,159,10,.3))}.ef-badge-1,.ef-badge-2,.ef-badge-3{display:none}.ef-brand-text,.ef-caps{display:none}.ef-form-panel{flex:1;width:100%;padding:1.75rem 1.25rem 2rem;min-height:auto;border-radius:24px 24px 0 0;margin-top:-20px;justify-content:flex-start}.ef-form-panel::after{display:none}.ef-form-inner{max-width:100%;width:100%}.ef-form-head h1{font-size:1.65rem}.ef-roles{gap:.5rem}.ef-role-card{padding:.65rem .75rem}.ef-role-icon{width:30px;height:30px;font-size:.8rem;border-radius:8px}.ef-rn{font-size:.75rem}.ef-rd{font-size:.62rem}.ef-recaptcha-wrap{align-items:center}.g-recaptcha{transform:scale(.95);transform-origin:left top}}
@media(max-width:375px){.g-recaptcha{transform:scale(.82);transform-origin:left top}.ef-roles{gap:.4rem}}
@media(min-width:1440px){.ef-brand{flex:0 0 45%}.ef-portrait-img{width:380px;height:450px}.ef-form-inner{max-width:460px}}
</style>

<div class="ef-login-wrap">

    <aside class="ef-brand" aria-label="EdFlow branding panel">
        <div class="ef-dots" aria-hidden="true"></div>
        <div class="ef-orb-orange" aria-hidden="true"></div>
        <div class="ef-ring ef-ring-1" aria-hidden="true"></div>
        <div class="ef-ring ef-ring-2" aria-hidden="true"></div>
        <div class="ef-ring ef-ring-3" aria-hidden="true"></div>
        <div class="ef-ring ef-ring-4" aria-hidden="true"></div>

        <div class="ef-top-bar">
            <div class="ef-logo-icon" aria-hidden="true">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="ef-logo-text">
                <div class="ef-word">Ed<span>Flow</span></div>
                <div class="ef-sub">Smart Campus Platform</div>
            </div>
        </div>

        <div class="ef-portrait-zone">
            <div class="ef-portrait-glow">
                <div class="ef-portrait-ring-2" aria-hidden="true"></div>
                <div class="ef-float-badge ef-badge-1" aria-hidden="true">
                    <i class="fa-solid fa-chart-line" style="color:var(--orange);"></i> Live Analytics
                </div>
                <div class="ef-float-badge ef-badge-2" aria-hidden="true">
                    <i class="fa-solid fa-shield-halved" style="color:#818cf8;"></i> Secure Platform
                </div>
                <div class="ef-float-badge ef-badge-3" aria-hidden="true">
                    <i class="fa-solid fa-users" style="color:#4ade80;"></i> Multi-Role Access
                </div>
                <img src="{{ asset('images/edflow-founder.jpg') }}" alt="EdFlow Founder" class="ef-portrait-img" loading="eager" draggable="false">
            </div>
            <div class="ef-brand-text">
                <h2>Smart Campus Management</h2>
                <p>A complete platform to manage students, teachers, academics, attendance, exams, fees and more.</p>
            </div>
        </div>

        <div class="ef-caps">
            <div class="ef-cap-card"><i class="fa-solid fa-user-graduate"></i> Student Management</div>
            <div class="ef-cap-card"><i class="fa-solid fa-chalkboard-user"></i> Teacher Management</div>
            <div class="ef-cap-card"><i class="fa-solid fa-book-open-reader"></i> Academic Management</div>
        </div>
    </aside>

    <main class="ef-form-panel" id="login-main" role="main">
        <div class="ef-form-inner">

            <div class="ef-anim ef-d1">
                <div class="ef-secure-badge">
                    <i class="fa-solid fa-shield-halved"></i> Secure Login
                </div>
            </div>

            <div class="ef-form-head ef-anim ef-d2">
                <h1>Welcome Back! 👋</h1>
                <p>Sign in to access your EdFlow Dashboard.</p>
            </div>

            <x-auth-session-status class="session-msg" :status="session('status')" />

            <div class="ef-roles ef-anim ef-d3" id="role-chips" role="group" aria-label="Select your role">
                <button type="button" class="ef-role-card" data-role="student" onclick="selectRole('student',this)" aria-pressed="false" id="role-student">
                    <div class="ef-role-icon" aria-hidden="true"><i class="fa-solid fa-user-graduate"></i></div>
                    <div class="ef-role-info"><div class="ef-rn">Student</div><div class="ef-rd">Courses &amp; Results</div></div>
                </button>
                <button type="button" class="ef-role-card" data-role="teacher" onclick="selectRole('teacher',this)" aria-pressed="false" id="role-teacher">
                    <div class="ef-role-icon" aria-hidden="true"><i class="fa-solid fa-chalkboard-user"></i></div>
                    <div class="ef-role-info"><div class="ef-rn">Teacher</div><div class="ef-rd">Classes &amp; Attendance</div></div>
                </button>
                <button type="button" class="ef-role-card" data-role="admin" onclick="selectRole('admin',this)" aria-pressed="false" id="role-admin">
                    <div class="ef-role-icon" aria-hidden="true"><i class="fa-solid fa-user-shield"></i></div>
                    <div class="ef-role-info"><div class="ef-rn">Admin</div><div class="ef-rd">System Management</div></div>
                </button>
                <button type="button" class="ef-role-card" data-role="parent" onclick="selectRole('parent',this)" aria-pressed="false" id="role-parent">
                    <div class="ef-role-icon" aria-hidden="true"><i class="fa-solid fa-user-group"></i></div>
                    <div class="ef-role-info"><div class="ef-rn">Parent</div><div class="ef-rd">Child &amp; Progress</div></div>
                </button>
            </div>

            <form method="POST" action="{{ route('login') }}" id="login-form" novalidate>
                @csrf

                <div class="ef-field-wrap ef-anim ef-d4">
                    <label class="ef-label" for="email">Email Address</label>
                    <div class="ef-input-row">
                        <i class="fa-solid fa-envelope ef-input-icon" aria-hidden="true"></i>
                        <input id="email" type="email" name="email" class="ef-input"
                            value="{{ old('email') }}" placeholder="you@edflow.com"
                            required autofocus autocomplete="username"
                            aria-describedby="email-error"
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                    </div>
                    @error('email')
                        <div class="ef-field-error" id="email-error" role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="ef-field-wrap ef-anim ef-d5">
                    <label class="ef-label" for="pw-field">Password</label>
                    <div class="ef-input-row">
                        <i class="fa-solid fa-lock ef-input-icon" aria-hidden="true"></i>
                        <input id="pw-field" type="password" name="password" class="ef-input"
                            placeholder="Enter your password" required autocomplete="current-password"
                            style="padding-right:3rem;"
                            aria-describedby="pw-error"
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
                        <button type="button" class="ef-pw-toggle" onclick="togglePw()" id="pw-btn"
                                aria-label="Toggle password visibility" aria-pressed="false">
                            <i class="fa-regular fa-eye" id="pw-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="ef-field-error" id="pw-error" role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="ef-opts-row ef-anim ef-d6">
                    <label class="ef-remember" for="remember_me">
                        <input type="checkbox" name="remember" id="remember_me">
                        <div class="ef-checkbox-ui" aria-hidden="true"></div>
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="ef-forgot">Forgot password?</a>
                    @endif
                </div>

                <div class="ef-recaptcha-wrap ef-anim ef-d6">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    @error('g-recaptcha-response')
                        <div class="ef-field-error" style="margin-top:8px;width:100%;" role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="ef-anim ef-d7">
                    <button type="submit" class="ef-submit-btn" id="login-btn">
                        <div class="btn-content">
                            Log in to Dashboard
                            <i class="fa-solid fa-arrow-right btn-arrow" aria-hidden="true"></i>
                        </div>
                    </button>
                </div>
            </form>

            <div class="ef-signup-row ef-anim ef-d7">
                New to EdFlow? <a href="/register/student">Apply as a Student &rarr;</a>
            </div>

        </div>
    </main>
</div>

<script>
    function togglePw(){
        var field=document.getElementById('pw-field')||document.getElementById('password');
        var eye=document.getElementById('pw-eye');
        var btn=document.getElementById('pw-btn');
        if(!field)return;
        var isHidden=field.type==='password';
        field.type=isHidden?'text':'password';
        if(eye){eye.classList.toggle('fa-eye',!isHidden);eye.classList.toggle('fa-eye-slash',isHidden)}
        if(btn)btn.setAttribute('aria-pressed',isHidden?'true':'false');
    }
    function selectRole(role,el){
        document.querySelectorAll('.ef-role-card').forEach(function(c){c.classList.remove('active');c.setAttribute('aria-pressed','false')});
        el.classList.add('active');el.setAttribute('aria-pressed','true');
        var ph={student:'student@edflow.com',teacher:'teacher@edflow.com',admin:'admin@edflow.com',parent:'parent@edflow.com'};
        var emailInput=document.getElementById('email');
        if(emailInput&&!emailInput.value)emailInput.placeholder=ph[role]||'you@edflow.com';
    }
    (function(){
        var form=document.getElementById('login-form');
        if(!form)return;
        form.addEventListener('submit',function(){
            var btn=document.getElementById('login-btn');
            if(!btn)return;
            btn.innerHTML='<div class="btn-content"><i class="fa-solid fa-circle-notch fa-spin" aria-hidden="true"></i> Signing in\u2026</div>';
            btn.style.opacity='0.82';btn.disabled=true;btn.style.cursor='wait';
        });
    })();
</script>

</x-guest-layout>