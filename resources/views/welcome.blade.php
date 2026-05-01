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
        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .dark .glass {
            background: rgba(17, 24, 39, 0.7);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        /* Grid Pattern */
        .bg-grid {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(0,0,0,0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(0,0,0,0.05) 1px, transparent 1px);
        }
        .dark .bg-grid {
            background-image: linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
        }

        /* Smooth Theme Transition */
        body, nav, div, section, footer, input, button, p, h1, h2, h3, h4 {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Hide scrollbar for marquee */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Custom Scrollbar for inner modals */
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background-color: rgba(156, 163, 175, 0.5); border-radius: 10px; }
        .dark .custom-scroll::-webkit-scrollbar-thumb { background-color: rgba(75, 85, 99, 0.5); }

        /* Smooth Accordion transition */
        .faq-content {
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        .faq-content.open { max-height: 500px; opacity: 1; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 bg-grid dark:bg-black dark:text-gray-100 selection:bg-gray-900 selection:text-white dark:selection:bg-white dark:selection:text-gray-900">

    <!-- ═══════════════════════════════════════════════════════════════════
         CINEMATIC 3D PRELOADER  |  Three.js + GSAP  |  Cyberpunk Theme
    ═══════════════════════════════════════════════════════════════════ -->
    <div id="edflow-loader" style="
        position:fixed;inset:0;z-index:99999;
        background:#000000;
        display:flex;flex-direction:column;align-items:center;justify-content:center;
        overflow:hidden;
    ">

        <!-- Three.js canvas will be injected here -->
        <canvas id="preloader-canvas" style="
            position:absolute;inset:0;width:100%;height:100%;
            display:block;
        "></canvas>

        <!-- UI Overlay -->
        <div id="preloader-ui" style="
            position:relative;z-index:10;
            display:flex;flex-direction:column;align-items:center;gap:28px;
            pointer-events:none;
        ">
            <!-- Brand -->
            <div id="preloader-brand" style="opacity:0;transform:translateY(-20px);transition:all 0.8s cubic-bezier(0.16,1,0.3,1);">
                <span style="
                    font-family:'Plus Jakarta Sans',sans-serif;
                    font-size:13px;font-weight:800;
                    letter-spacing:0.35em;text-transform:uppercase;
                    color:rgba(255,255,255,0.3);
                ">EdFlow</span>
            </div>

            <!-- Percentage -->
            <div style="text-align:center;">
                <div id="preloader-pct" style="
                    font-family:'Plus Jakarta Sans',sans-serif;
                    font-size:clamp(52px,8vw,88px);
                    font-weight:900;
                    letter-spacing:-0.03em;
                    color:#ffffff;
                    line-height:1;
                    opacity:0;
                    text-shadow:0 0 40px rgba(220,38,38,0.6),0 0 80px rgba(147,51,234,0.3);
                    transition:opacity 0.6s ease;
                ">0</div>
                <div style="
                    font-family:'Plus Jakarta Sans',sans-serif;
                    font-size:13px;font-weight:600;
                    letter-spacing:0.2em;text-transform:uppercase;
                    color:rgba(255,255,255,0.25);
                    margin-top:6px;
                ">%</div>
            </div>

            <!-- Subtitle -->
            <div id="preloader-sub" style="
                font-family:'Plus Jakarta Sans',sans-serif;
                font-size:11px;font-weight:600;
                letter-spacing:0.3em;text-transform:uppercase;
                color:rgba(255,255,255,0.2);
                opacity:0;transition:opacity 0.8s ease 0.4s;
            ">Loading Experience&thinsp;&hellip;</div>

            <!-- Progress bar -->
            <div style="width:clamp(160px,25vw,280px);">
                <div style="
                    width:100%;height:1px;
                    background:rgba(255,255,255,0.06);
                    border-radius:999px;overflow:hidden;
                ">
                    <div id="preloader-bar" style="
                        height:100%;width:0%;
                        background:linear-gradient(90deg,#dc2626,#9333ea);
                        border-radius:999px;
                        box-shadow:0 0 8px rgba(220,38,38,0.8),0 0 20px rgba(147,51,234,0.4);
                        transition:width 0.4s cubic-bezier(0.4,0,0.2,1);
                    "></div>
                </div>
            </div>
        </div>

        <!-- Skip button (fallback for slow devices) -->
        <button id="preloader-skip" onclick="window.__skipPreloader&&window.__skipPreloader()" style="
            position:absolute;bottom:32px;right:32px;
            font-family:'Plus Jakarta Sans',sans-serif;
            font-size:10px;font-weight:700;
            letter-spacing:0.25em;text-transform:uppercase;
            color:rgba(255,255,255,0.15);
            background:none;border:none;cursor:pointer;
            padding:8px 12px;
            transition:color 0.3s ease;
            opacity:0;
        " onmouseover="this.style.color='rgba(255,255,255,0.5)'" onmouseout="this.style.color='rgba(255,255,255,0.15)'">
            Skip &rsaquo;
        </button>
    </div>

    <!-- ─── Preloader Script ───────────────────────────────────────────── -->
    <script>
    (function() {
        'use strict';

        // ── Bail if Three.js failed to load ──────────────────────────────
        if (typeof THREE === 'undefined') {
            document.getElementById('edflow-loader').style.display = 'none';
            return;
        }

        // ── DOM refs ─────────────────────────────────────────────────────
        const loader    = document.getElementById('edflow-loader');
        const canvas    = document.getElementById('preloader-canvas');
        const pctEl     = document.getElementById('preloader-pct');
        const barEl     = document.getElementById('preloader-bar');
        const brandEl   = document.getElementById('preloader-brand');
        const subEl     = document.getElementById('preloader-sub');
        const skipBtn   = document.getElementById('preloader-skip');

        // ── State ────────────────────────────────────────────────────────
        let currentPct  = 0;
        let targetPct   = 0;
        let rafId       = null;
        let dismissed   = false;
        let orbReady    = false;

        // ── Three.js Setup ───────────────────────────────────────────────
        const W = window.innerWidth, H = window.innerHeight;
        const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        renderer.setSize(W, H);
        renderer.setClearColor(0x000000, 1);

        const scene  = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(60, W / H, 0.1, 100);
        camera.position.set(0, 0, 5);

        // ── Mouse parallax ───────────────────────────────────────────────
        let mouseX = 0, mouseY = 0;
        window.addEventListener('mousemove', e => {
            mouseX = (e.clientX / window.innerWidth  - 0.5) * 2;
            mouseY = (e.clientY / window.innerHeight - 0.5) * 2;
        });

        // ── Orb (energy sphere) ──────────────────────────────────────────
        const orbGeo  = new THREE.SphereGeometry(1, 64, 64);
        const orbMat  = new THREE.MeshStandardMaterial({
            color: 0x1a0000,
            emissive: new THREE.Color(0xdc2626),
            emissiveIntensity: 0.0,
            roughness: 0.1,
            metalness: 0.9,
            transparent: true,
            opacity: 0,
        });
        const orb = new THREE.Mesh(orbGeo, orbMat);
        scene.add(orb);

        // ── Wireframe shell ──────────────────────────────────────────────
        const shellGeo  = new THREE.SphereGeometry(1.02, 24, 24);
        const shellMat  = new THREE.MeshBasicMaterial({
            color: 0xdc2626, wireframe: true,
            transparent: true, opacity: 0,
        });
        const shell = new THREE.Mesh(shellGeo, shellMat);
        scene.add(shell);

        // ── Inner glow (additive sphere) ─────────────────────────────────
        const glowGeo = new THREE.SphereGeometry(1.3, 32, 32);
        const glowMat = new THREE.MeshBasicMaterial({
            color: 0x9333ea,
            transparent: true, opacity: 0,
            side: THREE.BackSide,
        });
        const glowMesh = new THREE.Mesh(glowGeo, glowMat);
        scene.add(glowMesh);

        // ── Particles ────────────────────────────────────────────────────
        const PARTICLE_COUNT = 280;
        const pPositions = new Float32Array(PARTICLE_COUNT * 3);
        const pSpeeds    = [];
        const pRadii     = [];
        const pAngles    = [];
        const pTilts     = [];

        for (let i = 0; i < PARTICLE_COUNT; i++) {
            const ring   = Math.floor(i / (PARTICLE_COUNT / 4));
            const radius = 1.6 + ring * 0.35 + Math.random() * 0.3;
            const angle  = Math.random() * Math.PI * 2;
            const tilt   = (Math.random() - 0.5) * 0.6;
            pRadii.push(radius);
            pAngles.push(angle);
            pTilts.push(tilt);
            pSpeeds.push((0.003 + Math.random() * 0.004) * (Math.random() < 0.5 ? 1 : -1));
            pPositions[i * 3]     = Math.cos(angle) * radius;
            pPositions[i * 3 + 1] = Math.sin(tilt) * radius;
            pPositions[i * 3 + 2] = Math.sin(angle) * radius;
        }

        const pGeo = new THREE.BufferGeometry();
        pGeo.setAttribute('position', new THREE.BufferAttribute(pPositions, 3));
        const pMat = new THREE.PointsMaterial({
            color: 0xdc2626,
            size: 0.025,
            transparent: true,
            opacity: 0,
            sizeAttenuation: true,
        });
        const particles = new THREE.Points(pGeo, pMat);
        scene.add(particles);

        // ── Lights ───────────────────────────────────────────────────────
        scene.add(new THREE.AmbientLight(0xffffff, 0.2));
        const redLight    = new THREE.PointLight(0xdc2626, 4, 8);
        redLight.position.set(0, 0, 2);
        scene.add(redLight);
        const purpleLight = new THREE.PointLight(0x9333ea, 2, 8);
        purpleLight.position.set(2, 1, -1);
        scene.add(purpleLight);

        // ── Resize ───────────────────────────────────────────────────────
        window.addEventListener('resize', () => {
            const w = window.innerWidth, h = window.innerHeight;
            renderer.setSize(w, h);
            camera.aspect = w / h;
            camera.updateProjectionMatrix();
        });

        // ── Three.js LoadingManager (real progress) ───────────────────────
        const manager = new THREE.LoadingManager();
        window.__THREE_LOADING_MANAGER__ = manager;

        // Simulate page asset progress: combine DOMContentLoaded + images + fonts
        let domLoaded    = false;
        let imagesLoaded = 0;
        let totalImages  = 0;
        let fontsLoaded  = false;

        function calcProgress() {
            // DOM:40%, Images:40%, Fonts:20%
            let p = 0;
            if (domLoaded)   p += 40;
            if (totalImages) p += Math.round((imagesLoaded / totalImages) * 40);
            else             p += 40; // no images → full credit
            if (fontsLoaded) p += 20;
            setTarget(Math.min(p, 99)); // hold at 99 until forceDone
        }

        function setTarget(v) {
            if (v > targetPct) targetPct = v;
        }

        // DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => { domLoaded = true; calcProgress(); });
        } else {
            domLoaded = true;
        }

        // Images
        function trackImages() {
            const imgs = Array.from(document.images);
            totalImages = imgs.length;
            if (!totalImages) { calcProgress(); return; }
            imgs.forEach(img => {
                if (img.complete) { imagesLoaded++; calcProgress(); }
                else {
                    img.addEventListener('load',  () => { imagesLoaded++; calcProgress(); });
                    img.addEventListener('error', () => { imagesLoaded++; calcProgress(); });
                }
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', trackImages);
        } else {
            trackImages();
        }

        // Fonts
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(() => { fontsLoaded = true; calcProgress(); });
        } else {
            fontsLoaded = true;
        }

        // Full-page load → push to 100
        window.addEventListener('load', () => {
            domLoaded = true; fontsLoaded = true;
            imagesLoaded = totalImages || 0;
            calcProgress();
            setTimeout(() => forceDone(), 300);
        });

        // Safety timeout (slow devices) – max 8s
        setTimeout(() => forceDone(), 8000);

        function forceDone() {
            setTarget(100);
        }

        // ── Skip handler ─────────────────────────────────────────────────
        window.__skipPreloader = function() { forceDone(); };

        // ── Dismiss preloader (called when progress hits 100) ─────────────
        function dismiss() {
            if (dismissed) return;
            dismissed = true;

            // 1. Flash surge
            const surgeTl = window.gsap
                ? gsap.timeline()
                : null;

            if (surgeTl) {
                surgeTl
                  .to(orbMat,   { emissiveIntensity: 3.5, duration: 0.4, ease: 'power2.in' })
                  .to(glowMat,  { opacity: 0.5,           duration: 0.3, ease: 'power2.in' }, '<')
                  .to(pMat,     { opacity: 1.0,           duration: 0.2             }, '<')
                  // 2. Explode / dissolve
                  .to(orbMat,   { emissiveIntensity: 0, opacity: 0, duration: 0.5, ease: 'power3.out' })
                  .to(shellMat, { opacity: 0,             duration: 0.4             }, '<')
                  .to(glowMat,  { opacity: 0,             duration: 0.4             }, '<')
                  .to(pMat,     { opacity: 0,             duration: 0.6, ease: 'power3.out' }, '<0.1')
                  .to([pctEl, barEl.parentElement.parentElement, brandEl, subEl, skipBtn], {
                        opacity: 0, y: -15, duration: 0.5, stagger: 0.05, ease: 'power2.in'
                  }, '<')
                  // 3. Fade out loader
                  .to(loader, {
                        opacity: 0, duration: 0.7, ease: 'power2.inOut',
                        onComplete: () => {
                            loader.style.display = 'none';
                            cancelAnimationFrame(rafId);
                            renderer.dispose();
                        }
                  });
            } else {
                // Fallback without GSAP
                loader.style.transition = 'opacity 0.7s ease';
                loader.style.opacity    = '0';
                setTimeout(() => { loader.style.display = 'none'; cancelAnimationFrame(rafId); }, 800);
            }
        }

        // ── Intro animation (runs once orb is visible) ────────────────────
        function introAnimate() {
            if (window.gsap) {
                const tl = gsap.timeline({
                    onComplete: () => { orbReady = true; }
                });
                tl
                  .to(orbMat,  { opacity: 0.95, duration: 1.2, ease: 'power2.out' })
                  .to(orbMat,  { emissiveIntensity: 0.8, duration: 1.0, ease: 'power2.out' }, '<0.3')
                  .to(shellMat,{ opacity: 0.08, duration: 0.8, ease: 'power2.out' }, '<0.2')
                  .to(glowMat, { opacity: 0.12, duration: 0.8, ease: 'power2.out' }, '<')
                  .to(pMat,    { opacity: 0.7,  duration: 1.0, ease: 'power2.out' }, '<0.2')
                  .call(() => {
                        // Reveal UI text
                        if (pctEl)   { pctEl.style.opacity = '1'; }
                        if (brandEl) { brandEl.style.opacity = '1'; brandEl.style.transform = 'translateY(0)'; }
                        if (subEl)   { subEl.style.opacity  = '1'; }
                        if (skipBtn) { setTimeout(() => { skipBtn.style.opacity = '1'; }, 1500); }
                  });
            } else {
                // Fallback: instant show
                orbMat.opacity  = 0.95;
                orbMat.emissiveIntensity = 0.8;
                pMat.opacity    = 0.7;
                orbReady = true;
            }
        }

        // ── Render loop ───────────────────────────────────────────────────
        const clock = new THREE.Clock();
        let introStarted = false;

        function animate() {
            rafId = requestAnimationFrame(animate);
            const t = clock.getElapsedTime();

            // Start intro after 1 frame
            if (!introStarted) { introStarted = true; introAnimate(); }

            // ── Smooth progress interpolation ─────────────────────────
            if (currentPct < targetPct) {
                currentPct += (targetPct - currentPct) * 0.04;
                if (targetPct - currentPct < 0.15) currentPct = targetPct;
                const d = Math.round(currentPct);
                if (pctEl)  pctEl.textContent = d;
                if (barEl)  barEl.style.width  = currentPct + '%';

                // Trigger dismiss when we hit 100
                if (d >= 100 && !dismissed) dismiss();
            }

            // ── Orb rotation + pulsing ────────────────────────────────
            if (orbReady) {
                orb.rotation.y   = t * 0.18;
                orb.rotation.x   = Math.sin(t * 0.3) * 0.15;
                shell.rotation.y = -t * 0.12;
                shell.rotation.z =  t * 0.06;

                // Pulsing glow
                const pulse = 0.7 + Math.sin(t * 1.8) * 0.3;
                orbMat.emissiveIntensity = 0.8 * pulse;
                glowMat.opacity          = 0.12 * pulse;
                redLight.intensity       = 4  * pulse;

                // Camera parallax (subtle)
                camera.position.x += (mouseX * 0.4 - camera.position.x) * 0.03;
                camera.position.y += (-mouseY * 0.3 - camera.position.y) * 0.03;
                camera.lookAt(0, 0, 0);
            }

            // ── Particle orbit ────────────────────────────────────────
            const pos = particles.geometry.attributes.position;
            for (let i = 0; i < PARTICLE_COUNT; i++) {
                pAngles[i] += pSpeeds[i];
                const a = pAngles[i];
                const r = pRadii[i];
                pos.array[i * 3]     = Math.cos(a) * r;
                pos.array[i * 3 + 1] = Math.sin(pTilts[i] + t * 0.1) * r * 0.3;
                pos.array[i * 3 + 2] = Math.sin(a) * r;
            }
            pos.needsUpdate = true;

            renderer.render(scene, camera);
        }

        animate();
    })();
    </script>

    <!-- Elegant animated background effect -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-gray-100 via-gray-50 to-white dark:from-gray-900 dark:via-black dark:to-black">
        <div class="absolute -top-[20%] -left-[10%] w-[60%] h-[60%] rounded-full bg-brand-500/20 dark:bg-brand-500/20 blur-[120px] animate-[blob_15s_ease-in-out_infinite_alternate]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[50%] h-[50%] rounded-full bg-purple-500/20 dark:bg-purple-900/30 blur-[120px] animate-[blob_20s_ease-in-out_infinite_alternate-reverse]" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-[20%] left-[20%] w-[60%] h-[60%] rounded-full bg-indigo-500/10 dark:bg-indigo-900/20 blur-[120px] animate-[blob_18s_ease-in-out_infinite_alternate]" style="animation-delay: 4s;"></div>
    </div>

    <nav class="fixed w-full z-50 top-0 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-brand-500/30">
                        <i class="fa-solid fa-graduation-cap text-xl"></i>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900 dark:text-white">EdFlow<span class="text-brand-600">.</span></span>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="#features" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Features</a>
                    <a href="#testimonials" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Testimonials</a>
                    <a href="#stats" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Analytics</a>
                    <a href="#faq" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors mr-2">FAQ</a>
                    
                    <button id="theme-toggle" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-all">
                        <i class="fa-solid fa-moon text-lg dark:hidden"></i> 
                        <i class="fa-solid fa-sun text-lg hidden dark:block text-yellow-400"></i> 
                    </button>

                    <button onclick="toggleRegisterModal()" class="px-5 py-2 rounded-full bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700 text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md">
                        Register
                    </button>

                    <a href="/login" class="px-6 py-2 rounded-full bg-gray-900 dark:bg-white dark:text-gray-900 text-white text-sm font-bold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 inline-block">
                        Log In
                    </a>
                </div>

                <div class="md:hidden flex items-center gap-4">
                     <button id="theme-toggle-mobile" class="p-2 rounded-full text-gray-500 dark:text-gray-400 focus:outline-none">
                        <i class="fa-solid fa-moon text-lg dark:hidden"></i>
                        <i class="fa-solid fa-sun text-lg hidden dark:block text-yellow-400"></i>
                    </button>
                    <button id="mobile-menu-btn" class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline-none p-1">
                        <i id="mobile-menu-icon" class="fa-solid fa-bars text-2xl transition-transform duration-300"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div id="mobileMenu" class="fixed inset-0 z-40 bg-white/95 dark:bg-black/95 backdrop-blur-2xl transform translate-x-full transition-transform duration-500 ease-in-out md:hidden flex flex-col overflow-hidden">
        <!-- Ambient Colorful Glowing Orbs inside Mobile Menu -->
        <div class="absolute inset-0 z-0 pointer-events-none opacity-60">
            <div class="absolute top-[10%] -left-[20%] w-[300px] h-[300px] bg-brand-500/30 rounded-full blur-[80px] mix-blend-screen animate-[pulse_6s_infinite]"></div>
            <div class="absolute bottom-[20%] -right-[20%] w-[350px] h-[350px] bg-purple-600/30 rounded-full blur-[80px] mix-blend-screen animate-[pulse_8s_infinite_reverse]"></div>
        </div>

        <div class="relative z-10 flex flex-col h-full pt-32 px-8 pb-10 overflow-y-auto hide-scrollbar">
            <!-- Navigation Links -->
            <div class="flex flex-col space-y-8 flex-1 text-center mt-4">
                <a href="#features" class="mobile-link group relative inline-block text-4xl font-black text-gray-900 dark:text-white tracking-tight hover:scale-105 transition-transform duration-300">
                    <span class="absolute inset-0 bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300">Features</span>
                    <span class="relative group-hover:opacity-0 transition-opacity duration-300">Features</span>
                </a>
                <a href="#testimonials" class="mobile-link group relative inline-block text-4xl font-black text-gray-900 dark:text-white tracking-tight hover:scale-105 transition-transform duration-300">
                    <span class="absolute inset-0 bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-rose-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300">Testimonials</span>
                    <span class="relative group-hover:opacity-0 transition-opacity duration-300">Testimonials</span>
                </a>
                <a href="#stats" class="mobile-link group relative inline-block text-4xl font-black text-gray-900 dark:text-white tracking-tight hover:scale-105 transition-transform duration-300">
                    <span class="absolute inset-0 bg-clip-text text-transparent bg-gradient-to-r from-emerald-500 to-teal-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">Analytics</span>
                    <span class="relative group-hover:opacity-0 transition-opacity duration-300">Analytics</span>
                </a>
                <a href="#faq" class="mobile-link group relative inline-block text-4xl font-black text-gray-900 dark:text-white tracking-tight hover:scale-105 transition-transform duration-300">
                    <span class="absolute inset-0 bg-clip-text text-transparent bg-gradient-to-r from-orange-500 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">FAQ</span>
                    <span class="relative group-hover:opacity-0 transition-opacity duration-300">FAQ</span>
                </a>
            </div>
            
            <!-- Bottom Auth Buttons & Footer -->
            <div class="mt-auto pt-10 flex flex-col gap-4">
                <button onclick="toggleRegisterModal(); toggleMobileMenu();" class="relative group w-full py-4 rounded-2xl bg-white dark:bg-white/5 text-gray-900 dark:text-white font-black text-lg transition-all border border-gray-200 dark:border-white/10 hover:border-brand-500 shadow-sm overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-100 to-gray-50 dark:from-white/10 dark:to-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <span class="relative z-10">Create Account</span>
                </button>
                <a href="/login" class="relative block text-center group w-full py-4 rounded-2xl text-white font-black text-lg transition-all shadow-[0_0_20px_rgba(59,130,246,0.3)] overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-purple-600 group-hover:scale-105 transition-transform duration-500"></div>
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Log In <i class="fa-solid fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </a>
                
                <div class="mt-8 flex items-center justify-center gap-6 text-2xl text-gray-400">
                    <a href="https://www.facebook.com/thesomishere/" target="_blank" class="hover:text-brand-500 transition-colors"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://github.com/somnath-sen/" target="_blank" class="hover:text-brand-500 transition-colors"><i class="fa-brands fa-github"></i></a>
                    <a href="https://www.linkedin.com/in/thesomishere/" target="_blank" class="hover:text-brand-500 transition-colors"><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/50 dark:bg-white/5 backdrop-blur-md border border-gray-200/50 dark:border-white/10 shadow-sm mb-8 animate-fade-in">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-500 shadow-[0_0_8px_rgba(59,130,246,0.8)]"></span>
                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-widest">EdFlow v2.5.1 Live</span>
            </div>

            <h1 class="text-5xl md:text-8xl font-black tracking-tighter text-gray-900 dark:text-white mb-6 animate-fade-in leading-tight md:leading-tight" style="animation-delay: 0.1s;">
                Student Management <br class="hidden md:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-900 to-gray-500 dark:from-white dark:to-gray-500">beautifully unified.</span>
            </h1>

            <p class="mt-6 max-w-2xl mx-auto text-lg md:text-xl text-gray-500 dark:text-gray-400 mb-10 animate-fade-in font-medium" style="animation-delay: 0.2s;">
                Admissions, attendance, fees, and examinations in one sleek cloud platform. Built for modern institutions that value design and speed.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in" style="animation-delay: 0.3s;">
                <button onclick="toggleRegisterModal()" class="px-8 py-3.5 rounded-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold text-sm hover:scale-105 transition-transform shadow-lg shadow-gray-900/20 dark:shadow-white/10">
                    Apply Now
                </button>
                <a href="#features" class="px-8 py-3.5 rounded-full bg-white dark:bg-gray-900 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-800 font-bold text-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors inline-block leading-normal">
                    Explore Features
                </a>
            </div>

            <div class="mt-20 relative mx-auto max-w-5xl animate-fade-in" style="animation-delay: 0.5s;">
                <div class="rounded-2xl md:rounded-[2rem] bg-gray-100/50 dark:bg-white/5 p-2 md:p-3 backdrop-blur-xl border border-gray-200/50 dark:border-white/10 shadow-2xl">
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

    <section id="features" class="py-24 bg-white dark:bg-black transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-brand-600 dark:text-gray-400 font-bold tracking-widest uppercase text-xs mb-3">Core Modules</h2>
                <h3 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">Everything you need.</h3>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Powerful systems perfectly integrated into one unified dashboard.</p>
            </div>

            <!-- New Premium Animated Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 auto-rows-[300px]">
                
                <!-- Large Card: Analytics -->
                <div class="md:col-span-2 md:row-span-2 group p-1 rounded-[2.5rem] bg-gradient-to-b from-gray-200 to-transparent dark:from-white/10 dark:to-transparent hover:from-brand-500/40 dark:hover:from-brand-500/30 transition-all duration-700 relative overflow-hidden backdrop-blur-2xl shadow-lg">
                    <div class="absolute inset-0 z-0 opacity-40 group-hover:opacity-100 transition-opacity duration-1000 delay-100">
                        <div class="absolute top-[10%] right-[10%] w-[300px] h-[300px] bg-brand-500/50 rounded-full blur-[80px] animate-[spin_8s_linear_infinite]"></div>
                        <div class="absolute bottom-[10%] left-[10%] w-[250px] h-[250px] bg-purple-600/50 rounded-full blur-[80px] animate-[spin_12s_linear_infinite_reverse]"></div>
                    </div>
                    <div class="relative z-10 w-full h-full bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl rounded-[2.4rem] p-10 flex flex-col border border-white/60 dark:border-white/5 group-hover:bg-white/90 dark:group-hover:bg-zinc-950/60 transition-colors duration-700 overflow-hidden">
                        <div class="w-16 h-16 bg-gradient-to-br from-brand-500 to-purple-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-xl shadow-brand-500/20 group-hover:scale-110 group-hover:-rotate-3 transition-all duration-500">
                            <i class="fa-solid fa-chart-line text-2xl"></i>
                        </div>
                        <!-- Mini bar chart mock-UI -->
                        <div class="flex items-end gap-2 h-20 mb-6">
                            <div class="flex-1 bg-brand-500/20 rounded-t-lg group-hover:bg-brand-500/60 transition-all duration-[800ms] ease-out" style="height:40%"></div>
                            <div class="flex-1 bg-brand-500/20 rounded-t-lg group-hover:bg-brand-500/60 transition-all duration-[900ms] ease-out delay-75" style="height:65%"></div>
                            <div class="flex-1 bg-brand-500/20 rounded-t-lg group-hover:bg-brand-500/60 transition-all duration-[1000ms] ease-out delay-100" style="height:50%"></div>
                            <div class="flex-1 bg-purple-500/20 rounded-t-lg group-hover:bg-purple-500/70 transition-all duration-[1100ms] ease-out delay-150" style="height:85%"></div>
                            <div class="flex-1 bg-purple-500/20 rounded-t-lg group-hover:bg-purple-500/70 transition-all duration-[1200ms] ease-out delay-200" style="height:72%"></div>
                            <div class="flex-1 bg-brand-500/30 rounded-t-lg group-hover:bg-brand-500/80 shadow-[0_0_12px_rgba(59,130,246,0.5)] transition-all duration-[1300ms] ease-out delay-250" style="height:95%"></div>
                        </div>
                        <div class="flex gap-3 mb-4">
                            <div class="flex-1 rounded-xl bg-brand-50 dark:bg-brand-500/10 border border-brand-100 dark:border-brand-500/20 px-3 py-2 text-center">
                                <div class="text-lg font-black text-brand-600 dark:text-brand-400">94%</div>
                                <div class="text-[10px] text-brand-500 font-bold uppercase tracking-wider">Efficiency</div>
                            </div>
                            <div class="flex-1 rounded-xl bg-purple-50 dark:bg-purple-500/10 border border-purple-100 dark:border-purple-500/20 px-3 py-2 text-center">
                                <div class="text-lg font-black text-purple-600 dark:text-purple-400">+18%</div>
                                <div class="text-[10px] text-purple-500 font-bold uppercase tracking-wider">Growth</div>
                            </div>
                        </div>
                        <div class="mt-auto relative z-20">
                            <h3 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white mb-4">Performance Analytics</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg font-medium max-w-sm">Deep, actionable insights into student performance, attendance patterns, and institutional health across the entire ecosystem.</p>
                        </div>
                        <div class="absolute -bottom-20 -right-20 w-72 h-72 border border-brand-500/20 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-[1500ms] scale-50 group-hover:scale-100">
                            <div class="w-48 h-48 border border-purple-500/30 rounded-full animate-ping" style="animation-duration: 3s;"></div>
                        </div>
                    </div>
                </div>

                <!-- Medium Card: QR Identity -->
                <div class="md:col-span-2 md:row-span-1 group p-1 rounded-[2.5rem] bg-gradient-to-b from-gray-200 to-transparent dark:from-white/10 dark:to-transparent hover:from-blue-500/40 dark:hover:from-blue-500/30 transition-all duration-700 relative overflow-hidden backdrop-blur-2xl shadow-lg">
                    <div class="absolute inset-0 z-0 opacity-40 group-hover:opacity-100 transition-opacity duration-1000 delay-100">
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[200px] bg-blue-500/40 rounded-full blur-[70px] animate-[spin_6s_linear_infinite]"></div>
                    </div>
                    <div class="relative z-10 w-full h-full bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl rounded-[2.4rem] p-8 flex flex-row items-center gap-6 border border-white/60 dark:border-white/5 group-hover:bg-white/90 dark:group-hover:bg-zinc-950/60 transition-colors duration-700 overflow-hidden">
                        <!-- QR mock visual -->
                        <div class="shrink-0 w-20 h-20 rounded-2xl bg-white dark:bg-zinc-900 border-2 border-blue-100 dark:border-blue-500/20 p-2 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                            <div class="grid grid-cols-3 gap-0.5 w-full h-full">
                                <div class="bg-gray-900 dark:bg-white rounded-sm"></div><div class="bg-gray-100 dark:bg-zinc-700 rounded-sm"></div><div class="bg-gray-900 dark:bg-white rounded-sm"></div>
                                <div class="bg-gray-100 dark:bg-zinc-700 rounded-sm"></div><div class="bg-blue-500 rounded-sm animate-pulse"></div><div class="bg-gray-100 dark:bg-zinc-700 rounded-sm"></div>
                                <div class="bg-gray-900 dark:bg-white rounded-sm"></div><div class="bg-gray-100 dark:bg-zinc-700 rounded-sm"></div><div class="bg-gray-900 dark:bg-white rounded-sm"></div>
                            </div>
                        </div>
                        <div class="relative z-20 flex-1">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20 mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                <span class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest">Instant Scan</span>
                            </div>
                            <h3 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white mb-2">Smart QR Identity</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed font-medium">Instantly generate scannable digital ID cards for dynamic & highly secure campus access control.</p>
                        </div>
                    </div>
                </div>

                <!-- Small Card: Tracker -->
                <div class="md:col-span-1 md:row-span-1 group p-1 rounded-[2.5rem] bg-gradient-to-b from-gray-200 to-transparent dark:from-white/10 dark:to-transparent hover:from-emerald-500/40 dark:hover:from-emerald-500/30 transition-all duration-700 relative overflow-hidden backdrop-blur-2xl shadow-lg">
                    <div class="absolute inset-0 z-0 opacity-40 group-hover:opacity-100 transition-opacity duration-1000 delay-100">
                        <div class="absolute bottom-0 right-0 w-[200px] h-[200px] bg-emerald-500/50 rounded-full blur-[60px] animate-pulse"></div>
                    </div>
                    <div class="relative z-10 w-full h-full bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl rounded-[2.4rem] p-6 flex flex-col justify-between border border-white/60 dark:border-white/5 group-hover:bg-white/90 dark:group-hover:bg-zinc-950/60 transition-colors duration-700 overflow-hidden items-center text-center">
                        <!-- Radar mock-UI -->
                        <div class="relative w-16 h-16 flex items-center justify-center">
                            <div class="absolute inset-0 rounded-full border border-emerald-200 dark:border-emerald-500/20 group-hover:scale-150 transition-all duration-700 opacity-0 group-hover:opacity-100"></div>
                            <div class="absolute inset-2 rounded-full border border-emerald-300 dark:border-emerald-500/30 group-hover:scale-125 transition-all duration-500 opacity-0 group-hover:opacity-60"></div>
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/20 group-hover:scale-110 group-hover:-translate-y-1 transition-all duration-500">
                                <i class="fa-solid fa-satellite-dish text-xl animate-[pulse_2s_infinite]"></i>
                            </div>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-400 rounded-full animate-ping"></span>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full"></span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black tracking-tight text-gray-900 dark:text-white mb-1">Live Tracker</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Secure live GPS tracking.</p>
                        </div>
                    </div>
                </div>

                <!-- Small Card: AI Agent -->
                <div class="md:col-span-1 md:row-span-1 group p-1 rounded-[2.5rem] bg-gradient-to-b from-gray-200 to-transparent dark:from-white/10 dark:to-transparent hover:from-rose-500/40 dark:hover:from-rose-500/30 transition-all duration-700 relative overflow-hidden backdrop-blur-2xl shadow-lg">
                    <div class="absolute inset-0 z-0 opacity-40 group-hover:opacity-100 transition-opacity duration-1000 delay-100">
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] h-[250px] bg-gradient-to-r from-rose-500/60 to-orange-500/60 rounded-full blur-[60px] animate-[spin_5s_linear_infinite]"></div>
                    </div>
                    <div class="relative z-10 w-full h-full bg-gray-900 dark:bg-zinc-950/80 backdrop-blur-xl rounded-[2.4rem] p-6 flex flex-col justify-between border border-transparent dark:border-white/5 group-hover:bg-black transition-colors duration-700 overflow-hidden text-center items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-rose-500 to-orange-500 rounded-2xl flex items-center justify-center text-white mb-2 shadow-lg shadow-rose-500/30 group-hover:scale-110 group-hover:rotate-12 transition-all duration-500 border border-white/20">
                            <i class="fa-solid fa-robot text-xl"></i>
                        </div>
                        <!-- AI chat bubble mock -->
                        <div class="w-full space-y-1.5 mb-1">
                            <div class="flex justify-end"><div class="text-[10px] bg-rose-500/30 text-rose-200 rounded-xl px-2 py-1 max-w-[80%] text-right">Explain photosynthesis</div></div>
                            <div class="flex justify-start"><div class="text-[10px] bg-white/10 text-gray-300 rounded-xl px-2 py-1 max-w-[80%] opacity-0 group-hover:opacity-100 transition-opacity duration-700 delay-300">Sure! It's the process...</div></div>
                        </div>
                        <div>
                            <h3 class="text-xl font-black tracking-tight text-white mb-1">StudyAI Agent</h3>
                            <p class="text-gray-400 text-sm font-medium">Gemini-powered tutor.</p>
                        </div>
                    </div>
                </div>

                <!-- Medium Card: Parent Access -->
                <div class="md:col-span-2 md:row-span-1 group p-1 rounded-[2.5rem] bg-gradient-to-b from-gray-200 to-transparent dark:from-white/10 dark:to-transparent hover:from-indigo-500/40 dark:hover:from-indigo-500/30 transition-all duration-700 relative overflow-hidden backdrop-blur-2xl shadow-lg">
                    <div class="absolute inset-0 z-0 opacity-40 group-hover:opacity-100 transition-opacity duration-1000 delay-100">
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[200px] bg-indigo-500/40 rounded-full blur-[70px] animate-[spin_6s_linear_infinite]"></div>
                    </div>
                    <div class="relative z-10 w-full h-full bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl rounded-[2.4rem] p-8 flex flex-row items-center gap-6 border border-white/60 dark:border-white/5 group-hover:bg-white/90 dark:group-hover:bg-zinc-950/60 transition-colors duration-700 overflow-hidden">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-500/20 group-hover:scale-110 group-hover:-rotate-6 transition-all duration-500 shrink-0">
                            <i class="fa-solid fa-users text-2xl"></i>
                        </div>
                        <div class="relative z-20 flex-1">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-100 dark:border-indigo-500/20 mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                                <span class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">Live Updates</span>
                            </div>
                            <h3 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white mb-1">Parent Access</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed font-medium text-sm">Empower parents with real-time access to their children's attendance, grades, and fee records securely.</p>
                            <!-- Mini notification feed -->
                            <div class="mt-3 space-y-1 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200">
                                <div class="flex items-center gap-2 text-[11px] text-indigo-600 dark:text-indigo-400 font-bold">
                                    <i class="fa-solid fa-circle-check text-emerald-500"></i> Attendance: 91% — On Track
                                </div>
                                <div class="flex items-center gap-2 text-[11px] text-indigo-600 dark:text-indigo-400 font-bold">
                                    <i class="fa-solid fa-indian-rupee-sign text-amber-500"></i> Fee Status: Paid ✓
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medium Card: Broadcasting -->
                <div class="md:col-span-2 md:row-span-1 group p-1 rounded-[2.5rem] bg-gradient-to-b from-gray-200 to-transparent dark:from-white/10 dark:to-transparent hover:from-amber-500/40 dark:hover:from-amber-500/30 transition-all duration-700 relative overflow-hidden backdrop-blur-2xl shadow-lg">
                    <div class="absolute inset-0 z-0 opacity-40 group-hover:opacity-100 transition-opacity duration-1000 delay-100">
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[200px] bg-amber-500/40 rounded-full blur-[70px] animate-[spin_6s_linear_infinite_reverse]"></div>
                    </div>
                    <div class="relative z-10 w-full h-full bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl rounded-[2.4rem] p-8 flex flex-row items-center gap-6 border border-white/60 dark:border-white/5 group-hover:bg-white/90 dark:group-hover:bg-zinc-950/60 transition-colors duration-700 overflow-hidden">
                        <!-- Signal wave icon -->
                        <div class="relative shrink-0 w-16 flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-amber-500/20 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <i class="fa-solid fa-bullhorn text-2xl"></i>
                            </div>
                            <!-- Signal rings -->
                            <div class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-amber-400 opacity-0 group-hover:opacity-100 group-hover:animate-ping transition-opacity"></div>
                        </div>
                        <div class="relative z-20 flex-1">
                            <h3 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white mb-1">Broadcasting</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed font-medium text-sm">Instantly deliver subject-specific announcements and urgent institutional notices across all devices.</p>
                            <!-- Notice feed mock -->
                            <div class="mt-3 space-y-1 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200">
                                <div class="flex items-center gap-2 text-[11px] text-amber-700 dark:text-amber-400 font-bold bg-amber-50 dark:bg-amber-500/10 rounded-lg px-2 py-1">
                                    <i class="fa-solid fa-circle text-[6px] text-amber-500 animate-pulse"></i> Exam schedule updated — Math, 2nd Floor
                                </div>
                                <div class="flex items-center gap-2 text-[11px] text-amber-700 dark:text-amber-400 font-bold bg-amber-50 dark:bg-amber-500/10 rounded-lg px-2 py-1">
                                    <i class="fa-solid fa-circle text-[6px] text-amber-500"></i> Holiday notice: 15th April
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medium Card: AI Study Coach -->
                <div class="md:col-span-2 md:row-span-1 group p-1 rounded-[2.5rem] bg-gradient-to-b from-gray-200 to-transparent dark:from-white/10 dark:to-transparent hover:from-fuchsia-500/40 dark:hover:from-fuchsia-500/30 transition-all duration-700 relative overflow-hidden backdrop-blur-2xl shadow-lg">
                    <div class="absolute inset-0 z-0 opacity-40 group-hover:opacity-100 transition-opacity duration-1000 delay-100">
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[200px] bg-fuchsia-500/40 rounded-full blur-[70px] animate-[spin_6s_linear_infinite]"></div>
                    </div>
                    <div class="relative z-10 w-full h-full bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl rounded-[2.4rem] p-8 flex flex-row items-center gap-6 border border-white/60 dark:border-white/5 group-hover:bg-white/90 dark:group-hover:bg-zinc-950/60 transition-colors duration-700 overflow-hidden">
                        <div class="w-16 h-16 bg-gradient-to-br from-fuchsia-400 to-fuchsia-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-fuchsia-500/20 group-hover:scale-110 group-hover:-rotate-3 transition-all duration-500 shrink-0">
                            <i class="fa-solid fa-brain text-2xl"></i>
                        </div>
                        <div class="relative z-20 flex-1">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-fuchsia-50 dark:bg-fuchsia-500/10 border border-fuchsia-100 dark:border-fuchsia-500/20 mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-fuchsia-500 animate-pulse"></span>
                                <span class="text-[10px] font-black text-fuchsia-600 dark:text-fuchsia-400 uppercase tracking-widest">Gemini Powered</span>
                            </div>
                            <h3 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white mb-1">AI Study Coach</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed font-medium text-sm">An intelligent assistant to personalize study plans, solve queries, and provide 24/7 support.</p>
                            <!-- Study plan mock -->
                            <div class="mt-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200">
                                <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-fuchsia-100 dark:bg-fuchsia-500/20 text-fuchsia-700 dark:text-fuchsia-300">Math Plan ✓</span>
                                <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-300">Physics Quiz</span>
                                <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-indigo-100 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-300">+ 5 more</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medium Card: SOS for Emergency -->
                <div class="md:col-span-2 md:row-span-1 group p-1 rounded-[2.5rem] bg-gradient-to-b from-gray-200 to-transparent dark:from-white/10 dark:to-transparent hover:from-red-500/40 dark:hover:from-red-500/30 transition-all duration-700 relative overflow-hidden backdrop-blur-2xl shadow-lg">
                    <div class="absolute inset-0 z-0 opacity-40 group-hover:opacity-100 transition-opacity duration-1000 delay-100">
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[200px] bg-red-500/40 rounded-full blur-[70px] animate-[spin_6s_linear_infinite_reverse]"></div>
                    </div>
                    <div class="relative z-10 w-full h-full bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl rounded-[2.4rem] p-8 flex flex-row items-center gap-6 border border-white/60 dark:border-white/5 group-hover:bg-white/90 dark:group-hover:bg-zinc-950/60 transition-colors duration-700 overflow-hidden">
                        <!-- SOS pulsing icon -->
                        <div class="relative shrink-0">
                            <div class="absolute inset-0 rounded-2xl bg-red-500/30 group-hover:animate-ping"></div>
                            <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-red-500/20 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 relative">
                                <i class="fa-solid fa-bell text-2xl animate-pulse"></i>
                            </div>
                        </div>
                        <div class="relative z-20 flex-1">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                <span class="text-[10px] font-black text-red-600 dark:text-red-400 uppercase tracking-widest">Panic Alert Active</span>
                            </div>
                            <h3 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white mb-1">SOS for Emergency</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed font-medium text-sm">Instant panic alerts triggered by students automatically notify parents with live location data in case of emergencies.</p>
                            <!-- Alert status mock -->
                            <div class="mt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200">
                                <div class="flex items-center gap-2 text-[11px] text-red-700 dark:text-red-400 font-bold bg-red-50 dark:bg-red-500/10 rounded-lg px-2 py-1">
                                    <i class="fa-solid fa-location-dot text-red-500"></i> GPS signal acquired — Parent notified in 0.3s
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Large Card: AI Attendance Prediction -->
                <div class="md:col-span-2 md:row-span-2 group p-1 rounded-[2.5rem] bg-gradient-to-b from-gray-200 to-transparent dark:from-white/10 dark:to-transparent hover:from-cyan-500/40 dark:hover:from-cyan-500/30 transition-all duration-700 relative overflow-hidden backdrop-blur-2xl shadow-lg">
                    <!-- Animated Background Layers -->
                    <div class="absolute inset-0 z-0 opacity-40 group-hover:opacity-100 transition-opacity duration-1000 delay-100">
                        <div class="absolute top-[10%] right-[10%] w-[300px] h-[300px] bg-cyan-500/50 rounded-full blur-[80px] animate-[spin_8s_linear_infinite]"></div>
                        <div class="absolute bottom-[10%] left-[10%] w-[250px] h-[250px] bg-sky-600/50 rounded-full blur-[80px] animate-[spin_12s_linear_infinite_reverse]"></div>
                    </div>

                    <!-- Content Canvas -->
                    <div class="relative z-10 w-full h-full bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl rounded-[2.4rem] p-10 flex flex-col border border-white/60 dark:border-white/5 group-hover:bg-white/90 dark:group-hover:bg-zinc-950/60 transition-colors duration-700 overflow-hidden">
                        <div class="w-16 h-16 bg-gradient-to-br from-cyan-400 to-sky-600 rounded-2xl flex items-center justify-center text-white mb-8 shadow-xl shadow-cyan-500/20 group-hover:scale-110 group-hover:-rotate-3 transition-all duration-500">
                            <i class="fa-solid fa-chart-simple text-2xl"></i>
                        </div>

                        <!-- Animated prediction bar chart mock-UI -->
                        <div class="mb-6 space-y-3">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 w-16 shrink-0">Week 1</span>
                                <div class="flex-1 h-3 bg-gray-100 dark:bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-cyan-400 to-sky-500 rounded-full shadow-[0_0_8px_rgba(34,211,238,0.6)] group-hover:w-[88%] w-[50%] transition-all duration-[1200ms] ease-out"></div>
                                </div>
                                <span class="text-xs font-black text-cyan-500 w-10 text-right">88%</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 w-16 shrink-0">Week 2</span>
                                <div class="flex-1 h-3 bg-gray-100 dark:bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-amber-400 to-orange-500 rounded-full shadow-[0_0_8px_rgba(251,191,36,0.5)] group-hover:w-[61%] w-[30%] transition-all duration-[1400ms] ease-out"></div>
                                </div>
                                <span class="text-xs font-black text-amber-500 w-10 text-right">61%</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 w-16 shrink-0">Week 3</span>
                                <div class="flex-1 h-3 bg-gray-100 dark:bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-rose-400 to-red-500 rounded-full shadow-[0_0_8px_rgba(251,113,133,0.5)] group-hover:w-[42%] w-[20%] transition-all duration-[1600ms] ease-out"></div>
                                </div>
                                <span class="text-xs font-black text-rose-500 w-10 text-right">42%</span>
                            </div>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-xs font-bold text-gray-400 dark:text-gray-500 w-16 shrink-0">Predicted</span>
                                <div class="flex-1 h-3 bg-gray-100 dark:bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-violet-500 to-purple-600 rounded-full shadow-[0_0_12px_rgba(139,92,246,0.6)] group-hover:w-[38%] w-[15%] transition-all duration-[1800ms] ease-out animate-pulse"></div>
                                </div>
                                <span class="text-xs font-black text-violet-500 w-10 text-right">~38%</span>
                            </div>
                        </div>

                        <div class="mt-auto relative z-20">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cyan-50 dark:bg-cyan-500/10 border border-cyan-200 dark:border-cyan-500/20 mb-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-500 animate-pulse"></span>
                                <span class="text-[10px] font-black text-cyan-600 dark:text-cyan-400 uppercase tracking-widest">AI Powered</span>
                            </div>
                            <h3 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white mb-4">AI Attendance Prediction</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg font-medium max-w-sm">Analyzes historical attendance trends to predict future eligibility risk. Automatically triggers smart alerts for at-risk students before it's too late.</p>
                        </div>

                        <!-- Decorative rings -->
                        <div class="absolute -bottom-20 -right-20 w-72 h-72 border border-cyan-500/20 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-[1500ms] scale-50 group-hover:scale-100">
                            <div class="w-48 h-48 border border-sky-500/30 rounded-full animate-ping" style="animation-duration: 3s;"></div>
                        </div>
                    </div>
                </div>

                <!-- Large Card: Dropout Risk Detection -->
                <div class="md:col-span-2 md:row-span-2 group p-1 rounded-[2.5rem] bg-gradient-to-b from-gray-200 to-transparent dark:from-white/10 dark:to-transparent hover:from-rose-500/40 dark:hover:from-rose-500/30 transition-all duration-700 relative overflow-hidden backdrop-blur-2xl shadow-lg">
                    <!-- Animated Background Layers -->
                    <div class="absolute inset-0 z-0 opacity-40 group-hover:opacity-100 transition-opacity duration-1000 delay-100">
                        <div class="absolute top-[10%] right-[10%] w-[300px] h-[300px] bg-rose-500/50 rounded-full blur-[80px] animate-[spin_10s_linear_infinite]"></div>
                        <div class="absolute bottom-[10%] left-[10%] w-[250px] h-[250px] bg-orange-500/40 rounded-full blur-[80px] animate-[spin_14s_linear_infinite_reverse]"></div>
                    </div>

                    <!-- Content Canvas -->
                    <div class="relative z-10 w-full h-full bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl rounded-[2.4rem] p-10 flex flex-col border border-white/60 dark:border-white/5 group-hover:bg-white/90 dark:group-hover:bg-zinc-950/60 transition-colors duration-700 overflow-hidden">
                        <div class="w-16 h-16 bg-gradient-to-br from-rose-500 to-orange-600 rounded-2xl flex items-center justify-center text-white mb-8 shadow-xl shadow-rose-500/20 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                            <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                        </div>

                        <!-- Risk score mock-UI cards -->
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            <div class="rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 p-3 text-center group-hover:scale-105 transition-transform duration-500 delay-100">
                                <div class="text-xl font-black text-emerald-600 dark:text-emerald-400">Safe</div>
                                <div class="text-[10px] text-emerald-600 dark:text-emerald-500 font-bold uppercase tracking-wider mt-1">Score &lt; 30</div>
                                <div class="mt-2 w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center mx-auto">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                                </div>
                            </div>
                            <div class="rounded-2xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 p-3 text-center group-hover:scale-105 transition-transform duration-500 delay-200">
                                <div class="text-xl font-black text-amber-600 dark:text-amber-400">At Risk</div>
                                <div class="text-[10px] text-amber-600 dark:text-amber-500 font-bold uppercase tracking-wider mt-1">Score 30–59</div>
                                <div class="mt-2 w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center mx-auto">
                                    <i class="fa-solid fa-circle-exclamation text-amber-500 text-sm animate-pulse"></i>
                                </div>
                            </div>
                            <div class="rounded-2xl bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 p-3 text-center group-hover:scale-105 transition-transform duration-500 delay-300">
                                <div class="text-xl font-black text-rose-600 dark:text-rose-400">High Risk</div>
                                <div class="text-[10px] text-rose-600 dark:text-rose-500 font-bold uppercase tracking-wider mt-1">Score ≥ 60</div>
                                <div class="mt-2 w-8 h-8 rounded-full bg-rose-500/20 flex items-center justify-center mx-auto">
                                    <i class="fa-solid fa-skull-crossbones text-rose-500 text-sm animate-pulse"></i>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto relative z-20">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-50 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 mb-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                <span class="text-[10px] font-black text-rose-600 dark:text-rose-400 uppercase tracking-widest">Early Warning System</span>
                            </div>
                            <h3 class="text-3xl font-black tracking-tight text-gray-900 dark:text-white mb-4">Dropout Risk Detection</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg font-medium max-w-sm">Intelligently scores each student's dropout likelihood by fusing attendance, academic performance, and platform engagement data into a single actionable risk index.</p>
                        </div>

                        <!-- Decorative rings -->
                        <div class="absolute -bottom-20 -right-20 w-72 h-72 border border-rose-500/20 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-[1500ms] scale-50 group-hover:scale-100">
                            <div class="w-48 h-48 border border-orange-500/30 rounded-full animate-ping" style="animation-duration: 2.5s;"></div>
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

    <section id="stats" class="py-24 relative overflow-hidden bg-black border-t border-white/5">
        <!-- Colorful ambient background glow -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div class="absolute -top-[20%] right-[10%] w-[600px] h-[600px] bg-brand-500/20 rounded-full blur-[100px] mix-blend-screen animate-[pulse_10s_infinite]"></div>
            <div class="absolute -bottom-[20%] left-[10%] w-[600px] h-[600px] bg-purple-600/20 rounded-full blur-[100px] mix-blend-screen animate-[pulse_15s_infinite_reverse]"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Title -->
            <div class="text-center mb-16">
                <h2 class="text-brand-500 font-bold tracking-widest uppercase text-xs mb-3">Live Metrics</h2>
                <h3 class="text-3xl font-black tracking-tight text-white sm:text-5xl">Scale with confidence.</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <!-- Stat 1: Blue -->
                <div class="group relative p-8 rounded-[2rem] bg-white/5 border border-white/10 hover:border-brand-500/50 hover:bg-white/10 transition-all duration-500 backdrop-blur-md overflow-hidden hover:-translate-y-2 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <i class="fa-solid fa-users text-4xl text-brand-400 mb-6 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-500 drop-shadow-[0_0_15px_rgba(59,130,246,0.5)]"></i>
                        <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-b from-white to-gray-500 mb-3"><span class="count-up" data-target="50">0</span>k+</div>
                        <div class="text-gray-400 text-xs font-bold tracking-widest uppercase group-hover:text-brand-300 transition-colors">Students Managed</div>
                    </div>
                </div>
                
                <!-- Stat 2: Purple -->
                <div class="group relative p-8 rounded-[2rem] bg-white/5 border border-white/10 hover:border-purple-500/50 hover:bg-white/10 transition-all duration-500 backdrop-blur-md overflow-hidden hover:-translate-y-2 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <i class="fa-solid fa-building-columns text-4xl text-purple-400 mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500 drop-shadow-[0_0_15px_rgba(168,85,247,0.5)]"></i>
                        <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-b from-white to-gray-500 mb-3"><span class="count-up" data-target="120">0</span>+</div>
                        <div class="text-gray-400 text-xs font-bold tracking-widest uppercase group-hover:text-purple-300 transition-colors">Institutions</div>
                    </div>
                </div>
                
                <!-- Stat 3: Emerald -->
                <div class="group relative p-8 rounded-[2rem] bg-white/5 border border-white/10 hover:border-emerald-500/50 hover:bg-white/10 transition-all duration-500 backdrop-blur-md overflow-hidden hover:-translate-y-2 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <i class="fa-solid fa-server text-4xl text-emerald-400 mb-6 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 drop-shadow-[0_0_15px_rgba(52,211,153,0.5)]"></i>
                        <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-b from-white to-gray-500 mb-3"><span class="count-up" data-target="99.9">0</span>%</div>
                        <div class="text-gray-400 text-xs font-bold tracking-widest uppercase group-hover:text-emerald-300 transition-colors">Uptime Guarantee</div>
                    </div>
                </div>
                
                <!-- Stat 4: Orange -->
                <div class="group relative p-8 rounded-[2rem] bg-white/5 border border-white/10 hover:border-orange-500/50 hover:bg-white/10 transition-all duration-500 backdrop-blur-md overflow-hidden hover:-translate-y-2 shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <i class="fa-solid fa-headset text-4xl text-orange-400 mb-6 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 drop-shadow-[0_0_15px_rgba(251,146,60,0.5)]"></i>
                        <div class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-b from-white to-gray-500 mb-3"><span class="count-up" data-target="24">0</span>/7</div>
                        <div class="text-gray-400 text-xs font-bold tracking-widest uppercase group-hover:text-orange-300 transition-colors">Live Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Use Section -->
    <section id="how-to-use" class="py-32 relative bg-white dark:bg-black transition-colors duration-300 border-t border-gray-100 dark:border-white/5 overflow-hidden">
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

    <section id="faq" class="py-32 relative bg-white dark:bg-black transition-colors duration-300 border-t border-gray-100 dark:border-white/5 overflow-hidden">
        
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

    <footer id="contact" class="relative bg-white dark:bg-black border-t border-gray-200 dark:border-white/5 pt-24 pb-10 transition-colors duration-300 overflow-hidden">
        
        <!-- Ambient Footer Glow -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 w-[800px] h-[400px] bg-brand-600/30 rounded-full blur-[120px] mix-blend-screen pointer-events-none"></div>

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
                navbar.classList.add('glass');
                navbar.classList.add('shadow-sm');
                if (document.documentElement.classList.contains('dark')) {
                    navbar.classList.add('border-b', 'border-gray-800');
                }
            } else {
                navbar.classList.remove('glass');
                navbar.classList.remove('shadow-sm');
                navbar.classList.remove('border-b', 'border-gray-800');
            }
        });

        // Dark Mode Logic & Bot Theme Sync
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleMobile = document.getElementById('theme-toggle-mobile');
        
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            updateBotTheme('dark');
        } else {
            document.documentElement.classList.remove('dark');
            updateBotTheme('light');
        }

        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
                updateBotTheme('light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
                updateBotTheme('dark');
            }
        }

        function updateBotTheme(theme) {
            if (window.botpressWebChat) {
                window.botpressWebChat.sendEvent({
                    type: 'CONFIG',
                    payload: { theme: theme }
                });
            }
        }

        themeToggleBtn.addEventListener('click', toggleTheme);
        themeToggleMobile.addEventListener('click', toggleTheme);

        /* Mobile Menu Toggle Logic */
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuIcon = document.getElementById('mobile-menu-icon');
        const mobileLinks = document.querySelectorAll('.mobile-link');
        let isMobileMenuOpen = false;

        function toggleMobileMenu() {
            isMobileMenuOpen = !isMobileMenuOpen;
            if (isMobileMenuOpen) {
                mobileMenu.classList.remove('translate-x-full');
                mobileMenu.classList.add('translate-x-0');
                mobileMenuIcon.classList.remove('fa-bars');
                mobileMenuIcon.classList.add('fa-xmark');
                document.body.style.overflow = 'hidden';
            } else {
                mobileMenu.classList.remove('translate-x-0');
                mobileMenu.classList.add('translate-x-full');
                mobileMenuIcon.classList.remove('fa-xmark');
                mobileMenuIcon.classList.add('fa-bars');
                if (!document.querySelectorAll('.custom-modal:not(.hidden)').length) {
                    document.body.style.overflow = 'auto';
                }
            }
        }

        mobileMenuBtn.addEventListener('click', toggleMobileMenu);

        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                if(isMobileMenuOpen) toggleMobileMenu();
            });
        });

        /* Newsletter Logic */
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

    // ── 9. PARALLAX BLOBS ────────────────────────────────────────────────
    const blobs = document.querySelectorAll('.fixed.inset-0.-z-10 > div');
    blobs.forEach((blob, i) => {
        const speed = (i + 1) * 0.15;
        ScrollTrigger.create({
            trigger: document.body,
            start: 'top top',
            end: 'bottom bottom',
            scrub: true,
            onUpdate: self => {
                const yMove = self.progress * window.innerHeight * speed;
                gsap.set(blob, { y: yMove, overwrite: 'auto' });
            }
        });
    });

    // ── 10. MAGNETIC BUTTONS (desktop only) ──────────────────────────────
    if (window.innerWidth >= 768) {
        document.querySelectorAll('nav a, nav button, section > div > div > .flex > button, section > div > div > .flex > a').forEach(btn => {
            btn.addEventListener('mousemove', e => {
                const rect = btn.getBoundingClientRect();
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const dx = (e.clientX - cx) * 0.25;
                const dy = (e.clientY - cy) * 0.25;
                gsap.to(btn, { x: dx, y: dy, duration: 0.3, ease:'power2.out', overwrite:'auto' });
            });
            btn.addEventListener('mouseleave', () => {
                gsap.to(btn, { x:0, y:0, duration:0.5, ease:'elastic.out(1,0.5)', overwrite:'auto' });
            });
        });
    }

    // ── 11. 3D CARD TILT on Feature Bento cards ──────────────────────────
    document.querySelectorAll('#features .grid > div').forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const cx = rect.left + rect.width / 2;
            const cy = rect.top + rect.height / 2;
            const rotX = ((e.clientY - cy) / rect.height) * -8;
            const rotY = ((e.clientX - cx) / rect.width) * 8;
            gsap.to(card, { rotationX: rotX, rotationY: rotY, transformPerspective: 800, duration:0.4, ease:'power2.out', overwrite:'auto' });
        });
        card.addEventListener('mouseleave', () => {
            gsap.to(card, { rotationX:0, rotationY:0, duration:0.6, ease:'elastic.out(1,0.4)', overwrite:'auto' });
        });
    });

    // ── 12. SCROLL PROGRESS INDICATOR (thin line on top) ─────────────────
    const progressBar = document.createElement('div');
    progressBar.style.cssText = 'position:fixed;top:0;left:0;height:2px;background:linear-gradient(90deg,#3b82f6,#a855f7);z-index:9998;width:0%;will-change:width;pointer-events:none;';
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