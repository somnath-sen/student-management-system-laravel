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
        body, nav, div, section, footer, input, button {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Pause Marquee on Hover */
        .hover\:pause-marquee:hover .animate-marquee {
            animation-play-state: paused;
        }
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

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Features</a>
                    <a href="#stats" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Analytics</a>
                    <a href="#contact" class="text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">Support</a>
                    
                    <button id="theme-toggle" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-all">
                        <i class="fa-solid fa-moon text-lg dark:hidden"></i> 
                        <i class="fa-solid fa-sun text-lg hidden dark:block text-yellow-400"></i> 
                    </button>

                    <button onclick="toggleModal()" class="px-5 py-2.5 rounded-full bg-gray-900 dark:bg-white dark:text-gray-900 text-white text-sm font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        Log In
                    </button>
                </div>

                <div class="md:hidden flex items-center gap-4">
                     <button id="theme-toggle-mobile" class="p-2 rounded-full text-gray-500 dark:text-gray-400">
                        <i class="fa-solid fa-moon text-lg dark:hidden"></i>
                        <i class="fa-solid fa-sun text-lg hidden dark:block text-yellow-400"></i>
                    </button>
                    <button class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

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
                <button onclick="toggleModal()" class="px-8 py-4 rounded-full bg-brand-600 text-white font-bold text-lg hover:bg-brand-700 transition-all shadow-xl shadow-brand-500/30 hover:-translate-y-1">
                    Get Started Free
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

    <div class="relative bg-gradient-to-r from-brand-700 via-purple-700 to-brand-700 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-4 overflow-hidden border-y border-brand-500/30 shadow-lg shadow-brand-500/20 hover:pause-marquee group cursor-pointer">
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
                <a href="#" class="px-6 py-1.5 bg-yellow-400 text-gray-900 rounded-full font-bold text-sm hover:bg-yellow-300 transition-colors shadow-md">
                    Apply Now <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
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
                <a href="#" class="px-6 py-1.5 bg-yellow-400 text-gray-900 rounded-full font-bold text-sm hover:bg-yellow-300 transition-colors shadow-md">
                    Apply Now <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
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
                <a href="#" class="px-6 py-1.5 bg-yellow-400 text-gray-900 rounded-full font-bold text-sm hover:bg-yellow-300 transition-colors shadow-md">
                    Apply Now <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <section id="features" class="py-24 bg-white dark:bg-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white sm:text-4xl">Everything you need</h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Powerful modules integrated into a single ecosystem.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group p-8 rounded-2xl bg-gray-50 dark:bg-gray-900 hover:bg-brand-50 dark:hover:bg-gray-700 transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-brand-100 dark:hover:border-gray-600 hover:-translate-y-1">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Performance Analytics</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">Real-time insights into student performance, course trends, and institutional health.</p>
                </div>

                <div class="group p-8 rounded-2xl bg-gray-50 dark:bg-gray-900 hover:bg-purple-50 dark:hover:bg-gray-700 transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-purple-100 dark:hover:border-gray-600 hover:-translate-y-1">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center text-purple-600 dark:text-purple-400 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-clipboard-user text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Emergency Assistance</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">Quick response protocols and real-time incident tracking for campus safety.</p>
                </div>

                <div class="group p-8 rounded-2xl bg-gray-50 dark:bg-gray-900 hover:bg-green-50 dark:hover:bg-gray-700 transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-green-100 dark:hover:border-gray-600 hover:-translate-y-1">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-chart-pie text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">AI Chatbots</h3>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">AI-powered conversational agents to assist students with queries and support.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="stats" class="py-20 bg-gray-900 dark:bg-black text-white border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-800">
                <div>
                    <div class="text-4xl font-bold text-brand-500 mb-2">
                        <span class="count-up" data-target="50">0</span>k+
                    </div>
                    <div class="text-gray-400">Students Managed</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-brand-500 mb-2">
                        <span class="count-up" data-target="120">0</span>+
                    </div>
                    <div class="text-gray-400">Institutions</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-brand-500 mb-2">
                        <span class="count-up" data-target="99.9">0</span>%
                    </div>
                    <div class="text-gray-400">Uptime</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-brand-500 mb-2">
                        <span class="count-up" data-target="24">0</span>/7
                    </div>
                    <div class="text-gray-400">Live Support</div>
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
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-brand-600 hover:text-white dark:hover:bg-brand-600 dark:hover:text-white transition-all transform hover:-translate-y-1">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/thesomishere/" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-brand-600 hover:text-white dark:hover:bg-brand-600 dark:hover:text-white transition-all transform hover:-translate-y-1">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <a href="https://github.com/somnath-sen" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-brand-600 hover:text-white dark:hover:bg-brand-600 dark:hover:text-white transition-all transform hover:-translate-y-1">
                            <i class="fa-brands fa-github"></i>
                        </a>
                        <a href="https://www.instagram.com/thesomishere/" target="_blank" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-brand-600 hover:text-white dark:hover:bg-brand-600 dark:hover:text-white transition-all transform hover:-translate-y-1">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-6">Product</h4>
                    <ul class="space-y-3 text-sm text-gray-500 dark:text-gray-400">
                        <li><a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Overview</a></li>
                        <li><a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Features</a></li>
                        <li><a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Solutions</a></li>
                        <li><a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Pricing</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-6">Company</h4>
                    <ul class="space-y-3 text-sm text-gray-500 dark:text-gray-400">
                        <li><a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Contact</a></li>
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
                    <a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Terms of Service</a>
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

    <div id="loginModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleModal()"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-100 border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome Back</h2>
                        <button onclick="toggleModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 mb-8">Select your account type to continue.</p>
                    
                    <div class="space-y-4">
                        <a href="{{ route('login') }}?type=student" class="flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-brand-500 dark:hover:border-brand-500 hover:bg-brand-50 dark:hover:bg-gray-700 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-brand-100 dark:bg-brand-900/50 text-brand-600 dark:text-brand-400 flex items-center justify-center mr-4 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Student</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Access course & results</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-auto text-gray-300 dark:text-gray-600 group-hover:text-brand-500"></i>
                        </a>
                        <a href="{{ route('login') }}?type=teacher" class="flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-purple-500 dark:hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-gray-700 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 flex items-center justify-center mr-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">Teacher</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Manage class & attendance</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-auto text-gray-300 dark:text-gray-600 group-hover:text-purple-500"></i>
                        </a>
                        <a href="{{ route('login') }}?type=admin" class="flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-gray-900 dark:hover:border-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center mr-4 group-hover:bg-gray-900 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
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

    <div id="successModal" class="fixed inset-0 z-[110] hidden">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-sm w-full text-center transform scale-90 animate-scale-in border border-green-100 dark:border-green-900">
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
        // Use window.onload to ensure the bot script has run
        window.addEventListener('load', function() {
            // Helper to wait until botpress object is ready
            const checkForBot = setInterval(() => {
                if (window.botpressWebChat) {
                    clearInterval(checkForBot);
                    
                    // Force update the configuration
                    window.botpressWebChat.mergeConfig({
                        botName: 'EdFlow Assistant', // Customized Name
                        botConversationDescription: 'Smart Campus Support',
                        themeColor: '#2563eb', // Matches your brand
                        showPoweredBy: false
                    });
                }
            }, 500); // Check every 500ms
        });
    </script>

    <script>
        // Modal Logic
        const modal = document.getElementById('loginModal');
        
        function toggleModal() {
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; 
            } else {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
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

        /* =========================================================
           NEWSLETTER LOGIC (Google Sheets)
           =========================================================
        */
        const form = document.getElementById('newsletterForm');
        // Your Google Apps Script Web App URL
        const scriptURL = 'https://script.google.com/macros/s/AKfycbyzMyhmjvyiDU1n8oZGtKIlzbEFeXNgXfJDemrfxcyUW3NF-Q0qcJ9qWWIXhmiV2ZAV1w/exec'; 
        const successModal = document.getElementById('successModal');
        const btnLoader = document.getElementById('btnLoader');
        const subscribeBtn = document.getElementById('subscribeBtn');

        form.addEventListener('submit', e => {
            e.preventDefault();
            
            subscribeBtn.disabled = true;
            subscribeBtn.classList.add('opacity-75');
            btnLoader.classList.remove('hidden');

            let requestBody = new FormData(form);
            fetch(scriptURL, { method: 'POST', body: requestBody})
                .then(response => {
                    form.reset();
                    successModal.classList.remove('hidden');
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

        function closeSuccessModal() {
            successModal.classList.add('hidden');
        }

        /* =========================================================
           NUMBER COUNTER ANIMATION
           =========================================================
        */
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