<!-- GSAP Core -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<!-- Page Transition Overlay -->
<div id="page-transition-overlay" class="fixed inset-0 z-[9999] bg-slate-900 flex items-center justify-center pointer-events-none" style="transform: translateY(100%);">
    <div class="flex flex-col items-center gap-4">
        <div class="relative w-16 h-16">
            <div class="absolute inset-0 border-4 border-indigo-500/20 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-indigo-500 rounded-full border-t-transparent animate-spin"></div>
        </div>
        <div class="text-white font-bold tracking-widest uppercase text-xs animate-pulse">Loading</div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const overlay = document.getElementById('page-transition-overlay');
        const mainContent = document.body;

        // Ensure GSAP is loaded before executing
        if (typeof gsap === 'undefined') return;

        // ENTRANCE ANIMATION (Page Load)
        // Ensure overlay stays hidden on fresh load
        gsap.set(overlay, { y: "100%" });

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
                    
                    // Show the overlay (slide up from bottom)
                    gsap.fromTo(overlay, 
                        { y: "100%" },
                        { 
                            y: "0%", 
                            duration: 0.4, 
                            ease: "power3.inOut",
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
                gsap.set(overlay, { y: "100%" });
            }
        });
    });
</script>
