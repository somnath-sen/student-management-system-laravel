<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 | Server Error - EdFlow</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: {
                        brand: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 900: '#1e3a8a' }
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                        'float': 'float 6s ease-in-out infinite',
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
                            '50%': { transform: 'translateY(-15px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .bg-grid { background-size: 40px 40px; background-image: linear-gradient(to right, rgba(0,0,0,0.05) 1px, transparent 1px), linear-gradient(to bottom, rgba(0,0,0,0.05) 1px, transparent 1px); }
        .dark .bg-grid { background-image: linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px); }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50 bg-grid dark:bg-gray-900 dark:text-gray-100 flex items-center justify-center min-h-screen overflow-hidden selection:bg-purple-500 selection:text-white">

    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-400 dark:bg-purple-900/40 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-400 dark:bg-indigo-900/40 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    </div>

    <div class="relative z-10 w-full max-w-2xl px-6 py-12 mx-auto text-center">
        
        <div class="animate-float mb-6">
            <h1 class="text-[120px] md:text-[180px] font-extrabold leading-none tracking-tighter text-transparent bg-clip-text bg-gradient-to-br from-purple-600 via-indigo-500 to-purple-400 drop-shadow-xl select-none">
                500
            </h1>
        </div>

        <div class="animate-fade-in" style="animation-delay: 0.2s;">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm mb-6">
                <i class="fa-solid fa-server text-purple-500 animate-pulse"></i>
                <span class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">System Error</span>
            </div>
            
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                We're experiencing technical difficulties.
            </h2>
            
            <p class="text-lg text-gray-500 dark:text-gray-400 mb-10 max-w-lg mx-auto leading-relaxed">
                Something went wrong on our end. Our engineering team has been notified and is working to restore normal operations as quickly as possible.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                
                <button onclick="window.location.reload()" class="px-8 py-3.5 rounded-xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 font-bold text-base hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2 group">
                    <i class="fa-solid fa-rotate-right transform group-hover:rotate-180 transition-transform duration-500"></i> Refresh Page
                </button>

                <a href="{{ url('/') }}" class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold text-base transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                    <i class="fa-solid fa-house"></i> Return Home
                </a>
            </div>
        </div>

        <div class="mt-16 animate-fade-in text-gray-400 dark:text-gray-600 text-sm font-medium" style="animation-delay: 0.4s;">
            EdFlow Campus Management System
        </div>
    </div>

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</body>
</html>