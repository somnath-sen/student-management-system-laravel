<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EdFlow | Smart Campus Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Three.js for 3D preloader -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                        'float': 'float 6s ease-in-out infinite',
                        'marquee': 'marquee 25s linear infinite',
                        'marquee-slow': 'marquee 45s linear infinite',
                        'pulse-glow': 'pulseGlow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'scale-in': 'scaleIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                        'text-shimmer': 'textShimmer 3s linear infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        marquee: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-100%)' },
                        },
                        pulseGlow: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '.5' },
                        },
                        scaleIn: {
                            '0%': { opacity: '0', transform: 'scale(0.9)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                        textShimmer: {
                            '0%': { backgroundPosition: '0% 50%' },
                            '100%': { backgroundPosition: '200% 50%' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* ══════════════════════════════════════════
           GLASSMORPHISM SaaS — Light Mode Only
           ══════════════════════════════════════════ */

        body {
            background: linear-gradient(135deg,
                #ffffff 0%,
                #f8f9ff 30%,
                #f0f4ff 60%,
                #f8faff 100%) fixed;
        }

        /* Glassmorphism Navbar — lighter blur */
        .glass {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(230, 230, 255, 0.5);
            box-shadow: 0 1px 20px rgba(99, 102, 241, 0.06);
        }

        /* Subtle dot-grid pattern */
        .bg-grid {
            background-image: radial-gradient(circle, rgba(99,102,241,0.07) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        /* Glass card base — lighter */
        .glass-card {
            background: rgba(255, 255, 255, 0.80);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.90);
            box-shadow: 0 2px 16px rgba(99, 102, 241, 0.07), 0 1px 2px rgba(0,0,0,0.03);
        }

        /* Feature bento card glass — lighter, no saturate */
        .bento-card-inner {
            background: rgba(255, 255, 255, 0.88) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.07), inset 0 1px 0 rgba(255,255,255,1) !important;
        }

        /* Targeted transitions — only on interactive elements */
        a, button,
        .glass, .glass-card, .bento-card-inner,
        nav, input, select, textarea {
            transition: background-color 0.2s ease, color 0.2s ease,
                        border-color 0.2s ease, box-shadow 0.2s ease,
                        opacity 0.2s ease, transform 0.2s ease;
        }

        /* Hide scrollbar for marquee */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Custom Scrollbar for inner modals */
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: rgba(156, 163, 175, 0.4); border-radius: 10px; }

        /* Smooth Accordion transition */
        .faq-content {
            transition: max-height 0.28s ease-in-out, opacity 0.28s ease-in-out;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        .faq-content.open { max-height: 500px; opacity: 1; }

        /* Ambient orbs — lighter blur, slower drift */
        .orb-light {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
            will-change: transform;
        }

        /* Section glass divider */
        .section-glass {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-top: 1px solid rgba(255,255,255,0.9);
            border-bottom: 1px solid rgba(230,235,255,0.5);
        }

        /* Stats section */
        .stats-glass {
            background: linear-gradient(135deg,
                rgba(238,242,255,0.96) 0%,
                rgba(245,240,255,0.96) 50%,
                rgba(240,248,255,0.96) 100%);
            border-top: 1px solid rgba(199,210,254,0.4);
            border-bottom: 1px solid rgba(199,210,254,0.25);
        }

        /* Hero badge glass */
        .badge-glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.95);
            box-shadow: 0 2px 12px rgba(99,102,241,0.08);
        }

        /* Smooth card hover lift — GPU-friendly (transform only) */
        #features .grid > div {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            will-change: transform;
        }
        #features .grid > div:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(99,102,241,0.13);
        }
    </style>

