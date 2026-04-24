<!-- GSAP Core -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<style>
    /* Glossy Glassmorphism Loader Styles */
    .glass-loader-panel {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 1px 1px rgba(255, 255, 255, 0.1);
    }
    
    .ambient-blob {
        position: absolute;
        filter: blur(60px);
        z-index: 0;
        opacity: 0.5;
        animation: float-blob 8s infinite ease-in-out alternate;
        border-radius: 50%;
    }
    
    .blob-primary {
        background: #6366f1; /* Indigo */
        width: 300px; height: 300px;
        top: 20%; left: 20%;
        animation-delay: 0s;
    }
    
    .blob-secondary {
        background: #ec4899; /* Pink */
        width: 250px; height: 250px;
        bottom: 10%; right: 20%;
        animation-delay: -3s;
    }
    
    .blob-tertiary {
        background: #0ea5e9; /* Sky */
        width: 200px; height: 200px;
        top: 40%; right: 30%;
        animation-delay: -5s;
    }

    @keyframes float-blob {
        0% { transform: translate(0, 0) scale(1) rotate(0deg); }
        50% { transform: translate(50px, -50px) scale(1.1) rotate(180deg); }
        100% { transform: translate(-20px, 30px) scale(0.9) rotate(360deg); }
    }

    .shimmer-gradient-text {
        background: linear-gradient(90deg, #ffffff 0%, #a5b4fc 50%, #ffffff 100%);
        background-size: 200% auto;
        color: transparent;
        -webkit-background-clip: text;
        background-clip: text;
        animation: shine-text 2.5s linear infinite;
    }

    @keyframes shine-text {
        to { background-position: 200% center; }
    }

    .orbital-ring {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 2px solid transparent;
        border-top-color: rgba(255, 255, 255, 0.9);
        border-right-color: rgba(255, 255, 255, 0.2);
        animation: spin-orbit 1.2s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
    }

    .orbital-ring-inner {
        inset: 10px;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: rgba(99, 102, 241, 0.9);
        border-left-color: rgba(99, 102, 241, 0.3);
        animation: spin-orbit-reverse 1.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
    }

    @keyframes spin-orbit {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @keyframes spin-orbit-reverse {
        0% { transform: rotate(360deg); }
        100% { transform: rotate(-360deg); }
    }

    .pulse-glow {
        animation: glow-pulse 2s ease-in-out infinite alternate;
    }

    @keyframes glow-pulse {
        from { box-shadow: 0 0 10px rgba(99, 102, 241, 0.3), inset 0 0 10px rgba(99, 102, 241, 0.2); }
        to { box-shadow: 0 0 25px rgba(99, 102, 241, 0.6), inset 0 0 15px rgba(99, 102, 241, 0.4); }
    }
</style>

<!-- Page Transition Overlay -->
<div id="page-transition-overlay" class="fixed inset-0 z-[9999] bg-slate-950/80 items-center justify-center pointer-events-none overflow-hidden" style="display: none;">
    
    <!-- Animated Ambient Background -->
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <div class="ambient-blob blob-primary"></div>
        <div class="ambient-blob blob-secondary"></div>
        <div class="ambient-blob blob-tertiary"></div>
    </div>

    <!-- Glossy Container -->
    <div class="glass-loader-panel relative p-12 rounded-[2.5rem] flex flex-col items-center gap-8 z-10 min-w-[280px]">
        
        <!-- Animated Icon -->
        <div class="relative w-24 h-24 flex items-center justify-center">
            <div class="orbital-ring"></div>
            <div class="orbital-ring orbital-ring-inner"></div>
            
            <div class="w-12 h-12 bg-white/5 rounded-2xl pulse-glow backdrop-blur-md flex items-center justify-center border border-white/20 transform rotate-45">
                <i class="fa-solid fa-graduation-cap text-indigo-200 -rotate-45 text-2xl drop-shadow-[0_0_8px_rgba(165,180,252,0.8)]"></i>
            </div>
        </div>

        <!-- Typography -->
        <div class="text-center space-y-2">
            <h3 class="text-2xl font-black shimmer-gradient-text tracking-[0.15em] uppercase">EdFlow</h3>
            <div class="flex items-center justify-center gap-2">
                <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                <div class="w-1.5 h-1.5 bg-pink-500 rounded-full animate-bounce" style="animation-delay: 0.15s;"></div>
                <div class="w-1.5 h-1.5 bg-sky-500 rounded-full animate-bounce" style="animation-delay: 0.3s;"></div>
                <p class="text-[10px] text-slate-300 font-bold tracking-[0.2em] uppercase ml-1">Loading</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const overlay = document.getElementById('page-transition-overlay');
        const mainContent = document.body;

        // Ensure GSAP is loaded before executing
        if (typeof gsap === 'undefined') return;

        // ENTRANCE ANIMATION (Page Load)
        // Ensure overlay is hidden initially
        gsap.set(overlay, { display: "none", opacity: 0 });

        // Main content fade-in and slide-up
        gsap.from(mainContent, { 
            opacity: 0, 
            y: 20, 
            duration: 0.5, 
            ease: "power2.out", 
            delay: 0.1 
        });

        // EXIT ANIMATION (Link Click Interception)
        const links = document.querySelectorAll('a');
        
        links.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                const target = link.getAttribute('target');
                
                // Conditions to NOT trigger the transition:
                if (
                    !href || 
                    href.startsWith('#') || 
                    href.startsWith('javascript:') || 
                    href.startsWith('mailto:') || 
                    href.startsWith('tel:') || 
                    target === '_blank' || 
                    link.hasAttribute('download') ||
                    e.ctrlKey || e.metaKey || e.shiftKey || e.altKey
                ) {
                    return;
                }

                // Check if it's an internal link
                const isInternal = href.startsWith('/') || href.includes(window.location.origin);
                
                if (isInternal) {
                    e.preventDefault();
                    
                    // Show the overlay
                    gsap.set(overlay, { display: "flex", opacity: 0, y: "0%" });
                    
                    gsap.to(overlay, 
                        { 
                            opacity: 1, 
                            duration: 0.3, 
                            ease: "power2.out",
                            onComplete: () => {
                                // Once the overlay fully covers the screen, redirect
                                window.location.href = href;
                            }
                        }
                    );
                }
            });
        });

        // Handle BFCache (Browser Back/Forward buttons)
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                // If loaded from cache, immediately hide the overlay so it's ready for next click
                gsap.set(overlay, { display: "none", opacity: 0 });
            }
        });
    });
</script>
