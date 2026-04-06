<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Application | EdFlow</title>
    <meta name="description" content="Apply for student enrollment at EdFlow. Submit your application for admin review.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream-50:  #FFFDF7;
            --cream-100: #FEF9EC;
            --cream-200: #FDF0CC;
            --cream-300: #FAE4A0;
            --amber-400: #FBBF24;
            --amber-500: #F59E0B;
            --amber-600: #D97706;
            --warm-700:  #92400E;
            --warm-800:  #78350F;
            --brown-900: #451A03;
            --glass-bg:  rgba(255, 253, 245, 0.72);
            --glass-border: rgba(251, 191, 36, 0.25);
            --glass-shine: rgba(255, 255, 255, 0.65);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #FEF9EC;
            color: #451A03;
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Background ── */
        .page-bg {
            position: fixed; inset: 0; z-index: 0; overflow: hidden;
            background: radial-gradient(ellipse at 10% 0%, #fde68a55 0%, transparent 50%),
                        radial-gradient(ellipse at 90% 10%, #fcd34d44 0%, transparent 50%),
                        radial-gradient(ellipse at 50% 100%, #fef3c744 0%, transparent 60%),
                        #FEF9EC;
        }
        .page-bg::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(245, 158, 11, 0.12) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        @keyframes blob {
            0%   { transform: translate(0,0) scale(1) rotate(0deg); }
            33%  { transform: translate(40px,-60px) scale(1.12) rotate(5deg); }
            66%  { transform: translate(-30px,25px) scale(0.9) rotate(-4deg); }
            100% { transform: translate(0,0) scale(1) rotate(0deg); }
        }
        .blob {
            position: absolute; border-radius: 50%;
            filter: blur(70px); mix-blend-mode: multiply;
            animation: blob 18s infinite alternate;
        }
        .blob-1 { width: 42vw; height: 42vw; background: #fde68a; opacity: 0.55; top: -12%; left: -8%; animation-delay: 0s; }
        .blob-2 { width: 36vw; height: 36vw; background: #fcd34d; opacity: 0.45; top: 15%; right: -12%; animation-delay: 3s; }
        .blob-3 { width: 48vw; height: 48vw; background: #fef3c7; opacity: 0.50; bottom: -20%; left: 15%; animation-delay: 6s; }
        .blob-4 { width: 32vw; height: 32vw; background: #ffe4b5; opacity: 0.40; bottom: 8%;  right: 5%;  animation-delay: 2s; }

        @keyframes floatUp {
            0%   { transform: translateY(105vh) scale(0); opacity: 0; }
            10%  { opacity: 0.7; transform: translateY(85vh) scale(1); }
            90%  { opacity: 0.5; }
            100% { transform: translateY(-5vh) scale(0.3); opacity: 0; }
        }
        .sparkle {
            position: absolute; border-radius: 50%;
            animation: floatUp linear infinite; bottom: -5%;
        }

        /* ── Layout ── */
        .page-wrap {
            position: relative; z-index: 10;
            min-height: 100vh; padding: 48px 16px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
        }
        .card-wrap { width: 100%; max-width: 740px; }

        /* ── Header ── */
        .page-header { text-align: center; margin-bottom: 36px; }

        @keyframes logoPop {
            0%   { transform: scale(0.7) rotate(-8deg); opacity: 0; }
            60%  { transform: scale(1.08) rotate(2deg); }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
        .logo-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 72px; height: 72px; border-radius: 50%;
            background: linear-gradient(145deg, #fff8e1, #fffdf7);
            border: 2px solid rgba(251,191,36,0.4);
            color: #D97706; font-size: 28px; margin-bottom: 16px;
            text-decoration: none;
            box-shadow:
                0 8px 24px rgba(245,158,11,0.22),
                0 0 0 8px rgba(251,191,36,0.08),
                inset 0 1px 2px rgba(255,255,255,0.9);
            animation: logoPop 0.7s cubic-bezier(0.2,0.8,0.2,1) forwards;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .logo-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 14px 36px rgba(245,158,11,0.30), 0 0 0 10px rgba(251,191,36,0.1), inset 0 1px 2px rgba(255,255,255,0.9);
        }

        .page-title {
            font-size: clamp(26px, 4vw, 38px);
            font-weight: 800; color: #451A03;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 8px rgba(120,53,15,0.08);
        }
        .page-subtitle {
            margin-top: 10px; font-size: 16px; font-weight: 500;
            color: #92400E; opacity: 0.82;
        }

        /* ── Glossy Card ── */
        @keyframes cardSlide {
            from { opacity: 0; transform: translateY(40px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(1.4);
            -webkit-backdrop-filter: blur(20px) saturate(1.4);
            border: 1.5px solid var(--glass-border);
            border-radius: 28px;
            overflow: hidden; position: relative;
            box-shadow:
                0 24px 60px rgba(120,53,15,0.12),
                0 8px 20px rgba(245,158,11,0.08),
                inset 0 1.5px 0 var(--glass-shine);
            animation: cardSlide 0.65s cubic-bezier(0.2,0.8,0.2,1) both;
        }

        /* Glossy shine strip at top */
        .glass-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, #F59E0B, #FBBF24, #FDE68A, #FBBF24, #D97706);
            z-index: 1;
        }
        /* Inner glass sheen */
        .glass-card::after {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 55%;
            background: linear-gradient(180deg, rgba(255,255,255,0.45) 0%, rgba(255,255,255,0) 100%);
            pointer-events: none; z-index: 0; border-radius: 28px 28px 0 0;
        }

        /* ── Form ── */
        .form-body { padding: 40px 44px; position: relative; z-index: 2; }
        @media (max-width: 600px) { .form-body { padding: 28px 20px; } }

        .form-section { margin-bottom: 32px; }

        .section-label {
            display: flex; align-items: center; gap: 8px;
            font-size: 10.5px; font-weight: 800; letter-spacing: 1.2px;
            text-transform: uppercase; color: #D97706;
            padding-bottom: 10px;
            border-bottom: 1.5px solid rgba(251,191,36,0.28);
            margin-bottom: 20px;
        }
        .section-label i { font-size: 13px; color: #F59E0B; }

        .field-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }
        .field-grid-2 .col-span-2 { grid-column: span 2; }
        @media (max-width: 560px) {
            .field-grid-2 { grid-template-columns: 1fr; }
            .field-grid-2 .col-span-2 { grid-column: span 1; }
        }

        /* ── Field ── */
        .field-group { display: flex; flex-direction: column; gap: 6px; }

        .field-label {
            font-size: 12.5px; font-weight: 700;
            color: #78350F; letter-spacing: 0.1px;
        }
        .field-label .req { color: #ef4444; margin-left: 2px; }
        .field-label .opt { font-weight: 500; color: #a16207; font-size: 11px; margin-left: 4px; }

        .field-input {
            width: 100%; padding: 13px 16px;
            border-radius: 14px;
            border: 1.5px solid rgba(251,191,36,0.35);
            background: linear-gradient(160deg, rgba(255,255,255,0.85) 0%, rgba(255,252,235,0.70) 100%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px; color: #451A03;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.04), 0 1px 3px rgba(245,158,11,0.06);
            -webkit-appearance: none; appearance: none;
        }
        .field-input::placeholder { color: #c49a3c; opacity: 0.7; }
        .field-input:focus {
            border-color: #F59E0B;
            background: linear-gradient(160deg, rgba(255,255,255,0.98) 0%, rgba(255,252,235,0.88) 100%);
            box-shadow: 0 0 0 4px rgba(245,158,11,0.15), inset 0 1px 2px rgba(0,0,0,0.03);
        }
        .field-input:hover:not(:focus) { border-color: rgba(251,191,36,0.6); }

        /* Select */
        .field-select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23D97706' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
        }
        select optgroup { font-weight: 700; color: #D97706; background: #FEF9EC; }
        select option   { font-weight: 500; color: #451A03; background: #FFFDF7; }
        select::-webkit-scrollbar { width: 6px; }
        select::-webkit-scrollbar-thumb { background: #fbbf24; border-radius: 4px; }

        /* ── Terms ── */
        .terms-box {
            background: linear-gradient(135deg, rgba(255,252,235,0.9) 0%, rgba(254,243,199,0.75) 100%);
            border: 1.5px solid rgba(251,191,36,0.35);
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.7), 0 2px 8px rgba(245,158,11,0.07);
            margin-bottom: 28px;
        }
        .terms-label {
            display: flex; align-items: flex-start; gap: 12px;
            cursor: pointer;
        }
        .terms-check {
            width: 20px; height: 20px; margin-top: 1px; flex-shrink: 0;
            accent-color: #D97706; cursor: pointer;
        }
        .terms-text {
            font-size: 13.5px; color: #78350F; line-height: 1.65;
            font-weight: 500;
        }

        /* ── Submit Button ── */
        .submit-btn {
            width: 100%; padding: 16px;
            border: none; border-radius: 16px; cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 16px; font-weight: 800; color: #fff;
            letter-spacing: 0.3px;
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 50%, #B45309 100%);
            box-shadow:
                0 6px 20px rgba(180,83,9,0.35),
                inset 0 1px 0 rgba(255,255,255,0.25);
            position: relative; overflow: hidden;
            transition: transform 0.22s, box-shadow 0.22s, filter 0.22s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .submit-btn::before {
            content: '';
            position: absolute; top: 0; left: -100%;
            width: 60%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent);
            transition: left 0.55s ease;
        }
        .submit-btn:hover::before { left: 140%; }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(180,83,9,0.40), inset 0 1px 0 rgba(255,255,255,0.25);
        }
        .submit-btn:active { transform: translateY(0); }
        .submit-btn:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

        /* ── Success Panel ── */
        .success-panel {
            display: none; padding: 56px 44px; text-align: center;
            background: linear-gradient(160deg, rgba(255,255,255,0.85), rgba(255,252,235,0.7));
            position: relative; z-index: 2;
        }
        @keyframes successPop {
            0%   { transform: scale(0); opacity: 0; }
            65%  { transform: scale(1.12); }
            100% { transform: scale(1); opacity: 1; }
        }
        .success-icon {
            width: 96px; height: 96px; margin: 0 auto 24px;
            background: linear-gradient(135deg, #fde68a, #fbbf24);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 44px; color: #78350F;
            box-shadow: 0 8px 32px rgba(245,158,11,0.35), inset 0 1px 0 rgba(255,255,255,0.6);
            animation: successPop 0.55s cubic-bezier(0.2,0.8,0.2,1) forwards;
        }
        .success-title { font-size: 28px; font-weight: 800; color: #451A03; margin-bottom: 10px; }
        .success-sub { font-size: 15px; color: #92400E; font-weight: 500; max-width: 380px; margin: 0 auto 28px; line-height: 1.6; }
        .back-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 28px; border-radius: 50px;
            background: #451A03; color: #FEF9EC;
            font-size: 14px; font-weight: 700; text-decoration: none;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 14px rgba(69,26,3,0.28);
        }
        .back-btn:hover { background: #78350F; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(69,26,3,0.32); }

        /* ── Bottom Links ── */
        .bottom-links { text-align: center; margin-top: 28px; }
        .cancel-link {
            display: inline-block;
            padding: 9px 20px; border-radius: 50px;
            font-size: 13px; font-weight: 700;
            color: #92400E; text-decoration: none;
            background: rgba(255,255,255,0.55);
            border: 1.5px solid rgba(251,191,36,0.35);
            backdrop-filter: blur(8px);
            transition: color 0.2s, background 0.2s, border-color 0.2s;
        }
        .cancel-link:hover { color: #D97706; background: rgba(255,255,255,0.80); border-color: rgba(251,191,36,0.7); }

        /* FA spin */
        .fa-spin { animation: fa-spin 0.8s infinite linear; }
        @keyframes fa-spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(359deg); } }
    </style>
</head>
<body>

    <!-- Background -->
    <div class="page-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
        <div class="blob blob-4"></div>
        <!-- Sparkles -->
        <div class="sparkle" style="left:8%;  width:18px;height:18px;background:rgba(251,191,36,0.25);animation-duration:13s;animation-delay:0s;"></div>
        <div class="sparkle" style="left:25%; width:32px;height:32px;background:rgba(245,158,11,0.2); animation-duration:19s;animation-delay:2s;"></div>
        <div class="sparkle" style="left:55%; width:14px;height:14px;background:rgba(253,230,138,0.3);animation-duration:11s;animation-delay:5s;"></div>
        <div class="sparkle" style="left:78%; width:26px;height:26px;background:rgba(251,191,36,0.22);animation-duration:23s;animation-delay:1s;"></div>
        <div class="sparkle" style="left:43%; width:20px;height:20px;background:rgba(245,158,11,0.18);animation-duration:17s;animation-delay:7s;"></div>
        <div class="sparkle" style="left:88%; width:10px;height:10px;background:rgba(253,230,138,0.35);animation-duration:15s;animation-delay:3s;"></div>
    </div>

    <div class="page-wrap">
        <div class="card-wrap">

            <!-- Header -->
            <div class="page-header">
                <a href="/" class="logo-btn">
                    <i class="fa-solid fa-user-graduate"></i>
                </a>
                <h1 class="page-title">Student Application Portal</h1>
                <p class="page-subtitle">Please fill out all details carefully. Documents must be clear and legible.</p>
            </div>

            <!-- Glass Card -->
            <div class="glass-card">

                <form id="studentForm" class="form-body">
                    @csrf
                    <input type="hidden" name="type" value="Students">

                    <!-- Section 1: Personal Info -->
                    <div class="form-section">
                        <div class="section-label">
                            <i class="fa-solid fa-user"></i> Personal Information
                        </div>
                        <div class="field-grid-2">
                            <div class="field-group">
                                <label class="field-label">Full Name <span class="req">*</span></label>
                                <input type="text" name="name" required placeholder="e.g. Arjun Sharma" class="field-input">
                            </div>
                            <div class="field-group">
                                <label class="field-label">Email Address <span class="req">*</span></label>
                                <input type="email" name="email" required placeholder="arjun@email.com" class="field-input">
                            </div>
                            <div class="field-group">
                                <label class="field-label">Phone Number <span class="req">*</span></label>
                                <input type="tel" name="phone" required placeholder="+91 98765 43210" class="field-input">
                            </div>
                            <div class="field-group">
                                <label class="field-label">Roll Number <span class="opt">(Optional)</span></label>
                                <input type="text" name="roll" placeholder="e.g. 2023-CSE-001" class="field-input">
                            </div>
                            <div class="field-group col-span-2">
                                <label class="field-label">Desired Course <span class="req">*</span></label>
                                <select name="course" required class="field-input field-select">
                                    <option value="" disabled selected>Select a program...</option>

                                    <optgroup label="Professional &amp; Management">
                                        <option value="BCA">Bachelor of Computer Applications (BCA)</option>
                                        <option value="MCA">Master of Computer Applications (MCA)</option>
                                        <option value="BBA">Bachelor of Business Administration (BBA)</option>
                                        <option value="MBA">Master of Business Administration (MBA)</option>
                                    </optgroup>

                                    <optgroup label="Engineering (B.Tech / B.E.)">
                                        <option value="Computer Science and Engineering (CSE)">Computer Science &amp; Engineering (CSE)</option>
                                        <option value="Information Technology (IT)">Information Technology (IT)</option>
                                        <option value="Electronics and Communication Engineering (ECE)">Electronics &amp; Communication Engg (ECE)</option>
                                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                                        <option value="Civil Engineering">Civil Engineering</option>
                                        <option value="Electrical Engineering">Electrical Engineering</option>
                                        <option value="Artificial Intelligence and Data Science">Artificial Intelligence &amp; Data Science</option>
                                        <option value="Biotechnology Engineering">Biotechnology Engineering</option>
                                        <option value="Chemical Engineering">Chemical Engineering</option>
                                        <option value="Aerospace Engineering">Aerospace / Aeronautical Engineering</option>
                                        <option value="Marine Engineering">Marine Engineering</option>
                                        <option value="Food Technology">Food Technology</option>
                                    </optgroup>

                                    <optgroup label="Bachelor of Science (B.Sc.)">
                                        <option value="B.Sc. Computer Science">B.Sc. Computer Science</option>
                                        <option value="B.Sc. Information Technology">B.Sc. Information Technology</option>
                                        <option value="B.Sc. Data Science">B.Sc. Data Science</option>
                                        <option value="B.Sc. Mathematics">B.Sc. Mathematics</option>
                                        <option value="B.Sc. Physics">B.Sc. Physics</option>
                                        <option value="B.Sc. Chemistry">B.Sc. Chemistry</option>
                                        <option value="B.Sc. Biotechnology">B.Sc. Biotechnology</option>
                                        <option value="B.Sc. Microbiology">B.Sc. Microbiology</option>
                                        <option value="B.Sc. Botany">B.Sc. Botany</option>
                                        <option value="B.Sc. Zoology">B.Sc. Zoology</option>
                                        <option value="B.Sc. Statistics">B.Sc. Statistics</option>
                                        <option value="B.Sc. Electronics">B.Sc. Electronics</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Parent Info -->
                    <div class="form-section">
                        <div class="section-label">
                            <i class="fa-solid fa-heart"></i> Parent / Guardian Information
                        </div>
                        <div class="field-grid-2">
                            <div class="field-group">
                                <label class="field-label">Parent's Full Name <span class="req">*</span></label>
                                <input type="text" name="parent_name" required placeholder="e.g. Rajesh Sharma" class="field-input">
                            </div>
                            <div class="field-group">
                                <label class="field-label">Parent's Email Address <span class="req">*</span></label>
                                <input type="email" name="parent_email" required placeholder="rajesh@email.com" class="field-input">
                            </div>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="terms-box">
                        <label class="terms-label">
                            <input type="checkbox" required class="terms-check">
                            <span class="terms-text">
                                I hereby declare that all the information and documents provided are true and correct to the best of my knowledge. I understand that my application may be rejected if any information is found to be false.
                            </span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" id="submitBtn" class="submit-btn">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span id="btnText">Submit Application</span>
                        <i class="fa-solid fa-spinner fa-spin" id="btnLoader" style="display:none;"></i>
                    </button>
                </form>

                <!-- Success State -->
                <div id="successMessage" class="success-panel">
                    <div class="success-icon">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h2 class="success-title">Application Received!</h2>
                    <p class="success-sub">Your application has been securely sent to the administration for review. We will contact you via email shortly.</p>
                    <a href="/" class="back-btn">
                        <i class="fa-solid fa-arrow-left"></i> Return to Home
                    </a>
                </div>

            </div><!-- /.glass-card -->

            <!-- Bottom Link -->
            <div class="bottom-links">
                <a href="/" class="cancel-link">
                    <i class="fa-solid fa-xmark" style="margin-right:6px;"></i>Cancel and return to home
                </a>
            </div>

        </div>
    </div>

    <script>
        const scriptURL = "{{ route('register.student.store') }}";

        const form          = document.getElementById("studentForm");
        const submitBtn     = document.getElementById("submitBtn");
        const btnText       = document.getElementById("btnText");
        const btnLoader     = document.getElementById("btnLoader");
        const successPanel  = document.getElementById("successMessage");

        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            submitBtn.disabled = true;
            btnText.innerText  = "Submitting...";
            btnLoader.style.display = 'inline-block';

            try {
                const formData = new FormData(this);
                const response = await fetch(scriptURL, {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    form.style.display   = 'none';
                    successPanel.style.display = 'block';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    let msg = result.message || "An error occurred during submission.";
                    if (result.errors) { msg = Object.values(result.errors)[0][0]; }
                    alert("Error: " + msg);
                }
            } catch (err) {
                alert("Something went wrong. Please check your connection and try again.");
                console.error(err);
            } finally {
                submitBtn.disabled = false;
                btnText.innerText  = "Submit Application";
                btnLoader.style.display = 'none';
            }
        });
    </script>
</body>
</html>