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
<body class="font-sans antialiased text-gray-900 bg-gray-50 bg-grid dark:bg-gray-900 dark:text-gray-100 selection:bg-brand-500 selection:text-white">

    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-300 dark:bg-purple-900 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-yellow-300 dark:bg-blue-900 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-brand-300 dark:bg-brand-900 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
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

                    <button onclick="toggleCustomModal('loginModal')" class="px-6 py-2 rounded-full bg-gray-900 dark:bg-white dark:text-gray-900 text-white text-sm font-bold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        Log In
                    </button>
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

    <div id="mobileMenu" class="fixed inset-0 z-40 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl transform translate-x-full transition-transform duration-500 ease-in-out md:hidden flex flex-col pt-28 px-8 pb-8 overflow-y-auto">
        <div class="flex flex-col space-y-6 flex-1 text-center mt-8">
            <a href="#features" class="mobile-link text-3xl font-bold text-gray-900 dark:text-white hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Features</a>
            <a href="#testimonials" class="mobile-link text-3xl font-bold text-gray-900 dark:text-white hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Testimonials</a>
            <a href="#stats" class="mobile-link text-3xl font-bold text-gray-900 dark:text-white hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Analytics</a>
            <a href="#faq" class="mobile-link text-3xl font-bold text-gray-900 dark:text-white hover:text-brand-600 dark:hover:text-brand-400 transition-colors">FAQ</a>
        </div>
        
        <div class="mt-auto pt-8 flex flex-col gap-4">
            <button onclick="toggleRegisterModal(); toggleMobileMenu();" class="w-full py-4 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white font-bold text-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-all border border-gray-200 dark:border-gray-700 shadow-sm">
                Register
            </button>
            <button onclick="toggleCustomModal('loginModal'); toggleMobileMenu();" class="w-full py-4 rounded-full bg-brand-600 text-white font-bold text-lg hover:bg-brand-700 transition-all shadow-lg shadow-brand-500/30">
                Log In
            </button>
        </div>
    </div>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm mb-8 animate-fade-in">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">v2.0 is now live</span>
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-8 animate-fade-in" style="animation-delay: 0.1s;">
                Manage your task <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-purple-600">with intelligence.</span>
            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 dark:text-gray-400 mb-10 animate-fade-in" style="animation-delay: 0.2s;">
                Streamline admissions, attendance, fees, and examinations in one unified cloud platform designed for modern institutions.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in" style="animation-delay: 0.3s;">
                <button onclick="toggleRegisterModal()" class="px-8 py-4 rounded-full bg-brand-600 text-white font-bold text-lg hover:bg-brand-700 transition-all shadow-xl shadow-brand-500/30 hover:-translate-y-1">
                    Apply Now
                </button>
                <a href="#features" class="px-8 py-4 rounded-full bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 font-bold text-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                    Explore Features
                </a>
            </div>

            <div class="mt-16 relative mx-auto max-w-5xl animate-fade-in" style="animation-delay: 0.5s;">
                <div class="rounded-2xl bg-gray-900 p-2 shadow-2xl animate-float">
                    <div class="rounded-xl bg-gray-800 overflow-hidden relative aspect-[16/9] border border-gray-700">
                        <div class="absolute inset-0 bg-gray-800 flex flex-col">
                            <div class="h-12 border-b border-gray-700 flex items-center px-4 gap-2 bg-gray-900">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <div class="flex-1 p-8 grid grid-cols-4 gap-6 bg-gray-800">
                                <div class="col-span-1 bg-gray-700/50 rounded-lg h-full animate-pulse"></div>
                                <div class="col-span-3 grid grid-rows-3 gap-6">
                                    <div class="row-span-1 grid grid-cols-3 gap-6">
                                        <div class="bg-gray-700/50 rounded-lg h-32 animate-pulse"></div>
                                        <div class="bg-gray-700/50 rounded-lg h-32 animate-pulse" style="animation-delay: 100ms"></div>
                                        <div class="bg-gray-700/50 rounded-lg h-32 animate-pulse" style="animation-delay: 200ms"></div>
                                    </div>
                                    <div class="row-span-2 bg-gray-700/50 rounded-lg h-full animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="relative bg-gradient-to-r from-brand-700 via-purple-700 to-brand-700 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-4 overflow-hidden border-y border-brand-500/30 shadow-lg shadow-brand-500/20 group cursor-pointer">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse-glow pointer-events-none"></div>
        <div class="flex animate-marquee whitespace-nowrap group-hover:[animation-play-state:paused]">
            <div class="flex items-center gap-12 mx-4">
                <div class="flex items-center gap-3">
                    <span class="text-yellow-400 text-xl animate-bounce">🔔</span>
                    <span class="text-white font-bold text-lg uppercase tracking-wide">Admissions Open for 2026-2027</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 bg-white rounded-full"></span>
                    <span class="text-gray-100 font-medium">Limited Seats Available</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 bg-white rounded-full"></span>
                    <span class="text-gray-100 font-medium">Scholarships up to 50%</span>
                </div>
                <button onclick="toggleRegisterModal()" class="px-6 py-1.5 bg-yellow-400 text-gray-900 rounded-full font-bold text-sm hover:bg-yellow-300 transition-colors shadow-md">
                    Apply Now <i class="fa-solid fa-arrow-right ml-1"></i>
                </button>
            </div>
            <div class="flex items-center gap-12 mx-4">
                <div class="flex items-center gap-3">
                    <span class="text-yellow-400 text-xl animate-bounce">🔔</span>
                    <span class="text-white font-bold text-lg uppercase tracking-wide">Admissions Open for 2026-2027</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 bg-white rounded-full"></span>
                    <span class="text-gray-100 font-medium">Limited Seats Available</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 bg-white rounded-full"></span>
                    <span class="text-gray-100 font-medium">Scholarships up to 50%</span>
                </div>
                <button onclick="toggleRegisterModal()" class="px-6 py-1.5 bg-yellow-400 text-gray-900 rounded-full font-bold text-sm hover:bg-yellow-300 transition-colors shadow-md">
                    Apply Now <i class="fa-solid fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>
    </div>

    <section id="features" class="py-24 bg-white dark:bg-gray-800 transition-colors duration-300">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">Everything you need</h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Powerful modules integrated into a single ecosystem.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                
                <div class="group p-6 rounded-2xl bg-gray-50 dark:bg-gray-900 hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-blue-200 dark:hover:border-gray-600 hover:-translate-y-1">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400 mb-5 group-hover:scale-110 transition-transform shadow-sm">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Performance Analytics</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Real-time insights into student performance, course trends, and institutional health.</p>
                </div>

                <div class="group p-6 rounded-2xl bg-gray-50 dark:bg-gray-900 hover:bg-indigo-50 dark:hover:bg-gray-700 transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-indigo-200 dark:hover:border-gray-600 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-indigo-500/10 rounded-full blur-xl group-hover:bg-indigo-500/20 transition-all"></div>
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center text-indigo-600 dark:text-indigo-400 mb-5 group-hover:scale-110 transition-transform shadow-sm">
                        <i class="fa-solid fa-id-card-clip text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Smart QR Identity</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Instantly generate scannable digital ID cards for every student containing vital emergency details.</p>
                </div>

                <div class="group p-6 rounded-2xl bg-gray-50 dark:bg-gray-900 hover:bg-rose-50 dark:hover:bg-gray-700 transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-rose-200 dark:hover:border-gray-600 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute right-4 top-4">
                        <span class="flex h-2.5 w-2.5 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
                        </span>
                    </div>
                    <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center text-rose-600 dark:text-rose-400 mb-5 group-hover:scale-110 transition-transform shadow-sm">
                        <i class="fa-solid fa-satellite-dish text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Live Family Tracker</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Secure GPS location pinging and interactive maps to ensure student safety on and off campus.</p>
                </div>

                <div class="group p-6 rounded-2xl bg-gray-50 dark:bg-gray-900 hover:bg-purple-50 dark:hover:bg-gray-700 transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-purple-200 dark:hover:border-gray-600 hover:-translate-y-1">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center text-purple-600 dark:text-purple-400 mb-5 group-hover:scale-110 transition-transform shadow-sm">
                        <i class="fa-solid fa-clipboard-user text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Emergency Assistance</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Quick response protocols and real-time incident tracking for complete campus security.</p>
                </div>

                <div class="group p-6 rounded-2xl bg-gray-50 dark:bg-gray-900 hover:bg-green-50 dark:hover:bg-gray-700 transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-green-200 dark:hover:border-gray-600 hover:-translate-y-1">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400 mb-5 group-hover:scale-110 transition-transform shadow-sm">
                        <i class="fa-solid fa-robot text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">StudyAI Integration</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">Next-gen Gemini-powered conversational agents to assist students with real-time academic queries.</p>
                </div>

            </div>
        </div>
    </section>

    <section id="testimonials" class="py-24 bg-gray-50 dark:bg-gray-900 overflow-hidden relative border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16 relative z-10">
            <h2 class="text-brand-600 dark:text-brand-400 font-bold tracking-wide uppercase text-sm mb-2">Wall of Love</h2>
            <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Trusted by educators globally</h3>
            <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">See how EdFlow is transforming campuses everywhere.</p>
        </div>

        <div class="relative flex overflow-x-hidden group pb-8 hide-scrollbar">
            <div class="absolute top-0 bottom-0 left-0 w-24 md:w-48 bg-gradient-to-r from-gray-50 dark:from-gray-900 to-transparent z-20 pointer-events-none"></div>
            <div class="absolute top-0 bottom-0 right-0 w-24 md:w-48 bg-gradient-to-l from-gray-50 dark:from-gray-900 to-transparent z-20 pointer-events-none"></div>

            <div class="flex animate-marquee-slow group-hover:[animation-play-state:paused] shrink-0 gap-6 px-3">
                <div class="w-80 md:w-96 whitespace-normal p-8 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex text-yellow-400 mb-4 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic leading-relaxed">
                        "EdFlow completely removed the friction from our administrative tasks. The AI integrations alone save our staff dozens of hours every week."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-brand-100 dark:bg-brand-900 text-brand-600 dark:text-brand-300 flex items-center justify-center font-bold text-lg">SJ</div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">Sarah Jenkins</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Principal, Westfield High</p>
                        </div>
                    </div>
                </div>

                <div class="w-80 md:w-96 whitespace-normal p-8 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex text-yellow-400 mb-4 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic leading-relaxed">
                        "The analytics dashboard is a game-changer. We can now accurately track student performance trends and intervene before issues arise."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-300 flex items-center justify-center font-bold text-lg">DR</div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">Dr. Robert Chen</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Dean of Academics</p>
                        </div>
                    </div>
                </div>

                <div class="w-80 md:w-96 whitespace-normal p-8 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex text-yellow-400 mb-4 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic leading-relaxed">
                        "As a student, having all my attendance, fees, and examination results in one clean interface makes my college life so much less stressful."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 flex items-center justify-center font-bold text-lg">MK</div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">Maya Patel</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Computer Science Student</p>
                        </div>
                    </div>
                </div>

                <div class="w-80 md:w-96 whitespace-normal p-8 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex text-yellow-400 mb-4 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic leading-relaxed">
                        "Deployment was seamless. The ability to manage thousands of student records securely on the cloud is exactly what our IT team needed."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 flex items-center justify-center font-bold text-lg">JD</div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">James Doe</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">IT Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex animate-marquee-slow group-hover:[animation-play-state:paused] shrink-0 gap-6 px-3">
                <div class="w-80 md:w-96 whitespace-normal p-8 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex text-yellow-400 mb-4 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic leading-relaxed">
                        "EdFlow completely removed the friction from our administrative tasks. The AI integrations alone save our staff dozens of hours every week."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-brand-100 dark:bg-brand-900 text-brand-600 dark:text-brand-300 flex items-center justify-center font-bold text-lg">SJ</div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">Sarah Jenkins</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Principal, Westfield High</p>
                        </div>
                    </div>
                </div>

                <div class="w-80 md:w-96 whitespace-normal p-8 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex text-yellow-400 mb-4 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic leading-relaxed">
                        "The analytics dashboard is a game-changer. We can now accurately track student performance trends and intervene before issues arise."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-300 flex items-center justify-center font-bold text-lg">DR</div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">Dr. Robert Chen</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Dean of Academics</p>
                        </div>
                    </div>
                </div>

                <div class="w-80 md:w-96 whitespace-normal p-8 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex text-yellow-400 mb-4 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic leading-relaxed">
                        "As a student, having all my attendance, fees, and examination results in one clean interface makes my college life so much less stressful."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300 flex items-center justify-center font-bold text-lg">MK</div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">Maya Patel</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Computer Science Student</p>
                        </div>
                    </div>
                </div>

                <div class="w-80 md:w-96 whitespace-normal p-8 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex text-yellow-400 mb-4 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic leading-relaxed">
                        "Deployment was seamless. The ability to manage thousands of student records securely on the cloud is exactly what our IT team needed."
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 flex items-center justify-center font-bold text-lg">JD</div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">James Doe</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">IT Administrator</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section id="stats" class="py-20 bg-gray-900 dark:bg-black text-white border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-800">
                <div>
                    <div class="text-4xl font-bold text-brand-500 mb-2"><span class="count-up" data-target="50">0</span>k+</div>
                    <div class="text-gray-400">Students Managed</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-brand-500 mb-2"><span class="count-up" data-target="120">0</span>+</div>
                    <div class="text-gray-400">Institutions</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-brand-500 mb-2"><span class="count-up" data-target="99.9">0</span>%</div>
                    <div class="text-gray-400">Uptime</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-brand-500 mb-2"><span class="count-up" data-target="24">0</span>/7</div>
                    <div class="text-gray-400">Live Support</div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-24 bg-white dark:bg-gray-800 transition-colors duration-300 border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-brand-600 dark:text-brand-400 font-bold tracking-wide uppercase text-sm mb-2">Got Questions?</h2>
                <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Frequently Asked Questions</h3>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Everything you need to know about the product and billing.</p>
            </div>
            
            <div class="space-y-4">
                <div class="border border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50 dark:bg-gray-900 hover:border-brand-500 dark:hover:border-brand-500 transition-colors duration-300">
                    <button class="faq-btn w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none group">
                        <span class="font-semibold text-gray-900 dark:text-white group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">What exactly is EdFlow?</span>
                        <div class="w-8 h-8 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center border border-gray-200 dark:border-gray-700 shadow-sm">
                            <i class="fa-solid fa-chevron-down text-gray-500 transition-transform duration-300 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        <div class="pb-5">
                            EdFlow is an all-in-one cloud-based Smart Campus Management system. It provides dedicated portals for Administrators, Teachers, and Students to manage everything from academic results and attendance to admissions and internal communications securely.
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50 dark:bg-gray-900 hover:border-brand-500 dark:hover:border-brand-500 transition-colors duration-300">
                    <button class="faq-btn w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none group">
                        <span class="font-semibold text-gray-900 dark:text-white group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">Is our institutional data secure?</span>
                        <div class="w-8 h-8 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center border border-gray-200 dark:border-gray-700 shadow-sm">
                            <i class="fa-solid fa-chevron-down text-gray-500 transition-transform duration-300 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        <div class="pb-5">
                            Absolutely. EdFlow uses industry-standard encryption protocols. We feature role-based access control (RBAC), meaning a student can never see administrative settings, and a teacher can only modify grades for their assigned subjects. Passwords are automatically generated and securely hashed.
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50 dark:bg-gray-900 hover:border-brand-500 dark:hover:border-brand-500 transition-colors duration-300">
                    <button class="faq-btn w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none group">
                        <span class="font-semibold text-gray-900 dark:text-white group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">How does the integrated AI Assistant work?</span>
                        <div class="w-8 h-8 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center border border-gray-200 dark:border-gray-700 shadow-sm">
                            <i class="fa-solid fa-chevron-down text-gray-500 transition-transform duration-300 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        <div class="pb-5">
                            Our StudyAI feature utilizes the powerful Gemini API. It acts as an on-demand tutor for students to ask academic questions, summarize notes, or prepare for exams. For teachers, it can help draft lesson plans and generate quiz questions instantly inside the portal.
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50 dark:bg-gray-900 hover:border-brand-500 dark:hover:border-brand-500 transition-colors duration-300">
                    <button class="faq-btn w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none group">
                        <span class="font-semibold text-gray-900 dark:text-white group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">Do you support custom integrations?</span>
                        <div class="w-8 h-8 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center border border-gray-200 dark:border-gray-700 shadow-sm">
                            <i class="fa-solid fa-chevron-down text-gray-500 transition-transform duration-300 text-sm"></i>
                        </div>
                    </button>
                    <div class="faq-content px-6 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        <div class="pb-5">
                            Yes! Our admissions portal already seamlessly integrates with Google Sheets CRM so your administration team can review applicant data in real-time without leaving their familiar workflow. We offer additional API webhooks upon request.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact" class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 pt-20 pb-10 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div class="space-y-6">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center text-white">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <span class="font-bold text-2xl tracking-tight text-gray-900 dark:text-white">EdFlow<span class="text-brand-600">.</span></span>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        The all-in-one campus management solution. We help educational institutions streamline operations and focus on delivering quality education.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-brand-600 hover:text-white dark:hover:bg-brand-600 dark:hover:text-white transition-all transform hover:-translate-y-1"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/in/thesomishere/" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-brand-600 hover:text-white dark:hover:bg-brand-600 dark:hover:text-white transition-all transform hover:-translate-y-1"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="https://github.com/somnath-sen" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-brand-600 hover:text-white dark:hover:bg-brand-600 dark:hover:text-white transition-all transform hover:-translate-y-1"><i class="fa-brands fa-github"></i></a>
                        <a href="https://www.instagram.com/thesomishere/" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-brand-600 hover:text-white dark:hover:bg-brand-600 dark:hover:text-white transition-all transform hover:-translate-y-1"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-6">Product</h4>
                    <ul class="space-y-3 text-sm text-gray-500 dark:text-gray-400">
                        <li><a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Overview</a></li>
                        <li><a href="#features" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Features</a></li>
                        <li><a href="#testimonials" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Testimonials</a></li>
                        <li><a href="#faq" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-6">Company</h4>
                    <ul class="space-y-3 text-sm text-gray-500 dark:text-gray-400">
                        <li><button onclick="toggleCustomModal('aboutModal')" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors cursor-pointer text-left focus:outline-none">About Us</button></li>
                        <li><button onclick="toggleCustomModal('careersModal')" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors cursor-pointer text-left focus:outline-none">Careers</button></li>
                        <li><button onclick="toggleCustomModal('contactDetailsModal')" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors cursor-pointer text-left focus:outline-none">Contact</button></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-6">Stay Updated</h4>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">Subscribe to our newsletter for the latest updates.</p>
                    <form id="newsletterForm" class="space-y-3">
                        <div class="relative">
                            <input type="email" id="newsletterEmail" name="email" placeholder="Enter your email" required class="w-full pl-4 pr-10 py-3 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 dark:text-white transition-all">
                        </div>
                        <button type="submit" id="subscribeBtn" class="w-full py-3 px-4 bg-brand-600 hover:bg-brand-700 text-white rounded-lg text-sm font-semibold transition-all shadow-lg shadow-brand-500/30 flex items-center justify-center">
                            <span>Subscribe</span>
                            <i class="fa-solid fa-spinner fa-spin ml-2 hidden" id="btnLoader"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-400 text-center md:text-left">&copy; {{ date('Y') }} EdFlow Inc. All rights reserved.</p>
                <div class="flex space-x-6 text-sm text-gray-500 dark:text-gray-400">
                    <button onclick="toggleCustomModal('privacyModal')" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors focus:outline-none">Privacy Policy</button>
                    <button onclick="toggleCustomModal('termsModal')" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors focus:outline-none">Terms of Service</button>
                </div>
            </div>

            <div class="mt-8 text-center border-t border-gray-100 dark:border-gray-800 pt-8 pb-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center justify-center gap-1">
                    Design & Developed by 
                    <span class="inline-block animate-pulse text-red-500 mx-1 drop-shadow-md">❤️</span> 
                    <a href="https://github.com/somnath-sen" target="_blank" class="font-bold bg-gradient-to-r from-brand-600 via-purple-500 to-brand-600 bg-clip-text text-transparent hover:from-brand-500 hover:to-purple-400 transition-all duration-300 animate-text-shimmer bg-[length:200%_auto]">
                        Somnath Sen
                    </a>
                </p>
            </div>
        </div>
    </footer>

    <div id="loginModal" class="fixed inset-0 z-[100] hidden custom-modal">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('loginModal')"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-100 border border-gray-100 dark:border-gray-700 pointer-events-auto">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome Back</h2>
                        <button onclick="toggleCustomModal('loginModal')" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 mb-8">Select your account type to continue.</p>
                    
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
            <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-100 border border-gray-100 dark:border-gray-700 pointer-events-auto">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Join EdFlow</h2>
                        <button onclick="toggleCustomModal('registerModal')" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 mb-8">Select your application type to submit a registration request.</p>
                    
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
            <div class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-100 border border-gray-100 dark:border-gray-700 pointer-events-auto">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-brand-100 dark:bg-brand-900/50 text-brand-600 dark:text-brand-400 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-building text-lg"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">About EdFlow</h2>
                        </div>
                        <button onclick="toggleCustomModal('aboutModal')" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
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
            <div class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-100 border border-gray-100 dark:border-gray-700 pointer-events-auto">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-briefcase text-lg"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Join Our Team</h2>
                        </div>
                        <button onclick="toggleCustomModal('careersModal')" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 mb-6 text-sm">We are always looking for passionate individuals to build the future of education technology.</p>
                    
                    <div class="space-y-3">
                        <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-purple-500 transition-colors group cursor-not-allowed opacity-80">
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
            <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-100 border border-gray-100 dark:border-gray-700 pointer-events-auto">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Get in Touch</h2>
                        <button onclick="toggleCustomModal('contactDetailsModal')" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    
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
            <div class="bg-white dark:bg-gray-800 w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-100 border border-gray-100 dark:border-gray-700 pointer-events-auto flex flex-col max-h-[85vh]">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-brand-100 dark:bg-brand-900/50 text-brand-600 dark:text-brand-400 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-shield-halved text-lg"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Privacy Policy</h2>
                    </div>
                    <button onclick="toggleCustomModal('privacyModal')" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none w-8 h-8 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
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
                <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-right">
                    <button onclick="toggleCustomModal('privacyModal')" class="px-6 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-lg font-semibold transition-colors shadow-sm">I Understand</button>
                </div>
            </div>
        </div>
    </div>

    <div id="termsModal" class="fixed inset-0 z-[100] hidden custom-modal">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleCustomModal('termsModal')"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white dark:bg-gray-800 w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-100 border border-gray-100 dark:border-gray-700 pointer-events-auto flex flex-col max-h-[85vh]">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-file-contract text-lg"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Terms of Service</h2>
                    </div>
                    <button onclick="toggleCustomModal('termsModal')" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none w-8 h-8 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
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
                <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-right">
                    <button onclick="toggleCustomModal('termsModal')" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition-colors shadow-sm">Accept Terms</button>
                </div>
            </div>
        </div>
    </div>

    <div id="successModal" class="fixed inset-0 z-[110] hidden custom-modal">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-sm w-full text-center transform scale-90 animate-scale-in border border-green-100 dark:border-green-900 pointer-events-auto">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-check text-2xl text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Successfully Subscribed!</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6 text-sm">Thank you for joining our newsletter. We'll keep you updated.</p>
                <button onclick="closeSuccessModal()" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-lg font-semibold transition-colors">
                    Awesome
                </button>
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
            if(!isMobileMenuOpen) {
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

    </script>
</body>
</html>