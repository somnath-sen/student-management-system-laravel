<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EdFlow — Smart Education. Simplified Management.</title>
    <meta name="description" content="EdFlow is an all-in-one Smart Campus Management platform for students, teachers and administrators. Manage attendance, examinations, results, fees and more in one unified system.">
    <meta name="keywords" content="student management system, campus management, EdFlow, attendance, examination, results, fee management, edtech">
    <meta property="og:title" content="EdFlow — Smart Education. Simplified Management.">
    <meta property="og:description" content="One platform for every academic need. Manage students, teachers, academics, attendance, examinations, results and fees.">
    <meta property="og:type" content="website">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
                        navy: {
                            50:  '#eef2ff',
                            100: '#dce6fc',
                            200: '#b9cef9',
                            300: '#88abf5',
                            400: '#527de8',
                            500: '#2d57d1',
                            600: '#1d3fb5',
                            700: '#1a3393',
                            800: '#1b2d77',
                            900: '#0d1b4b',
                            950: '#070e2e',
                        },
                        orange: {
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea6a0a',
                        }
                    },
                    animation: {
                        'blob': 'blob 10s ease-in-out infinite',
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                        'float': 'float 6s ease-in-out infinite',
                        'marquee': 'marquee 30s linear infinite',
                        'pulse-glow': 'pulseGlow 2.5s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'scale-in': 'scaleIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                        'text-shimmer': 'textShimmer 3s linear infinite',
                        'spin-slow': 'spin 20s linear infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%':   { transform: 'translate(0px, 0px) scale(1)' },
                            '33%':  { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%':  { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        fadeIn: {
                            '0%':   { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%':      { transform: 'translateY(-10px)' },
                        },
                        marquee: {
                            '0%':   { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-50%)' },
                        },
                        pulseGlow: {
                            '0%, 100%': { opacity: '1' },
                            '50%':      { opacity: '.5' },
                        },
                        scaleIn: {
                            '0%':   { opacity: '0', transform: 'scale(0.9)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                        textShimmer: {
                            '0%':   { backgroundPosition: '0% 50%' },
                            '100%': { backgroundPosition: '200% 50%' },
                        },
                    }
                }
            }
        }
    </script>

    <style>
        /* ═══════════════════════════════════════════════════════
           EdFlow — Premium Dark Navy Design System
        ═══════════════════════════════════════════════════════ */

        :root {
            --navy-950: #070e2e;
            --navy-900: #0d1b4b;
            --navy-800: #1b2d77;
            --orange-500: #f97316;
            --orange-400: #fb923c;
        }

        /* ── Body ────────────────────────────────────────────── */
        body {
            background-color: #f8faff;
            background-image:
                radial-gradient(ellipse at 20% 10%, rgba(29,63,181,0.06) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 90%, rgba(249,115,22,0.04) 0%, transparent 50%);
        }

        /* ── Dot grid ────────────────────────────────────────── */
        .bg-dot-grid {
            background-image: radial-gradient(circle, rgba(29,63,181,0.06) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        /* ── Navy hero ───────────────────────────────────────── */
        .hero-navy {
            background: linear-gradient(160deg, var(--navy-950) 0%, #0f1f5c 40%, #1a1060 70%, var(--navy-950) 100%);
        }
        .hero-dot-grid {
            background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        /* ── Glass navbar (light) ────────────────────────────── */
        .glass-nav {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(220, 230, 255, 0.5);
            box-shadow: 0 1px 24px rgba(13, 27, 75, 0.06);
        }

        /* ── Glass card ──────────────────────────────────────── */
        .glass-card {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 20px rgba(13,27,75,0.07), 0 1px 2px rgba(0,0,0,0.03);
        }

        /* ── Navy card ───────────────────────────────────────── */
        .navy-card {
            background: rgba(13, 27, 75, 0.85);
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        /* ── Bento card ──────────────────────────────────────── */
        .bento-card {
            background: rgba(255, 255, 255, 0.90);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 24px rgba(13,27,75,0.07), inset 0 1px 0 rgba(255,255,255,1);
        }

        /* ── Smooth transitions ──────────────────────────────── */
        a, button, .glass-card, .bento-card, nav {
            transition: background-color 0.2s ease, color 0.2s ease,
                        border-color 0.2s ease, box-shadow 0.2s ease,
                        opacity 0.2s ease, transform 0.2s ease;
        }

        /* ── Hide scrollbar ──────────────────────────────────── */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* ── Custom modal scroll ─────────────────────────────── */
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: rgba(156,163,175,0.35); border-radius: 10px; }

        /* ── FAQ accordion ───────────────────────────────────── */
        .faq-content {
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        .faq-content.open { max-height: 500px; opacity: 1; }

        /* ── Feature card hover ──────────────────────────────── */
        #features .grid > div {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            will-change: transform;
        }
        #features .grid > div:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(13,27,75,0.14);
        }

        /* ── Orb ambient ─────────────────────────────────────── */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            pointer-events: none;
            will-change: transform;
        }

        /* ── Orange glow on portrait area ───────────────────── */
        .portrait-glow {
            background: radial-gradient(ellipse at 50% 60%,
                rgba(249,115,22,0.35) 0%,
                rgba(249,115,22,0.12) 40%,
                transparent 70%);
        }

        /* ── Floating stat cards ──────────────────────────────── */
        .stat-card-float {
            animation: float 5s ease-in-out infinite;
        }
        .stat-card-float-delay {
            animation: float 5s ease-in-out 1.5s infinite;
        }

        /* ── Section divider glass ──────────────────────────── */
        .section-light {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        /* ── Scroll progress bar ─────────────────────────────── */
        #scroll-progress {
            position: fixed;
            top: 0; left: 0;
            height: 2px;
            background: linear-gradient(90deg, #f97316, #fb923c, #1d3fb5);
            z-index: 9998;
            width: 0%;
            pointer-events: none;
            will-change: width;
        }

        /* ── Preloader keyframes ─────────────────────────────── */
        @keyframes morph {
            0%,100% { border-radius: 60% 40% 70% 30% / 50% 60% 40% 70%; }
            25%      { border-radius: 40% 70% 30% 60% / 65% 35% 65% 35%; }
            50%      { border-radius: 70% 30% 50% 50% / 30% 70% 50% 60%; }
            75%      { border-radius: 30% 60% 70% 40% / 55% 45% 70% 30%; }
        }
        @keyframes ring-spin  { to { transform: rotate(360deg); } }
        @keyframes ring-spin2 { to { transform: rotate(-360deg); } }
        @keyframes float-up   { to { transform: translateY(-120vh) scale(0); opacity: 0; } }
        @keyframes letter-in  {
            from { opacity: 0; transform: translateY(24px) skewY(6deg); filter: blur(6px); }
            to   { opacity: 1; transform: translateY(0)    skewY(0deg); filter: blur(0); }
        }
        @keyframes shimmer {
            0%   { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
        @keyframes shard-exit {
            to { transform: translate(var(--tx), var(--ty)) rotate(var(--tr)) scale(0.2); opacity: 0; }
        }
        @keyframes logo-glow {
            0%,100% { text-shadow: 0 0 20px rgba(249,115,22,0.5), 0 0 60px rgba(29,63,181,0.3); }
            50%      { text-shadow: 0 0 40px rgba(249,115,22,0.8), 0 0 100px rgba(29,63,181,0.5); }
        }
        @keyframes dot-bounce {
            0%,80%,100% { transform: scale(0.6); opacity: 0.4; }
            40%         { transform: scale(1.1); opacity: 1; }
        }
        @keyframes blob-drift { 0%,100% { transform: scale(1) translate(0,0); } 50% { transform: scale(1.15) translate(12px,-8px); } }
        @keyframes pulse-ring {
            0%   { transform: scale(0.9); opacity: 0.6; }
            50%  { transform: scale(1.08); opacity: 0.2; }
            100% { transform: scale(0.9); opacity: 0.6; }
        }

        .pl-letter {
            display: inline-block;
            opacity: 0;
            animation: letter-in 0.55s cubic-bezier(0.16,1,0.3,1) forwards;
        }
        .pl-dot {
            display: inline-block;
            animation: dot-bounce 1.4s ease-in-out infinite;
        }

        /* ── Mobile bottom nav ───────────────────────────────── */
        #mob-bottom-bar { display: none; }
        @media (max-width: 767px) {
            #mob-bottom-bar {
                display: block;
                position: fixed;
                bottom: 0; left: 0; right: 0;
                z-index: 9990;
            }
            body { padding-bottom: 155px; }
        }
        #mob-bottom-bar .mbb-wave { display: block; width: 100%; line-height: 0; overflow: hidden; filter: drop-shadow(0 -6px 18px rgba(13,27,75,0.20)); }
        #mob-bottom-bar .mbb-body {
            background: linear-gradient(160deg, #eef2ff 0%, #e8edff 45%, #dbeafe 100%);
            padding: 4px 12px 12px;
        }
        #mob-bottom-bar .mbb-row1 { display: grid; grid-template-columns: repeat(3,1fr); gap: 7px; margin-bottom: 7px; }
        #mob-bottom-bar .mbb-row2 { display: grid; grid-template-columns: repeat(2,1fr); gap: 7px; }
        .mbb-card {
            background: rgba(255,255,255,0.93);
            border: 1px solid rgba(255,255,255,0.96);
            border-radius: 14px;
            padding: 9px 6px 8px;
            display: flex; flex-direction: column; align-items: center; gap: 5px;
            cursor: pointer; text-decoration: none;
            box-shadow: 0 2px 10px rgba(13,27,75,0.10), inset 0 1px 0 rgba(255,255,255,1);
            transition: transform .22s cubic-bezier(.34,1.56,.64,1), box-shadow .22s ease;
            position: relative; overflow: hidden;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }
        .mbb-card:hover  { transform: translateY(-3px) scale(1.03); box-shadow: 0 8px 24px rgba(13,27,75,0.20); }
        .mbb-card:active { transform: scale(0.94); }
        .mbb-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; color: #fff;
            transition: transform .25s cubic-bezier(.34,1.56,.64,1);
        }
        .mbb-card:hover .mbb-icon { transform: scale(1.15) rotate(-5deg); }
        .mbb-i-navy   { background: linear-gradient(135deg, #1d3fb5, #0d1b4b); box-shadow: 0 3px 10px rgba(29,63,181,.35); }
        .mbb-i-orange { background: linear-gradient(135deg, #f97316, #fb923c); box-shadow: 0 3px 10px rgba(249,115,22,.35); }
        .mbb-i-purple { background: linear-gradient(135deg, #8b5cf6, #a855f7); box-shadow: 0 3px 10px rgba(168,85,247,.35); }
        .mbb-i-green  { background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 3px 10px rgba(16,185,129,.35); }
        .mbb-i-rose   { background: linear-gradient(135deg, #f43f5e, #e11d48); box-shadow: 0 3px 10px rgba(244,63,94,.35); }
        .mbb-label { font-size: 10px; font-weight: 700; color: #0d1b4b; text-align: center; line-height: 1.2; }

        /* ── Cursor glow ─────────────────────────────────────── */
        #cursor-glow {
            width: 300px; height: 300px;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(circle, rgba(249,115,22,0.05) 0%, transparent 70%);
            transform: translate(-50%, -50%);
            transition: opacity 0.3s ease;
            will-change: transform;
        }

        /* ── Reduced motion ──────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-dot-grid selection:bg-orange-500 selection:text-white">

<!-- Scroll progress bar -->
<div id="scroll-progress"></div>

<!-- ═══════════════════════════════════════════════════════════════
     PRELOADER — Dark Navy + Orange EdFlow Theme
═══════════════════════════════════════════════════════════════ -->
<div id="edflow-loader" style="
    position:fixed;inset:0;z-index:99999;
    background: linear-gradient(150deg,#070e2e 0%,#0d1b4b 50%,#0f1050 100%);
    display:flex;flex-direction:column;align-items:center;justify-content:center;
    overflow:hidden;
">
    <!-- Ambient blobs -->
    <div style="position:absolute;inset:0;pointer-events:none;overflow:hidden;">
        <div style="position:absolute;top:-20%;left:-15%;width:65vw;height:65vw;max-width:700px;max-height:700px;background:radial-gradient(circle,rgba(29,63,181,0.30) 0%,transparent 70%);animation:blob-drift 12s ease-in-out infinite;filter:blur(60px);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-20%;right:-15%;width:55vw;height:55vw;max-width:600px;max-height:600px;background:radial-gradient(circle,rgba(249,115,22,0.22) 0%,transparent 70%);animation:blob-drift 16s ease-in-out infinite reverse;filter:blur(70px);border-radius:50%;"></div>
    </div>

    <!-- Floating particles -->
    <div id="pl-particles" style="position:absolute;inset:0;pointer-events:none;overflow:hidden;"></div>

    <!-- Main orb -->
    <div style="position:relative;width:220px;height:220px;margin-bottom:48px;flex-shrink:0;">
        <!-- Pulse rings -->
        <div style="position:absolute;inset:-28px;border-radius:50%;border:1px solid rgba(249,115,22,0.25);animation:pulse-ring 3s ease-in-out infinite;"></div>
        <div style="position:absolute;inset:-52px;border-radius:50%;border:1px solid rgba(29,63,181,0.18);animation:pulse-ring 3s ease-in-out infinite 1s;"></div>
        <!-- Orbital rings -->
        <div style="position:absolute;inset:-20px;border-radius:50%;border-top:2px solid rgba(249,115,22,0.75);border-right:2px solid transparent;border-bottom:2px solid rgba(249,115,22,0.2);border-left:2px solid transparent;animation:ring-spin 3s linear infinite;filter:drop-shadow(0 0 8px rgba(249,115,22,0.8));"></div>
        <div style="position:absolute;inset:-36px;border-radius:50%;border-top:2px solid transparent;border-right:2px solid rgba(29,63,181,0.65);border-bottom:2px solid transparent;border-left:2px solid rgba(29,63,181,0.2);animation:ring-spin2 4.5s linear infinite;filter:drop-shadow(0 0 8px rgba(29,63,181,0.6));"></div>
        <!-- Morphing blob -->
        <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(29,63,181,0.70) 0%,rgba(13,27,75,0.80) 40%,rgba(249,115,22,0.50) 100%);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.15);box-shadow:0 8px 60px rgba(249,115,22,0.25),0 0 0 1px rgba(255,255,255,0.10) inset;animation:morph 6s ease-in-out infinite;overflow:hidden;">
            <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,0.14) 0%,transparent 60%,rgba(255,255,255,0.04) 100%);border-radius:inherit;"></div>
        </div>
        <!-- Center icon -->
        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
            <div style="width:68px;height:68px;background:rgba(255,255,255,0.12);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.28);border-radius:20px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 24px rgba(0,0,0,0.2),inset 0 1px 0 rgba(255,255,255,0.3);">
                <i class="fa-solid fa-graduation-cap" style="font-size:28px;color:#fff;filter:drop-shadow(0 0 12px rgba(249,115,22,0.6));"></i>
            </div>
        </div>
    </div>

    <!-- Brand name -->
    <div style="margin-bottom:10px;overflow:hidden;">
        <div id="pl-brand" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(30px,5vw,46px);font-weight:900;letter-spacing:-0.03em;color:#fff;line-height:1;animation:logo-glow 3s ease-in-out infinite;">
            <span class="pl-letter" style="animation-delay:0.05s">E</span><span class="pl-letter" style="animation-delay:0.12s">d</span><span class="pl-letter" style="animation-delay:0.19s">F</span><span class="pl-letter" style="animation-delay:0.26s">l</span><span class="pl-letter" style="animation-delay:0.33s">o</span><span class="pl-letter" style="animation-delay:0.40s">w</span><span class="pl-letter" style="animation-delay:0.47s;color:rgba(249,115,22,1)">.</span>
        </div>
    </div>

    <!-- Tagline -->
    <div id="pl-tag" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:600;letter-spacing:0.28em;text-transform:uppercase;color:rgba(255,255,255,0.35);margin-bottom:44px;opacity:0;animation:letter-in 0.7s cubic-bezier(0.16,1,0.3,1) 0.7s forwards;">Smart Campus · Reimagined</div>

    <!-- Progress bar -->
    <div style="width:clamp(180px,28vw,300px);">
        <div style="width:100%;height:3px;background:rgba(255,255,255,0.08);border-radius:999px;overflow:hidden;position:relative;">
            <div id="preloader-bar" style="height:100%;width:0%;background:linear-gradient(90deg,#1d3fb5,#f97316,#fb923c);border-radius:999px;transition:width 0.4s cubic-bezier(0.4,0,0.2,1);position:relative;overflow:hidden;">
                <div style="position:absolute;top:0;left:0;height:100%;width:40%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.6),transparent);animation:shimmer 1.6s ease-in-out infinite;"></div>
            </div>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:14px;">
            <div style="display:flex;gap:5px;">
                <span class="pl-dot" style="width:5px;height:5px;border-radius:50%;background:#1d3fb5;animation-delay:0s;"></span>
                <span class="pl-dot" style="width:5px;height:5px;border-radius:50%;background:#f97316;animation-delay:0.2s;"></span>
                <span class="pl-dot" style="width:5px;height:5px;border-radius:50%;background:#fb923c;animation-delay:0.4s;"></span>
            </div>
            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:0.1em;color:rgba(255,255,255,0.35);"><span id="preloader-pct">0</span>%</div>
        </div>
    </div>

    <!-- Skip -->
    <button id="preloader-skip" onclick="window.__skipPreloader&&window.__skipPreloader()" style="position:absolute;bottom:28px;right:28px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:0.22em;text-transform:uppercase;color:rgba(255,255,255,0.18);background:none;border:none;cursor:pointer;padding:8px 12px;transition:color 0.25s;opacity:0;" onmouseover="this.style.color='rgba(255,255,255,0.55)'" onmouseout="this.style.color='rgba(255,255,255,0.18)'">
        Skip ›
    </button>
</div>

<!-- Preloader Script -->
<script>
(function() {
    'use strict';
    const loader  = document.getElementById('edflow-loader');
    const barEl   = document.getElementById('preloader-bar');
    const pctEl   = document.getElementById('preloader-pct');
    const skipBtn = document.getElementById('preloader-skip');
    let currentPct = 0, targetPct = 0, dismissed = false;

    const pContainer = document.getElementById('pl-particles');
    const COLORS = ['#1d3fb5','#f97316','#fb923c','#3b5fd4','#fbbf72'];
    for (let i = 0; i < 35; i++) {
        const p = document.createElement('div');
        const size = 3 + Math.random() * 5;
        const x    = Math.random() * 100;
        const dur  = 4 + Math.random() * 6;
        const delay= Math.random() * 5;
        const color= COLORS[Math.floor(Math.random() * COLORS.length)];
        p.style.cssText = `position:absolute;bottom:-10px;left:${x}%;width:${size}px;height:${size}px;border-radius:50%;background:${color};opacity:${0.3+Math.random()*0.5};animation:float-up ${dur}s ease-in ${delay}s infinite;pointer-events:none;`;
        pContainer.appendChild(p);
    }

    let domDone = false, fontsDone = false;
    let totalImgs = 0, loadedImgs = 0;
    function calc() {
        let p = 0;
        if (domDone) p += 40;
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
        if (!totalImgs) { calc(); return; }
        imgs.forEach(img => {
            if (img.complete) { loadedImgs++; calc(); }
            else {
                img.addEventListener('load',  () => { loadedImgs++; calc(); });
                img.addEventListener('error', () => { loadedImgs++; calc(); });
            }
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', trackImgs);
    else trackImgs();

    if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(() => { fontsDone = true; calc(); });
    } else { fontsDone = true; }

    window.addEventListener('load', () => { domDone = true; fontsDone = true; loadedImgs = totalImgs || 0; calc(); setTimeout(forceDone, 200); });
    setTimeout(forceDone, 6000);
    function forceDone() { setTarget(100); }
    window.__skipPreloader = forceDone;
    setTimeout(() => { if (!dismissed && skipBtn) skipBtn.style.opacity = '1'; }, 1800);

    function dismiss() {
        if (dismissed) return;
        dismissed = true;
        const TILES = 16, cols = 4, rows = 4;
        const shardWrap = document.createElement('div');
        shardWrap.style.cssText = 'position:absolute;inset:0;pointer-events:none;z-index:10;';
        loader.appendChild(shardWrap);
        for (let r = 0; r < rows; r++) {
            for (let c = 0; c < cols; c++) {
                const s = document.createElement('div');
                const tx = (c - cols/2 + 0.5) * 180 + (Math.random()-0.5) * 80;
                const ty = (r - rows/2 + 0.5) * 160 + (Math.random()-0.5) * 80;
                const tr = (Math.random() - 0.5) * 60;
                s.style.cssText = `position:absolute;left:${(c/cols)*100}%;top:${(r/rows)*100}%;width:${100/cols}%;height:${100/rows}%;background:linear-gradient(135deg,rgba(29,63,181,${0.18+Math.random()*0.1}) 0%,rgba(249,115,22,${0.08+Math.random()*0.08}) 100%);backdrop-filter:blur(2px);border:1px solid rgba(255,255,255,0.05);--tx:${tx}px;--ty:${ty}px;--tr:${tr}deg;animation:shard-exit 0.7s cubic-bezier(0.4,0,1,1) ${0.05*Math.random()*10}s forwards;transform-origin:center;`;
                shardWrap.appendChild(s);
            }
        }
        setTimeout(() => {
            loader.style.transition = 'opacity 0.55s cubic-bezier(0.4,0,0.2,1)';
            loader.style.opacity = '0';
            setTimeout(() => { loader.style.display = 'none'; }, 580);
        }, 420);
    }

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


<!-- ═══════════════════════════════════════════════════════════════
     AMBIENT BACKGROUND (light sections)
═══════════════════════════════════════════════════════════════ -->
<div class="fixed inset-0 overflow-hidden pointer-events-none -z-10" style="background: linear-gradient(160deg, #ffffff 0%, #f5f8ff 40%, #edf2ff 70%, #f8faff 100%);">
    <div class="orb" style="width:600px;height:600px;top:-8%;left:-6%;background:radial-gradient(circle, rgba(29,63,181,0.09) 0%, transparent 70%);animation:blob 26s ease-in-out infinite alternate;"></div>
    <div class="orb" style="width:520px;height:520px;bottom:-10%;right:-5%;background:radial-gradient(circle, rgba(249,115,22,0.07) 0%, transparent 70%);animation:blob 30s ease-in-out infinite alternate-reverse;animation-delay:3s;"></div>
</div>


<!-- ═══════════════════════════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════════════════════════ -->
<nav class="fixed w-full z-50 top-0 transition-all duration-300 glass-nav" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <!-- Brand -->
            <div class="flex-shrink-0 flex items-center gap-2.5 cursor-pointer" onclick="window.scrollTo({top:0,behavior:'smooth'})">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shadow-lg" style="background:linear-gradient(135deg,#1d3fb5,#0d1b4b);box-shadow:0 4px 14px rgba(29,63,181,0.35);">
                    <i class="fa-solid fa-graduation-cap text-lg"></i>
                </div>
                <span class="font-black text-2xl tracking-tight text-navy-900" style="color:#0d1b4b;">EdFlow<span style="color:#f97316;">.</span></span>
            </div>

            <!-- Desktop Nav Links -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="#" class="px-3 py-2 text-sm font-semibold text-gray-600 hover:text-navy-800 hover:bg-navy-50 rounded-lg transition-all" style="--hover-bg:rgba(13,27,75,0.05);">Home</a>
                <a href="#features" class="px-3 py-2 text-sm font-semibold text-gray-600 hover:text-navy-800 hover:bg-navy-50 rounded-lg transition-all">Features</a>
                <a href="#solutions" class="px-3 py-2 text-sm font-semibold text-gray-600 hover:text-navy-800 hover:bg-navy-50 rounded-lg transition-all">Solutions</a>
                <a href="#how-it-works" class="px-3 py-2 text-sm font-semibold text-gray-600 hover:text-navy-800 hover:bg-navy-50 rounded-lg transition-all">How It Works</a>
                <a href="#about" class="px-3 py-2 text-sm font-semibold text-gray-600 hover:text-navy-800 hover:bg-navy-50 rounded-lg transition-all">About</a>
                <a href="#faq" class="px-3 py-2 text-sm font-semibold text-gray-600 hover:text-navy-800 hover:bg-navy-50 rounded-lg transition-all mr-2">FAQ</a>

                <a href="{{ route('login') }}" class="ml-1 px-5 py-2.5 rounded-xl bg-white text-navy-900 border border-gray-200 text-sm font-bold hover:bg-gray-50 hover:shadow-md transition-all" style="color:#0d1b4b;">
                    Login
                </a>
                <button onclick="toggleRegisterModal()" class="ml-1 px-6 py-2.5 rounded-xl text-white text-sm font-bold hover:-translate-y-0.5 transition-all shadow-lg inline-flex items-center gap-2" style="background:linear-gradient(135deg,#f97316,#ea6a0a);box-shadow:0 4px 14px rgba(249,115,22,0.35);">
                    Get Started <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center gap-3">
                <button id="mobile-menu-btn" class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center text-gray-700 shadow-sm">
                    <i id="mobile-menu-icon" class="fa-solid fa-bars text-base transition-transform duration-300"></i>
                </button>
            </div>
        </div>
    </div>
</nav>


<!-- ═══════════════════════════════════════════════════════════════
     HERO SECTION — Dark Navy + Two Column
═══════════════════════════════════════════════════════════════ -->
<section class="relative min-h-screen flex items-center pt-20 overflow-hidden hero-navy" id="hero">
    <!-- Background grid -->
    <div class="absolute inset-0 hero-dot-grid opacity-60"></div>

    <!-- Orange ambient orb -->
    <div class="absolute right-0 top-0 w-[600px] h-[600px] pointer-events-none" style="background:radial-gradient(ellipse at 70% 30%, rgba(249,115,22,0.18) 0%, transparent 65%);"></div>
    <!-- Navy/indigo ambient orb left -->
    <div class="absolute left-0 bottom-0 w-[500px] h-[500px] pointer-events-none" style="background:radial-gradient(ellipse at 30% 70%, rgba(29,63,181,0.20) 0%, transparent 65%);"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            <!-- LEFT: Text Content -->
            <div class="order-2 lg:order-1">
                <!-- Badge -->
                <div class="gsap-hero-badge inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-orange-500/30 bg-orange-500/10 mb-8">
                    <span class="w-1.5 h-1.5 rounded-full bg-orange-400 shadow-[0_0_8px_rgba(251,146,60,0.9)]"></span>
                    <span class="text-xs font-bold text-orange-300 uppercase tracking-widest">Smart Campus Management</span>
                </div>

                <!-- Headline -->
                <h1 class="gsap-hero-h1 text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black tracking-tight text-white leading-[1.05] mb-6">
                    One Platform.<br>
                    <span style="background:linear-gradient(90deg,#f97316,#fb923c,#fbbf24);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Every Academic</span><br>
                    Need.
                </h1>

                <!-- Sub copy -->
                <p class="gsap-hero-p text-lg text-blue-100/80 leading-relaxed max-w-lg mb-10 font-medium">
                    EdFlow brings students, teachers, academics and campus operations together in one intelligent platform — from attendance to results, fees to analytics.
                </p>

                <!-- CTA Buttons -->
                <div class="gsap-hero-btns flex flex-col sm:flex-row gap-4">
                    <button onclick="toggleRegisterModal()" class="inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-white font-bold text-base transition-all hover:-translate-y-0.5 hover:shadow-2xl group" style="background:linear-gradient(135deg,#f97316,#ea6a0a);box-shadow:0 8px 24px rgba(249,115,22,0.45);">
                        <span>Get Started</span>
                        <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/20 group-hover:bg-white/30 transition-colors">
                            <i class="fa-solid fa-arrow-right text-sm group-hover:translate-x-0.5 transition-transform"></i>
                        </span>
                    </button>
                    <a href="#features" class="inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-white font-bold text-base border border-white/20 hover:bg-white/10 hover:border-white/30 transition-all hover:-translate-y-0.5 group">
                        <span>Explore Features</span>
                        <i class="fa-solid fa-arrow-right text-sm group-hover:translate-x-0.5 transition-transform opacity-60"></i>
                    </a>
                </div>

                <!-- Quick trust indicators -->
                <div class="mt-12 flex flex-wrap gap-6">
                    <div class="flex items-center gap-2 text-sm text-blue-200/70">
                        <i class="fa-solid fa-shield-halved text-orange-400"></i>
                        <span>Role-Based Access</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-blue-200/70">
                        <i class="fa-solid fa-bolt text-orange-400"></i>
                        <span>AI-Powered Insights</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-blue-200/70">
                        <i class="fa-solid fa-mobile-screen text-orange-400"></i>
                        <span>Mobile-Ready</span>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Portrait Composition -->
            <div class="gsap-hero-visual order-1 lg:order-2 flex justify-center lg:justify-end relative">
                <div class="relative w-full max-w-[480px]">

                    <!-- Outer orange glow halo -->
                    <div class="absolute -inset-6 rounded-[3rem] pointer-events-none" style="background:radial-gradient(ellipse at 50% 60%, rgba(249,115,22,0.28) 0%, rgba(29,63,181,0.12) 50%, transparent 75%);filter:blur(24px);"></div>

                    <!-- Decorative orbital rings (behind the image) -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="w-[110%] h-[110%] rounded-full border border-orange-500/15 absolute"></div>
                        <div class="w-[125%] h-[125%] rounded-full border border-orange-400/10 absolute"></div>
                        <!-- Orange arc top-right -->
                        <div class="absolute top-0 right-0 w-28 h-28 rounded-full border-2 border-orange-500/35" style="clip-path:inset(0 0 55% 55%);"></div>
                        <!-- Orange arc bottom-left -->
                        <div class="absolute bottom-0 left-0 w-20 h-20 rounded-full border border-orange-400/25" style="clip-path:inset(55% 55% 0 0);"></div>
                    </div>

                    <!-- The portrait image — full bleed, rounded, shadowed -->
                    <div class="relative rounded-[2rem] overflow-hidden shadow-2xl" style="box-shadow:0 0 0 1px rgba(249,115,22,0.2), 0 24px 64px rgba(0,0,0,0.5), 0 0 60px rgba(249,115,22,0.15);">
                        <img src="{{ asset('images/edflow-hero-visual.jpg') }}"
                             alt="Somnath Sen — Founder of EdFlow"
                             class="w-full h-auto block object-cover"
                             style="aspect-ratio:3/4;object-position:top;">
                        <!-- Subtle navy gradient overlay at bottom for contrast -->
                        <div class="absolute bottom-0 left-0 right-0 h-1/3 pointer-events-none" style="background:linear-gradient(to top, rgba(7,14,46,0.75) 0%, transparent 100%);"></div>

                        <!-- Founder name tag at bottom -->
                        <div class="absolute bottom-5 left-5 right-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-black text-white tracking-tight">Somnath Sen</div>
                                    <div class="text-[11px] font-bold" style="color:rgba(249,115,22,0.9);">Founder & Lead Developer</div>
                                </div>
                                <div class="flex gap-1.5">
                                    <a href="https://github.com/somnath-sen" target="_blank" class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors" style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                                        <i class="fa-brands fa-github text-white text-xs"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/in/thesomishere/" target="_blank" class="w-7 h-7 rounded-lg flex items-center justify-center transition-colors" style="background:rgba(29,63,181,0.40);border:1px solid rgba(29,63,181,0.5);" onmouseover="this.style.background='rgba(29,63,181,0.7)'" onmouseout="this.style.background='rgba(29,63,181,0.40)'">
                                        <i class="fa-brands fa-linkedin-in text-white text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating badge top-left: AI Powered -->
                    <div class="absolute -top-3 -left-4 stat-card-float z-10">
                        <div class="flex items-center gap-2 px-3 py-2 rounded-xl shadow-xl" style="background:rgba(13,27,75,0.85);border:1px solid rgba(29,63,181,0.4);backdrop-filter:blur(12px);">
                            <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background:linear-gradient(135deg,#f97316,#ea6a0a);">
                                <i class="fa-solid fa-robot text-white text-[10px]"></i>
                            </div>
                            <div>
                                <div class="text-[10px] font-black text-white leading-none">AI Powered</div>
                                <div class="text-[9px] font-bold" style="color:#fb923c;">Gemini Integrated</div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating badge top-right: Live Analytics -->
                    <div class="absolute -top-2 -right-4 stat-card-float-delay z-10">
                        <div class="flex items-center gap-2 px-3 py-2 rounded-xl shadow-xl" style="background:rgba(13,27,75,0.85);border:1px solid rgba(16,185,129,0.35);backdrop-filter:blur(12px);">
                            <span class="w-2 h-2 rounded-full bg-green-400 shadow-[0_0_6px_rgba(52,211,153,0.9)]"></span>
                            <div class="text-[10px] font-black text-white leading-none">Live Analytics</div>
                        </div>
                    </div>

                    <!-- Floating bottom-right: Built with Laravel -->
                    <div class="absolute -bottom-3 -right-4 stat-card-float z-10">
                        <div class="flex items-center gap-2 px-3 py-2 rounded-xl shadow-xl" style="background:rgba(13,27,75,0.85);border:1px solid rgba(249,115,22,0.25);backdrop-filter:blur(12px);">
                            <i class="fa-brands fa-laravel text-orange-400 text-sm"></i>
                            <div class="text-[10px] font-black text-white">Laravel 12</div>
                        </div>
                    </div>

                    <!-- Decorative small circles -->
                    <div class="absolute -bottom-5 -left-5 w-14 h-14 rounded-full border-2 border-orange-500/20 opacity-70 pointer-events-none"></div>
                    <div class="absolute -top-5 -right-3 w-8 h-8 rounded-full pointer-events-none" style="background:radial-gradient(circle,rgba(249,115,22,0.35),transparent);"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wave transition to light section -->
    <div class="absolute bottom-0 left-0 right-0 pointer-events-none" style="height:80px;overflow:hidden;">
        <svg viewBox="0 0 1440 80" preserveAspectRatio="none" style="width:100%;height:100%;" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#f8faff"/>
        </svg>
    </div>
</section>



<!-- ═══════════════════════════════════════════════════════════════
     PLATFORM HIGHLIGHTS STRIP
═══════════════════════════════════════════════════════════════ -->
<div class="py-6 border-y overflow-hidden" style="background:rgba(255,255,255,0.85);border-color:rgba(220,230,255,0.5);">
    <div class="flex animate-marquee whitespace-nowrap">
        <!-- Block 1 -->
        <div class="flex items-center gap-10 mx-6">
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-user-graduate" style="color:#f97316;"></i>
                <span>Student Management</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-chalkboard-user" style="color:#f97316;"></i>
                <span>Teacher Management</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-chart-bar" style="color:#f97316;"></i>
                <span>Performance Analytics</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-clock-rotate-left" style="color:#f97316;"></i>
                <span>Attendance Tracking</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-file-invoice-dollar" style="color:#f97316;"></i>
                <span>Fee Management</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-brain" style="color:#f97316;"></i>
                <span>AI Study Coach</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-qrcode" style="color:#f97316;"></i>
                <span>Digital Smart ID</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-triangle-exclamation" style="color:#f97316;"></i>
                <span>Dropout Risk Detection</span>
            </div>
            <span style="color:#dce6fc;">·</span>
        </div>
        <!-- Block 2 (duplicate for seamless loop) -->
        <div class="flex items-center gap-10 mx-6">
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-user-graduate" style="color:#f97316;"></i>
                <span>Student Management</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-chalkboard-user" style="color:#f97316;"></i>
                <span>Teacher Management</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-chart-bar" style="color:#f97316;"></i>
                <span>Performance Analytics</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-clock-rotate-left" style="color:#f97316;"></i>
                <span>Attendance Tracking</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-file-invoice-dollar" style="color:#f97316;"></i>
                <span>Fee Management</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-brain" style="color:#f97316;"></i>
                <span>AI Study Coach</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-qrcode" style="color:#f97316;"></i>
                <span>Digital Smart ID</span>
            </div>
            <span style="color:#dce6fc;">·</span>
            <div class="flex items-center gap-2.5 text-sm font-bold" style="color:#0d1b4b;">
                <i class="fa-solid fa-triangle-exclamation" style="color:#f97316;"></i>
                <span>Dropout Risk Detection</span>
            </div>
            <span style="color:#dce6fc;">·</span>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════════
     FEATURES SECTION — Bento Grid
═══════════════════════════════════════════════════════════════ -->
<section id="features" class="py-28 section-light transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-xs font-bold uppercase tracking-widest mb-4" style="background:rgba(249,115,22,0.08);border-color:rgba(249,115,22,0.25);color:#ea6a0a;">
                <i class="fa-solid fa-grip"></i> Core Modules
            </div>
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight mb-4" style="color:#0d1b4b;">Everything You Need to Run <span style="background:linear-gradient(90deg,#f97316,#1d3fb5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Smarter.</span></h2>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto font-medium">Powerful systems perfectly integrated into one unified platform — built for modern educational institutions.</p>
        </div>

        <!-- Premium Bento Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 auto-rows-[300px]">

            <!-- 1. Large Card: Performance Analytics -->
            <div class="md:col-span-2 md:row-span-2 group rounded-[2rem] overflow-hidden shadow-md border" style="background:linear-gradient(135deg,#f0f4ff,#e8edff);border-color:rgba(29,63,181,0.12);">
                <div class="bento-card w-full h-full rounded-[2rem] p-10 flex flex-col overflow-hidden">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg group-hover:scale-105 transition-transform duration-200" style="background:linear-gradient(135deg,#1d3fb5,#0d1b4b);box-shadow:0 4px 14px rgba(29,63,181,0.25);">
                        <i class="fa-solid fa-chart-line text-xl"></i>
                    </div>
                    <!-- Mini bar chart -->
                    <div class="flex items-end gap-1.5 h-16 mb-5">
                        <div class="flex-1 rounded-t group-hover:opacity-90 transition-opacity" style="height:40%;background:#b9cef9;"></div>
                        <div class="flex-1 rounded-t" style="height:65%;background:#88abf5;"></div>
                        <div class="flex-1 rounded-t" style="height:50%;background:#527de8;"></div>
                        <div class="flex-1 rounded-t" style="height:85%;background:#1d3fb5;"></div>
                        <div class="flex-1 rounded-t" style="height:72%;background:#f97316;"></div>
                        <div class="flex-1 rounded-t" style="height:95%;background:linear-gradient(to top,#1d3fb5,#f97316);"></div>
                    </div>
                    <div class="flex gap-3 mb-5">
                        <div class="flex-1 rounded-xl border px-3 py-2 text-center" style="background:rgba(29,63,181,0.06);border-color:rgba(29,63,181,0.15);">
                            <div class="text-base font-black" style="color:#1d3fb5;">Live</div>
                            <div class="text-[10px] font-bold uppercase tracking-wider" style="color:#527de8;">Attendance</div>
                        </div>
                        <div class="flex-1 rounded-xl border px-3 py-2 text-center" style="background:rgba(249,115,22,0.06);border-color:rgba(249,115,22,0.15);">
                            <div class="text-base font-black" style="color:#ea6a0a;">Real-Time</div>
                            <div class="text-[10px] font-bold uppercase tracking-wider" style="color:#f97316;">Results</div>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <h3 class="text-2xl font-black tracking-tight mb-3" style="color:#0d1b4b;">Performance Analytics</h3>
                        <p class="text-gray-500 leading-relaxed font-medium max-w-sm text-base">Deep, actionable insights into student performance, attendance patterns, and institutional health — all in real time.</p>
                    </div>
                </div>
            </div>

            <!-- 2. Medium Card: Smart QR Identity -->
            <div class="md:col-span-2 md:row-span-1 group rounded-[2rem] overflow-hidden shadow-md border" style="background:linear-gradient(135deg,#eff8ff,#e0f2fe);border-color:rgba(14,165,233,0.12);">
                <div class="bento-card w-full h-full rounded-[2rem] p-8 flex flex-row items-center gap-6 overflow-hidden">
                    <div class="shrink-0 w-20 h-20 rounded-2xl bg-white border-2 p-2 shadow-md group-hover:scale-105 group-hover:rotate-2 transition-transform duration-200" style="border-color:rgba(14,165,233,0.2);">
                        <div class="grid grid-cols-3 gap-0.5 w-full h-full">
                            <div class="bg-gray-800 rounded-sm"></div><div class="bg-gray-100 rounded-sm"></div><div class="bg-gray-800 rounded-sm"></div>
                            <div class="bg-gray-100 rounded-sm"></div><div class="rounded-sm" style="background:#1d3fb5;"></div><div class="bg-gray-100 rounded-sm"></div>
                            <div class="bg-gray-800 rounded-sm"></div><div class="bg-gray-100 rounded-sm"></div><div class="bg-gray-800 rounded-sm"></div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full mb-2" style="background:rgba(14,165,233,0.08);border:1px solid rgba(14,165,233,0.2);">
                            <span class="w-1.5 h-1.5 rounded-full" style="background:#0ea5e9;"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest" style="color:#0284c7;">Instant Scan</span>
                        </div>
                        <h3 class="text-xl font-black tracking-tight mb-1.5" style="color:#0d1b4b;">Smart QR Identity</h3>
                        <p class="text-gray-500 leading-relaxed font-medium text-sm">Instantly generate scannable digital ID cards for secure campus access control and student verification.</p>
                    </div>
                </div>
            </div>

            <!-- 3. Small Card: GPS Location Tracker -->
            <div class="md:col-span-1 md:row-span-1 group rounded-[2rem] overflow-hidden shadow-md border" style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);border-color:rgba(16,185,129,0.12);">
                <div class="bento-card w-full h-full rounded-[2rem] p-6 flex flex-col justify-between overflow-hidden items-center text-center">
                    <div class="relative w-14 h-14 flex items-center justify-center">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white shadow-md group-hover:scale-105 transition-transform duration-200" style="background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 4px 14px rgba(16,185,129,0.25);">
                            <i class="fa-solid fa-satellite-dish text-xl"></i>
                        </div>
                        <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-emerald-500 rounded-full ring-2 ring-white"></span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black tracking-tight mb-1" style="color:#0d1b4b;">Live Tracker</h3>
                        <p class="text-gray-500 text-sm font-medium">Secure live GPS campus tracking.</p>
                    </div>
                </div>
            </div>

            <!-- 4. Small Card: StudyAI Agent -->
            <div class="md:col-span-1 md:row-span-1 group rounded-[2rem] overflow-hidden shadow-md">
                <div class="w-full h-full rounded-[2rem] p-6 flex flex-col justify-between overflow-hidden text-center items-center" style="background:#0d1b4b;">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white mb-2 shadow-lg group-hover:scale-105 transition-transform duration-200" style="background:linear-gradient(135deg,#f97316,#ea6a0a);box-shadow:0 4px 14px rgba(249,115,22,0.35);">
                        <i class="fa-solid fa-robot text-xl"></i>
                    </div>
                    <div class="w-full space-y-1.5 mb-1">
                        <div class="flex justify-end"><div class="text-[10px] rounded-xl px-2 py-1 max-w-[80%] text-right" style="background:rgba(249,115,22,0.2);color:#fed7aa;">Explain photosynthesis</div></div>
                        <div class="flex justify-start"><div class="text-[10px] rounded-xl px-2 py-1 max-w-[80%] opacity-0 group-hover:opacity-100 transition-opacity duration-200" style="background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.7);">Sure! It's the process...</div></div>
                    </div>
                    <div>
                        <h3 class="text-xl font-black tracking-tight text-white mb-1">StudyAI Agent</h3>
                        <p class="text-sm font-medium" style="color:rgba(255,255,255,0.5);">Gemini-powered tutor.</p>
                    </div>
                </div>
            </div>

            <!-- 5. Medium Card: Parent Access -->
            <div class="md:col-span-2 md:row-span-1 group rounded-[2rem] overflow-hidden shadow-md border" style="background:linear-gradient(135deg,#f0f4ff,#e8edff);border-color:rgba(29,63,181,0.12);">
                <div class="bento-card w-full h-full rounded-[2rem] p-8 flex flex-row items-center gap-6 overflow-hidden">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white shadow-md group-hover:scale-105 transition-transform duration-200 shrink-0" style="background:linear-gradient(135deg,#1d3fb5,#0d1b4b);box-shadow:0 4px 14px rgba(29,63,181,0.25);">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full mb-2" style="background:rgba(29,63,181,0.08);border:1px solid rgba(29,63,181,0.18);">
                            <span class="w-1.5 h-1.5 rounded-full" style="background:#1d3fb5;"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest" style="color:#1d3fb5;">Live Updates</span>
                        </div>
                        <h3 class="text-xl font-black tracking-tight mb-1.5" style="color:#0d1b4b;">Parent Access</h3>
                        <p class="text-gray-500 leading-relaxed font-medium text-sm">Empower parents with real-time access to their children's attendance, grades, and fee records securely.</p>
                        <div class="mt-3 space-y-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <div class="flex items-center gap-2 text-[11px] font-bold" style="color:#1d3fb5;"><i class="fa-solid fa-circle-check text-emerald-500"></i> Attendance: Tracked & Visible</div>
                            <div class="flex items-center gap-2 text-[11px] font-bold" style="color:#1d3fb5;"><i class="fa-solid fa-circle-check text-emerald-500"></i> Report Card: PDF Download</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. Medium Card: Broadcasting -->
            <div class="md:col-span-2 md:row-span-1 group rounded-[2rem] overflow-hidden shadow-md border" style="background:linear-gradient(135deg,#fffbeb,#fef3c7);border-color:rgba(245,158,11,0.12);">
                <div class="bento-card w-full h-full rounded-[2rem] p-8 flex flex-row items-center gap-6 overflow-hidden">
                    <div class="relative shrink-0">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg group-hover:scale-105 group-hover:rotate-3 transition-transform duration-200" style="background:linear-gradient(135deg,#f59e0b,#d97706);box-shadow:0 4px 14px rgba(245,158,11,0.25);">
                            <i class="fa-solid fa-bullhorn text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-black tracking-tight mb-1" style="color:#0d1b4b;">Broadcasting</h3>
                        <p class="text-gray-500 leading-relaxed font-medium text-sm">Instantly deliver subject-specific announcements and urgent institutional notices across all user devices.</p>
                        <div class="mt-3 space-y-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <div class="flex items-center gap-2 text-[11px] font-bold rounded-lg px-2 py-1" style="background:rgba(245,158,11,0.08);color:#92400e;"><span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></span> Exam schedule updated — Math, 2nd Floor</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 7. Medium Card: Examination Management -->
            <div class="md:col-span-2 md:row-span-1 group rounded-[2rem] overflow-hidden shadow-md border" style="background:linear-gradient(135deg,#fdf4ff,#fae8ff);border-color:rgba(168,85,247,0.12);">
                <div class="bento-card w-full h-full rounded-[2rem] p-8 flex flex-row items-center gap-6 overflow-hidden">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg group-hover:scale-105 transition-transform duration-200 shrink-0" style="background:linear-gradient(135deg,#a855f7,#7c3aed);box-shadow:0 4px 14px rgba(168,85,247,0.25);">
                        <i class="fa-solid fa-pen-to-square text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full mb-2" style="background:rgba(168,85,247,0.08);border:1px solid rgba(168,85,247,0.2);">
                            <span class="w-1.5 h-1.5 rounded-full" style="background:#a855f7;"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest" style="color:#7c3aed;">Exam + Admit Card</span>
                        </div>
                        <h3 class="text-xl font-black tracking-tight mb-1.5" style="color:#0d1b4b;">Examination & Results</h3>
                        <p class="text-gray-500 leading-relaxed font-medium text-sm">Manage examinations, marks entry, result publishing, marksheet PDF generation and digital admit cards.</p>
                    </div>
                </div>
            </div>

            <!-- 8. Medium Card: SOS Emergency -->
            <div class="md:col-span-2 md:row-span-1 group rounded-[2rem] overflow-hidden shadow-md border" style="background:linear-gradient(135deg,#fff1f2,#ffe4e6);border-color:rgba(244,63,94,0.12);">
                <div class="bento-card w-full h-full rounded-[2rem] p-8 flex flex-row items-center gap-6 overflow-hidden">
                    <div class="relative shrink-0">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg group-hover:scale-105 group-hover:rotate-3 transition-transform duration-200" style="background:linear-gradient(135deg,#f43f5e,#be123c);box-shadow:0 4px 14px rgba(244,63,94,0.25);">
                            <i class="fa-solid fa-bell text-2xl"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full mb-2" style="background:rgba(244,63,94,0.08);border:1px solid rgba(244,63,94,0.2);">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest" style="color:#be123c;">Panic Alert</span>
                        </div>
                        <h3 class="text-xl font-black tracking-tight mb-1.5" style="color:#0d1b4b;">SOS Emergency</h3>
                        <p class="text-gray-500 leading-relaxed font-medium text-sm">Instant panic alerts triggered by students automatically notify parents with live GPS location data in emergencies.</p>
                    </div>
                </div>
            </div>

            <!-- 9. Large Card: AI Attendance Prediction -->
            <div class="md:col-span-2 md:row-span-2 group rounded-[2rem] overflow-hidden shadow-md border" style="background:linear-gradient(135deg,#f0fdff,#e0f7fa);border-color:rgba(6,182,212,0.12);">
                <div class="bento-card w-full h-full rounded-[2rem] p-10 flex flex-col overflow-hidden">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg group-hover:scale-105 transition-transform duration-200" style="background:linear-gradient(135deg,#06b6d4,#0891b2);box-shadow:0 4px 14px rgba(6,182,212,0.25);">
                        <i class="fa-solid fa-chart-simple text-2xl"></i>
                    </div>
                    <!-- Animated prediction bars -->
                    <div class="mb-6 space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-gray-400 w-16 shrink-0">Week 1</span>
                            <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full group-hover:w-[88%] w-[50%] transition-all duration-700 ease-out" style="background:linear-gradient(90deg,#06b6d4,#0891b2);"></div>
                            </div>
                            <span class="text-xs font-black w-10 text-right" style="color:#06b6d4;">88%</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-gray-400 w-16 shrink-0">Week 2</span>
                            <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full group-hover:w-[61%] w-[30%] transition-all duration-700 ease-out delay-75" style="background:linear-gradient(90deg,#f59e0b,#d97706);"></div>
                            </div>
                            <span class="text-xs font-black w-10 text-right" style="color:#d97706;">61%</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-gray-400 w-16 shrink-0">Week 3</span>
                            <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full group-hover:w-[42%] w-[20%] transition-all duration-700 ease-out delay-150" style="background:linear-gradient(90deg,#f43f5e,#be123c);"></div>
                            </div>
                            <span class="text-xs font-black w-10 text-right" style="color:#be123c;">42%</span>
                        </div>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-xs font-bold text-gray-400 w-16 shrink-0">Predicted</span>
                            <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full group-hover:w-[38%] w-[15%] transition-all duration-700 ease-out delay-200" style="background:linear-gradient(90deg,#f97316,#ea6a0a);"></div>
                            </div>
                            <span class="text-xs font-black w-10 text-right" style="color:#f97316;">~38%</span>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full mb-3" style="background:rgba(6,182,212,0.08);border:1px solid rgba(6,182,212,0.2);">
                            <span class="w-1.5 h-1.5 rounded-full" style="background:#06b6d4;"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest" style="color:#0891b2;">AI Powered</span>
                        </div>
                        <h3 class="text-2xl font-black tracking-tight mb-3" style="color:#0d1b4b;">AI Attendance Prediction</h3>
                        <p class="text-gray-500 leading-relaxed font-medium max-w-sm text-base">Analyzes historical trends to predict future eligibility risk. Automatically triggers smart alerts for at-risk students before it's too late.</p>
                    </div>
                </div>
            </div>

            <!-- 10. Large Card: Dropout Risk Detection -->
            <div class="md:col-span-2 md:row-span-2 group rounded-[2rem] overflow-hidden shadow-md border" style="background:linear-gradient(135deg,#fff7ed,#ffedd5);border-color:rgba(249,115,22,0.12);">
                <div class="bento-card w-full h-full rounded-[2rem] p-10 flex flex-col overflow-hidden">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white mb-8 shadow-lg group-hover:scale-105 transition-transform duration-200" style="background:linear-gradient(135deg,#f97316,#c2410c);box-shadow:0 4px 14px rgba(249,115,22,0.25);">
                        <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                    </div>
                    <!-- Risk score cards -->
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <div class="rounded-2xl border p-3 text-center group-hover:scale-[1.03] transition-transform duration-200" style="background:rgba(16,185,129,0.08);border-color:rgba(16,185,129,0.25);">
                            <div class="text-xl font-black" style="color:#059669;">Safe</div>
                            <div class="text-[10px] font-bold uppercase tracking-wider mt-1" style="color:#10b981;">Score &lt; 30</div>
                            <div class="mt-2 w-8 h-8 rounded-full flex items-center justify-center mx-auto" style="background:rgba(16,185,129,0.15);">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                            </div>
                        </div>
                        <div class="rounded-2xl border p-3 text-center group-hover:scale-[1.03] transition-transform duration-200 delay-50" style="background:rgba(245,158,11,0.08);border-color:rgba(245,158,11,0.25);">
                            <div class="text-xl font-black" style="color:#d97706;">At Risk</div>
                            <div class="text-[10px] font-bold uppercase tracking-wider mt-1" style="color:#f59e0b;">Score 30–59</div>
                            <div class="mt-2 w-8 h-8 rounded-full flex items-center justify-center mx-auto" style="background:rgba(245,158,11,0.15);">
                                <i class="fa-solid fa-circle-exclamation text-amber-500 text-sm"></i>
                            </div>
                        </div>
                        <div class="rounded-2xl border p-3 text-center group-hover:scale-[1.03] transition-transform duration-200 delay-100" style="background:rgba(244,63,94,0.08);border-color:rgba(244,63,94,0.25);">
                            <div class="text-xl font-black" style="color:#be123c;">High Risk</div>
                            <div class="text-[10px] font-bold uppercase tracking-wider mt-1" style="color:#f43f5e;">Score ≥ 60</div>
                            <div class="mt-2 w-8 h-8 rounded-full flex items-center justify-center mx-auto" style="background:rgba(244,63,94,0.15);">
                                <i class="fa-solid fa-circle-xmark text-rose-500 text-sm"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full mb-3" style="background:rgba(249,115,22,0.08);border:1px solid rgba(249,115,22,0.25);">
                            <span class="w-1.5 h-1.5 rounded-full" style="background:#f97316;"></span>
                            <span class="text-[10px] font-black uppercase tracking-widest" style="color:#ea6a0a;">Early Warning System</span>
                        </div>
                        <h3 class="text-2xl font-black tracking-tight mb-3" style="color:#0d1b4b;">Dropout Risk Detection</h3>
                        <p class="text-gray-500 leading-relaxed font-medium max-w-sm text-base">Intelligently scores each student's dropout likelihood by fusing attendance, academic performance, and engagement data into one actionable risk index.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     ROLE-BASED EXPERIENCE — "One Platform. Every Role."
═══════════════════════════════════════════════════════════════ -->
<section id="solutions" class="py-28 relative overflow-hidden" style="background:linear-gradient(160deg,#070e2e 0%,#0d1b4b 50%,#0f1050 100%);">
    <!-- Ambient orbs -->
    <div class="absolute top-0 left-1/4 w-96 h-96 pointer-events-none" style="background:radial-gradient(ellipse,rgba(249,115,22,0.12) 0%,transparent 65%);filter:blur(40px);"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 pointer-events-none" style="background:radial-gradient(ellipse,rgba(29,63,181,0.20) 0%,transparent 65%);filter:blur(40px);"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-xs font-bold uppercase tracking-widest mb-4" style="background:rgba(249,115,22,0.10);border-color:rgba(249,115,22,0.30);color:#fb923c;">
                <i class="fa-solid fa-users"></i> Role-Based Access
            </div>
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight text-white mb-4">One Platform. <span style="background:linear-gradient(90deg,#f97316,#fb923c);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Every Role.</span></h2>
            <p class="text-lg font-medium max-w-2xl mx-auto" style="color:rgba(255,255,255,0.55);">EdFlow provides dedicated, purpose-built portals for each stakeholder — so everyone gets exactly what they need.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Admin Card -->
            <div class="group relative rounded-3xl p-8 border border-white/10 overflow-hidden hover:border-orange-500/40 transition-all duration-500 hover:-translate-y-2" style="background:rgba(255,255,255,0.04);">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:linear-gradient(135deg,rgba(249,115,22,0.06) 0%,transparent 60%);"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg" style="background:linear-gradient(135deg,#f97316,#ea6a0a);box-shadow:0 4px 14px rgba(249,115,22,0.35);">
                        <i class="fa-solid fa-shield-halved text-xl"></i>
                    </div>
                    <div class="text-xs font-black uppercase tracking-widest mb-3" style="color:#f97316;">Administrator</div>
                    <h3 class="text-2xl font-black text-white mb-4 tracking-tight">Complete Institutional Control</h3>
                    <p class="font-medium leading-relaxed mb-6" style="color:rgba(255,255,255,0.55);">Manage your institution from one central dashboard. Approve registrations, configure courses, oversee attendance, manage fees, publish results and generate reports.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2 text-sm font-medium" style="color:rgba(255,255,255,0.65);"><i class="fa-solid fa-check text-orange-400 text-xs"></i> Student & Teacher Management</li>
                        <li class="flex items-center gap-2 text-sm font-medium" style="color:rgba(255,255,255,0.65);"><i class="fa-solid fa-check text-orange-400 text-xs"></i> Fee Approval & Analytics</li>
                        <li class="flex items-center gap-2 text-sm font-medium" style="color:rgba(255,255,255,0.65);"><i class="fa-solid fa-check text-orange-400 text-xs"></i> Result Publishing & Report Cards</li>
                        <li class="flex items-center gap-2 text-sm font-medium" style="color:rgba(255,255,255,0.65);"><i class="fa-solid fa-check text-orange-400 text-xs"></i> Dropout & Attendance Risk AI</li>
                    </ul>
                </div>
            </div>

            <!-- Teacher Card -->
            <div class="group relative rounded-3xl p-8 border border-white/10 overflow-hidden hover:border-blue-400/40 transition-all duration-500 hover:-translate-y-2" style="background:rgba(255,255,255,0.04);">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:linear-gradient(135deg,rgba(29,63,181,0.08) 0%,transparent 60%);"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg" style="background:linear-gradient(135deg,#1d3fb5,#0d1b4b);box-shadow:0 4px 14px rgba(29,63,181,0.35);">
                        <i class="fa-solid fa-chalkboard-user text-xl"></i>
                    </div>
                    <div class="text-xs font-black uppercase tracking-widest mb-3" style="color:#527de8;">Teacher</div>
                    <h3 class="text-2xl font-black text-white mb-4 tracking-tight">Teaching Made Effortless</h3>
                    <p class="font-medium leading-relaxed mb-6" style="color:rgba(255,255,255,0.55);">Manage classes, record attendance, enter marks, broadcast announcements and track student performance — all from a clean, focused portal.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2 text-sm font-medium" style="color:rgba(255,255,255,0.65);"><i class="fa-solid fa-check text-blue-400 text-xs"></i> Attendance Recording</li>
                        <li class="flex items-center gap-2 text-sm font-medium" style="color:rgba(255,255,255,0.65);"><i class="fa-solid fa-check text-blue-400 text-xs"></i> Marks Entry & Locking</li>
                        <li class="flex items-center gap-2 text-sm font-medium" style="color:rgba(255,255,255,0.65);"><i class="fa-solid fa-check text-blue-400 text-xs"></i> Timetable & Broadcast</li>
                        <li class="flex items-center gap-2 text-sm font-medium" style="color:rgba(255,255,255,0.65);"><i class="fa-solid fa-check text-blue-400 text-xs"></i> Performance Analysis</li>
                    </ul>
                </div>
            </div>

            <!-- Student Card -->
            <div class="group relative rounded-3xl p-8 border border-white/10 overflow-hidden hover:border-emerald-400/40 transition-all duration-500 hover:-translate-y-2" style="background:rgba(255,255,255,0.04);">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background:linear-gradient(135deg,rgba(16,185,129,0.06) 0%,transparent 60%);"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg" style="background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 4px 14px rgba(16,185,129,0.35);">
                        <i class="fa-solid fa-user-graduate text-xl"></i>
                    </div>
                    <div class="text-xs font-black uppercase tracking-widest mb-3" style="color:#34d399;">Student</div>
                    <h3 class="text-2xl font-black text-white mb-4 tracking-tight">Your Academic Life, Unified</h3>
                    <p class="font-medium leading-relaxed mb-6" style="color:rgba(255,255,255,0.55);">Access your attendance, courses, timetable, examination schedule, results, marksheets, fees and AI study assistant — all in one place.</p>
                    <ul class="space-y-2">
                        <li class="flex items-center gap-2 text-sm font-medium" style="color:rgba(255,255,255,0.65);"><i class="fa-solid fa-check text-emerald-400 text-xs"></i> Attendance & Insights</li>
                        <li class="flex items-center gap-2 text-sm font-medium" style="color:rgba(255,255,255,0.65);"><i class="fa-solid fa-check text-emerald-400 text-xs"></i> Results & Marksheet PDF</li>
                        <li class="flex items-center gap-2 text-sm font-medium" style="color:rgba(255,255,255,0.65);"><i class="fa-solid fa-check text-emerald-400 text-xs"></i> Fee Payment & Receipts</li>
                        <li class="flex items-center gap-2 text-sm font-medium" style="color:rgba(255,255,255,0.65);"><i class="fa-solid fa-check text-emerald-400 text-xs"></i> StudyAI + Smart ID Card</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     HOW EDFLOW WORKS — 4 Steps
═══════════════════════════════════════════════════════════════ -->
<section id="how-it-works" class="py-28 section-light transition-colors duration-300 relative overflow-hidden">
    <!-- Ambient -->
    <div class="absolute top-1/4 right-0 w-96 h-96 pointer-events-none" style="background:radial-gradient(ellipse,rgba(249,115,22,0.06) 0%,transparent 65%);filter:blur(60px);"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-xs font-bold uppercase tracking-widest mb-4" style="background:rgba(29,63,181,0.06);border-color:rgba(29,63,181,0.18);color:#1d3fb5;">
                <i class="fa-solid fa-route"></i> How It Works
            </div>
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight mb-4" style="color:#0d1b4b;">Up and Running in <span style="background:linear-gradient(90deg,#f97316,#1d3fb5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">4 Simple Steps.</span></h2>
            <p class="text-lg text-gray-500 font-medium max-w-2xl mx-auto">EdFlow is designed to be adopted quickly. From setup to full institutional deployment, the process is streamlined and guided.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="group relative p-8 rounded-3xl glass-card hover:-translate-y-2 transition-all duration-300 hover:shadow-xl">
                <div class="text-5xl font-black mb-4" style="color:rgba(249,115,22,0.15);">01</div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white mb-5" style="background:linear-gradient(135deg,#f97316,#ea6a0a);box-shadow:0 4px 12px rgba(249,115,22,0.30);">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <h3 class="text-xl font-black mb-3" style="color:#0d1b4b;">Set Up Your Institution</h3>
                <p class="text-gray-500 text-sm font-medium leading-relaxed">Configure your institution — add courses, subjects, and system settings to prepare EdFlow for your campus.</p>
            </div>

            <!-- Step 2 -->
            <div class="group relative p-8 rounded-3xl glass-card hover:-translate-y-2 transition-all duration-300 hover:shadow-xl" style="margin-top:0;">
                <div class="text-5xl font-black mb-4" style="color:rgba(29,63,181,0.12);">02</div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white mb-5" style="background:linear-gradient(135deg,#1d3fb5,#0d1b4b);box-shadow:0 4px 12px rgba(29,63,181,0.30);">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3 class="text-xl font-black mb-3" style="color:#0d1b4b;">Manage Students & Teachers</h3>
                <p class="text-gray-500 text-sm font-medium leading-relaxed">Approve student and faculty registrations. Assign roles, courses and subjects. Everyone gets their own secure portal.</p>
            </div>

            <!-- Step 3 -->
            <div class="group relative p-8 rounded-3xl glass-card hover:-translate-y-2 transition-all duration-300 hover:shadow-xl">
                <div class="text-5xl font-black mb-4" style="color:rgba(16,185,129,0.12);">03</div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white mb-5" style="background:linear-gradient(135deg,#10b981,#059669);box-shadow:0 4px 12px rgba(16,185,129,0.30);">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <h3 class="text-xl font-black mb-3" style="color:#0d1b4b;">Organize Academic Activities</h3>
                <p class="text-gray-500 text-sm font-medium leading-relaxed">Track attendance, build timetables, schedule examinations, broadcast notices and manage fees — all automated.</p>
            </div>

            <!-- Step 4 -->
            <div class="group relative p-8 rounded-3xl glass-card hover:-translate-y-2 transition-all duration-300 hover:shadow-xl">
                <div class="text-5xl font-black mb-4" style="color:rgba(168,85,247,0.12);">04</div>
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white mb-5" style="background:linear-gradient(135deg,#a855f7,#7c3aed);box-shadow:0 4px 12px rgba(168,85,247,0.30);">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3 class="text-xl font-black mb-3" style="color:#0d1b4b;">Track Results & Progress</h3>
                <p class="text-gray-500 text-sm font-medium leading-relaxed">Publish results, generate marksheets and report cards. Use AI-driven insights to identify at-risk students early.</p>
            </div>
        </div>

        <div class="text-center mt-14">
            <button onclick="toggleRegisterModal()" class="inline-flex items-center gap-3 px-10 py-4 rounded-2xl text-white font-bold text-base transition-all hover:-translate-y-0.5 hover:shadow-2xl" style="background:linear-gradient(135deg,#0d1b4b,#1d3fb5);box-shadow:0 8px 24px rgba(13,27,75,0.30);">
                Start using EdFlow <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     ABOUT SECTION
═══════════════════════════════════════════════════════════════ -->
<section id="about" class="py-28 relative overflow-hidden" style="background:linear-gradient(160deg,#070e2e 0%,#0d1b4b 50%,#0f1050 100%);">
    <div class="absolute inset-0 pointer-events-none" style="background:radial-gradient(ellipse at 60% 50%,rgba(249,115,22,0.10) 0%,transparent 60%);"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <!-- Left: Visual -->
            <div class="relative flex justify-center lg:justify-start">
                <div class="relative rounded-3xl p-8 border border-white/10" style="background:rgba(255,255,255,0.04);max-width:400px;width:100%;">
                    <!-- Abstract EdFlow identity graphic -->
                    <div class="flex items-center justify-center mb-8">
                        <div class="relative">
                            <div class="w-24 h-24 rounded-3xl flex items-center justify-center" style="background:linear-gradient(135deg,#f97316,#ea6a0a);box-shadow:0 0 60px rgba(249,115,22,0.4);">
                                <i class="fa-solid fa-graduation-cap text-white text-4xl"></i>
                            </div>
                            <div class="absolute -bottom-3 -right-3 w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(29,63,181,0.8);border:2px solid rgba(255,255,255,0.2);">
                                <i class="fa-solid fa-bolt text-white text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3 p-3 rounded-xl" style="background:rgba(249,115,22,0.08);border:1px solid rgba(249,115,22,0.2);">
                            <i class="fa-solid fa-bullseye text-orange-400"></i>
                            <div>
                                <div class="text-xs font-black text-white uppercase tracking-wider">Our Mission</div>
                                <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.55);">Eliminate administrative friction so educators focus on teaching</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl" style="background:rgba(29,63,181,0.08);border:1px solid rgba(29,63,181,0.25);">
                            <i class="fa-solid fa-shield-halved text-blue-400"></i>
                            <div>
                                <div class="text-xs font-black text-white uppercase tracking-wider">Security First</div>
                                <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.55);">Role-based access control with encrypted data handling</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl" style="background:rgba(16,185,129,0.07);border:1px solid rgba(16,185,129,0.2);">
                            <i class="fa-solid fa-code text-emerald-400"></i>
                            <div>
                                <div class="text-xs font-black text-white uppercase tracking-wider">Open Development</div>
                                <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.55);">Built with Laravel, Tailwind CSS and modern web standards</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3 justify-center">
                        <a href="https://github.com/somnath-sen" target="_blank" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white transition-all hover:opacity-80" style="background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);">
                            <i class="fa-brands fa-github"></i> GitHub
                        </a>
                        <a href="https://www.linkedin.com/in/thesomishere/" target="_blank" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white transition-all hover:opacity-80" style="background:rgba(29,63,181,0.20);border:1px solid rgba(29,63,181,0.30);">
                            <i class="fa-brands fa-linkedin-in"></i> LinkedIn
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right: Text -->
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-xs font-bold uppercase tracking-widest mb-6" style="background:rgba(249,115,22,0.10);border-color:rgba(249,115,22,0.30);color:#fb923c;">
                    <i class="fa-solid fa-info-circle"></i> About EdFlow
                </div>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white mb-6 leading-tight">Built to Make Education Management <span style="background:linear-gradient(90deg,#f97316,#fb923c);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Simpler.</span></h2>
                <div class="space-y-5 font-medium leading-relaxed" style="color:rgba(255,255,255,0.65);">
                    <p>EdFlow is a next-generation Smart Campus Management platform built to seamlessly bridge the gap between modern education and advanced technology. It replaces dozens of fragmented administrative tools with one beautiful, unified system.</p>
                    <p>Founded on the principles of speed, security, and simplicity, EdFlow provides dedicated portals for administrators, teachers, students, and parents — each tailored to their specific needs while maintaining complete institutional oversight.</p>
                    <p>From AI-powered dropout risk detection to Gemini-integrated study assistance, EdFlow brings cutting-edge technology to everyday campus operations — making institutions more efficient, educators more effective, and students more supported.</p>
                </div>

                <div class="mt-8 flex flex-wrap gap-4">
                    <div class="flex items-center gap-2 text-sm font-bold" style="color:rgba(255,255,255,0.70);">
                        <i class="fa-solid fa-layer-group text-orange-400"></i>
                        <span>Laravel 12 Backend</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm font-bold" style="color:rgba(255,255,255,0.70);">
                        <i class="fa-solid fa-robot text-orange-400"></i>
                        <span>Gemini AI Integration</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm font-bold" style="color:rgba(255,255,255,0.70);">
                        <i class="fa-solid fa-lock text-orange-400"></i>
                        <span>RBAC Security</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm font-bold" style="color:rgba(255,255,255,0.70);">
                        <i class="fa-brands fa-github text-orange-400"></i>
                        <span>Open Source</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     FAQ SECTION
═══════════════════════════════════════════════════════════════ -->
<section id="faq" class="py-28 section-light transition-colors duration-300 relative overflow-hidden">
    <div class="absolute top-1/3 left-0 w-80 h-80 pointer-events-none" style="background:radial-gradient(ellipse,rgba(29,63,181,0.06) 0%,transparent 65%);filter:blur(50px);"></div>
    <div class="absolute bottom-1/4 right-0 w-80 h-80 pointer-events-none" style="background:radial-gradient(ellipse,rgba(249,115,22,0.05) 0%,transparent 65%);filter:blur(50px);"></div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-xs font-bold uppercase tracking-widest mb-4" style="background:rgba(29,63,181,0.06);border-color:rgba(29,63,181,0.18);color:#1d3fb5;">
                <i class="fa-solid fa-circle-question"></i> FAQ
            </div>
            <h2 class="text-4xl sm:text-6xl font-black tracking-tight mb-4 leading-tight" style="color:#0d1b4b;">Got questions?<br><span style="background:linear-gradient(90deg,#f97316,#1d3fb5);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">We have answers.</span></h2>
        </div>

        <div class="space-y-5">

            <!-- FAQ 1 -->
            <div class="group relative bg-white rounded-2xl border border-gray-100 hover:border-orange-300 shadow-sm hover:shadow-xl hover:shadow-orange-500/8 transition-all duration-400 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute top-0 bottom-0 left-0 w-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-l-full" style="background:linear-gradient(to bottom,#f97316,#ea6a0a);"></div>
                <button class="faq-btn w-full px-7 py-5 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 group-hover:text-orange-600 transition-colors text-lg pr-4">What exactly is EdFlow?</span>
                    <div class="w-9 h-9 shrink-0 rounded-xl bg-gray-50 flex items-center justify-center border border-gray-100 group-hover:border-orange-400 group-hover:shadow-[0_0_12px_rgba(249,115,22,0.3)] transition-all duration-300" style="group-hover:background:#f97316;">
                        <i class="fa-solid fa-chevron-down text-gray-400 group-hover:text-orange-500 transition-transform duration-300 text-sm"></i>
                    </div>
                </button>
                <div class="faq-content px-7 text-gray-600 text-base font-medium leading-relaxed">
                    <div class="pb-6 border-t border-gray-50 pt-4 mt-2">
                        EdFlow is an all-in-one Smart Campus Management System. It provides dedicated portals for Administrators, Teachers, Students, and Parents to manage everything from academic results and attendance to admissions, examinations, fees and internal communications — all in one secure platform.
                    </div>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="group relative bg-white rounded-2xl border border-gray-100 hover:border-blue-300 shadow-sm hover:shadow-xl hover:shadow-blue-500/8 transition-all duration-400 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute top-0 bottom-0 left-0 w-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-l-full" style="background:linear-gradient(to bottom,#1d3fb5,#527de8);"></div>
                <button class="faq-btn w-full px-7 py-5 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 group-hover:text-blue-700 transition-colors text-lg pr-4">Who can use EdFlow?</span>
                    <div class="w-9 h-9 shrink-0 rounded-xl bg-gray-50 flex items-center justify-center border border-gray-100 group-hover:border-blue-400 transition-all duration-300">
                        <i class="fa-solid fa-chevron-down text-gray-400 group-hover:text-blue-600 transition-transform duration-300 text-sm"></i>
                    </div>
                </button>
                <div class="faq-content px-7 text-gray-600 text-base font-medium leading-relaxed">
                    <div class="pb-6 border-t border-gray-50 pt-4 mt-2">
                        EdFlow is built for educational institutions. There are four types of users: <strong>Administrators</strong> (who manage the entire campus), <strong>Teachers</strong> (who manage classes and attendance), <strong>Students</strong> (who access their academic information), and <strong>Parents</strong> (who can view their child's progress and receive updates).
                    </div>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="group relative bg-white rounded-2xl border border-gray-100 hover:border-emerald-300 shadow-sm hover:shadow-xl hover:shadow-emerald-500/8 transition-all duration-400 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute top-0 bottom-0 left-0 w-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-l-full" style="background:linear-gradient(to bottom,#10b981,#059669);"></div>
                <button class="faq-btn w-full px-7 py-5 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 group-hover:text-emerald-700 transition-colors text-lg pr-4">Does EdFlow support multiple user roles?</span>
                    <div class="w-9 h-9 shrink-0 rounded-xl bg-gray-50 flex items-center justify-center border border-gray-100 group-hover:border-emerald-400 transition-all duration-300">
                        <i class="fa-solid fa-chevron-down text-gray-400 group-hover:text-emerald-600 transition-transform duration-300 text-sm"></i>
                    </div>
                </button>
                <div class="faq-content px-7 text-gray-600 text-base font-medium leading-relaxed">
                    <div class="pb-6 border-t border-gray-50 pt-4 mt-2">
                        Yes. EdFlow uses a comprehensive Role-Based Access Control (RBAC) system. Each role — Admin, Teacher, Student, and Parent — has its own dedicated portal with precisely tailored permissions. A student can never access administrative settings, and a teacher can only modify grades for their assigned subjects.
                    </div>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="group relative bg-white rounded-2xl border border-gray-100 hover:border-purple-300 shadow-sm hover:shadow-xl hover:shadow-purple-500/8 transition-all duration-400 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute top-0 bottom-0 left-0 w-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-l-full" style="background:linear-gradient(to bottom,#a855f7,#7c3aed);"></div>
                <button class="faq-btn w-full px-7 py-5 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 group-hover:text-purple-700 transition-colors text-lg pr-4">How does the StudyAI feature work?</span>
                    <div class="w-9 h-9 shrink-0 rounded-xl bg-gray-50 flex items-center justify-center border border-gray-100 group-hover:border-purple-400 transition-all duration-300">
                        <i class="fa-solid fa-chevron-down text-gray-400 group-hover:text-purple-600 transition-transform duration-300 text-sm"></i>
                    </div>
                </button>
                <div class="faq-content px-7 text-gray-600 text-base font-medium leading-relaxed">
                    <div class="pb-6 border-t border-gray-50 pt-4 mt-2">
                        StudyAI uses the Google Gemini API to provide an intelligent on-demand tutor for students. Students can ask academic questions, get explanations, summarize notes, or prepare for exams. Teachers can also use it to draft lesson plans and generate quiz questions — all accessible directly from inside EdFlow.
                    </div>
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="group relative bg-white rounded-2xl border border-gray-100 hover:border-orange-300 shadow-sm hover:shadow-xl hover:shadow-orange-500/8 transition-all duration-400 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute top-0 bottom-0 left-0 w-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-l-full" style="background:linear-gradient(to bottom,#f97316,#ea6a0a);"></div>
                <button class="faq-btn w-full px-7 py-5 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 group-hover:text-orange-600 transition-colors text-lg pr-4">What can students access in EdFlow?</span>
                    <div class="w-9 h-9 shrink-0 rounded-xl bg-gray-50 flex items-center justify-center border border-gray-100 group-hover:border-orange-400 transition-all duration-300">
                        <i class="fa-solid fa-chevron-down text-gray-400 group-hover:text-orange-500 transition-transform duration-300 text-sm"></i>
                    </div>
                </button>
                <div class="faq-content px-7 text-gray-600 text-base font-medium leading-relaxed">
                    <div class="pb-6 border-t border-gray-50 pt-4 mt-2">
                        Students get access to their attendance records and insights, course information, timetable, exam schedules, admit cards, results, marksheets (with PDF download), fee payment history, report cards, digital smart ID card with QR verification, StudyAI tutor, broadcast messages from teachers, and emergency SOS features.
                    </div>
                </div>
            </div>

            <!-- FAQ 6 -->
            <div class="group relative bg-white rounded-2xl border border-gray-100 hover:border-blue-300 shadow-sm hover:shadow-xl hover:shadow-blue-500/8 transition-all duration-400 overflow-hidden transform hover:-translate-y-1">
                <div class="absolute top-0 bottom-0 left-0 w-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-l-full" style="background:linear-gradient(to bottom,#1d3fb5,#0d1b4b);"></div>
                <button class="faq-btn w-full px-7 py-5 text-left flex justify-between items-center focus:outline-none">
                    <span class="font-bold text-gray-900 group-hover:text-blue-700 transition-colors text-lg pr-4">Is our institutional data secure?</span>
                    <div class="w-9 h-9 shrink-0 rounded-xl bg-gray-50 flex items-center justify-center border border-gray-100 group-hover:border-blue-400 transition-all duration-300">
                        <i class="fa-solid fa-chevron-down text-gray-400 group-hover:text-blue-600 transition-transform duration-300 text-sm"></i>
                    </div>
                </button>
                <div class="faq-content px-7 text-gray-600 text-base font-medium leading-relaxed">
                    <div class="pb-6 border-t border-gray-50 pt-4 mt-2">
                        Absolutely. EdFlow uses industry-standard security practices including database encryption, secure password hashing, role-based access control (RBAC), and CSRF protection on all forms. Each user role is strictly isolated — a student cannot access teacher or administrator data under any circumstances.
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     FINAL CTA SECTION
═══════════════════════════════════════════════════════════════ -->
<section class="py-28 relative overflow-hidden" style="background:linear-gradient(160deg,#070e2e 0%,#0d1b4b 55%,#0f1050 100%);">
    <!-- Orange glow -->
    <div class="absolute inset-0 pointer-events-none" style="background:radial-gradient(ellipse at 50% 50%,rgba(249,115,22,0.15) 0%,transparent 65%);"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-xs font-bold uppercase tracking-widest mb-8" style="background:rgba(249,115,22,0.10);border-color:rgba(249,115,22,0.30);color:#fb923c;">
            <span class="w-1.5 h-1.5 rounded-full bg-orange-400 shadow-[0_0_8px_rgba(251,146,60,0.9)]"></span>
            Get Started Today
        </div>

        <h2 class="text-4xl sm:text-6xl font-black tracking-tight text-white mb-6 leading-tight">
            Ready to Simplify<br>
            <span style="background:linear-gradient(90deg,#f97316,#fb923c);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Education Management?</span>
        </h2>

        <p class="text-lg font-medium mb-12 max-w-2xl mx-auto" style="color:rgba(255,255,255,0.60);">Bring students, teachers and academic operations together with EdFlow. One platform. Every academic need.</p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button onclick="toggleRegisterModal()" class="inline-flex items-center justify-center gap-3 px-10 py-4 rounded-2xl text-white font-bold text-base transition-all hover:-translate-y-0.5 hover:shadow-2xl group" style="background:linear-gradient(135deg,#f97316,#ea6a0a);box-shadow:0 8px 30px rgba(249,115,22,0.45);">
                <span>Get Started</span>
                <span class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/20 group-hover:bg-white/30 transition-colors">
                    <i class="fa-solid fa-arrow-right text-sm group-hover:translate-x-0.5 transition-transform"></i>
                </span>
            </button>
            <a href="#features" class="inline-flex items-center justify-center gap-3 px-10 py-4 rounded-2xl text-white font-bold text-base border border-white/20 hover:bg-white/10 hover:border-white/30 transition-all hover:-translate-y-0.5 group">
                <span>Explore Features</span>
                <i class="fa-solid fa-arrow-right text-sm group-hover:translate-x-0.5 transition-transform opacity-60"></i>
            </a>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════════════════════ -->
<footer id="contact" class="relative pt-20 pb-10 overflow-hidden" style="background:#070e2e;border-top:1px solid rgba(255,255,255,0.06);">
    <!-- Glow -->
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-[700px] h-[300px] pointer-events-none" style="background:radial-gradient(ellipse,rgba(249,115,22,0.12) 0%,transparent 65%);filter:blur(60px);"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">

            <!-- Brand -->
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <div class="relative w-10 h-10 rounded-xl flex items-center justify-center text-white" style="background:linear-gradient(135deg,#f97316,#ea6a0a);box-shadow:0 0 20px rgba(249,115,22,0.35);">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span class="font-black text-2xl tracking-tight text-white">EdFlow<span style="color:#f97316;">.</span></span>
                </div>
                <p class="text-sm font-medium leading-relaxed" style="color:rgba(255,255,255,0.45);">
                    The all-in-one Smart Campus Management platform. Streamlining operations so institutions can focus purely on education.
                </p>
                <div class="flex space-x-3">
                    <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:-translate-y-1" style="background:rgba(255,255,255,0.05);color:rgba(255,255,255,0.5);" onmouseover="this.style.background='#f97316';this.style.color='white'" onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.color='rgba(255,255,255,0.5)'">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/thesomishere/" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:-translate-y-1" style="background:rgba(255,255,255,0.05);color:rgba(255,255,255,0.5);" onmouseover="this.style.background='#0077b5';this.style.color='white'" onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.color='rgba(255,255,255,0.5)'">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="https://github.com/somnath-sen" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:-translate-y-1" style="background:rgba(255,255,255,0.05);color:rgba(255,255,255,0.5);" onmouseover="this.style.background='rgba(255,255,255,0.15)';this.style.color='white'" onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.color='rgba(255,255,255,0.5)'">
                        <i class="fa-brands fa-github"></i>
                    </a>
                    <a href="https://www.instagram.com/thesomishere/" target="_blank" class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:-translate-y-1" style="background:rgba(255,255,255,0.05);color:rgba(255,255,255,0.5);" onmouseover="this.style.background='#e1306c';this.style.color='white'" onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.color='rgba(255,255,255,0.5)'">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Product Links -->
            <div>
                <h4 class="font-bold text-white mb-6 uppercase tracking-widest text-xs">Product</h4>
                <ul class="space-y-4 text-sm font-medium" style="color:rgba(255,255,255,0.45);">
                    <li class="group flex items-center gap-2 hover:text-orange-400 transition-colors cursor-pointer" onclick="window.scrollTo({top:0,behavior:'smooth'})">
                        <i class="fa-solid fa-arrow-right text-[10px] text-orange-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i>Home
                    </li>
                    <li class="group flex items-center gap-2"><i class="fa-solid fa-arrow-right text-[10px] text-orange-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i><a href="#features" class="hover:text-orange-400 transition-colors">Features</a></li>
                    <li class="group flex items-center gap-2"><i class="fa-solid fa-arrow-right text-[10px] text-orange-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i><a href="#solutions" class="hover:text-orange-400 transition-colors">Solutions</a></li>
                    <li class="group flex items-center gap-2"><i class="fa-solid fa-arrow-right text-[10px] text-orange-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i><a href="#how-it-works" class="hover:text-orange-400 transition-colors">How It Works</a></li>
                    <li class="group flex items-center gap-2"><i class="fa-solid fa-arrow-right text-[10px] text-orange-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i><a href="#faq" class="hover:text-orange-400 transition-colors">FAQ</a></li>
                </ul>
            </div>

            <!-- Company Links -->
            <div>
                <h4 class="font-bold text-white mb-6 uppercase tracking-widest text-xs">Account</h4>
                <ul class="space-y-4 text-sm font-medium" style="color:rgba(255,255,255,0.45);">
                    <li class="group flex items-center gap-2"><i class="fa-solid fa-arrow-right text-[10px] text-orange-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i><button onclick="toggleRegisterModal()" class="hover:text-orange-400 transition-colors text-left focus:outline-none">Get Started</button></li>
                    <li class="group flex items-center gap-2"><i class="fa-solid fa-arrow-right text-[10px] text-orange-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i><a href="{{ route('login') }}" class="hover:text-orange-400 transition-colors">Login</a></li>
                    <li class="group flex items-center gap-2"><i class="fa-solid fa-arrow-right text-[10px] text-orange-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i><button onclick="toggleCustomModal('aboutModal')" class="hover:text-orange-400 transition-colors text-left focus:outline-none">About</button></li>
                    <li class="group flex items-center gap-2"><i class="fa-solid fa-arrow-right text-[10px] text-orange-500 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300"></i><button onclick="toggleCustomModal('contactDetailsModal')" class="hover:text-orange-400 transition-colors text-left focus:outline-none">Contact</button></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h4 class="font-bold text-white mb-6 uppercase tracking-widest text-xs">Stay Updated</h4>
                <p class="text-sm mb-4 font-medium" style="color:rgba(255,255,255,0.45);">Subscribe for the latest EdFlow updates and feature announcements.</p>
                <form id="newsletterForm" class="space-y-3">
                    <input type="email" id="newsletterEmail" name="email" placeholder="Enter your email" required
                        class="w-full px-4 py-3 rounded-xl text-sm focus:outline-none transition-all text-white placeholder-gray-500"
                        style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);focus-visible:border-color:#f97316;">
                    <button type="submit" id="subscribeBtn" class="relative group/btn w-full py-3.5 px-4 rounded-xl text-sm font-black text-white transition-all shadow-lg overflow-hidden" style="background:linear-gradient(135deg,#f97316,#ea6a0a);">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            Subscribe <i class="fa-solid fa-paper-plane text-xs"></i>
                            <i class="fa-solid fa-spinner fa-spin hidden" id="btnLoader"></i>
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-4" style="border-top:1px solid rgba(255,255,255,0.08);">
            <p class="text-sm font-bold text-center md:text-left" style="color:rgba(255,255,255,0.35);">&copy; {{ date('Y') }} EdFlow. All rights reserved.</p>
            <div class="flex space-x-6 text-sm font-bold" style="color:rgba(255,255,255,0.35);">
                <button onclick="toggleCustomModal('privacyModal')" class="hover:text-orange-400 transition-colors focus:outline-none">Privacy Policy</button>
                <button onclick="toggleCustomModal('termsModal')" class="hover:text-orange-400 transition-colors focus:outline-none">Terms of Service</button>
            </div>
        </div>

        <div class="mt-8 text-center rounded-2xl py-4 border" style="background:rgba(255,255,255,0.03);border-color:rgba(255,255,255,0.06);">
            <p class="text-sm font-bold flex items-center justify-center gap-2" style="color:rgba(255,255,255,0.35);">
                Designed & Developed with
                <span class="inline-block animate-pulse text-rose-500 text-lg drop-shadow-[0_0_8px_rgba(244,63,94,0.8)]"><i class="fa-solid fa-heart"></i></span>
                by <a href="https://somnath-sen.github.io/somnathsen/" target="_blank" class="font-black hover:opacity-80 transition-opacity" style="background:linear-gradient(90deg,#f97316,#fb923c);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Somnath Sen</a>
            </p>
        </div>
    </div>
</footer>


<!-- ═══════════════════════════════════════════════════════════════
     MOBILE BOTTOM NAV BAR
═══════════════════════════════════════════════════════════════ -->
<div id="mob-bottom-bar" aria-label="Quick Navigation" role="navigation">
    <div class="mbb-wave" style="height:32px;position:relative;overflow:hidden;">
        <svg style="position:absolute;bottom:0;left:0;width:200%;height:100%;" viewBox="0 0 780 32" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path fill="#dce6fc" fill-opacity="0.5" d="M0,16 C65,28 130,4 195,16 C260,28 325,4 390,16 C455,28 520,4 585,16 C650,28 715,4 780,16 L780,32 L0,32 Z">
                <animateTransform attributeName="transform" type="translate" from="0,0" to="-390,0" dur="4s" repeatCount="indefinite"/>
            </path>
            <path fill="#eef2ff" d="M0,18 C50,8 100,28 155,18 C210,8 265,28 320,18 C375,8 430,28 485,18 C540,8 595,28 650,18 C705,8 760,28 780,18 L780,32 L0,32 Z">
                <animateTransform attributeName="transform" type="translate" from="0,0" to="-390,0" dur="2.5s" repeatCount="indefinite"/>
            </path>
        </svg>
    </div>
    <div class="mbb-body">
        <div class="mbb-row1">
            <a href="#features" id="mbb-features" class="mbb-card" aria-label="Features">
                <div class="mbb-icon mbb-i-navy"><i class="fa-solid fa-grip"></i></div>
                <span class="mbb-label">Features</span>
            </a>
            <a href="#solutions" id="mbb-solutions" class="mbb-card" aria-label="Solutions">
                <div class="mbb-icon mbb-i-purple"><i class="fa-solid fa-users"></i></div>
                <span class="mbb-label">Solutions</span>
            </a>
            <a href="{{ route('login') }}" id="mbb-login" class="mbb-card" aria-label="Log In">
                <div class="mbb-icon mbb-i-rose"><i class="fa-solid fa-user"></i></div>
                <span class="mbb-label">Log in</span>
            </a>
        </div>
        <div class="mbb-row2">
            <button onclick="toggleRegisterModal()" id="mbb-register" class="mbb-card w-full" aria-label="Get Started">
                <div class="mbb-icon mbb-i-orange"><i class="fa-solid fa-arrow-right"></i></div>
                <span class="mbb-label">Get Started</span>
            </button>
            <a href="#faq" id="mbb-faq" class="mbb-card" aria-label="FAQ">
                <div class="mbb-icon mbb-i-green"><i class="fa-solid fa-circle-question"></i></div>
                <span class="mbb-label">FAQ</span>
            </a>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════════
     ALL MODALS (Preserved — updated accent colors)
═══════════════════════════════════════════════════════════════ -->

<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 z-[100] hidden custom-modal">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('loginModal')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white/95 backdrop-blur-3xl w-full max-w-md rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden border border-white/80 pointer-events-auto flex flex-col">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50/80 border-b border-gray-100">
                <div class="flex items-center gap-2 w-16">
                    <button onclick="toggleCustomModal('loginModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10">
                        <i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i>
                    </button>
                    <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                    <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                </div>
                <h2 class="text-xs font-bold text-gray-700 tracking-wide">Welcome Back to EdFlow</h2>
                <div class="w-16"></div>
            </div>
            <div class="p-8">
                <p class="text-gray-500 mb-8 text-center text-sm font-medium">Select your account type to continue.</p>
                <div class="space-y-4">
                    <a href="{{ route('login') }}?type=student" class="flex items-center p-4 rounded-xl border border-gray-200 hover:border-orange-400 hover:bg-orange-50 transition-all group">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4 transition-colors" style="background:rgba(249,115,22,0.10);color:#ea6a0a;" onmouseover="this.style.background='#f97316';this.style.color='white'" onmouseout="this.style.background='rgba(249,115,22,0.10)';this.style.color='#ea6a0a'"><i class="fa-solid fa-graduation-cap"></i></div>
                        <div><h3 class="font-semibold text-gray-900">Student</h3><p class="text-xs text-gray-500">Access courses, results & attendance</p></div>
                        <i class="fa-solid fa-chevron-right ml-auto text-gray-300 group-hover:text-orange-500"></i>
                    </a>
                    <a href="{{ route('login') }}?type=teacher" class="flex items-center p-4 rounded-xl border border-gray-200 hover:border-navy-500 hover:bg-blue-50 transition-all group">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4 transition-colors" style="background:rgba(29,63,181,0.10);color:#1d3fb5;" onmouseover="this.style.background='#1d3fb5';this.style.color='white'" onmouseout="this.style.background='rgba(29,63,181,0.10)';this.style.color='#1d3fb5'"><i class="fa-solid fa-chalkboard-user"></i></div>
                        <div><h3 class="font-semibold text-gray-900">Teacher</h3><p class="text-xs text-gray-500">Manage class & attendance</p></div>
                        <i class="fa-solid fa-chevron-right ml-auto text-gray-300 group-hover:text-blue-600"></i>
                    </a>
                    <a href="{{ route('login') }}?type=admin" class="flex items-center p-4 rounded-xl border border-gray-200 hover:border-gray-900 hover:bg-gray-50 transition-all group">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4 bg-gray-100 text-gray-600 group-hover:bg-gray-900 group-hover:text-white transition-colors"><i class="fa-solid fa-shield-halved"></i></div>
                        <div><h3 class="font-semibold text-gray-900">Administrator</h3><p class="text-xs text-gray-500">System settings & management</p></div>
                        <i class="fa-solid fa-chevron-right ml-auto text-gray-300 group-hover:text-gray-900"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div id="registerModal" class="fixed inset-0 z-[100] hidden custom-modal">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('registerModal')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white/95 backdrop-blur-3xl w-full max-w-md rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden border border-white/80 pointer-events-auto flex flex-col">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50/80 border-b border-gray-100">
                <div class="flex items-center gap-2 w-16">
                    <button onclick="toggleCustomModal('registerModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10">
                        <i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i>
                    </button>
                    <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                    <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                </div>
                <h2 class="text-xs font-bold text-gray-700 tracking-wide">Join EdFlow</h2>
                <div class="w-16"></div>
            </div>
            <div class="p-8">
                <p class="text-gray-500 mb-8 text-center text-sm font-medium">Select your application type to submit a registration request.</p>
                <div class="space-y-4">
                    <a href="/register/student" class="flex items-center p-4 rounded-xl border border-gray-200 hover:border-orange-400 hover:bg-orange-50 transition-all group">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4 transition-colors" style="background:rgba(249,115,22,0.10);color:#ea6a0a;" onmouseover="this.style.background='#f97316';this.style.color='white'" onmouseout="this.style.background='rgba(249,115,22,0.10)';this.style.color='#ea6a0a'"><i class="fa-solid fa-graduation-cap"></i></div>
                        <div><h3 class="font-semibold text-gray-900">Apply as Student</h3><p class="text-xs text-gray-500">Enrollment application</p></div>
                        <i class="fa-solid fa-chevron-right ml-auto text-gray-300 group-hover:text-orange-500"></i>
                    </a>
                    <a href="/register/teacher" class="flex items-center p-4 rounded-xl border border-gray-200 hover:border-navy-500 hover:bg-blue-50 transition-all group">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4 transition-colors" style="background:rgba(29,63,181,0.10);color:#1d3fb5;" onmouseover="this.style.background='#1d3fb5';this.style.color='white'" onmouseout="this.style.background='rgba(29,63,181,0.10)';this.style.color='#1d3fb5'"><i class="fa-solid fa-chalkboard-user"></i></div>
                        <div><h3 class="font-semibold text-gray-900">Apply as Faculty</h3><p class="text-xs text-gray-500">Instructor application</p></div>
                        <i class="fa-solid fa-chevron-right ml-auto text-gray-300 group-hover:text-blue-600"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Modal -->
<div id="aboutModal" class="fixed inset-0 z-[100] hidden custom-modal">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('aboutModal')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white/95 backdrop-blur-3xl w-full max-w-lg rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden border border-white/80 pointer-events-auto flex flex-col">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50/80 border-b border-gray-100">
                <div class="flex items-center gap-2 w-16">
                    <button onclick="toggleCustomModal('aboutModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10"><i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i></button>
                    <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                    <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                </div>
                <h2 class="text-xs font-bold text-gray-700 tracking-wide flex items-center gap-2"><i class="fa-solid fa-building" style="color:#f97316;"></i> About EdFlow</h2>
                <div class="w-16"></div>
            </div>
            <div class="p-8">
                <div class="space-y-5">
                    <p class="text-gray-600 leading-relaxed text-sm">EdFlow is a next-generation campus management platform built to seamlessly bridge the gap between modern education and advanced cloud technology.</p>
                    <div class="p-5 rounded-xl border" style="background:rgba(249,115,22,0.05);border-color:rgba(249,115,22,0.15);">
                        <h4 class="font-bold mb-2 flex items-center gap-2" style="color:#ea6a0a;"><i class="fa-solid fa-bullseye"></i> Our Mission</h4>
                        <p class="text-sm text-gray-600 leading-relaxed">To completely eliminate administrative friction so educators can focus 100% of their energy on teaching and student success.</p>
                    </div>
                    <p class="text-gray-600 leading-relaxed text-sm">Founded on the principles of speed, security, and simplicity, EdFlow replaces dozens of outdated systems with one beautiful, unified dashboard.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Careers Modal -->
<div id="careersModal" class="fixed inset-0 z-[100] hidden custom-modal">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('careersModal')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white/95 backdrop-blur-3xl w-full max-w-lg rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden border border-white/80 pointer-events-auto flex flex-col">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50/80 border-b border-gray-100">
                <div class="flex items-center gap-2 w-16">
                    <button onclick="toggleCustomModal('careersModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10"><i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i></button>
                    <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                    <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                </div>
                <h2 class="text-xs font-bold text-gray-700 tracking-wide flex items-center gap-2"><i class="fa-solid fa-briefcase" style="color:#a855f7;"></i> Join Our Team</h2>
                <div class="w-16"></div>
            </div>
            <div class="p-8">
                <p class="text-gray-500 mb-6 text-center text-sm font-medium">We are always looking for passionate individuals to build the future of education technology.</p>
                <div class="space-y-3">
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 opacity-75 cursor-not-allowed">
                        <div class="flex justify-between items-center">
                            <div><h4 class="font-bold text-gray-900">Laravel Backend Engineer</h4><p class="text-xs text-gray-500 mt-1">Remote • Full Time</p></div>
                            <span class="text-xs font-bold px-2 py-1 bg-gray-200 text-gray-500 rounded">Filled</span>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 opacity-75 cursor-not-allowed">
                        <div class="flex justify-between items-center">
                            <div><h4 class="font-bold text-gray-900">UI/UX Product Designer</h4><p class="text-xs text-gray-500 mt-1">Hybrid • Full Time</p></div>
                            <span class="text-xs font-bold px-2 py-1 bg-gray-200 text-gray-500 rounded">Filled</span>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center p-4 rounded-xl border" style="background:rgba(249,115,22,0.05);border-color:rgba(249,115,22,0.15);">
                    <p class="text-sm font-medium" style="color:#ea6a0a;">Don't see a perfect fit right now?</p>
                    <p class="text-xs mt-1 text-gray-500">Send your resume to <a href="mailto:careers@edflow.com" class="font-bold hover:underline" style="color:#f97316;">careers@edflow.com</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Modal -->
<div id="contactDetailsModal" class="fixed inset-0 z-[100] hidden custom-modal">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('contactDetailsModal')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white/95 backdrop-blur-3xl w-full max-w-md rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden border border-white/80 pointer-events-auto flex flex-col">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50/80 border-b border-gray-100">
                <div class="flex items-center gap-2 w-16">
                    <button onclick="toggleCustomModal('contactDetailsModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10"><i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i></button>
                    <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                    <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                </div>
                <h2 class="text-xs font-bold text-gray-700 tracking-wide">Get in Touch</h2>
                <div class="w-16"></div>
            </div>
            <div class="p-8">
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 mb-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 text-white rounded-full flex items-center justify-center text-2xl font-bold shadow-md" style="background:linear-gradient(135deg,#f97316,#1d3fb5);">SS</div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Somnath Sen</h3>
                            <p class="text-sm font-medium" style="color:#f97316;">Founder & Lead Developer</p>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <div class="flex items-center gap-4 text-gray-600">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm border border-gray-100" style="color:#f97316;"><i class="fa-solid fa-envelope"></i></div>
                            <div><p class="text-[11px] uppercase tracking-wider font-bold text-gray-400">Email</p><a href="mailto:somnath@edflow.com" class="font-medium text-sm hover:text-orange-500 transition-colors">somnath@edflow.com</a></div>
                        </div>
                        <div class="flex items-center gap-4 text-gray-600">
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm border border-gray-100" style="color:#10b981;"><i class="fa-solid fa-location-dot"></i></div>
                            <div><p class="text-[11px] uppercase tracking-wider font-bold text-gray-400">Location</p><p class="font-medium text-sm">Academy of Technology Campus, WB</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Privacy Modal -->
<div id="privacyModal" class="fixed inset-0 z-[100] hidden custom-modal">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('privacyModal')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white/95 backdrop-blur-3xl w-full max-w-2xl rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden border border-white/80 pointer-events-auto flex flex-col max-h-[85vh]">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50/80 border-b border-gray-100">
                <div class="flex items-center gap-2 w-16">
                    <button onclick="toggleCustomModal('privacyModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10"><i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i></button>
                    <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                    <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                </div>
                <h2 class="text-xs font-bold text-gray-700 tracking-wide flex items-center gap-2"><i class="fa-solid fa-shield-halved" style="color:#f97316;"></i> Privacy Policy</h2>
                <div class="w-16"></div>
            </div>
            <div class="p-8 overflow-y-auto custom-scroll flex-1">
                <div class="prose prose-sm max-w-none text-gray-600 space-y-5">
                    <p><strong>Last Updated: {{ date('F Y') }}</strong></p>
                    <p>At EdFlow, we take your privacy seriously. This policy explains how we collect, use, and protect your personal information.</p>
                    <h4 class="text-gray-900 font-bold">1. Information We Collect</h4>
                    <p>We collect information necessary to provide our educational management services. This includes names, email addresses, academic records, and role assignments (Student, Teacher, Admin).</p>
                    <h4 class="text-gray-900 font-bold">2. How We Use Information</h4>
                    <p>Your data is exclusively used to operate the EdFlow platform. We do not sell your personal data to third parties. We use your email to send auto-generated credentials and system notifications.</p>
                    <h4 class="text-gray-900 font-bold">3. Data Security</h4>
                    <p>We implement strict security measures including database encryption, secure password hashing, and role-based access control (RBAC) to ensure your institutional data remains private.</p>
                    <h4 class="text-gray-900 font-bold">4. Third-Party Integrations</h4>
                    <p>Certain features utilize third-party APIs (such as Google Gemini for StudyAI and Razorpay for fees). Data shared with these services is strictly limited to the function requested.</p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/80 flex justify-end">
                <button onclick="toggleCustomModal('privacyModal')" class="px-6 py-2 text-white rounded-xl text-sm font-semibold transition-colors focus:outline-none" style="background:#f97316;" onmouseover="this.style.background='#ea6a0a'" onmouseout="this.style.background='#f97316'">I Understand</button>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div id="termsModal" class="fixed inset-0 z-[100] hidden custom-modal">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('termsModal')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white/95 backdrop-blur-3xl w-full max-w-2xl rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] overflow-hidden border border-white/80 pointer-events-auto flex flex-col max-h-[85vh]">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50/80 border-b border-gray-100">
                <div class="flex items-center gap-2 w-16">
                    <button onclick="toggleCustomModal('termsModal')" class="w-3 h-3 rounded-full bg-[#ff5f56] hover:bg-[#ff5f56]/80 flex items-center justify-center group focus:outline-none transition-colors border border-black/10"><i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i></button>
                    <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                    <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                </div>
                <h2 class="text-xs font-bold text-gray-700 tracking-wide flex items-center gap-2"><i class="fa-solid fa-file-contract" style="color:#a855f7;"></i> Terms of Service</h2>
                <div class="w-16"></div>
            </div>
            <div class="p-8 overflow-y-auto custom-scroll flex-1">
                <div class="prose prose-sm max-w-none text-gray-600 space-y-5">
                    <p><strong>Last Updated: {{ date('F Y') }}</strong></p>
                    <p>By accessing and using EdFlow, you accept and agree to be bound by the terms and provisions of this agreement.</p>
                    <h4 class="text-gray-900 font-bold">1. Account Responsibilities</h4>
                    <p>Users are responsible for maintaining the confidentiality of their login credentials. Any activities that occur under your account are your sole responsibility. Automated creation of accounts is strictly prohibited.</p>
                    <h4 class="text-gray-900 font-bold">2. Acceptable Use</h4>
                    <p>EdFlow must only be used for legitimate academic and administrative purposes. You may not use the service to distribute malware, harass others, or attempt to bypass security protocols (RBAC).</p>
                    <h4 class="text-gray-900 font-bold">3. AI Assistant Usage</h4>
                    <p>The StudyAI feature is designed as an educational aid. Responses generated by AI should be verified by human educators. EdFlow is not responsible for inaccuracies in AI-generated content.</p>
                    <h4 class="text-gray-900 font-bold">4. Termination</h4>
                    <p>Administrators reserve the right to suspend or terminate access to any user account that violates these terms or poses a security risk to the institution.</p>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/80 flex justify-end">
                <button onclick="toggleCustomModal('termsModal')" class="px-6 py-2 text-white rounded-xl text-sm font-semibold transition-colors focus:outline-none" style="background:#a855f7;" onmouseover="this.style.background='#7c3aed'" onmouseout="this.style.background='#a855f7'">Accept Terms</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal (Newsletter) -->
<div id="successModal" class="fixed inset-0 z-[110] hidden custom-modal">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white/95 backdrop-blur-3xl rounded-[20px] shadow-[0_30px_60px_-12px_rgba(0,0,0,0.5)] max-w-sm w-full border border-white/80 pointer-events-auto flex flex-col overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50/80 border-b border-gray-100">
                <div class="flex items-center gap-2 w-16">
                    <button onclick="closeSuccessModal()" class="w-3 h-3 rounded-full bg-[#ff5f56] flex items-center justify-center group focus:outline-none border border-black/10"><i class="fa-solid fa-xmark text-[6px] text-[#4d0000] opacity-0 group-hover:opacity-100"></i></button>
                    <div class="w-3 h-3 rounded-full bg-[#ffbd2e] border border-black/10"></div>
                    <div class="w-3 h-3 rounded-full bg-[#27c93f] border border-black/10"></div>
                </div>
                <h2 class="text-xs font-bold text-gray-700 tracking-wide">Subscribed!</h2>
                <div class="w-16"></div>
            </div>
            <div class="p-8 text-center">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5" style="background:rgba(249,115,22,0.10);">
                    <i class="fa-solid fa-circle-check text-3xl" style="color:#f97316;"></i>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-3">You're in!</h3>
                <p class="text-sm text-gray-500 font-medium leading-relaxed mb-6">Thanks for subscribing. You'll receive the latest EdFlow updates and announcements in your inbox.</p>
                <button onclick="closeSuccessModal()" class="w-full py-3 rounded-xl text-white text-sm font-bold transition-colors" style="background:#f97316;" onmouseover="this.style.background='#ea6a0a'" onmouseout="this.style.background='#f97316'">Done</button>
            </div>
        </div>
    </div>
</div>

<!-- Role Auth Loader Overlay -->
<div id="role-auth-loader" class="fixed inset-0 z-[200] flex flex-col items-center justify-center bg-white/95 backdrop-blur-2xl transition-all duration-500 ease-in-out opacity-0 pointer-events-none hidden">
    <div class="relative flex items-center justify-center w-28 h-28 mb-8">
        <div class="absolute inset-0 rounded-full border-4 bg-gray-50" style="border-color:rgba(249,115,22,0.10);"></div>
        <div id="role-ring-inner" class="absolute inset-0 rounded-full border-t-4 border-orange-500 animate-[spin_1s_cubic-bezier(0.8,_0,_0.2,_1)_infinite]"></div>
        <div id="role-icon-container" class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-xl transition-colors duration-300 relative z-10" style="background:#f97316;">
            <i id="role-icon" class="fa-solid fa-user text-3xl text-white"></i>
        </div>
    </div>
    <h3 id="role-auth-title" class="text-2xl font-bold text-gray-900 mb-3 tracking-tight">Authenticating</h3>
    <p class="text-sm text-gray-500 font-medium animate-pulse">Establishing secure connection...</p>
    <div class="mt-10 w-64 h-1.5 bg-gray-100 rounded-full overflow-hidden">
        <div id="role-progress" class="h-full w-0 transition-all duration-[1500ms] ease-out rounded-full" style="background:#f97316;"></div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════════
     MAIN JAVASCRIPT
═══════════════════════════════════════════════════════════════ -->
<script>
    // Lock to light mode
    document.documentElement.classList.remove('dark');
    localStorage.theme = 'light';

    // ── FAQ Accordion ────────────────────────────────────────────
    const faqBtns = document.querySelectorAll('.faq-btn');
    faqBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const content = btn.nextElementSibling;
            const icon = btn.querySelector('i');
            faqBtns.forEach(otherBtn => {
                if (otherBtn !== btn) {
                    otherBtn.nextElementSibling.classList.remove('open');
                    const oi = otherBtn.querySelector('i');
                    if (oi) oi.classList.remove('rotate-180');
                }
            });
            content.classList.toggle('open');
            if (icon) icon.classList.toggle('rotate-180');
        });
    });

    // ── Unified Modal Toggle ─────────────────────────────────────
    function toggleCustomModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        modal.classList.contains('hidden') ? modal.classList.remove('hidden') : modal.classList.add('hidden');
        checkBodyOverflow();
    }
    function toggleModal() { toggleCustomModal('loginModal'); }
    function toggleRegisterModal() { toggleCustomModal('registerModal'); }
    function checkBodyOverflow() {
        const anyOpen = document.querySelectorAll('.custom-modal:not(.hidden)').length > 0;
        document.body.style.overflow = anyOpen ? 'hidden' : '';
    }

    // ── Navbar Scroll Effect ─────────────────────────────────────
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 20) {
            navbar.classList.add('glass-nav', 'shadow-sm');
        } else {
            navbar.classList.remove('shadow-sm');
        }
    });

    // ── Mobile Bottom Bar — smooth scroll + ripple ───────────────
    (function initMobBottomBar() {
        const cards = document.querySelectorAll('.mbb-card');
        if (!cards.length) return;
        cards.forEach(card => {
            const href = card.getAttribute('href');
            if (href && href.startsWith('#')) {
                card.addEventListener('click', e => {
                    e.preventDefault();
                    const t = document.querySelector(href);
                    if (t) t.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            }
            card.addEventListener('pointerdown', e => {
                const r = document.createElement('span');
                const rect = card.getBoundingClientRect();
                const sz = Math.max(rect.width, rect.height);
                r.style.cssText = `position:absolute;border-radius:50%;pointer-events:none;width:${sz}px;height:${sz}px;left:${e.clientX-rect.left-sz/2}px;top:${e.clientY-rect.top-sz/2}px;background:rgba(249,115,22,0.12);transform:scale(0);transition:transform .5s ease,opacity .5s ease;opacity:1`;
                card.appendChild(r);
                requestAnimationFrame(() => { r.style.transform = 'scale(2.5)'; r.style.opacity = '0'; });
                setTimeout(() => r.remove(), 600);
            });
        });
    })();

    // ── Mobile hamburger ─────────────────────────────────────────
    const mobileMenuBtn  = document.getElementById('mobile-menu-btn');
    const mobileMenuIcon = document.getElementById('mobile-menu-icon');
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenuIcon.classList.toggle('fa-bars');
            mobileMenuIcon.classList.toggle('fa-xmark');
        });
    }

    // ── Newsletter Form ──────────────────────────────────────────
    const form = document.getElementById('newsletterForm');
    const scriptURL = 'https://script.google.com/macros/s/AKfycbyzMyhmjvyiDU1n8oZGtKIlzbEFeXNgXfJDemrfxcyUW3NF-Q0qcJ9qWWIXhmiV2ZAV1w/exec';
    const btnLoader = document.getElementById('btnLoader');
    const subscribeBtn = document.getElementById('subscribeBtn');
    if (form) {
        form.addEventListener('submit', e => {
            e.preventDefault();
            subscribeBtn.disabled = true;
            subscribeBtn.classList.add('opacity-75');
            btnLoader.classList.remove('hidden');
            fetch(scriptURL, { method: 'POST', body: new FormData(form) })
                .then(() => {
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
    function closeSuccessModal() { toggleCustomModal('successModal'); }

    // ── Role Auth Loader ─────────────────────────────────────────
    function handleRoleLogin(e, roleName, url, themeContext) {
        e.preventDefault();
        const loginModal = document.getElementById('loginModal');
        if (loginModal && !loginModal.classList.contains('hidden')) toggleCustomModal('loginModal');
        const loader = document.getElementById('role-auth-loader');
        const ringInner = document.getElementById('role-ring-inner');
        const iconContainer = document.getElementById('role-icon-container');
        const icon = document.getElementById('role-icon');
        const title = document.getElementById('role-auth-title');
        const progress = document.getElementById('role-progress');
        title.innerText = `Authenticating ${roleName}`;
        if (themeContext === 'student') {
            ringInner.className = 'absolute inset-0 rounded-full border-t-4 border-orange-500 animate-[spin_1s_cubic-bezier(0.8,_0,_0.2,_1)_infinite]';
            iconContainer.style.background = '#f97316';
            icon.className = 'fa-solid fa-graduation-cap text-2xl text-white animate-pulse';
            progress.style.background = '#f97316';
        } else if (themeContext === 'teacher') {
            ringInner.className = 'absolute inset-0 rounded-full border-t-4 border-blue-600 animate-[spin_1s_cubic-bezier(0.8,_0,_0.2,_1)_infinite]';
            iconContainer.style.background = '#1d3fb5';
            icon.className = 'fa-solid fa-chalkboard-user text-2xl text-white animate-pulse';
            progress.style.background = '#1d3fb5';
        } else if (themeContext === 'admin') {
            ringInner.className = 'absolute inset-0 rounded-full border-t-4 border-gray-900 animate-[spin_1s_cubic-bezier(0.8,_0,_0.2,_1)_infinite]';
            iconContainer.style.background = '#0d1b4b';
            icon.className = 'fa-solid fa-shield-halved text-2xl text-white animate-pulse';
            progress.style.background = '#0d1b4b';
        }
        progress.style.width = '0%';
        loader.classList.remove('hidden');
        requestAnimationFrame(() => {
            loader.classList.remove('opacity-0', 'pointer-events-none');
            loader.classList.add('opacity-100');
            setTimeout(() => { progress.style.width = '100%'; }, 100);
        });
        setTimeout(() => { window.location.href = url; }, 1500);
    }
</script>


<!-- ═══════════════════════════════════════════════════════════════
     GSAP SCROLL ANIMATIONS
═══════════════════════════════════════════════════════════════ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

<div id="cursor-glow"></div>

<script>
(function() {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
    gsap.registerPlugin(ScrollTrigger);

    // ── Cursor glow ──────────────────────────────────────────────
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

    // ── Scroll progress bar ──────────────────────────────────────
    const progressBar = document.getElementById('scroll-progress');
    if (progressBar) {
        ScrollTrigger.create({
            trigger: document.body,
            start: 'top top',
            end: 'bottom bottom',
            scrub: 0.3,
            onUpdate: self => { progressBar.style.width = (self.progress * 100) + '%'; }
        });
    }

    // ── Navbar animation ─────────────────────────────────────────
    const nav = document.getElementById('navbar');
    if (nav) {
        gsap.fromTo(nav, { y: -80, opacity: 0 }, { y: 0, opacity: 1, duration: 0.7, ease: 'power3.out', delay: 0.2 });
    }

    // ── Hero animations ──────────────────────────────────────────
    const heroSection = document.getElementById('hero');
    if (heroSection) {
        const loaderEl = document.getElementById('edflow-loader');
        const startDelay = loaderEl ? 1.2 : 0.1;
        const heroTl = gsap.timeline({ delay: startDelay });
        const badge  = heroSection.querySelector('.gsap-hero-badge');
        const h1     = heroSection.querySelector('.gsap-hero-h1');
        const heroP  = heroSection.querySelector('.gsap-hero-p');
        const btns   = heroSection.querySelector('.gsap-hero-btns');
        const visual = heroSection.querySelector('.gsap-hero-visual');
        if (badge)  heroTl.fromTo(badge,  { opacity:0, y:-20, scale:0.9 }, { opacity:1, y:0, scale:1, duration:0.5, ease:'back.out(1.7)' });
        if (h1)     heroTl.fromTo(h1,     { opacity:0, y:40  }, { opacity:1, y:0, duration:0.7, ease:'power3.out' }, '-=0.2');
        if (heroP)  heroTl.fromTo(heroP,  { opacity:0, y:20  }, { opacity:1, y:0, duration:0.5, ease:'power2.out' }, '-=0.3');
        if (btns)   heroTl.fromTo(btns,   { opacity:0, y:20, scale:0.97 }, { opacity:1, y:0, scale:1, duration:0.5, ease:'power2.out' }, '-=0.2');
        if (visual) heroTl.fromTo(visual, { opacity:0, x:40  }, { opacity:1, x:0, duration:0.8, ease:'power3.out' }, '-=0.3');
    }

    // ── Features bento stagger ───────────────────────────────────
    const featureCards = document.querySelectorAll('#features .grid > div');
    if (featureCards.length) {
        gsap.fromTo(featureCards,
            { opacity:0, y:50, scale:0.96 },
            { opacity:1, y:0, scale:1, duration:0.7, ease:'power3.out', stagger:0.10,
              scrollTrigger: { trigger: '#features', start: 'top 80%', toggleActions: 'play none none none' }
            }
        );
    }

    // ── Generic section reveal ───────────────────────────────────
    const revealSections = document.querySelectorAll('#solutions .grid > div, #how-it-works .grid > div, #faq .space-y-5 > div');
    if (revealSections.length) {
        revealSections.forEach((el, i) => {
            gsap.fromTo(el,
                { opacity:0, y:30 },
                { opacity:1, y:0, duration:0.6, ease:'power2.out',
                  scrollTrigger: { trigger: el, start: 'top 88%', toggleActions: 'play none none none' }
                }
            );
        });
    }

    // ── About section ────────────────────────────────────────────
    const aboutSection = document.getElementById('about');
    if (aboutSection) {
        const children = aboutSection.querySelectorAll('.grid > div');
        gsap.fromTo(children,
            { opacity:0, y:40 },
            { opacity:1, y:0, duration:0.7, stagger:0.15, ease:'power3.out',
              scrollTrigger: { trigger: aboutSection, start: 'top 75%', toggleActions: 'play none none none' }
            }
        );
    }

})();
</script>

</body>
</html>