</head>
<body class="font-sans antialiased text-gray-900 bg-grid selection:bg-indigo-600 selection:text-white">

    <!-- ═══════════════════════════════════════════════════════════════
         LIQUID GLASS PRELOADER — Indigo/Violet SaaS Theme
    ═══════════════════════════════════════════════════════════════ -->
    <style>
        /* ── Preloader keyframes ────────────────────────────────── */
        @keyframes morph {
            0%,100% { border-radius: 60% 40% 70% 30% / 50% 60% 40% 70%; }
            25%      { border-radius: 40% 70% 30% 60% / 65% 35% 65% 35%; }
            50%      { border-radius: 70% 30% 50% 50% / 30% 70% 50% 60%; }
            75%      { border-radius: 30% 60% 70% 40% / 55% 45% 70% 30%; }
        }
        @keyframes morph2 {
            0%,100% { border-radius: 50% 60% 40% 70% / 65% 35% 65% 35%; }
            33%      { border-radius: 70% 40% 60% 30% / 40% 65% 35% 60%; }
            66%      { border-radius: 30% 70% 30% 70% / 60% 40% 70% 30%; }
        }
        @keyframes ring-spin  { to { transform: rotate(360deg); } }
        @keyframes ring-spin2 { to { transform: rotate(-360deg); } }
        @keyframes ring-spin3 { to { transform: rotate(360deg); } }
        @keyframes float-up   { to { transform: translateY(-120vh) scale(0); opacity: 0; } }
        @keyframes letter-in  {
            from { opacity: 0; transform: translateY(24px) skewY(6deg); filter: blur(6px); }
            to   { opacity: 1; transform: translateY(0)    skewY(0deg); filter: blur(0); }
        }
        @keyframes shimmer {
            0%   { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
        @keyframes bar-fill { from { width: 0; } to { width: 100%; } }
        @keyframes pulse-ring {
            0%   { transform: scale(0.9); opacity: 0.6; }
            50%  { transform: scale(1.08); opacity: 0.2; }
            100% { transform: scale(0.9); opacity: 0.6; }
        }
        @keyframes shard-exit {
            to { transform: translate(var(--tx), var(--ty)) rotate(var(--tr)) scale(0.2); opacity: 0; }
        }
        @keyframes logo-glow {
            0%,100% { text-shadow: 0 0 20px rgba(99,102,241,0.4), 0 0 60px rgba(139,92,246,0.2); }
            50%      { text-shadow: 0 0 40px rgba(99,102,241,0.7), 0 0 100px rgba(139,92,246,0.4); }
        }
        @keyframes dot-bounce {
            0%,80%,100% { transform: scale(0.6); opacity: 0.4; }
            40%         { transform: scale(1.1); opacity: 1; }
        }
        @keyframes blob-drift { 0%,100% { transform: scale(1) translate(0,0); } 50% { transform: scale(1.15) translate(12px,-8px); } }

        #edflow-loader * { box-sizing: border-box; }

        .pl-letter {
            display: inline-block;
            opacity: 0;
            animation: letter-in 0.55s cubic-bezier(0.16,1,0.3,1) forwards;
        }
        .pl-dot {
            display: inline-block;
            animation: dot-bounce 1.4s ease-in-out infinite;
        }
    </style>

    <div id="edflow-loader" style="
        position:fixed;inset:0;z-index:99999;
        background: linear-gradient(150deg,#0f0c29 0%,#302b63 50%,#24243e 100%);
        display:flex;flex-direction:column;align-items:center;justify-content:center;
        overflow:hidden;
    ">
        <!-- ── Ambient blobs ─────────────────────────────────────── -->
        <div style="position:absolute;inset:0;pointer-events:none;overflow:hidden;">
            <div style="
                position:absolute;top:-20%;left:-15%;
                width:65vw;height:65vw;max-width:700px;max-height:700px;
                background:radial-gradient(circle,rgba(99,102,241,0.25) 0%,transparent 70%);
                animation:blob-drift 12s ease-in-out infinite;
                filter:blur(60px);border-radius:50%;
            "></div>
            <div style="
                position:absolute;bottom:-20%;right:-15%;
                width:55vw;height:55vw;max-width:600px;max-height:600px;
                background:radial-gradient(circle,rgba(139,92,246,0.22) 0%,transparent 70%);
                animation:blob-drift 16s ease-in-out infinite reverse;
                filter:blur(70px);border-radius:50%;
            "></div>
            <div style="
                position:absolute;top:35%;left:40%;
                width:40vw;height:40vw;max-width:400px;max-height:400px;
                background:radial-gradient(circle,rgba(79,70,229,0.15) 0%,transparent 70%);
                animation:blob-drift 10s ease-in-out infinite 3s;
                filter:blur(50px);border-radius:50%;
            "></div>
        </div>

        <!-- ── Floating particles ────────────────────────────────── -->
        <div id="pl-particles" style="position:absolute;inset:0;pointer-events:none;overflow:hidden;"></div>

        <!-- ── Main glass orb ───────────────────────────────────── -->
        <div style="position:relative;width:240px;height:240px;margin-bottom:52px;flex-shrink:0;">

            <!-- Pulse rings -->
            <div style="
                position:absolute;inset:-28px;border-radius:50%;
                border:1px solid rgba(99,102,241,0.25);
                animation:pulse-ring 3s ease-in-out infinite;
            "></div>
            <div style="
                position:absolute;inset:-52px;border-radius:50%;
                border:1px solid rgba(139,92,246,0.15);
                animation:pulse-ring 3s ease-in-out infinite 1s;
            "></div>

            <!-- Orbital rings -->
            <div style="
                position:absolute;inset:-20px;
                border-radius:50%;
                border-top:2px solid rgba(99,102,241,0.7);
                border-right:2px solid transparent;
                border-bottom:2px solid rgba(99,102,241,0.2);
                border-left:2px solid transparent;
                animation:ring-spin 3s linear infinite;
                filter:drop-shadow(0 0 8px rgba(99,102,241,0.8));
            "></div>
            <div style="
                position:absolute;inset:-36px;
                border-radius:50%;
                border-top:2px solid transparent;
                border-right:2px solid rgba(139,92,246,0.6);
                border-bottom:2px solid transparent;
                border-left:2px solid rgba(139,92,246,0.2);
                animation:ring-spin2 4.5s linear infinite;
                filter:drop-shadow(0 0 8px rgba(139,92,246,0.6));
            "></div>
            <div style="
                position:absolute;inset:-52px;
                border-radius:50%;
                border-top:1px solid rgba(167,139,250,0.35);
                border-right:1px solid transparent;
                border-bottom:1px solid rgba(167,139,250,0.1);
                border-left:1px solid transparent;
                animation:ring-spin3 7s linear infinite;
            "></div>

            <!-- Morphing glass blob -->
            <div style="
                position:absolute;inset:0;
                background: linear-gradient(135deg,
                    rgba(99,102,241,0.55) 0%,
                    rgba(139,92,246,0.45) 40%,
                    rgba(79,70,229,0.60) 100%);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255,255,255,0.20);
                box-shadow:
                    0 8px 60px rgba(99,102,241,0.45),
                    0 0 0 1px rgba(255,255,255,0.12) inset,
                    0 2px 0 rgba(255,255,255,0.25) inset;
                animation: morph 6s ease-in-out infinite;
                overflow:hidden;
            ">
                <!-- Inner shimmer -->
                <div style="
                    position:absolute;inset:0;
                    background:linear-gradient(135deg,rgba(255,255,255,0.18) 0%,transparent 60%,rgba(255,255,255,0.05) 100%);
                    border-radius:inherit;
                "></div>
                <!-- Spinning shimmer sweep -->
                <div style="
                    position:absolute;top:-50%;left:-50%;width:200%;height:200%;
                    background:conic-gradient(from 0deg,transparent 0%,rgba(255,255,255,0.06) 10%,transparent 20%);
                    animation:ring-spin 4s linear infinite;
                "></div>
            </div>

            <!-- Secondary blob (behind, offset) -->
            <div style="
                position:absolute;inset:12px;
                background: linear-gradient(225deg,
                    rgba(167,139,250,0.35) 0%,
                    rgba(99,102,241,0.2) 100%);
                animation: morph2 8s ease-in-out infinite;
                filter:blur(4px);
                opacity:0.7;
                border-radius:50%;
            "></div>

            <!-- Center icon -->
            <div style="
                position:absolute;inset:0;
                display:flex;align-items:center;justify-content:center;
            ">
                <div style="
                    width:72px;height:72px;
                    background:rgba(255,255,255,0.15);
                    backdrop-filter:blur(12px);
                    border:1px solid rgba(255,255,255,0.30);
                    border-radius:20px;
                    display:flex;align-items:center;justify-content:center;
                    box-shadow:0 4px 24px rgba(0,0,0,0.2),inset 0 1px 0 rgba(255,255,255,0.3);
                ">
                    <i class="fa-solid fa-graduation-cap" style="font-size:30px;color:#fff;filter:drop-shadow(0 0 12px rgba(255,255,255,0.5));"></i>
                </div>
            </div>
        </div>

        <!-- ── Brand name ────────────────────────────────────────── -->
        <div style="margin-bottom:10px;overflow:hidden;">
            <div id="pl-brand" style="
                font-family:'Plus Jakarta Sans',sans-serif;
                font-size:clamp(32px,5vw,48px);
                font-weight:900;
                letter-spacing:-0.03em;
                color:#fff;
                line-height:1;
                animation: logo-glow 3s ease-in-out infinite;
            ">
                <span class="pl-letter" style="animation-delay:0.05s">E</span><span class="pl-letter" style="animation-delay:0.12s">d</span><span class="pl-letter" style="animation-delay:0.19s">F</span><span class="pl-letter" style="animation-delay:0.26s">l</span><span class="pl-letter" style="animation-delay:0.33s">o</span><span class="pl-letter" style="animation-delay:0.40s">w</span><span class="pl-letter" style="animation-delay:0.47s;color:rgba(167,139,250,1)">.</span>
            </div>
        </div>

        <!-- ── Tagline ───────────────────────────────────────────── -->
        <div id="pl-tag" style="
            font-family:'Plus Jakarta Sans',sans-serif;
            font-size:11px;font-weight:600;
            letter-spacing:0.28em;text-transform:uppercase;
            color:rgba(255,255,255,0.35);
            margin-bottom:44px;
            opacity:0;
            animation: letter-in 0.7s cubic-bezier(0.16,1,0.3,1) 0.7s forwards;
        ">Smart Campus · Reimagined</div>

        <!-- ── Progress bar ──────────────────────────────────────── -->
        <div style="width:clamp(180px,28vw,320px);">
            <div style="
                width:100%;height:3px;
                background:rgba(255,255,255,0.08);
                border-radius:999px;overflow:hidden;
                position:relative;
            ">
                <!-- Fill -->
                <div id="preloader-bar" style="
                    height:100%;width:0%;
                    background:linear-gradient(90deg,#6366f1,#8b5cf6,#a78bfa);
                    border-radius:999px;
                    transition:width 0.4s cubic-bezier(0.4,0,0.2,1);
                    position:relative;overflow:hidden;
                ">
                    <!-- Shimmer sweep -->
                    <div style="
                        position:absolute;top:0;left:0;height:100%;width:40%;
                        background:linear-gradient(90deg,transparent,rgba(255,255,255,0.6),transparent);
                        animation:shimmer 1.6s ease-in-out infinite;
                    "></div>
                </div>
            </div>

            <!-- Dots + percent row -->
            <div style="
                display:flex;justify-content:space-between;align-items:center;
                margin-top:14px;
            ">
                <!-- Animated dots -->
                <div style="display:flex;gap:5px;">
                    <span class="pl-dot" style="width:5px;height:5px;border-radius:50%;background:#6366f1;animation-delay:0s;"></span>
                    <span class="pl-dot" style="width:5px;height:5px;border-radius:50%;background:#8b5cf6;animation-delay:0.2s;"></span>
                    <span class="pl-dot" style="width:5px;height:5px;border-radius:50%;background:#a78bfa;animation-delay:0.4s;"></span>
                </div>
                <!-- Percent -->
                <div style="
                    font-family:'Plus Jakarta Sans',sans-serif;
                    font-size:11px;font-weight:700;
                    letter-spacing:0.1em;
                    color:rgba(255,255,255,0.35);
                "><span id="preloader-pct">0</span>%</div>
            </div>
        </div>

        <!-- Skip -->
        <button id="preloader-skip" onclick="window.__skipPreloader&&window.__skipPreloader()" style="
            position:absolute;bottom:28px;right:28px;
            font-family:'Plus Jakarta Sans',sans-serif;
            font-size:10px;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;
            color:rgba(255,255,255,0.18);
            background:none;border:none;cursor:pointer;padding:8px 12px;
            transition:color 0.25s;opacity:0;
        " onmouseover="this.style.color='rgba(255,255,255,0.55)'" onmouseout="this.style.color='rgba(255,255,255,0.18)'">
            Skip ›
        </button>
    </div>

    <!-- ── Preloader Script ──────────────────────────────────────── -->
    <script>
    (function() {
        'use strict';
        const loader  = document.getElementById('edflow-loader');
        const barEl   = document.getElementById('preloader-bar');
        const pctEl   = document.getElementById('preloader-pct');
        const skipBtn = document.getElementById('preloader-skip');

        let currentPct = 0, targetPct = 0, dismissed = false;

        /* ── Floating particles ──────────────────────────────────── */
        const pContainer = document.getElementById('pl-particles');
        const COLORS = ['#6366f1','#8b5cf6','#a78bfa','#c4b5fd','#e0e7ff'];
        for (let i = 0; i < 38; i++) {
            const p = document.createElement('div');
            const size = 3 + Math.random() * 5;
            const x    = Math.random() * 100;
            const dur  = 4 + Math.random() * 6;
            const delay= Math.random() * 5;
            const color= COLORS[Math.floor(Math.random() * COLORS.length)];
            p.style.cssText = `
                position:absolute;bottom:-10px;left:${x}%;
                width:${size}px;height:${size}px;border-radius:50%;
                background:${color};opacity:${0.3+Math.random()*0.5};
                animation:float-up ${dur}s ease-in ${delay}s infinite;
                pointer-events:none;
            `;
            pContainer.appendChild(p);
        }

        /* ── Progress tracking ───────────────────────────────────── */
        let domDone = false, imgsDone = false, fontsDone = false;
        let totalImgs = 0, loadedImgs = 0;

        function calc() {
            let p = 0;
            if (domDone)  p += 40;
            if (totalImgs) p += Math.round((loadedImgs / totalImgs) * 35);
            else           p += 35;
            if (fontsDone) p += 25;
            setTarget(Math.min(p, 99));
        }
        function setTarget(v) { if (v > targetPct) targetPct = v; }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => { domDone = true; calc(); });
        } else { domDone = true; }

        function trackImgs() {
            const imgs = Array.from(document.images);
            totalImgs = imgs.length;
            if (!totalImgs) { imgsDone = true; calc(); return; }
            imgs.forEach(img => {
                if (img.complete) { loadedImgs++; if (loadedImgs >= totalImgs) imgsDone = true; calc(); }
                else {
                    img.addEventListener('load',  () => { loadedImgs++; if (loadedImgs >= totalImgs) imgsDone = true; calc(); });
                    img.addEventListener('error', () => { loadedImgs++; if (loadedImgs >= totalImgs) imgsDone = true; calc(); });
                }
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', trackImgs);
        } else { trackImgs(); }

        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(() => { fontsDone = true; calc(); });
        } else { fontsDone = true; }

        window.addEventListener('load', () => {
            domDone = true; fontsDone = true; imgsDone = true;
            loadedImgs = totalImgs || 0;
            calc();
            setTimeout(forceDone, 200);
        });

        setTimeout(forceDone, 6000);

        function forceDone() { setTarget(100); }
        window.__skipPreloader = forceDone;

        /* ── Show skip after 1.8s ────────────────────────────────── */
        setTimeout(() => { if (!dismissed && skipBtn) skipBtn.style.opacity = '1'; }, 1800);

        /* ── Dismiss with glass-shard exit ───────────────────────── */
        function dismiss() {
            if (dismissed) return;
            dismissed = true;

            /* Shatter the loader into virtual tiles that fly outward */
            const TILES = 16;
            const cols  = 4, rows = 4;
            const W = loader.offsetWidth, H = loader.offsetHeight;

            const shardWrap = document.createElement('div');
            shardWrap.style.cssText = 'position:absolute;inset:0;pointer-events:none;z-index:10;';
            loader.appendChild(shardWrap);

            for (let r = 0; r < rows; r++) {
                for (let c = 0; c < cols; c++) {
                    const s = document.createElement('div');
                    const tx = (c - cols/2 + 0.5) * 180 + (Math.random()-0.5) * 80;
                    const ty = (r - rows/2 + 0.5) * 160 + (Math.random()-0.5) * 80;
                    const tr = (Math.random() - 0.5) * 60;
                    s.style.cssText = `
                        position:absolute;
                        left:${(c/cols)*100}%;top:${(r/rows)*100}%;
                        width:${100/cols}%;height:${100/rows}%;
                        background:linear-gradient(135deg,
                            rgba(99,102,241,${0.18+Math.random()*0.1}) 0%,
                            rgba(139,92,246,${0.12+Math.random()*0.1}) 100%);
                        backdrop-filter:blur(2px);
                        border:1px solid rgba(255,255,255,0.06);
                        --tx:${tx}px;--ty:${ty}px;--tr:${tr}deg;
                        animation: shard-exit 0.7s cubic-bezier(0.4,0,1,1) ${0.05*Math.random()*10}s forwards;
                        transform-origin:center;
                    `;
                    shardWrap.appendChild(s);
                }
            }

            /* Fade out everything else */
            const ui = loader.querySelector('#preloader-ui') || loader;
            if (ui !== loader) {
                ui.style.transition = 'opacity 0.3s';
                ui.style.opacity = '0';
            }

            setTimeout(() => {
                loader.style.transition = 'opacity 0.55s cubic-bezier(0.4,0,0.2,1)';
                loader.style.opacity = '0';
                setTimeout(() => { loader.style.display = 'none'; }, 580);
            }, 420);
        }

        /* ── RAF progress ticker ─────────────────────────────────── */
        (function tick() {
            if (dismissed) return;
            requestAnimationFrame(tick);
            if (currentPct < targetPct) {
                currentPct += (targetPct - currentPct) * 0.045;
                if (targetPct - currentPct < 0.15) currentPct = targetPct;
                const d = Math.round(currentPct);
                if (pctEl) pctEl.textContent = d;
                if (barEl) barEl.style.width  = currentPct + '%';
                if (d >= 100 && !dismissed) dismiss();
            }
        })();
    })();
    </script>


    <!-- Ambient background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10" style="background: linear-gradient(150deg, #ffffff 0%, #f5f3ff 40%, #eef2ff 70%, #f8faff 100%);">
        <!-- Two soft orbs only — gentle, non-spinning -->
        <div class="orb-light" style="width:580px;height:580px;top:-10%;left:-8%;background:radial-gradient(circle, rgba(99,102,241,0.10) 0%, transparent 70%);animation:blob 24s ease-in-out infinite alternate;"></div>
        <div class="orb-light" style="width:500px;height:500px;bottom:-12%;right:-6%;background:radial-gradient(circle, rgba(139,92,246,0.09) 0%, transparent 70%);animation:blob 28s ease-in-out infinite alternate-reverse;animation-delay:3s;"></div>
        <!-- Fine noise texture overlay -->
        <div style="position:absolute;inset:0;opacity:0.012;background-image:url(&quot;data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E&quot;);background-size:200px;"></div>
    </div>

    <nav class="fixed w-full z-50 top-0 transition-all duration-300 glass" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2.5 cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                        <i class="fa-solid fa-graduation-cap text-xl"></i>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900">EdFlow<span class="text-indigo-500">.</span></span>
                </div>

                <div class="hidden md:flex items-center space-x-1">
                    <a href="#features" class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">Features</a>
                    <a href="#testimonials" class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">Testimonials</a>
                    <a href="#stats" class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">Analytics</a>
                    <a href="#faq" class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all mr-2">FAQ</a>



                    <button onclick="toggleRegisterModal()" class="ml-1 px-5 py-2.5 rounded-xl bg-white/80 text-gray-800 border border-gray-200/80 text-sm font-bold hover:bg-white hover:shadow-md transition-all backdrop-blur-sm">
                        Register
                    </button>

                    <a href="/login" class="ml-1 px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-sm font-bold hover:from-indigo-500 hover:to-violet-500 transition-all shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5 inline-block">
                        Log In
                    </a>
                </div>

                <div class="md:hidden flex items-center gap-3">

                    <button id="mobile-menu-btn" class="w-10 h-10 rounded-xl bg-white/80 border border-gray-200/80 flex items-center justify-center text-gray-700 shadow-sm backdrop-blur-sm">
                        <i id="mobile-menu-icon" class="fa-solid fa-bars text-base transition-transform duration-300"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>







    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full badge-glass mb-8 animate-fade-in">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(99,102,241,0.8)]"></span>
                <span class="text-xs font-semibold text-indigo-700 dark:text-indigo-300 uppercase tracking-widest">EdFlow v2.1.0</span>
            </div>

            <h1 class="text-5xl md:text-8xl font-black tracking-tighter text-gray-900 dark:text-white mb-6 animate-fade-in leading-tight md:leading-tight" style="animation-delay: 0.1s;">
                Student Management <br class="hidden md:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 dark:from-indigo-400 dark:via-violet-400 dark:to-purple-400">beautifully unified.</span>
            </h1>

            <p class="mt-6 max-w-2xl mx-auto text-lg md:text-xl text-gray-500 dark:text-gray-400 mb-10 animate-fade-in font-medium" style="animation-delay: 0.2s;">
                EdFlow is a complete student management system solution that helps you automate tasks, manage operations and focus on what matters most — education.
            </p>

            <div class="flex flex-row flex-wrap justify-center gap-3 animate-fade-in" style="animation-delay: 0.3s;">
                <button onclick="toggleRegisterModal()" class="w-72 flex items-center justify-between px-7 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold text-base hover:from-indigo-500 hover:to-violet-500 transition-all duration-300 shadow-xl shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:-translate-y-0.5 group">
                    <span>Apply Now</span>
                    <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/20 group-hover:bg-white/30 transition-colors">
                        <i class="fa-solid fa-arrow-right text-sm group-hover:translate-x-0.5 transition-transform"></i>
                    </span>
                </button>
                <a href="#features" class="w-72 flex items-center justify-between px-7 py-4 rounded-2xl bg-white/70 dark:bg-white/5 text-gray-900 dark:text-white border border-white/90 dark:border-white/10 font-bold text-base hover:bg-white dark:hover:bg-white/10 transition-all duration-300 shadow-lg shadow-indigo-100/60 dark:shadow-none backdrop-blur-sm group">
                    <span>Explore Features</span>
                    <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-indigo-50 dark:bg-white/10 group-hover:bg-indigo-100 dark:group-hover:bg-white/20 transition-colors">
                        <i class="fa-solid fa-arrow-right text-indigo-500 text-sm group-hover:translate-x-0.5 transition-transform"></i>
                    </span>
                </a>
            </div>

            <div class="mt-20 relative mx-auto max-w-5xl animate-fade-in" style="animation-delay: 0.5s; perspective: 1000px;">
                <div class="rounded-2xl md:rounded-[2rem] bg-white/40 dark:bg-white/5 p-2 md:p-3 backdrop-blur-xl border border-white/80 dark:border-white/10 shadow-2xl shadow-indigo-200/40 dark:shadow-none" style="box-shadow: 0 24px 80px rgba(99,102,241,0.12), 0 0 0 1px rgba(255,255,255,0.8), inset 0 1px 0 rgba(255,255,255,0.9);">
                    <div class="rounded-xl md:rounded-2xl bg-white dark:bg-black overflow-hidden relative aspect-[16/9] border border-gray-200 dark:border-gray-800 flex flex-col shadow-inner">
                        <div class="h-10 border-b border-gray-100 dark:border-gray-800 flex items-center px-4 gap-2 bg-gray-50/50 dark:bg-gray-900/50 backdrop-blur-md">
                            <div class="w-3 h-3 rounded-full bg-gray-300 dark:bg-gray-700"></div>
                            <div class="w-3 h-3 rounded-full bg-gray-300 dark:bg-gray-700"></div>
                            <div class="w-3 h-3 rounded-full bg-gray-300 dark:bg-gray-700"></div>
                        </div>
                        <div class="flex-1 relative overflow-hidden bg-gray-900 dark:bg-black flex items-center justify-center group">
                            <!-- Animated Aura Background imitating a video -->
                            <div class="absolute inset-0 z-0 opacity-80 group-hover:opacity-100 transition-opacity duration-1000">
                                <div class="absolute -top-[50%] -left-[50%] w-[200%] h-[200%] bg-gradient-to-r from-brand-600/20 via-purple-500/10 to-indigo-900/30 rounded-full blur-3xl animate-[spin_20s_linear_infinite]"></div>
                                <div class="absolute -bottom-[50%] -right-[50%] w-[200%] h-[200%] bg-gradient-to-l from-brand-400/10 via-blue-500/10 to-purple-600/20 rounded-full blur-3xl animate-[spin_25s_linear_infinite_reverse]"></div>
                            </div>
                            
                            <!-- Glass Overlay UI Elements -->
                            <div class="relative z-10 w-full h-full p-6 md:p-10 flex flex-col justify-between">
                                <div class="flex justify-between items-start">
                                    <div class="space-y-5 w-1/3">
                                        <div class="h-10 w-full bg-white/10 dark:bg-white/5 backdrop-blur-md border border-white/10 rounded-xl overflow-hidden relative shadow-lg">
                                            <div class="absolute inset-y-0 left-0 bg-brand-500/60 w-[65%] shadow-[0_0_20px_rgba(59,130,246,0.8)]"></div>
                                        </div>
                                        <div class="h-10 w-4/5 bg-white/10 dark:bg-white/5 backdrop-blur-md border border-white/10 rounded-xl overflow-hidden relative shadow-lg">
                                            <div class="absolute inset-y-0 left-0 bg-purple-500/60 w-[45%] shadow-[0_0_20px_rgba(168,85,247,0.8)]"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- A stylized central orb or chart ring -->
                                    <div class="w-28 h-28 md:w-36 md:h-36 rounded-full border-[12px] border-white/5 relative flex items-center justify-center backdrop-blur-sm shadow-2xl">
                                        <div class="absolute inset-[-12px] rounded-full border-[12px] border-transparent border-t-brand-500/80 border-r-brand-500/80 animate-[spin_3s_linear_infinite]"></div>
                                        <div class="absolute inset-[-12px] rounded-full border-[12px] border-transparent border-b-purple-500/80 animate-[spin_5s_linear_infinite_reverse]"></div>
                                        <div class="flex flex-col items-center">
                                            <span class="text-white font-black text-2xl md:text-3xl tracking-tighter">94%</span>
                                            <span class="text-brand-200 text-[8px] uppercase tracking-widest">Efficiency</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-3 gap-4 md:gap-6 mt-8">
                                    <div class="h-24 md:h-32 bg-white/10 dark:bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl shadow-xl flex items-end p-4">
                                        <div class="w-full flex items-end gap-2 h-16">
                                            <div class="w-1/4 bg-brand-500/80 rounded-t h-[40%] animate-pulse"></div>
                                            <div class="w-1/4 bg-brand-500/80 rounded-t h-[70%] animate-pulse" style="animation-delay: 150ms"></div>
                                            <div class="w-1/4 bg-brand-500/90 rounded-t h-[95%] shadow-[0_0_15px_rgba(59,130,246,0.5)] animate-pulse" style="animation-delay: 300ms"></div>
                                            <div class="w-1/4 bg-brand-500/80 rounded-t h-[60%] animate-pulse" style="animation-delay: 450ms"></div>
                                        </div>
                                    </div>
                                    <div class="h-24 md:h-32 bg-white/10 dark:bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl shadow-xl flex items-center justify-center relative overflow-hidden">
                                        <div class="absolute inset-0 bg-[linear-gradient(45deg,transparent_25%,rgba(255,255,255,0.1)_50%,transparent_75%,transparent_100%)] bg-[length:250%_250%] animate-[textShimmer_3s_linear_infinite]"></div>
                                        <i class="fa-solid fa-microchip text-4xl text-white/80 z-10 animate-pulse"></i>
                                    </div>
                                    <div class="h-24 md:h-32 bg-white/10 dark:bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl shadow-xl p-4 md:p-6 flex flex-col justify-center gap-3">
                                        <div class="h-2.5 w-full bg-white/30 rounded-full animate-pulse" style="animation-delay: 0ms"></div>
                                        <div class="h-2.5 w-5/6 bg-white/30 rounded-full animate-pulse" style="animation-delay: 200ms"></div>
                                        <div class="h-2.5 w-4/6 bg-white/30 rounded-full animate-pulse" style="animation-delay: 400ms"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ═══════════════════════════════════════════════════════════════
         FIXED MOBILE BOTTOM NAVIGATION BAR
         Only on mobile (< 768 px). Stays fixed at bottom of viewport.
         Page content scrolls freely above it.
    ═══════════════════════════════════════════════════════════════ -->
    <style>
        /* ── Fixed bottom bar: mobile only ── */
        #mob-bottom-bar {
            display: none;
        }
        @media (max-width: 767px) {
            #mob-bottom-bar {
                display: block;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 9990;
            }
            /* Push page content above bar so nothing hides behind it */
            body { padding-bottom: 160px; }
        }

        /* Wave SVG shape at top of bar */
        #mob-bottom-bar .mbb-wave {
            display: block;
            width: 100%;
            line-height: 0;
            overflow: hidden;
            filter: drop-shadow(0 -6px 18px rgba(99,102,241,0.20));
        }

        /* Body of the bar */
        #mob-bottom-bar .mbb-body {
            background: linear-gradient(160deg,#eef2ff 0%,#ede9fe 45%,#dbeafe 100%);
            padding: 4px 12px 12px;
        }
        .dark #mob-bottom-bar .mbb-body {
            background: linear-gradient(160deg,#0f172a 0%,#1e1b4b 50%,#0c1a3a 100%);
        }

        /* Grid layouts */
        #mob-bottom-bar .mbb-row1 {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 7px;
            margin-bottom: 7px;
        }
        #mob-bottom-bar .mbb-row2 {
            display: grid;
            grid-template-columns: repeat(2,1fr);
            gap: 7px;
        }

        /* Each card */
        .mbb-card {
            background: rgba(255,255,255,0.92);
            border: 1px solid rgba(255,255,255,0.95);
            border-radius: 14px;
            padding: 9px 6px 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 10px rgba(99,102,241,0.10), inset 0 1px 0 rgba(255,255,255,1);
            transition: transform .22s cubic-bezier(.34,1.56,.64,1), box-shadow .22s ease;
            position: relative;
            overflow: hidden;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
        .dark .mbb-card {
            background: rgba(30,27,75,0.80);
            border-color: rgba(99,102,241,0.2);
        }
        .mbb-card:hover  { transform: translateY(-3px) scale(1.03); box-shadow: 0 8px 24px rgba(99,102,241,0.20); }
        .mbb-card:active { transform: scale(0.94); }

        /* Icon pill */
        .mbb-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; color: #fff;
            transition: transform .25s cubic-bezier(.34,1.56,.64,1);
        }
        .mbb-card:hover .mbb-icon { transform: scale(1.15) rotate(-5deg); }
        .mbb-i-blue   { background: linear-gradient(135deg,#3b82f6,#6366f1); box-shadow:0 3px 10px rgba(99,102,241,.35); }
        .mbb-i-purple { background: linear-gradient(135deg,#8b5cf6,#a855f7); box-shadow:0 3px 10px rgba(168,85,247,.35); }
        .mbb-i-rose   { background: linear-gradient(135deg,#f43f5e,#e11d48); box-shadow:0 3px 10px rgba(244,63,94,.35); }
        .mbb-i-green  { background: linear-gradient(135deg,#10b981,#059669); box-shadow:0 3px 10px rgba(16,185,129,.35); }
        .mbb-i-amber  { background: linear-gradient(135deg,#f59e0b,#d97706); box-shadow:0 3px 10px rgba(245,158,11,.35); }

        /* Label */
        .mbb-label {
            font-size: 10px; font-weight: 700;
            color: #1e1b4b; text-align: center; line-height: 1.2;
        }
        .dark .mbb-label { color: #e0e7ff; }

        /* ── Botpress chatbot: float at top-right of wave nav on mobile ── */
        @media (max-width: 767px) {
            #bp-web-widget-container {
                bottom: 148px !important;  /* sits right at / overlapping the wave top-right */
                right: 10px !important;
                z-index: 9995 !important;
            }
        }
    </style>

    <!-- Fixed bottom bar HTML -->
    <div id="mob-bottom-bar" aria-label="Quick Navigation" role="navigation">
        <!-- Animated Water Flow Wave -->
        <div class="mbb-wave" style="height:32px; position:relative; overflow:hidden;">

            <!-- LIGHT MODE waves -->
            <svg class="dark:hidden" style="position:absolute;bottom:0;left:0;width:200%;height:100%;" viewBox="0 0 780 32" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Back wave: slower, lighter -->
                <path fill="#c7d2fe" fill-opacity="0.5"
                      d="M0,16 C65,28 130,4 195,16 C260,28 325,4 390,16 C455,28 520,4 585,16 C650,28 715,4 780,16 L780,32 L0,32 Z">
                    <animateTransform attributeName="transform" type="translate" from="0,0" to="-390,0" dur="4s" repeatCount="indefinite"/>
                </path>
                <!-- Front wave: faster, solid fill -->
                <path fill="#eef2ff"
                      d="M0,18 C50,8 100,28 155,18 C210,8 265,28 320,18 C375,8 430,28 485,18 C540,8 595,28 650,18 C705,8 760,28 780,18 L780,32 L0,32 Z">
                    <animateTransform attributeName="transform" type="translate" from="0,0" to="-390,0" dur="2.5s" repeatCount="indefinite"/>
                </path>
                <!-- Shimmer highlight -->
                <path fill="white" fill-opacity="0.35"
                      d="M0,20 C80,12 160,26 240,20 C320,14 400,26 480,20 C560,14 640,26 720,20 L780,20 L780,32 L0,32 Z">
                    <animateTransform attributeName="transform" type="translate" from="-390,0" to="0,0" dur="3.5s" repeatCount="indefinite"/>
                </path>
            </svg>

            <!-- DARK MODE waves -->
            <svg class="hidden dark:block" style="position:absolute;bottom:0;left:0;width:200%;height:100%;" viewBox="0 0 780 32" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="#1e1b4b" fill-opacity="0.6"
                      d="M0,16 C65,28 130,4 195,16 C260,28 325,4 390,16 C455,28 520,4 585,16 C650,28 715,4 780,16 L780,32 L0,32 Z">
                    <animateTransform attributeName="transform" type="translate" from="0,0" to="-390,0" dur="4s" repeatCount="indefinite"/>
                </path>
                <path fill="#0f172a"
                      d="M0,18 C50,8 100,28 155,18 C210,8 265,28 320,18 C375,8 430,28 485,18 C540,8 595,28 650,18 C705,8 760,28 780,18 L780,32 L0,32 Z">
                    <animateTransform attributeName="transform" type="translate" from="0,0" to="-390,0" dur="2.5s" repeatCount="indefinite"/>
                </path>
                <path fill="#6366f1" fill-opacity="0.08"
                      d="M0,20 C80,12 160,26 240,20 C320,14 400,26 480,20 C560,14 640,26 720,20 L780,20 L780,32 L0,32 Z">
                    <animateTransform attributeName="transform" type="translate" from="-390,0" to="0,0" dur="3.5s" repeatCount="indefinite"/>
                </path>
            </svg>

        </div>
        <div class="mbb-body">
            <!-- Row 1: Features · Testimonials · Log In -->
            <div class="mbb-row1">
                <a href="#features" id="mbb-features" class="mbb-card" aria-label="Features">
                    <div class="mbb-icon mbb-i-blue"><i class="fa-solid fa-grip"></i></div>
                    <span class="mbb-label">Features</span>
                </a>
                <a href="#testimonials" id="mbb-testimonials" class="mbb-card" aria-label="Testimonials">
                    <div class="mbb-icon mbb-i-purple"><i class="fa-solid fa-users"></i></div>
                    <span class="mbb-label">Testimonials</span>
                </a>
                <a href="/login" id="mbb-login" class="mbb-card" aria-label="Log In">
                    <div class="mbb-icon mbb-i-rose"><i class="fa-solid fa-user"></i></div>
                    <span class="mbb-label">Log in</span>
                </a>
            </div>
            <!-- Row 2: Create Account · Analytics -->
            <div class="mbb-row2">
                <button onclick="toggleRegisterModal()" id="mbb-register" class="mbb-card w-full" aria-label="Create Account">
                    <div class="mbb-icon mbb-i-green"><i class="fa-solid fa-user-plus"></i></div>
                    <span class="mbb-label">Create Account</span>
                </button>
                <a href="#stats" id="mbb-analytics" class="mbb-card" aria-label="Analytics">
                    <div class="mbb-icon mbb-i-amber"><i class="fa-solid fa-chart-line"></i></div>
                    <span class="mbb-label">Analytics</span>
                </a>
            </div>
        </div>
    </div>
    <!-- /mob-bottom-bar -->




    <div class="relative py-4 overflow-hidden border-y border-white/20 group cursor-pointer text-sm shadow-2xl shadow-brand-500/20">
        <!-- Animated vibrant background -->
        <div class="absolute inset-0 bg-gradient-to-r from-brand-600 via-purple-500 to-brand-600 bg-[length:200%_auto] animate-[textShimmer_4s_linear_infinite]"></div>
        
        <div class="flex animate-marquee whitespace-nowrap group-hover:[animation-play-state:paused] relative z-10 items-center">
            
            <!-- Block 1 -->
            <div class="flex items-center gap-12 mx-4">
                <div class="flex items-center gap-3">
                    <span class="text-white font-black uppercase tracking-[0.2em] text-xs drop-shadow-md">Admissions Open 2026-2027</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 bg-yellow-300 rounded-full animate-pulse shadow-[0_0_12px_rgba(253,224,71,0.9)]"></span>
                    <span class="text-white font-medium tracking-wide">Limited Seats Available</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 bg-green-300 rounded-full animate-pulse shadow-[0_0_12px_rgba(134,239,172,0.9)]" style="animation-delay: 500ms;"></span>
                    <span class="text-white font-medium tracking-wide">Scholarships up to 50%</span>
                </div>
                <button onclick="toggleRegisterModal()" class="relative inline-flex items-center justify-center px-6 py-2 font-black text-brand-700 bg-white rounded-full overflow-hidden hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,255,255,0.5)] group/btn border-2 border-transparent hover:border-white hover:text-white hover:bg-transparent">
                    <div class="absolute inset-0 flex h-full w-full justify-center [transform:skew(-12deg)_translateX(-150%)] group-hover/btn:duration-1000 group-hover/btn:[transform:skew(-12deg)_translateX(150%)]">
                        <div class="relative h-full w-8 bg-white/40"></div>
                    </div>
                    <span class="relative flex items-center gap-2">Apply Now <i class="fa-solid fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i></span>
                </button>
            </div>

            <!-- Block 2 -->
            <div class="flex items-center gap-12 mx-4">
                <div class="flex items-center gap-3">
                    <span class="text-white font-black uppercase tracking-[0.2em] text-xs drop-shadow-md">Admissions Open 2026-2027</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 bg-yellow-300 rounded-full animate-pulse shadow-[0_0_12px_rgba(253,224,71,0.9)]"></span>
                    <span class="text-white font-medium tracking-wide">Limited Seats Available</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 bg-green-300 rounded-full animate-pulse shadow-[0_0_12px_rgba(134,239,172,0.9)]" style="animation-delay: 500ms;"></span>
                    <span class="text-white font-medium tracking-wide">Scholarships up to 50%</span>
                </div>
                <button onclick="toggleRegisterModal()" class="relative inline-flex items-center justify-center px-6 py-2 font-black text-brand-700 bg-white rounded-full overflow-hidden hover:scale-105 transition-all shadow-[0_0_20px_rgba(255,255,255,0.5)] group/btn border-2 border-transparent hover:border-white hover:text-white hover:bg-transparent">
                    <div class="absolute inset-0 flex h-full w-full justify-center [transform:skew(-12deg)_translateX(-150%)] group-hover/btn:duration-1000 group-hover/btn:[transform:skew(-12deg)_translateX(150%)]">
                        <div class="relative h-full w-8 bg-white/40"></div>
                    </div>
                    <span class="relative flex items-center gap-2">Apply Now <i class="fa-solid fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform"></i></span>
                </button>
            </div>

        </div>
    </div>

    <section id="features" class="py-24 section-glass transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-brand-600 dark:text-gray-400 font-bold tracking-widest uppercase text-xs mb-3">Core Modules</h2>
                <h3 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">Everything you need.</h3>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Powerful systems perfectly integrated into one unified dashboard.</p>
            </div>

            <!-- Premium Bento Grid — all 10 cards, smooth & performant -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 auto-rows-[300px]">

                <!-- 1. Large Card: Analytics -->
                <div class="md:col-span-2 md:row-span-2 group rounded-[2rem] bg-gradient-to-br from-indigo-50 to-violet-50 shadow-md overflow-hidden border border-indigo-100/60">
                    <div class="bento-card-inner w-full h-full rounded-[2rem] p-10 flex flex-col overflow-hidden">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-200">
                            <i class="fa-solid fa-chart-line text-xl"></i>
                        </div>
                        <!-- Mini bar chart -->
                        <div class="flex items-end gap-1.5 h-16 mb-5">
                            <div class="flex-1 bg-indigo-200 rounded-t group-hover:bg-indigo-400 transition-colors duration-300" style="height:40%"></div>
                            <div class="flex-1 bg-indigo-200 rounded-t group-hover:bg-indigo-400 transition-colors duration-300 delay-[40ms]" style="height:65%"></div>
                            <div class="flex-1 bg-indigo-200 rounded-t group-hover:bg-indigo-400 transition-colors duration-300 delay-[80ms]" style="height:50%"></div>
                            <div class="flex-1 bg-violet-200 rounded-t group-hover:bg-violet-500 transition-colors duration-300 delay-[120ms]" style="height:85%"></div>
                            <div class="flex-1 bg-violet-200 rounded-t group-hover:bg-violet-500 transition-colors duration-300 delay-[160ms]" style="height:72%"></div>
                            <div class="flex-1 bg-indigo-300 rounded-t group-hover:bg-indigo-600 transition-colors duration-300 delay-[200ms]" style="height:95%"></div>
                        </div>
                        <div class="flex gap-3 mb-5">
                            <div class="flex-1 rounded-xl bg-indigo-50 border border-indigo-100 px-3 py-2 text-center">
                                <div class="text-lg font-black text-indigo-600">94%</div>
                                <div class="text-[10px] text-indigo-400 font-bold uppercase tracking-wider">Efficiency</div>
                            </div>
                            <div class="flex-1 rounded-xl bg-violet-50 border border-violet-100 px-3 py-2 text-center">
                                <div class="text-lg font-black text-violet-600">+18%</div>
                                <div class="text-[10px] text-violet-400 font-bold uppercase tracking-wider">Growth</div>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <h3 class="text-2xl font-black tracking-tight text-gray-900 mb-3">Performance Analytics</h3>
                            <p class="text-gray-500 leading-relaxed font-medium max-w-sm text-base">Deep, actionable insights into student performance, attendance patterns, and institutional health.</p>
                        </div>
                    </div>
                </div>

                <!-- 2. Medium Card: QR Identity -->
                <div class="md:col-span-2 md:row-span-1 group rounded-[2rem] bg-gradient-to-br from-blue-50 to-sky-50 shadow-md overflow-hidden border border-blue-100/60">
                    <div class="bento-card-inner w-full h-full rounded-[2rem] p-8 flex flex-row items-center gap-6 overflow-hidden">
                        <div class="shrink-0 w-20 h-20 rounded-2xl bg-white border-2 border-blue-100 p-2 shadow-md group-hover:scale-105 group-hover:rotate-2 transition-transform duration-200">
                            <div class="grid grid-cols-3 gap-0.5 w-full h-full">
                                <div class="bg-gray-800 rounded-sm"></div><div class="bg-gray-100 rounded-sm"></div><div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-gray-100 rounded-sm"></div><div class="bg-blue-500 rounded-sm"></div><div class="bg-gray-100 rounded-sm"></div>
                                <div class="bg-gray-800 rounded-sm"></div><div class="bg-gray-100 rounded-sm"></div><div class="bg-gray-800 rounded-sm"></div>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 border border-blue-100 mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Instant Scan</span>
                            </div>
                            <h3 class="text-xl font-black tracking-tight text-gray-900 mb-1.5">Smart QR Identity</h3>
                            <p class="text-gray-500 leading-relaxed font-medium text-sm">Instantly generate scannable digital ID cards for dynamic &amp; highly secure campus access control.</p>
                        </div>
                    </div>
                </div>

                <!-- 3. Small Card: Live Tracker -->
                <div class="md:col-span-1 md:row-span-1 group rounded-[2rem] bg-gradient-to-br from-emerald-50 to-teal-50 shadow-md overflow-hidden border border-emerald-100/60">
                    <div class="bento-card-inner w-full h-full rounded-[2rem] p-6 flex flex-col justify-between overflow-hidden items-center text-center">
                        <div class="relative w-14 h-14 flex items-center justify-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform duration-200">
                                <i class="fa-solid fa-satellite-dish text-xl"></i>
                            </div>
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-emerald-500 rounded-full ring-2 ring-white"></span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black tracking-tight text-gray-900 mb-1">Live Tracker</h3>
                            <p class="text-gray-500 text-sm font-medium">Secure live GPS tracking.</p>
                        </div>
                    </div>
                </div>

                <!-- 4. Small Card: StudyAI Agent (dark card) -->
                <div class="md:col-span-1 md:row-span-1 group rounded-[2rem] overflow-hidden shadow-md">
                    <div class="w-full h-full bg-gray-900 rounded-[2rem] p-6 flex flex-col justify-between overflow-hidden text-center items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-rose-500 to-orange-500 rounded-xl flex items-center justify-center text-white mb-2 shadow-lg shadow-rose-500/25 group-hover:scale-105 transition-transform duration-200">
                            <i class="fa-solid fa-robot text-xl"></i>
                        </div>
                        <div class="w-full space-y-1.5 mb-1">
                            <div class="flex justify-end"><div class="text-[10px] bg-rose-500/25 text-rose-300 rounded-xl px-2 py-1 max-w-[80%] text-right">Explain photosynthesis</div></div>
                            <div class="flex justify-start"><div class="text-[10px] bg-white/10 text-gray-400 rounded-xl px-2 py-1 max-w-[80%] opacity-0 group-hover:opacity-100 transition-opacity duration-200">Sure! It's the process...</div></div>
                        </div>
                        <div>
                            <h3 class="text-xl font-black tracking-tight text-white mb-1">StudyAI Agent</h3>
                            <p class="text-gray-400 text-sm font-medium">Gemini-powered tutor.</p>
                        </div>
                    </div>
                </div>

                <!-- 5. Medium Card: Parent Access -->
                <div class="md:col-span-2 md:row-span-1 group rounded-[2rem] bg-gradient-to-br from-indigo-50 to-blue-50 shadow-md overflow-hidden border border-indigo-100/60">
                    <div class="bento-card-inner w-full h-full rounded-[2rem] p-8 flex flex-row items-center gap-6 overflow-hidden">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-200 shrink-0">
                            <i class="fa-solid fa-users text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-indigo-50 border border-indigo-100 mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Live Updates</span>
                            </div>
                            <h3 class="text-xl font-black tracking-tight text-gray-900 mb-1.5">Parent Access</h3>
                            <p class="text-gray-500 leading-relaxed font-medium text-sm">Empower parents with real-time access to their children's attendance, grades, and fee records securely.</p>
                            <div class="mt-3 space-y-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <div class="flex items-center gap-2 text-[11px] text-indigo-600 font-bold">
                                    <i class="fa-solid fa-circle-check text-emerald-500"></i> Attendance: 91% — On Track
                                </div>
                                <div class="flex items-center gap-2 text-[11px] text-indigo-600 font-bold">
                                    <i class="fa-solid fa-indian-rupee-sign text-amber-500"></i> Fee Status: Paid ✓
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. Medium Card: Broadcasting -->
                <div class="md:col-span-2 md:row-span-1 group rounded-[2rem] bg-gradient-to-br from-amber-50 to-orange-50 shadow-md overflow-hidden border border-amber-100/60">
                    <div class="bento-card-inner w-full h-full rounded-[2rem] p-8 flex flex-row items-center gap-6 overflow-hidden">
                        <div class="relative shrink-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-500/20 group-hover:scale-105 group-hover:rotate-3 transition-transform duration-200">
                                <i class="fa-solid fa-bullhorn text-2xl"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-black tracking-tight text-gray-900 mb-1">Broadcasting</h3>
                            <p class="text-gray-500 leading-relaxed font-medium text-sm">Instantly deliver subject-specific announcements and urgent institutional notices across all devices.</p>
                            <div class="mt-3 space-y-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <div class="flex items-center gap-2 text-[11px] text-amber-700 font-bold bg-amber-50 rounded-lg px-2 py-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></span> Exam schedule updated — Math, 2nd Floor
                                </div>
                                <div class="flex items-center gap-2 text-[11px] text-amber-700 font-bold bg-amber-50 rounded-lg px-2 py-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shrink-0"></span> Holiday notice: 15th April
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 7. Medium Card: AI Study Coach -->
                <div class="md:col-span-2 md:row-span-1 group rounded-[2rem] bg-gradient-to-br from-fuchsia-50 to-purple-50 shadow-md overflow-hidden border border-fuchsia-100/60">
                    <div class="bento-card-inner w-full h-full rounded-[2rem] p-8 flex flex-row items-center gap-6 overflow-hidden">
                        <div class="w-16 h-16 bg-gradient-to-br from-fuchsia-400 to-fuchsia-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-fuchsia-500/20 group-hover:scale-105 transition-transform duration-200 shrink-0">
                            <i class="fa-solid fa-brain text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-fuchsia-50 border border-fuchsia-100 mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-fuchsia-500"></span>
                                <span class="text-[10px] font-black text-fuchsia-600 uppercase tracking-widest">Gemini Powered</span>
                            </div>
                            <h3 class="text-xl font-black tracking-tight text-gray-900 mb-1.5">AI Study Coach</h3>
                            <p class="text-gray-500 leading-relaxed font-medium text-sm">An intelligent assistant to personalize study plans, solve queries, and provide 24/7 support.</p>
                            <div class="mt-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-fuchsia-100 text-fuchsia-700">Math Plan ✓</span>
                                <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-purple-100 text-purple-700">Physics Quiz</span>
                                <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-indigo-100 text-indigo-700">+ 5 more</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 8. Medium Card: SOS Emergency -->
                <div class="md:col-span-2 md:row-span-1 group rounded-[2rem] bg-gradient-to-br from-red-50 to-rose-50 shadow-md overflow-hidden border border-red-100/60">
                    <div class="bento-card-inner w-full h-full rounded-[2rem] p-8 flex flex-row items-center gap-6 overflow-hidden">
                        <div class="relative shrink-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-red-500/20 group-hover:scale-105 group-hover:rotate-3 transition-transform duration-200">
                                <i class="fa-solid fa-bell text-2xl"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 border border-red-200 mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                <span class="text-[10px] font-black text-red-600 uppercase tracking-widest">Panic Alert Active</span>
                            </div>
                            <h3 class="text-xl font-black tracking-tight text-gray-900 mb-1.5">SOS for Emergency</h3>
                            <p class="text-gray-500 leading-relaxed font-medium text-sm">Instant panic alerts triggered by students automatically notify parents with live location data in emergencies.</p>
                            <div class="mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <div class="flex items-center gap-2 text-[11px] text-red-700 font-bold bg-red-50 rounded-lg px-2 py-1">
                                    <i class="fa-solid fa-location-dot text-red-500"></i> GPS signal acquired — Parent notified in 0.3s
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 9. Large Card: AI Attendance Prediction -->
                <div class="md:col-span-2 md:row-span-2 group rounded-[2rem] bg-gradient-to-br from-cyan-50 to-sky-50 shadow-md overflow-hidden border border-cyan-100/60">
                    <div class="bento-card-inner w-full h-full rounded-[2rem] p-10 flex flex-col overflow-hidden">
                        <div class="w-16 h-16 bg-gradient-to-br from-cyan-400 to-sky-600 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-cyan-500/20 group-hover:scale-105 transition-transform duration-200">
                            <i class="fa-solid fa-chart-simple text-2xl"></i>
                        </div>
                        <!-- Animated prediction bars -->
                        <div class="mb-6 space-y-3">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-gray-400 w-16 shrink-0">Week 1</span>
                                <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-cyan-400 to-sky-500 rounded-full group-hover:w-[88%] w-[50%] transition-all duration-700 ease-out"></div>
                                </div>
                                <span class="text-xs font-black text-cyan-500 w-10 text-right">88%</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-gray-400 w-16 shrink-0">Week 2</span>
                                <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-amber-400 to-orange-500 rounded-full group-hover:w-[61%] w-[30%] transition-all duration-700 ease-out delay-75"></div>
                                </div>
                                <span class="text-xs font-black text-amber-500 w-10 text-right">61%</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-gray-400 w-16 shrink-0">Week 3</span>
                                <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-rose-400 to-red-500 rounded-full group-hover:w-[42%] w-[20%] transition-all duration-700 ease-out delay-150"></div>
                                </div>
                                <span class="text-xs font-black text-rose-500 w-10 text-right">42%</span>
                            </div>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-xs font-bold text-gray-400 w-16 shrink-0">Predicted</span>
                                <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-violet-500 to-purple-600 rounded-full group-hover:w-[38%] w-[15%] transition-all duration-700 ease-out delay-200"></div>
                                </div>
                                <span class="text-xs font-black text-violet-500 w-10 text-right">~38%</span>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cyan-50 border border-cyan-200 mb-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                                <span class="text-[10px] font-black text-cyan-600 uppercase tracking-widest">AI Powered</span>
                            </div>
                            <h3 class="text-2xl font-black tracking-tight text-gray-900 mb-3">AI Attendance Prediction</h3>
                            <p class="text-gray-500 leading-relaxed font-medium max-w-sm text-base">Analyzes historical trends to predict future eligibility risk. Automatically triggers smart alerts for at-risk students before it's too late.</p>
                        </div>
                    </div>
                </div>

                <!-- 10. Large Card: Dropout Risk Detection -->
                <div class="md:col-span-2 md:row-span-2 group rounded-[2rem] bg-gradient-to-br from-rose-50 to-orange-50 shadow-md overflow-hidden border border-rose-100/60">
                    <div class="bento-card-inner w-full h-full rounded-[2rem] p-10 flex flex-col overflow-hidden">
                        <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-orange-600 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg shadow-rose-500/20 group-hover:scale-105 transition-transform duration-200">
                            <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                        </div>
                        <!-- Risk score cards -->
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-3 text-center group-hover:scale-[1.03] transition-transform duration-200">
                                <div class="text-xl font-black text-emerald-600">Safe</div>
                                <div class="text-[10px] text-emerald-500 font-bold uppercase tracking-wider mt-1">Score &lt; 30</div>
                                <div class="mt-2 w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center mx-auto">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                                </div>
                            </div>
                            <div class="rounded-2xl bg-amber-50 border border-amber-200 p-3 text-center group-hover:scale-[1.03] transition-transform duration-200 delay-50">
                                <div class="text-xl font-black text-amber-600">At Risk</div>
                                <div class="text-[10px] text-amber-500 font-bold uppercase tracking-wider mt-1">Score 30–59</div>
                                <div class="mt-2 w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center mx-auto">
                                    <i class="fa-solid fa-circle-exclamation text-amber-500 text-sm"></i>
                                </div>
                            </div>
                            <div class="rounded-2xl bg-rose-50 border border-rose-200 p-3 text-center group-hover:scale-[1.03] transition-transform duration-200 delay-100">
                                <div class="text-xl font-black text-rose-600">High Risk</div>
                                <div class="text-[10px] text-rose-500 font-bold uppercase tracking-wider mt-1">Score ≥ 60</div>
                                <div class="mt-2 w-8 h-8 rounded-full bg-rose-500/20 flex items-center justify-center mx-auto">
                                    <i class="fa-solid fa-skull-crossbones text-rose-500 text-sm"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 border border-rose-200 mb-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                <span class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Early Warning System</span>
                            </div>
                            <h3 class="text-2xl font-black tracking-tight text-gray-900 mb-3">Dropout Risk Detection</h3>
                            <p class="text-gray-500 leading-relaxed font-medium max-w-sm text-base">Intelligently scores each student's dropout likelihood by fusing attendance, academic performance, and engagement data into one actionable risk index.</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <section id="testimonials" class="py-24 bg-white dark:bg-black overflow-hidden relative border-t border-gray-100 dark:border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Text Side -->
                <div>
                    <h2 class="text-brand-600 dark:text-gray-400 font-bold tracking-widest uppercase text-xs mb-3">Wall of Love</h2>
                    <h3 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl leading-tight mb-6">Trusted by leading educators.</h3>
                    <p class="text-lg text-gray-500 dark:text-gray-400 mb-10 max-w-lg leading-relaxed">See how EdFlow is transforming campuses globally. Our platform completely removes administrative friction, allowing staff to focus entirely on improving student success.</p>
                    
                    <div class="flex items-center gap-4">
                        <div class="flex -space-x-4">
                            <div class="w-12 h-12 rounded-full border-[3px] border-white dark:border-black bg-brand-500 text-white flex items-center justify-center font-bold text-sm shadow-sm relative z-40">SJ</div>
                            <div class="w-12 h-12 rounded-full border-[3px] border-white dark:border-black bg-purple-500 text-white flex items-center justify-center font-bold text-sm shadow-sm relative z-30">DR</div>
                            <div class="w-12 h-12 rounded-full border-[3px] border-white dark:border-black bg-emerald-500 text-white flex items-center justify-center font-bold text-sm shadow-sm relative z-20">MP</div>
                            <div class="w-12 h-12 rounded-full border-[3px] border-white dark:border-black bg-rose-500 text-white flex items-center justify-center font-bold text-sm shadow-sm relative z-10">JD</div>
                        </div>
                        <div>
                            <div class="flex items-center text-yellow-400 text-sm mb-1">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            </div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">1,200+ 5-Star Reviews</p>
                        </div>
                    </div>
                </div>

                <!-- Card Shuffle Side -->
                <div class="relative h-[380px] md:h-[350px] w-full max-w-lg mx-auto lg:ml-auto [perspective:1000px]">
                    <!-- Shuffle Cards -->
                    <div class="shuffle-card absolute w-full rounded-[2rem] bg-white/95 dark:bg-zinc-900/90 backdrop-blur-xl border border-gray-200/60 dark:border-white/10 shadow-2xl p-8 transition-all duration-[800ms] ease-[cubic-bezier(0.22,1,0.36,1)]" data-index="0">
                        <div class="text-brand-500 mb-6 opacity-80"><i class="fa-solid fa-quote-left text-4xl"></i></div>
                        <p class="text-gray-900 dark:text-white mb-8 leading-relaxed text-lg font-medium">"EdFlow completely removed the friction from our administrative tasks. The AI integrations alone save our staff dozens of hours every week."</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-brand-100 dark:bg-brand-900/40 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-lg">SJ</div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm">Sarah Jenkins</h4>
                                <p class="text-xs text-brand-600 dark:text-brand-400 font-bold tracking-wide uppercase mt-1">Principal, Westfield High</p>
                            </div>
                        </div>
                    </div>

                    <div class="shuffle-card absolute w-full rounded-[2rem] bg-white/95 dark:bg-zinc-900/90 backdrop-blur-xl border border-gray-200/60 dark:border-white/10 shadow-2xl p-8 transition-all duration-[800ms] ease-[cubic-bezier(0.22,1,0.36,1)]" data-index="1">
                        <div class="text-purple-500 mb-6 opacity-80"><i class="fa-solid fa-quote-left text-4xl"></i></div>
                        <p class="text-gray-900 dark:text-white mb-8 leading-relaxed text-lg font-medium">"The analytics dashboard is a game-changer. We can now accurately track student performance trends and intervene before issues arise."</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold text-lg">DR</div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm">Dr. Robert Chen</h4>
                                <p class="text-xs text-purple-600 dark:text-purple-400 font-bold tracking-wide uppercase mt-1">Dean of Academics</p>
                            </div>
                        </div>
                    </div>

                    <div class="shuffle-card absolute w-full rounded-[2rem] bg-white/95 dark:bg-zinc-900/90 backdrop-blur-xl border border-gray-200/60 dark:border-white/10 shadow-2xl p-8 transition-all duration-[800ms] ease-[cubic-bezier(0.22,1,0.36,1)]" data-index="2">
                        <div class="text-emerald-500 mb-6 opacity-80"><i class="fa-solid fa-quote-left text-4xl"></i></div>
                        <p class="text-gray-900 dark:text-white mb-8 leading-relaxed text-lg font-medium">"As a student, having all my attendance, fees, and examination results in one clean interface makes my college life so much less stressful."</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-lg">MP</div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm">Maya Patel</h4>
                                <p class="text-xs text-emerald-600 dark:text-emerald-400 font-bold tracking-wide uppercase mt-1">Computer Science Student</p>
                            </div>
                        </div>
                    </div>

                    <div class="shuffle-card absolute w-full rounded-[2rem] bg-white/95 dark:bg-zinc-900/90 backdrop-blur-xl border border-gray-200/60 dark:border-white/10 shadow-2xl p-8 transition-all duration-[800ms] ease-[cubic-bezier(0.22,1,0.36,1)]" data-index="3">
                        <div class="text-rose-500 mb-6 opacity-80"><i class="fa-solid fa-quote-left text-4xl"></i></div>
                        <p class="text-gray-900 dark:text-white mb-8 leading-relaxed text-lg font-medium">"Deployment was seamless. The ability to manage thousands of student records securely on the cloud is exactly what our IT team needed."</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-rose-100 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400 flex items-center justify-center font-bold text-lg">JD</div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm">James Doe</h4>
                                <p class="text-xs text-rose-600 dark:text-rose-400 font-bold tracking-wide uppercase mt-1">IT Administrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="stats" class="py-24 relative overflow-hidden stats-glass">
        <!-- Colorful ambient background glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute -top-[20%] right-[10%] w-[600px] h-[600px] bg-indigo-400/15 rounded-full blur-[100px] dark:mix-blend-screen animate-[pulse_10s_infinite]"></div>
            <div class="absolute -bottom-[20%] left-[10%] w-[600px] h-[600px] bg-violet-400/10 rounded-full blur-[100px] dark:mix-blend-screen animate-[pulse_15s_infinite_reverse]"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Title -->
            <div class="text-center mb-16">
                <h2 class="text-indigo-600 dark:text-brand-400 font-bold tracking-widest uppercase text-xs mb-3">Live Metrics</h2>
                <h3 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white sm:text-5xl">Scale with confidence.</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <!-- Stat 1: Indigo -->
                <div class="group relative p-8 rounded-[2rem] glass-card hover:border-indigo-400/60 hover:shadow-indigo-100/60 dark:hover:border-brand-500/50 dark:hover:bg-white/10 transition-all duration-500 overflow-hidden hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/8 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <i class="fa-solid fa-users text-4xl text-indigo-500 dark:text-brand-400 mb-6 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-500 drop-shadow-[0_0_15px_rgba(99,102,241,0.4)]"></i>
                        <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-b from-gray-900 to-gray-400 dark:from-white dark:to-gray-500 mb-3"><span class="count-up" data-target="50">0</span>k+</div>
                        <div class="text-gray-500 dark:text-gray-400 text-xs font-bold tracking-widest uppercase group-hover:text-indigo-600 dark:group-hover:text-brand-300 transition-colors">Students Managed</div>
                    </div>
                </div>

                <!-- Stat 2: Purple -->
                <div class="group relative p-8 rounded-[2rem] glass-card hover:border-violet-400/60 hover:shadow-violet-100/60 dark:hover:border-purple-500/50 dark:hover:bg-white/10 transition-all duration-500 overflow-hidden hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-violet-500/8 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <i class="fa-solid fa-building-columns text-4xl text-violet-500 dark:text-purple-400 mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 drop-shadow-[0_0_15px_rgba(139,92,246,0.4)]"></i>
                        <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-b from-gray-900 to-gray-400 dark:from-white dark:to-gray-500 mb-3"><span class="count-up" data-target="120">0</span>+</div>
                        <div class="text-gray-500 dark:text-gray-400 text-xs font-bold tracking-widest uppercase group-hover:text-violet-600 dark:group-hover:text-purple-300 transition-colors">Institutions</div>
                    </div>
                </div>

                <!-- Stat 3: Emerald -->
                <div class="group relative p-8 rounded-[2rem] glass-card hover:border-emerald-400/60 hover:shadow-emerald-100/60 dark:hover:border-emerald-500/50 dark:hover:bg-white/10 transition-all duration-500 overflow-hidden hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/8 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <i class="fa-solid fa-server text-4xl text-emerald-500 dark:text-emerald-400 mb-6 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 drop-shadow-[0_0_15px_rgba(52,211,153,0.4)]"></i>
                        <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-b from-gray-900 to-gray-400 dark:from-white dark:to-gray-500 mb-3"><span class="count-up" data-target="99.9">0</span>%</div>
                        <div class="text-gray-500 dark:text-gray-400 text-xs font-bold tracking-widest uppercase group-hover:text-emerald-600 dark:group-hover:text-emerald-300 transition-colors">Uptime Guarantee</div>
                    </div>
                </div>

                <!-- Stat 4: Orange -->
                <div class="group relative p-8 rounded-[2rem] glass-card hover:border-orange-400/60 hover:shadow-orange-100/60 dark:hover:border-orange-500/50 dark:hover:bg-white/10 transition-all duration-500 overflow-hidden hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-500/8 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <i class="fa-solid fa-headset text-4xl text-orange-500 dark:text-orange-400 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 drop-shadow-[0_0_15px_rgba(251,146,60,0.4)]"></i>
                        <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-b from-gray-900 to-gray-400 dark:from-white dark:to-gray-500 mb-3"><span class="count-up" data-target="24">0</span>/7</div>
                        <div class="text-gray-500 dark:text-gray-400 text-xs font-bold tracking-widest uppercase group-hover:text-orange-600 dark:group-hover:text-orange-300 transition-colors">Live Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Use Section -->
    <section id="how-to-use" class="py-32 relative section-glass transition-colors duration-300 overflow-hidden">
        <!-- Ambient animated background -->
        <div class="absolute inset-0 z-0 pointer-events-none opacity-40 dark:opacity-20">
            <div class="absolute top-[20%] right-[10%] w-[400px] h-[400px] bg-brand-500/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen animate-[pulse_10s_infinite]"></div>
            <div class="absolute bottom-[20%] left-[10%] w-[500px] h-[500px] bg-purple-500/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen animate-[pulse_12s_infinite_reverse]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16">
                 <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-50 dark:bg-brand-500/10 border border-brand-200 dark:border-brand-500/20 text-brand-600 dark:text-brand-400 font-bold tracking-widest uppercase text-xs mb-6 shadow-[0_0_15px_rgba(59,130,246,0.2)]">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span> Guide
                </div>
                <h3 class="text-4xl md:text-5xl font-black tracking-tight text-gray-900 dark:text-white mb-4">See EdFlow in <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-purple-600 dark:from-brand-400 dark:to-purple-400">Action</span></h3>
                <p class="text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto font-medium">Master the platform in minutes. Watch our quick start guide and follow the simple steps to revolutionize your campus management today.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Video Container (Left Side) -->
                <div class="relative group mx-auto w-full max-w-2xl lg:max-w-none [perspective:1000px]">
                    <!-- Glowing backplate -->
                    <div class="absolute -inset-2 bg-gradient-to-r from-brand-600 to-purple-600 rounded-[3rem] blur-xl opacity-30 group-hover:opacity-60 transition duration-1000 group-hover:duration-200 animate-pulse"></div>
                    
                    <div class="relative rounded-[2.5rem] bg-white/80 dark:bg-zinc-900/80 backdrop-blur-xl p-2 md:p-4 border border-gray-200/50 dark:border-white/10 shadow-2xl overflow-hidden transform group-hover:scale-[1.02] group-hover:-rotate-1 transition-all duration-700 ease-[cubic-bezier(0.22,1,0.36,1)]">
                        <!-- Mac OS window style bar -->
                        <div class="h-12 border-b border-gray-100 dark:border-white/5 flex items-center px-5 gap-2 bg-gray-50/50 dark:bg-black/50 mb-3 rounded-t-[2rem]">
                            <div class="w-3.5 h-3.5 rounded-full bg-rose-400 dark:bg-rose-500/80 shadow-sm"></div>
                            <div class="w-3.5 h-3.5 rounded-full bg-amber-400 dark:bg-amber-500/80 shadow-sm"></div>
                            <div class="w-3.5 h-3.5 rounded-full bg-emerald-400 dark:bg-emerald-500/80 shadow-sm"></div>
                            <div class="ml-4 flex-1 flex justify-center">
                                <div class="px-5 py-1.5 rounded-full bg-white/60 dark:bg-white/5 border border-gray-200/50 dark:border-white/10 text-[11px] text-gray-500 dark:text-gray-400 font-bold tracking-wider hover:bg-white dark:hover:bg-white/10 transition-colors cursor-default">edflow-demo.mp4</div>
                            </div>
                        </div>
                        
                        <!-- Video iframe container -->
                        <div class="relative aspect-video rounded-[1.5rem] overflow-hidden bg-gray-100 dark:bg-black drop-shadow-xl border border-gray-200/50 dark:border-white/5 group-hover:shadow-[0_0_30px_rgba(59,130,246,0.3)] transition-shadow duration-500">
                            <iframe class="absolute inset-0 w-full h-full object-cover" src="https://www.youtube.com/embed/OFDIXIPKN3c?autoplay=0&controls=1&rel=0&showinfo=0&modestbranding=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>

                <!-- Instructions (Right Side) -->
                <div class="space-y-8 relative">
                    <!-- Vertical joining line (desktop only) -->
                    <div class="hidden lg:block absolute left-[27px] top-8 bottom-8 w-1 h-[calc(100%-4rem)] bg-gradient-to-b from-brand-500/30 via-purple-500/30 to-emerald-500/30 z-0 rounded-full"></div>

                    <!-- Step 1 -->
                    <div class="relative z-10 flex gap-6 group">
                        <div class="flex flex-col items-center">
                            <div class="relative w-14 h-14 rounded-2xl bg-white dark:bg-zinc-900 border-2 border-brand-500 shadow-lg shadow-brand-500/20 flex items-center justify-center font-black text-xl text-brand-600 dark:text-brand-400 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-500 overflow-hidden">
                                <div class="absolute inset-0 bg-brand-500/5 group-hover:bg-brand-500/20 transition-colors"></div>
                                1
                            </div>
                        </div>
                        <div class="pt-2 group-hover:translate-x-2 transition-transform duration-500">
                            <h4 class="text-2xl font-black text-gray-900 dark:text-white mb-2 tracking-tight group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">Create your account</h4>
                            <p class="text-gray-600 dark:text-gray-400 font-medium leading-relaxed">Sign up in seconds. Enter your institutional details, role, and set up your secure credentials to join the ecosystem instantly.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative z-10 flex gap-6 group">
                        <div class="flex flex-col items-center">
                            <div class="relative w-14 h-14 rounded-2xl bg-white dark:bg-zinc-900 border-2 border-purple-500 shadow-lg shadow-purple-500/20 flex items-center justify-center font-black text-xl text-purple-600 dark:text-purple-400 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 overflow-hidden">
                                <div class="absolute inset-0 bg-purple-500/5 group-hover:bg-purple-500/20 transition-colors"></div>
                                2
                            </div>
                        </div>
                        <div class="pt-2 group-hover:translate-x-2 transition-transform duration-500">
                            <h4 class="text-2xl font-black text-gray-900 dark:text-white mb-2 tracking-tight group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">Configure Dashboard</h4>
                            <p class="text-gray-600 dark:text-gray-400 font-medium leading-relaxed">Personalize your workspace. Set up your classes, subjects, and sync data seamlessly with our smart import tools.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative z-10 flex gap-6 group">
                        <div class="flex flex-col items-center">
                            <div class="relative w-14 h-14 rounded-2xl bg-white dark:bg-zinc-900 border-2 border-emerald-500 shadow-lg shadow-emerald-500/20 flex items-center justify-center font-black text-xl text-emerald-600 dark:text-emerald-400 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 overflow-hidden">
                                <div class="absolute inset-0 bg-emerald-500/5 group-hover:bg-emerald-500/20 transition-colors"></div>
                                3
                            </div>
                        </div>
                        <div class="pt-2 group-hover:translate-x-2 transition-transform duration-500">
                            <h4 class="text-2xl font-black text-gray-900 dark:text-white mb-2 tracking-tight group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">Automate & Manage</h4>
                            <p class="text-gray-600 dark:text-gray-400 font-medium leading-relaxed">Let EdFlow handle the rest. Track attendance with QR codes, generate fee receipts, and analyze results on auto-pilot.</p>
                        </div>
                    </div>

                    <div class="pt-6 pl-[80px]">
                        <button onclick="toggleRegisterModal()" class="relative group/btn inline-flex items-center justify-center px-8 py-4 font-black text-white bg-gray-900 dark:bg-white dark:text-gray-900 text-sm rounded-full overflow-hidden shadow-xl hover:shadow-2xl transition-all hover:scale-105 hover:-translate-y-1 group border border-transparent">
                            <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-purple-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300 dark:hidden"></div>
                            <span class="relative z-10 flex items-center gap-3 group-hover/btn:text-white dark:group-hover/btn:text-gray-900 transition-colors">Start using EdFlow <i class="fa-solid fa-arrow-right text-xs transform group-hover/btn:translate-x-1 transition-transform"></i></span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-32 relative section-glass transition-colors duration-300 overflow-hidden">
        
        <!-- Animated Ambient Background -->
        <div class="absolute inset-0 z-0 pointer-events-none opacity-40 dark:opacity-20">
            <div class="absolute top-[30%] -left-[10%] w-[500px] h-[500px] bg-brand-500/30 rounded-full blur-[120px] mix-blend-multiply dark:mix-blend-screen animate-[pulse_8s_infinite]"></div>
            <div class="absolute bottom-[10%] -right-[10%] w-[600px] h-[600px] bg-emerald-500/20 rounded-full blur-[120px] mix-blend-multiply dark:mix-blend-screen animate-[pulse_12s_infinite_reverse]"></div>
        </div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <!-- Glowing badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-50 dark:bg-brand-500/10 border border-brand-200 dark:border-brand-500/20 text-brand-600 dark:text-brand-400 font-bold tracking-widest uppercase text-xs mb-6 shadow-[0_0_15px_rgba(59,130,246,0.2)]">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span> FAQ
                </div>
                <!-- Colorful gradient title -->
                <h3 class="text-4xl font-black tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-brand-600 to-gray-900 dark:from-white dark:via-brand-400 dark:to-white sm:text-6xl mb-4 leading-tight">Got questions? <br/>We have answers.</h3>
            </div>
            
            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="group relative bg-white dark:bg-zinc-900/40 backdrop-blur-xl border border-gray-200 dark:border-white/10 rounded-[1.5rem] hover:border-brand-500/50 dark:hover:border-brand-500/50 shadow-sm hover:shadow-2xl hover:shadow-brand-500/10 transition-all duration-500 overflow-hidden transform hover:-translate-y-1">
                    <!-- Left colorful accent bar -->
                    <div class="absolute top-0 bottom-0 left-0 w-1.5 bg-gradient-to-b from-brand-400 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <button class="faq-btn w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-bold text-gray-900 dark:text-white group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors text-lg pr-4">What exactly is EdFlow?</span>
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-gray-50 dark:bg-white/5 flex items-center justify-center border border-gray-200 dark:border-white/10 group-hover:bg-brand-500 group-hover:border-brand-500 group-hover:shadow-[0_0_15px_rgba(59,130,246,0.5)] transition-all duration-300">
                            <i class="fa-solid fa-chevron-down text-gray-500 dark:text-gray-400 group-hover:text-white transition-transform duration-300 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-content px-8 text-gray-600 dark:text-gray-300 text-base font-medium leading-relaxed">
                        <div class="pb-6 border-t border-gray-100 dark:border-white/5 pt-4 mt-2">
                            EdFlow is an all-in-one cloud-based Smart Campus Management system. It provides dedicated portals for Administrators, Teachers, and Students to manage everything from academic results and attendance to admissions and internal communications securely.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="group relative bg-white dark:bg-zinc-900/40 backdrop-blur-xl border border-gray-200 dark:border-white/10 rounded-[1.5rem] hover:border-purple-500/50 dark:hover:border-purple-500/50 shadow-sm hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-500 overflow-hidden transform hover:-translate-y-1">
                    <div class="absolute top-0 bottom-0 left-0 w-1.5 bg-gradient-to-b from-purple-400 to-rose-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="faq-btn w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-bold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors text-lg pr-4">Is our institutional data secure?</span>
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-gray-50 dark:bg-white/5 flex items-center justify-center border border-gray-200 dark:border-white/10 group-hover:bg-purple-500 group-hover:border-purple-500 group-hover:shadow-[0_0_15px_rgba(168,85,247,0.5)] transition-all duration-300">
                            <i class="fa-solid fa-chevron-down text-gray-500 dark:text-gray-400 group-hover:text-white transition-transform duration-300 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-content px-8 text-gray-600 dark:text-gray-300 text-base font-medium leading-relaxed">
                        <div class="pb-6 border-t border-gray-100 dark:border-white/5 pt-4 mt-2">
                            Absolutely. EdFlow uses industry-standard encryption protocols. We feature role-based access control (RBAC), meaning a student can never see administrative settings, and a teacher can only modify grades for their assigned subjects. Passwords are automatically generated and securely hashed.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="group relative bg-white dark:bg-zinc-900/40 backdrop-blur-xl border border-gray-200 dark:border-white/10 rounded-[1.5rem] hover:border-emerald-500/50 dark:hover:border-emerald-500/50 shadow-sm hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500 overflow-hidden transform hover:-translate-y-1">
                    <div class="absolute top-0 bottom-0 left-0 w-1.5 bg-gradient-to-b from-emerald-400 to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="faq-btn w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors text-lg pr-4">How does the integrated AI Assistant work?</span>
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-gray-50 dark:bg-white/5 flex items-center justify-center border border-gray-200 dark:border-white/10 group-hover:bg-emerald-500 group-hover:border-emerald-500 group-hover:shadow-[0_0_15px_rgba(16,185,129,0.5)] transition-all duration-300">
                            <i class="fa-solid fa-chevron-down text-gray-500 dark:text-gray-400 group-hover:text-white transition-transform duration-300 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-content px-8 text-gray-600 dark:text-gray-300 text-base font-medium leading-relaxed">
                        <div class="pb-6 border-t border-gray-100 dark:border-white/5 pt-4 mt-2">
                            Our StudyAI feature utilizes the powerful Gemini API. It acts as an on-demand tutor for students to ask academic questions, summarize notes, or prepare for exams. For teachers, it can help draft lesson plans and generate quiz questions instantly inside the portal.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="group relative bg-white dark:bg-zinc-900/40 backdrop-blur-xl border border-gray-200 dark:border-white/10 rounded-[1.5rem] hover:border-rose-500/50 dark:hover:border-rose-500/50 shadow-sm hover:shadow-2xl hover:shadow-rose-500/10 transition-all duration-500 overflow-hidden transform hover:-translate-y-1">
                    <div class="absolute top-0 bottom-0 left-0 w-1.5 bg-gradient-to-b from-rose-400 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <button class="faq-btn w-full px-8 py-6 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-bold text-gray-900 dark:text-white group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors text-lg pr-4">Do you support custom integrations?</span>
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-gray-50 dark:bg-white/5 flex items-center justify-center border border-gray-200 dark:border-white/10 group-hover:bg-rose-500 group-hover:border-rose-500 group-hover:shadow-[0_0_15px_rgba(244,63,94,0.5)] transition-all duration-300">
                            <i class="fa-solid fa-chevron-down text-gray-500 dark:text-gray-400 group-hover:text-white transition-transform duration-300 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-content px-8 text-gray-600 dark:text-gray-300 text-base font-medium leading-relaxed">
                        <div class="pb-6 border-t border-gray-100 dark:border-white/5 pt-4 mt-2">
                            Yes! Our admissions portal already seamlessly integrates with Google Sheets CRM so your administration team can review applicant data in real-time without leaving their familiar workflow. We offer additional API webhooks upon request.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer id="contact" class="relative section-glass border-t border-indigo-100/60 dark:border-white/5 pt-24 pb-10 transition-colors duration-300 overflow-hidden">
        
        <!-- Ambient Footer Glow -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-[800px] h-[400px] bg-indigo-400/15 dark:bg-brand-600/30 rounded-full blur-[120px] dark:mix-blend-screen pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Brand Profile -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="relative w-10 h-10 bg-gradient-to-br from-brand-500 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-[0_0_20px_rgba(59,130,246,0.5)]">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <span class="font-black text-2xl tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-400">EdFlow<span class="text-brand-500">.</span></span>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed font-medium">
                        The all-in-one cloud campus management solution. Streamlining operations so institutions can focus purely on education.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-brand-500 hover:text-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-[0_0_15px_rgba(59,130,246,0.5)]"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/in/thesomishere/" target="_blank" class="w-10 h-10 rounded-full bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-blue-600 hover:text-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-[0_0_15px_rgba(37,99,235,0.5)]"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="https://github.com/somnath-sen" target="_blank" class="w-10 h-10 rounded-full bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-900 hover:text-white dark:hover:bg-white dark:hover:text-black transition-all duration-300 transform hover:-translate-y-1 hover:shadow-[0_0_15px_rgba(255,255,255,0.3)]"><i class="fa-brands fa-github"></i></a>
                        <a href="https://www.instagram.com/thesomishere/" target="_blank" class="w-10 h-10 rounded-full bg-gray-50 dark:bg-white/5 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-rose-500 hover:text-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-[0_0_15px_rgba(244,63,94,0.5)]"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Product Links -->
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-6 uppercase tracking-widest text-xs">Product</h4>
                    <ul class="space-y-4 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <li class="group flex items-center"><i class="fa-solid fa-arrow-right text-[10px] text-brand-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 mr-2"></i><a href="#" class="group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">Overview</a></li>
                        <li class="group flex items-center"><i class="fa-solid fa-arrow-right text-[10px] text-brand-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 mr-2"></i><a href="#features" class="group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">Features</a></li>
                        <li class="group flex items-center"><i class="fa-solid fa-arrow-right text-[10px] text-brand-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 mr-2"></i><a href="#testimonials" class="group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">Testimonials</a></li>
                        <li class="group flex items-center"><i class="fa-solid fa-arrow-right text-[10px] text-brand-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 mr-2"></i><a href="#faq" class="group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Company Links -->
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-6 uppercase tracking-widest text-xs">Company</h4>
                    <ul class="space-y-4 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <li class="group flex items-center"><i class="fa-solid fa-arrow-right text-[10px] text-purple-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 mr-2"></i><button onclick="toggleCustomModal('aboutModal')" class="group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors cursor-pointer text-left focus:outline-none">About Us</button></li>
                        <li class="group flex items-center"><i class="fa-solid fa-arrow-right text-[10px] text-purple-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 mr-2"></i><button onclick="toggleCustomModal('careersModal')" class="group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors cursor-pointer text-left focus:outline-none">Careers</button></li>
                        <li class="group flex items-center"><i class="fa-solid fa-arrow-right text-[10px] text-purple-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 mr-2"></i><button onclick="toggleCustomModal('contactDetailsModal')" class="group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors cursor-pointer text-left focus:outline-none">Contact</button></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-6 uppercase tracking-widest text-xs">Stay Updated</h4>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 font-medium">Subscribe to our newsletter for the latest updates.</p>
                    <form id="newsletterForm" class="space-y-3">
                        <div class="relative group/input">
                            <div class="absolute inset-0 bg-gradient-to-r from-brand-500 to-purple-600 rounded-xl blur opacity-20 group-hover/input:opacity-50 transition-opacity duration-500"></div>
                            <input type="email" id="newsletterEmail" name="email" placeholder="Enter your email" required class="relative w-full pl-5 pr-10 py-3.5 rounded-xl bg-white dark:bg-zinc-900/80 backdrop-blur-sm border border-gray-200 dark:border-white/10 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 dark:text-white transition-all shadow-sm placeholder-gray-400">
                        </div>
                        <button type="submit" id="subscribeBtn" class="relative group/btn w-full py-3.5 px-4 rounded-xl text-sm font-black transition-all shadow-lg overflow-hidden border border-transparent hover:border-white/20">
                            <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-purple-600 group-hover/btn:scale-105 transition-transform duration-500"></div>
                            <span class="relative z-10 flex items-center justify-center text-white gap-2">
                                Subscribe <i class="fa-solid fa-paper-plane text-xs"></i>
                                <i class="fa-solid fa-spinner fa-spin hidden" id="btnLoader"></i>
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-200 dark:border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 mt-10">
                <p class="text-sm font-bold text-gray-600 dark:text-gray-400 text-center md:text-left">&copy; {{ date('Y') }} EdFlow Inc. All rights reserved.</p>
                <div class="flex space-x-6 text-sm font-bold text-gray-600 dark:text-gray-400">
                    <button onclick="toggleCustomModal('privacyModal')" class="hover:text-brand-600 dark:hover:text-white transition-colors focus:outline-none">Privacy Policy</button>
                    <button onclick="toggleCustomModal('termsModal')" class="hover:text-brand-600 dark:hover:text-white transition-colors focus:outline-none">Terms of Service</button>
                </div>
            </div>

            <div class="mt-8 text-center bg-gray-50 dark:bg-white/5 rounded-2xl py-4 border border-gray-200 dark:border-white/10">
                <p class="text-sm font-bold text-gray-600 dark:text-gray-300 flex items-center justify-center gap-2">
                    Designed & Developed by 
                    <span class="inline-block animate-pulse text-rose-500 text-lg drop-shadow-[0_0_8px_rgba(244,63,94,0.8)]"><i class="fa-solid fa-heart"></i></span> 
                    <a href="https://somnath-sen.github.io/somnathsen/" target="_blank" class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-purple-600 dark:from-brand-400 dark:to-purple-400 hover:opacity-80 transition-opacity">Somnath Sen</a>
                </p>
            </div>
        </div>
    </footer>

    <div id="loginModal" class="fixed inset-0 z-[100] hidden custom-modal">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('loginModal')"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white/70 dark:bg-zinc-900/70 backdrop-blur-3xl w-full max-w-md rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden transform transition-all scale-100 border border-white/50 dark:border-white/10 pointer-events-auto flex flex-col">
                <div class="flex items-center justify-between px-4 py-3 bg-white/40 dark:bg-white/5 border-b border-gray-200/50 dark:border-white/10">
                    <div class="flex items-center gap-2 w-16">
                        <button onclick="toggleCustomModal('loginModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10">
                            <i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i>
                        </button>
                        <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                        <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                    </div>
                    <h2 class="text-xs font-bold text-gray-700 dark:text-gray-300 tracking-wide">Welcome Back</h2>
                    <div class="w-16"></div>
                </div>
                <div class="p-8">
                    <p class="text-gray-500 dark:text-gray-400 mb-8 text-center text-sm font-medium">Select your account type to continue.</p>
                    
                    <div class="space-y-4">
                        <a href="{{ route('login') }}?type=student" class="flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-brand-500 dark:hover:border-brand-500 hover:bg-brand-50 dark:hover:bg-gray-700 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-brand-100 dark:bg-brand-900/50 text-brand-600 dark:text-brand-400 flex items-center justify-center mr-4 group-hover:bg-brand-600 group-hover:text-white transition-colors"><i class="fa-solid fa-graduation-cap"></i></div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Student</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Access course & results</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-auto text-gray-300 dark:text-gray-600 group-hover:text-brand-500"></i>
                        </a>
                        <a href="{{ route('login') }}?type=teacher" class="flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-purple-500 dark:hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-gray-700 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 flex items-center justify-center mr-4 group-hover:bg-purple-600 group-hover:text-white transition-colors"><i class="fa-solid fa-chalkboard-user"></i></div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Teacher</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Manage class & attendance</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-auto text-gray-300 dark:text-gray-600 group-hover:text-purple-500"></i>
                        </a>
                        <a href="{{ route('login') }}?type=admin" class="flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-gray-900 dark:hover:border-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center mr-4 group-hover:bg-gray-900 group-hover:text-white transition-colors"><i class="fa-solid fa-shield-halved"></i></div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Administrator</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">System settings</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-auto text-gray-300 dark:text-gray-600 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="registerModal" class="fixed inset-0 z-[100] hidden custom-modal">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('registerModal')"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white/70 dark:bg-zinc-900/70 backdrop-blur-3xl w-full max-w-md rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden transform transition-all scale-100 border border-white/50 dark:border-white/10 pointer-events-auto flex flex-col">
                <div class="flex items-center justify-between px-4 py-3 bg-white/40 dark:bg-white/5 border-b border-gray-200/50 dark:border-white/10">
                    <div class="flex items-center gap-2 w-16">
                        <button onclick="toggleCustomModal('registerModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10">
                            <i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i>
                        </button>
                        <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                        <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                    </div>
                    <h2 class="text-xs font-bold text-gray-700 dark:text-gray-300 tracking-wide">Join EdFlow</h2>
                    <div class="w-16"></div>
                </div>
                <div class="p-8">
                    <p class="text-gray-500 dark:text-gray-400 mb-8 text-center text-sm font-medium">Select your application type to submit a registration request.</p>
                    
                    <div class="space-y-4">
                        <a href="/register/student" class="flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-brand-500 dark:hover:border-brand-500 hover:bg-brand-50 dark:hover:bg-gray-700 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-brand-100 dark:bg-brand-900/50 text-brand-600 dark:text-brand-400 flex items-center justify-center mr-4 group-hover:bg-brand-600 group-hover:text-white transition-colors"><i class="fa-solid fa-graduation-cap"></i></div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Apply as Student</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Enrollment application</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-auto text-gray-300 dark:text-gray-600 group-hover:text-brand-500"></i>
                        </a>
                        <a href="/register/teacher" class="flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-purple-500 dark:hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-gray-700 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 flex items-center justify-center mr-4 group-hover:bg-purple-600 group-hover:text-white transition-colors"><i class="fa-solid fa-chalkboard-user"></i></div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Apply as Faculty</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Instructor application</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-auto text-gray-300 dark:text-gray-600 group-hover:text-purple-500"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="aboutModal" class="fixed inset-0 z-[100] hidden custom-modal">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('aboutModal')"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white/70 dark:bg-zinc-900/70 backdrop-blur-3xl w-full max-w-lg rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden transform transition-all scale-100 border border-white/50 dark:border-white/10 pointer-events-auto flex flex-col">
                <div class="flex items-center justify-between px-4 py-3 bg-white/40 dark:bg-white/5 border-b border-gray-200/50 dark:border-white/10">
                    <div class="flex items-center gap-2 w-16">
                        <button onclick="toggleCustomModal('aboutModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10">
                            <i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i>
                        </button>
                        <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                        <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                    </div>
                    <h2 class="text-xs font-bold text-gray-700 dark:text-gray-300 tracking-wide flex items-center gap-2"><i class="fa-solid fa-building text-brand-500"></i> About EdFlow</h2>
                    <div class="w-16"></div>
                </div>
                <div class="p-8">
                    <div class="flex justify-center items-center mb-6 hidden">
                        <div class="flex items-center gap-3">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">About EdFlow</h2>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-sm">
                            EdFlow is a next-generation campus management platform built to seamlessly bridge the gap between modern education and advanced cloud technology. 
                        </p>
                        <div class="bg-brand-50 dark:bg-brand-900/20 p-5 rounded-xl border border-brand-100 dark:border-brand-800/50">
                            <h4 class="font-bold text-brand-700 dark:text-brand-400 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-bullseye"></i> Our Mission
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                To completely eliminate administrative friction so educators can focus 100% of their energy on teaching and student success.
                            </p>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-sm">
                            Founded on the principles of speed, security, and simplicity, EdFlow replaces dozens of outdated systems with one beautiful, unified dashboard.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="careersModal" class="fixed inset-0 z-[100] hidden custom-modal">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('careersModal')"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white/70 dark:bg-zinc-900/70 backdrop-blur-3xl w-full max-w-lg rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden transform transition-all scale-100 border border-white/50 dark:border-white/10 pointer-events-auto flex flex-col">
                <div class="flex items-center justify-between px-4 py-3 bg-white/40 dark:bg-white/5 border-b border-gray-200/50 dark:border-white/10">
                    <div class="flex items-center gap-2 w-16">
                        <button onclick="toggleCustomModal('careersModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10">
                            <i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i>
                        </button>
                        <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                        <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                    </div>
                    <h2 class="text-xs font-bold text-gray-700 dark:text-gray-300 tracking-wide flex items-center gap-2"><i class="fa-solid fa-briefcase text-purple-500"></i> Join Our Team</h2>
                    <div class="w-16"></div>
                </div>
                <div class="p-8">
                    <p class="text-gray-500 dark:text-gray-400 mb-6 text-center text-sm font-medium">We are always looking for passionate individuals to build the future of education technology.</p>
                    
                    <div class="space-y-3">
                        <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-purple-50 transition-colors group cursor-not-allowed opacity-80">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white transition-colors">Laravel Backend Engineer</h4>
                                    <p class="text-xs text-gray-500 mt-1">Remote • Full Time</p>
                                </div>
                                <span class="text-xs font-bold px-2 py-1 bg-gray-200 dark:bg-gray-800 text-gray-500 rounded">Filled</span>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-purple-500 transition-colors group cursor-not-allowed opacity-80">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white transition-colors">UI/UX Product Designer</h4>
                                    <p class="text-xs text-gray-500 mt-1">Hybrid • Full Time</p>
                                </div>
                                <span class="text-xs font-bold px-2 py-1 bg-gray-200 dark:bg-gray-800 text-gray-500 rounded">Filled</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 text-center p-4 rounded-xl bg-brand-50 dark:bg-brand-900/20 border border-brand-100 dark:border-brand-800/50">
                        <p class="text-sm text-brand-700 dark:text-brand-300 font-medium">Don't see a perfect fit right now?</p>
                        <p class="text-xs text-brand-600/80 dark:text-brand-400 mt-1">Send your resume to <a href="mailto:careers@edflow.com" class="font-bold hover:underline">careers@edflow.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="contactDetailsModal" class="fixed inset-0 z-[100] hidden custom-modal">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('contactDetailsModal')"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white/70 dark:bg-zinc-900/70 backdrop-blur-3xl w-full max-w-md rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden transform transition-all scale-100 border border-white/50 dark:border-white/10 pointer-events-auto flex flex-col">
                <div class="flex items-center justify-between px-4 py-3 bg-white/40 dark:bg-white/5 border-b border-gray-200/50 dark:border-white/10">
                    <div class="flex items-center gap-2 w-16">
                        <button onclick="toggleCustomModal('contactDetailsModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10">
                            <i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i>
                        </button>
                        <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                        <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                    </div>
                    <h2 class="text-xs font-bold text-gray-700 dark:text-gray-300 tracking-wide">Get in Touch</h2>
                    <div class="w-16"></div>
                </div>
                <div class="p-8">
                    
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700 mb-6">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-brand-500 to-purple-600 text-white rounded-full flex items-center justify-center text-2xl font-bold shadow-md">
                                SS
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Somnath Sen</h3>
                                <p class="text-sm text-brand-600 dark:text-brand-400 font-medium">Founder & Lead Developer</p>
                            </div>
                        </div>
                        
                        <div class="space-y-5">
                            <div class="flex items-center gap-4 text-gray-600 dark:text-gray-300">
                                <div class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm border border-gray-100 dark:border-gray-700 text-brand-500"><i class="fa-solid fa-phone"></i></div>
                                <div>
                                    <p class="text-[11px] uppercase tracking-wider font-bold text-gray-400">Direct Contact</p>
                                    <p class="font-medium text-sm">+91 98765 43210</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-gray-600 dark:text-gray-300">
                                <div class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm border border-gray-100 dark:border-gray-700 text-purple-500"><i class="fa-solid fa-envelope"></i></div>
                                <div>
                                    <p class="text-[11px] uppercase tracking-wider font-bold text-gray-400">Business Email</p>
                                    <a href="mailto:somnath@edflow.com" class="font-medium text-sm hover:text-brand-600 transition-colors">somnath@edflow.com</a>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-gray-600 dark:text-gray-300">
                                <div class="w-10 h-10 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm border border-gray-100 dark:border-gray-700 text-emerald-500"><i class="fa-solid fa-location-dot"></i></div>
                                <div>
                                    <p class="text-[11px] uppercase tracking-wider font-bold text-gray-400">Headquarters</p>
                                    <p class="font-medium text-sm">Academy of Technology Campus, WB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="privacyModal" class="fixed inset-0 z-[100] hidden custom-modal">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('privacyModal')"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white/70 dark:bg-zinc-900/70 backdrop-blur-3xl w-full max-w-2xl rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden transform transition-all scale-100 border border-white/50 dark:border-white/10 pointer-events-auto flex flex-col max-h-[85vh]">
                <div class="flex items-center justify-between px-4 py-3 bg-white/40 dark:bg-white/5 border-b border-gray-200/50 dark:border-white/10">
                    <div class="flex items-center gap-2 w-16">
                        <button onclick="toggleCustomModal('privacyModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10">
                            <i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i>
                        </button>
                        <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                        <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                    </div>
                    <h2 class="text-xs font-bold text-gray-700 dark:text-gray-300 tracking-wide flex items-center gap-2"><i class="fa-solid fa-shield-halved text-brand-500"></i> Privacy Policy</h2>
                    <div class="w-16"></div>
                </div>
                <div class="p-8 overflow-y-auto custom-scroll flex-1">
                    <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 space-y-5">
                        <p><strong>Last Updated: {{ date('F Y') }}</strong></p>
                        <p>At EdFlow, we take your privacy seriously. This policy explains how we collect, use, and protect your personal information.</p>
                        
                        <h4 class="text-gray-900 dark:text-white font-bold">1. Information We Collect</h4>
                        <p>We collect information necessary to provide our educational management services. This includes names, email addresses, academic records, and role assignments (Student, Teacher, Admin).</p>
                        
                        <h4 class="text-gray-900 dark:text-white font-bold">2. How We Use Information</h4>
                        <p>Your data is exclusively used to operate the EdFlow platform. We do not sell your personal data to third parties. We use your email to send auto-generated credentials and system notifications.</p>
                        
                        <h4 class="text-gray-900 dark:text-white font-bold">3. Data Security</h4>
                        <p>We implement strict security measures including database encryption, secure password hashing, and role-based access control (RBAC) to ensure your institutional data remains private.</p>
                        
                        <h4 class="text-gray-900 dark:text-white font-bold">4. Third-Party Integrations</h4>
                        <p>Certain features utilize third-party APIs (such as Google Sheets for registrations or Google Gemini for StudyAI). Data shared with these services is strictly limited to the function requested.</p>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200/50 dark:border-white/10 bg-white/40 dark:bg-white/5 text-right flex justify-end">
                    <button onclick="toggleCustomModal('privacyModal')" class="px-6 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-[0_4px_14px_0_rgba(37,99,235,0.39)] focus:outline-none border border-transparent">I Understand</button>
                </div>
            </div>
        </div>
    </div>

    <div id="termsModal" class="fixed inset-0 z-[100] hidden custom-modal">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('termsModal')"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white/70 dark:bg-zinc-900/70 backdrop-blur-3xl w-full max-w-2xl rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden transform transition-all scale-100 border border-white/50 dark:border-white/10 pointer-events-auto flex flex-col max-h-[85vh]">
                <div class="flex items-center justify-between px-4 py-3 bg-white/40 dark:bg-white/5 border-b border-gray-200/50 dark:border-white/10">
                    <div class="flex items-center gap-2 w-16">
                        <button onclick="toggleCustomModal('termsModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10">
                            <i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i>
                        </button>
                        <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                        <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                    </div>
                    <h2 class="text-xs font-bold text-gray-700 dark:text-gray-300 tracking-wide flex items-center gap-2"><i class="fa-solid fa-file-contract text-purple-500"></i> Terms of Service</h2>
                    <div class="w-16"></div>
                </div>
                <div class="p-8 overflow-y-auto custom-scroll flex-1">
                    <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 space-y-5">
                        <p><strong>Last Updated: {{ date('F Y') }}</strong></p>
                        <p>By accessing and using EdFlow, you accept and agree to be bound by the terms and provisions of this agreement.</p>
                        
                        <h4 class="text-gray-900 dark:text-white font-bold">1. Account Responsibilities</h4>
                        <p>Users are responsible for maintaining the confidentiality of their login credentials. Any activities that occur under your account are your sole responsibility. Automated creation of accounts is strictly prohibited.</p>
                        
                        <h4 class="text-gray-900 dark:text-white font-bold">2. Acceptable Use</h4>
                        <p>EdFlow must only be used for legitimate academic and administrative purposes. You may not use the service to distribute malware, harass others, or attempt to bypass security protocols (RBAC).</p>
                        
                        <h4 class="text-gray-900 dark:text-white font-bold">3. AI Assistant Usage</h4>
                        <p>The StudyAI feature is designed as an educational aid. Responses generated by AI should be verified by human educators. EdFlow is not responsible for inaccuracies in AI-generated content.</p>
                        
                        <h4 class="text-gray-900 dark:text-white font-bold">4. Termination</h4>
                        <p>Administrators reserve the right to suspend or terminate access to any user account that violates these terms or poses a security risk to the institution.</p>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200/50 dark:border-white/10 bg-white/40 dark:bg-white/5 text-right flex justify-end">
                    <button onclick="toggleCustomModal('termsModal')" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-[0_4px_14px_0_rgba(168,85,247,0.39)] focus:outline-none border border-transparent">Accept Terms</button>
                </div>
            </div>
        </div>
    </div>

    <div id="successModal" class="fixed inset-0 z-[110] hidden custom-modal">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white/70 dark:bg-zinc-900/70 backdrop-blur-3xl rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] max-w-sm w-full transform scale-90 animate-scale-in border border-white/50 dark:border-white/10 pointer-events-auto flex flex-col overflow-hidden">
                <div class="flex items-center justify-between px-4 py-3 bg-white/40 dark:bg-white/5 border-b border-gray-200/50 dark:border-white/10">
                    <div class="flex items-center gap-2 w-16">
                        <button onclick="closeSuccessModal()" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10">
                            <i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i>
                        </button>
                        <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                        <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                    </div>
                    <h2 class="text-xs font-bold text-gray-700 dark:text-gray-300 tracking-wide">Success</h2>
                    <div class="w-16"></div>
                </div>
                <div class="p-8 text-center pt-6">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-green-200/50 dark:border-green-800">
                        <i class="fa-solid fa-check text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Successfully Subscribed!</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6 text-[13px] leading-relaxed">Thank you for joining our newsletter. We'll keep you updated.</p>
                    <button onclick="closeSuccessModal()" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm focus:outline-none">
                        Awesome
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2026/02/20/10/20260220102644-17W4KRC6.js" defer></script>

    <script>
        // Botpress Customization
        window.addEventListener('load', function() {
            const checkForBot = setInterval(() => {
                if (window.botpressWebChat) {
                    clearInterval(checkForBot);
                    window.botpressWebChat.mergeConfig({
                        botName: 'EdFlow Assistant',
                        botConversationDescription: 'Smart Campus Support',
                        themeColor: '#2563eb',
                        showPoweredBy: false
                    });
                }
            }, 500);

            // ── Force bot position on mobile via JS (CSS can't override Botpress inline styles) ──
            function applyBotMobilePos() {
                if (window.innerWidth > 767) return; // desktop: leave as-is
                const container = document.getElementById('bp-web-widget-container');
                if (container) {
                    container.style.setProperty('bottom', '148px', 'important');
                    container.style.setProperty('right',  '10px',  'important');
                    container.style.setProperty('z-index','9995',   'important');
                }
            }

            // Apply once the widget appears in the DOM
            const observer = new MutationObserver(() => applyBotMobilePos());
            observer.observe(document.body, { childList: true, subtree: true, attributes: true, attributeFilter: ['style'] });

            // Also reapply on resize
            window.addEventListener('resize', applyBotMobilePos);

            // Poll briefly after load to catch late injection
            let polls = 0;
            const pollPos = setInterval(() => {
                applyBotMobilePos();
                if (++polls >= 20) clearInterval(pollPos);
            }, 500);
        });

        // FAQ Accordion Logic
        const faqBtns = document.querySelectorAll('.faq-btn');
        faqBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const content = btn.nextElementSibling;
                const icon = btn.querySelector('i');
                
                faqBtns.forEach(otherBtn => {
                    if (otherBtn !== btn) {
                        otherBtn.nextElementSibling.classList.remove('open');
                        otherBtn.querySelector('i').classList.remove('rotate-180');
                    }
                });

                content.classList.toggle('open');
                icon.classList.toggle('rotate-180');
            });
        });

        // Unified Modal Toggle Logic
        function toggleCustomModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
            checkBodyOverflow();
        }

        // Keep legacy modal functions working with new unified check
        function toggleModal() { toggleCustomModal('loginModal'); }
        function toggleRegisterModal() { toggleCustomModal('registerModal'); }

        // Check if any modal is open to prevent background scrolling
        function checkBodyOverflow() {
            const anyOpen = document.querySelectorAll('.custom-modal:not(.hidden)').length > 0;
            if(typeof isMobileMenuOpen !== 'undefined' && !isMobileMenuOpen) {
                document.body.style.overflow = anyOpen ? 'hidden' : 'auto';
            }
        }

        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 20) {
                navbar.classList.add('glass', 'shadow-sm');
            } else {
                navbar.classList.remove('glass', 'shadow-sm');
            }
        });

        // Theme: permanently locked to light mode (toggle removed)
        document.documentElement.classList.remove('dark');
        localStorage.theme = 'light';

        /* ─────────────────────────────────────────────────────────────
           FIXED MOBILE BOTTOM BAR – smooth-scroll + ripple
        ───────────────────────────────────────────────────────────── */
        (function initMobBottomBar() {
            const cards = document.querySelectorAll('.mbb-card');
            if (!cards.length) return;
            cards.forEach(card => {
                // Smooth scroll for anchor hrefs
                const href = card.getAttribute('href');
                if (href && href.startsWith('#')) {
                    card.addEventListener('click', e => {
                        e.preventDefault();
                        const t = document.querySelector(href);
                        if (t) t.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                }
                // Ripple on tap
                card.addEventListener('pointerdown', e => {
                    const r = document.createElement('span');
                    const rect = card.getBoundingClientRect();
                    const sz = Math.max(rect.width, rect.height);
                    r.style.cssText = `position:absolute;border-radius:50%;pointer-events:none;width:${sz}px;height:${sz}px;left:${e.clientX-rect.left-sz/2}px;top:${e.clientY-rect.top-sz/2}px;background:rgba(99,102,241,0.15);transform:scale(0);transition:transform .5s ease,opacity .5s ease;opacity:1`;
                    card.appendChild(r);
                    requestAnimationFrame(() => { r.style.transform = 'scale(2.5)'; r.style.opacity = '0'; });
                    setTimeout(() => r.remove(), 600);
                });
            });
        })();

        /* Mobile hamburger button – currently unused (no slide menu on homepage).
           Wired up in case a slide menu is re-added later. */
        const mobileMenuBtn  = document.getElementById('mobile-menu-btn');
        const mobileMenuIcon = document.getElementById('mobile-menu-icon');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                /* placeholder – can open a side drawer in future */
                mobileMenuIcon.classList.toggle('fa-bars');
                mobileMenuIcon.classList.toggle('fa-xmark');
            });
        }


        const form = document.getElementById('newsletterForm');
        const scriptURL = 'https://script.google.com/macros/s/AKfycbyzMyhmjvyiDU1n8oZGtKIlzbEFeXNgXfJDemrfxcyUW3NF-Q0qcJ9qWWIXhmiV2ZAV1w/exec'; 
        const successModal = document.getElementById('successModal');
        const btnLoader = document.getElementById('btnLoader');
        const subscribeBtn = document.getElementById('subscribeBtn');

        if(form) {
            form.addEventListener('submit', e => {
                e.preventDefault();
                
                subscribeBtn.disabled = true;
                subscribeBtn.classList.add('opacity-75');
                btnLoader.classList.remove('hidden');

                let requestBody = new FormData(form);
                fetch(scriptURL, { method: 'POST', body: requestBody})
                    .then(response => {
                        form.reset();
                        toggleCustomModal('successModal');
                        subscribeBtn.disabled = false;
                        subscribeBtn.classList.remove('opacity-75');
                        btnLoader.classList.add('hidden');
                    })
                    .catch(error => {
                        alert('Error! ' + error.message);
                        subscribeBtn.disabled = false;
                        subscribeBtn.classList.remove('opacity-75');
                        btnLoader.classList.add('hidden');
                    });
            });
        }

        function closeSuccessModal() {
            toggleCustomModal('successModal');
        }

        /* Number Counter Animation */
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.5 
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.count-up');
                    counters.forEach(counter => {
                        const target = parseFloat(counter.getAttribute('data-target'));
                        const duration = 2000;
                        const start = 0;
                        const startTime = performance.now();

                        function update(currentTime) {
                            const elapsed = currentTime - startTime;
                            const progress = Math.min(elapsed / duration, 1);
                            const ease = 1 - Math.pow(1 - progress, 4); 
                            const current = start + (target - start) * ease;

                            if (target % 1 !== 0) {
                                counter.innerText = current.toFixed(1);
                            } else {
                                counter.innerText = Math.floor(current);
                            }

                            if (progress < 1) {
                                requestAnimationFrame(update);
                            } else {
                                counter.innerText = target;
                            }
                        }
                        requestAnimationFrame(update);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        const statsSection = document.getElementById('stats');
        if(statsSection) observer.observe(statsSection);

        // Page Loader Logic
        window.addEventListener('load', function () {
            const loader = document.getElementById('edflow-loader');
            if (loader) {
                // Add a tiny delay so the user can actually see the beautiful animation for a second
                setTimeout(() => {
                    // Fade it out
                    loader.style.opacity = '0';
                    loader.style.visibility = 'hidden';
                    
                    // Remove it completely from the page after the fade transition finishes
                    setTimeout(() => {
                        loader.remove();
                    }, 700); 
                }, 500); 
            }
        });

        // Role Auth Loader Logic
        function handleRoleLogin(e, roleName, url, themeContext) {
            e.preventDefault();
            
            // Close login modal if open
            const loginModal = document.getElementById('loginModal');
            if(loginModal && !loginModal.classList.contains('hidden')) {
                toggleCustomModal('loginModal');
            }
            
            // Setup Loader UI based on Role
            const loader = document.getElementById('role-auth-loader');
            const ringInner = document.getElementById('role-ring-inner');
            const iconContainer = document.getElementById('role-icon-container');
            const icon = document.getElementById('role-icon');
            const title = document.getElementById('role-auth-title');
            const progress = document.getElementById('role-progress');
            
            title.innerText = `Authenticating ${roleName}`;
            
            // Re-apply classes dynamically based on the role to change themes
            if (themeContext === 'student') {
                ringInner.className = 'absolute inset-0 rounded-full border-t-4 border-brand-500 animate-[spin_1s_cubic-bezier(0.8,_0,_0.2,_1)_infinite]';
                iconContainer.className = 'w-14 h-14 rounded-2xl flex items-center justify-center shadow-xl transition-colors duration-300 bg-brand-600 shadow-brand-500/30';
                icon.className = 'fa-solid fa-graduation-cap text-2xl text-white animate-pulse';
                progress.className = 'h-full bg-brand-500 w-0 transition-all duration-[1500ms] ease-out rounded-full';
            } else if (themeContext === 'teacher') {
                ringInner.className = 'absolute inset-0 rounded-full border-t-4 border-purple-500 animate-[spin_1s_cubic-bezier(0.8,_0,_0.2,_1)_infinite]';
                iconContainer.className = 'w-14 h-14 rounded-2xl flex items-center justify-center shadow-xl transition-colors duration-300 bg-purple-600 shadow-purple-500/30';
                icon.className = 'fa-solid fa-chalkboard-user text-2xl text-white animate-pulse';
                progress.className = 'h-full bg-purple-500 w-0 transition-all duration-[1500ms] ease-out rounded-full';
            } else if (themeContext === 'admin') {
                ringInner.className = 'absolute inset-0 rounded-full border-t-4 border-gray-900 dark:border-white animate-[spin_1s_cubic-bezier(0.8,_0,_0.2,_1)_infinite]';
                iconContainer.className = 'w-14 h-14 rounded-2xl flex items-center justify-center shadow-xl transition-colors duration-300 bg-gray-900 dark:bg-gray-100 shadow-gray-900/30 dark:shadow-white/20';
                icon.className = 'fa-solid fa-shield-halved text-2xl text-white dark:text-gray-900 animate-pulse';
                progress.className = 'h-full bg-gray-900 dark:bg-white w-0 transition-all duration-[1500ms] ease-out rounded-full';
            }
            
            // Reset Progress bar
            progress.style.width = '0%';
            
            // Show Loader Overlay
            loader.classList.remove('hidden');
            
            // Trigger animation frame for opacity transition
            requestAnimationFrame(() => {
                loader.classList.remove('opacity-0', 'pointer-events-none');
                loader.classList.add('opacity-100');
                
                // Animate progress bar across screen
                setTimeout(() => {
                    progress.style.width = '100%';
                }, 100);
            });
            
            // Redirect after simulating a brief authentication delay
            setTimeout(() => {
                window.location.href = url;
            }, 1500);
        }

        // Testimonial Card Shuffle Logic
        function initCardShuffle() {
            const cards = document.querySelectorAll('.shuffle-card');
            if(cards.length > 0) {
                let activeIndex = 0;
                
                function updateCards() {
                    cards.forEach((card, index) => {
                        let offset = index - activeIndex;
                        if (offset < 0) offset += cards.length;
                        
                        // Apply CSS transforms for the 3D stack effect
                        if (offset === 0) { // Active Front Card
                            card.style.transform = 'translateY(0px) scale(1) translateZ(0px)';
                            card.style.opacity = '1';
                            card.style.zIndex = '30';
                            card.style.filter = 'blur(0px)';
                        } else if (offset === 1) { // 1st behind
                            card.style.transform = 'translateY(24px) scale(0.95) translateZ(-50px)';
                            card.style.opacity = '0.7';
                            card.style.zIndex = '20';
                            card.style.filter = 'blur(1px)';
                        } else if (offset === 2) { // 2nd behind
                            card.style.transform = 'translateY(48px) scale(0.90) translateZ(-100px)';
                            card.style.opacity = '0.4';
                            card.style.zIndex = '10';
                            card.style.filter = 'blur(2px)';
                        } else { // Hidden
                            card.style.transform = 'translateY(72px) scale(0.85) translateZ(-150px)';
                            card.style.opacity = '0';
                            card.style.zIndex = '0';
                            card.style.filter = 'blur(4px)';
                        }
                    });
                }
                
                updateCards();
                
                // Automatically shuffle every 4 seconds
                setInterval(() => {
                    activeIndex = (activeIndex + 1) % cards.length;
                    updateCards();
                }, 4000);
            }
        }
        
        // Initialize
        initCardShuffle();

    </script>
    <!-- Role Auth Loader Overlay -->
    <div id="role-auth-loader" class="fixed inset-0 z-[200] flex flex-col items-center justify-center bg-white/95 dark:bg-black/95 backdrop-blur-2xl transition-all duration-500 ease-in-out opacity-0 pointer-events-none hidden">
        <div class="relative flex items-center justify-center w-28 h-28 mb-8">
            <!-- Pulsing outer ring -->
            <div class="absolute inset-0 rounded-full border-4 border-gray-100 dark:border-white/5 bg-gray-50 dark:bg-white/5"></div>
            <!-- Dynamic Spinning inner ring -->
            <div id="role-ring-inner" class="absolute inset-0 rounded-full border-t-4 border-brand-500 animate-[spin_1s_cubic-bezier(0.8,_0,_0.2,_1)_infinite]"></div>
            
            <!-- Dynamic Center Icon Container -->
            <div id="role-icon-container" class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-xl transition-colors duration-300 relative z-10">
                <i id="role-icon" class="fa-solid fa-user text-3xl text-white"></i>
            </div>
        </div>
        
        <h3 id="role-auth-title" class="text-2xl font-bold text-gray-900 dark:text-white mb-3 tracking-tight">Authenticating</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 font-medium animate-pulse">Establishing secure connection...</p>
        
        <!-- Progress bar -->
        <div class="mt-10 w-64 h-1.5 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
            <div id="role-progress" class="h-full bg-brand-500 w-0 transition-all duration-[1500ms] ease-out rounded-full"></div>
        </div>
    </div>

</body>

<!-- ====================================================
     GSAP MICRO ANIMATION SYSTEM – EdFlow Welcome Page
     ==================================================== -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

<style>
    /* Cursor glow element */
    #cursor-glow {
        width: 300px; height: 300px;
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 0;
        background: radial-gradient(circle, rgba(59,130,246,0.08) 0%, transparent 70%);
        transform: translate(-50%, -50%);
        transition: opacity 0.3s ease;
        will-change: transform;
    }
    /* Magnetic button base */
    .magnetic-btn { display: inline-block; will-change: transform; }
    /* Ensure hero elements start invisible for GSAP entry */
    .gsap-hero-badge,
    .gsap-hero-h1,
    .gsap-hero-p,
    .gsap-hero-btns,
    .gsap-hero-visual { opacity: 0; }
</style>

<!-- Cursor Glow -->
<div id="cursor-glow"></div>

<script>
(function() {
    // ── Guard ──────────────────────────────────────────────────────────
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
    gsap.registerPlugin(ScrollTrigger);

    // ── 1. CURSOR GLOW ──────────────────────────────────────────────────
    const glow = document.getElementById('cursor-glow');
    let glowX = 0, glowY = 0, mouseX = 0, mouseY = 0;
    window.addEventListener('mousemove', e => { mouseX = e.clientX; mouseY = e.clientY; });
    function animateGlow() {
        glowX += (mouseX - glowX) * 0.08;
        glowY += (mouseY - glowY) * 0.08;
        if (glow) { glow.style.left = glowX + 'px'; glow.style.top = glowY + 'px'; }
        requestAnimationFrame(animateGlow);
    }
    animateGlow();

    // ── 2. HERO SECTION – add classes then animate ──────────────────────
    const heroSection = document.querySelector('section');
    if (heroSection) {
        const badge  = heroSection.querySelector('.inline-flex');
        const h1     = heroSection.querySelector('h1');
        const heroP  = heroSection.querySelector('p');
        const btns   = heroSection.querySelector('.flex.flex-col.sm\\:flex-row');
        const visual = heroSection.querySelector('.mt-20');

        // Wait for 3D preloader to fully clear before hero animation
        const loaderEl = document.getElementById('edflow-loader');
        const startDelay = loaderEl ? 1.2 : 0.1;

        const heroTl = gsap.timeline({ delay: startDelay });

        if (badge)  heroTl.fromTo(badge,  { opacity:0, y:-20, scale:0.9 }, { opacity:1, y:0, scale:1, duration:0.5, ease:'back.out(1.7)' });
        if (h1)     heroTl.fromTo(h1,     { opacity:0, y:40  }, { opacity:1, y:0, duration:0.7, ease:'power3.out' }, '-=0.2');
        if (heroP)  heroTl.fromTo(heroP,  { opacity:0, y:20  }, { opacity:1, y:0, duration:0.5, ease:'power2.out' }, '-=0.3');
        if (btns)   heroTl.fromTo(btns,   { opacity:0, y:20, scale:0.97 }, { opacity:1, y:0, scale:1, duration:0.5, ease:'power2.out' }, '-=0.2');
        if (visual) heroTl.fromTo(visual, { opacity:0, y:40  }, { opacity:1, y:0, duration:0.8, ease:'power3.out' }, '-=0.2');
    }

    // ── 3. NAVBAR SLIDE DOWN ────────────────────────────────────────────
    const nav = document.getElementById('navbar');
    if (nav) {
        gsap.fromTo(nav, { y:-80, opacity:0 }, { y:0, opacity:1, duration:0.6, ease:'power3.out', delay:0.2 });
    }

    // ── 4. FEATURES SECTION – bento cards stagger ──────────────────────
    const featureCards = document.querySelectorAll('#features .grid > div');
    if (featureCards.length) {
        gsap.fromTo(featureCards,
            { opacity:0, y:50, scale:0.96 },
            {
                opacity:1, y:0, scale:1,
                duration:0.7, ease:'power3.out',
                stagger:0.12,
                scrollTrigger: {
                    trigger: '#features',
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                }
            }
        );
    }

    // ── 5. FEATURES HEADING ──────────────────────────────────────────────
    const featuresHeading = document.querySelector('#features .text-center');
    if (featuresHeading) {
        gsap.fromTo(featuresHeading,
            { opacity:0, y:30 },
            { opacity:1, y:0, duration:0.6, ease:'power2.out',
              scrollTrigger: { trigger: featuresHeading, start:'top 85%' }
            }
        );
    }

    // ── 6. STATS SECTION – counter + fade in ────────────────────────────
    const statsSection = document.getElementById('stats');
    if (statsSection) {
        // Section heading
        gsap.fromTo(statsSection.querySelector('.text-center'),
            { opacity:0, y:30 },
            { opacity:1, y:0, duration:0.6, ease:'power2.out',
              scrollTrigger: { trigger: statsSection, start:'top 80%' }
            }
        );

        // Stat cards
        const statCards = statsSection.querySelectorAll('.grid > div');
        gsap.fromTo(statCards,
            { opacity:0, y:40, scale:0.9 },
            { opacity:1, y:0, scale:1, duration:0.6, stagger:0.1, ease:'back.out(1.5)',
              scrollTrigger: { trigger: statsSection, start:'top 75%', toggleActions:'play none none none' }
            }
        );

        // Animated counters
        const counters = statsSection.querySelectorAll('.count-up');
        counters.forEach(el => {
            const target = parseFloat(el.dataset.target);
            const isDecimal = target % 1 !== 0;
            ScrollTrigger.create({
                trigger: el,
                start: 'top 85%',
                once: true,
                onEnter: () => {
                    gsap.fromTo({ val: 0 }, { val: target, duration: 2, ease:'power2.out',
                        onUpdate: function() {
                            el.textContent = isDecimal
                                ? this.targets()[0].val.toFixed(1)
                                : Math.round(this.targets()[0].val);
                        }
                    });
                }
            });
        });
    }

    // ── 7. TESTIMONIALS ──────────────────────────────────────────────────
    const testimonialsSection = document.getElementById('testimonials');
    if (testimonialsSection) {
        const textSide = testimonialsSection.querySelector('.grid > div:first-child');
        const cardSide = testimonialsSection.querySelector('.grid > div:last-child');

        if (textSide) {
            gsap.fromTo(textSide,
                { opacity:0, x:-50 },
                { opacity:1, x:0, duration:0.8, ease:'power3.out',
                  scrollTrigger: { trigger: testimonialsSection, start:'top 75%' }
                }
            );
        }
        if (cardSide) {
            gsap.fromTo(cardSide,
                { opacity:0, x:50 },
                { opacity:1, x:0, duration:0.8, ease:'power3.out',
                  scrollTrigger: { trigger: testimonialsSection, start:'top 75%' }
                }
            );
        }
    }

    // ── 8. GENERIC SCROLL-REVEAL for sections not yet targeted ───────────
    const genericRevealEls = document.querySelectorAll(
        '#faq .space-y-4 > div, footer > div > div'
    );
    if (genericRevealEls.length) {
        gsap.fromTo(genericRevealEls,
            { opacity:0, y:30 },
            { opacity:1, y:0, duration:0.5, stagger:0.08, ease:'power2.out',
              scrollTrigger: { trigger: genericRevealEls[0], start:'top 85%', toggleActions:'play none none none' }
            }
        );
    }

    // ── 9. SCROLL PROGRESS INDICATOR (thin line on top) ─────────────────
    const progressBar = document.createElement('div');
    progressBar.style.cssText = 'position:fixed;top:0;left:0;height:2px;background:linear-gradient(90deg,#6366f1,#a855f7);z-index:9998;width:0%;will-change:width;pointer-events:none;';
    document.body.appendChild(progressBar);
    ScrollTrigger.create({
        trigger: document.body,
        start: 'top top',
        end: 'bottom bottom',
        scrub: 0.3,
        onUpdate: self => { progressBar.style.width = (self.progress * 100) + '%'; }
    });

})();
</script>
</html>
