<div id="global-skeleton-loader" class="absolute inset-0 z-[50] bg-[#FDFBF7] p-4 sm:p-6 lg:p-8 transition-opacity duration-500 ease-in-out pointer-events-none">
    <div class="animate-pulse space-y-6 max-w-7xl mx-auto mt-2">
        <!-- Header Skeleton -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div class="space-y-3 w-full md:w-1/3">
                <div class="h-9 bg-slate-200/80 rounded-xl w-3/4 shimmer"></div>
                <div class="h-4 bg-slate-200/80 rounded-md w-1/2 shimmer"></div>
            </div>
            <div class="hidden md:block h-12 bg-slate-200/80 rounded-xl w-32 shimmer"></div>
        </div>
        
        <!-- Cards Skeleton -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="h-36 bg-white/80 border border-slate-100 rounded-[1.5rem] shadow-sm shimmer"></div>
            <div class="h-36 bg-white/80 border border-slate-100 rounded-[1.5rem] shadow-sm shimmer"></div>
            <div class="h-36 bg-white/80 border border-slate-100 rounded-[1.5rem] shadow-sm shimmer"></div>
        </div>
        
        <!-- Content Area Skeleton -->
        <div class="h-[400px] bg-white/80 border border-slate-100 rounded-[1.5rem] shadow-sm shimmer"></div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const skeleton = document.getElementById('global-skeleton-loader');
        const content = document.getElementById('main-page-content');
        
        // Hide actual content immediately before paint
        if (content) {
            content.style.opacity = '0';
            content.style.transition = 'opacity 0.5s ease-out';
        }

        // Wait for page to fully load, then crossfade
        window.addEventListener('load', () => {
            // A tiny artificial delay makes the shimmer feel intentional and premium
            setTimeout(() => {
                if (skeleton) {
                    skeleton.style.opacity = '0';
                    // Remove from DOM after fade finishes
                    setTimeout(() => skeleton.remove(), 500);
                }
                if (content) {
                    content.style.opacity = '1';
                }
            }, 300);
        });
    });
</script>
