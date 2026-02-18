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
                        'fade-in': 'fadeIn 0.5s ease-out forwards',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .glass-dark {
            background: rgba(17, 24, 39, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        /* Grid Background Pattern */
        .bg-grid {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(0,0,0,0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(0,0,0,0.05) 1px, transparent 1px);
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 bg-grid selection:bg-brand-500 selection:text-white">

    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-yellow-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-brand-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>

    <nav class="fixed w-full z-50 transition-all duration-300 top-0" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                    <div class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-brand-500/30">
                        <i class="fa-solid fa-graduation-cap text-xl"></i>
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900">EdFlow<span class="text-brand-600">.</span></span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Features</a>
                    <a href="#stats" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Analytics</a>
                    <a href="#contact" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Support</a>
                    <button onclick="toggleModal()" class="px-5 py-2.5 rounded-full bg-gray-900 text-white text-sm font-semibold hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                        Log In
                    </button>
                </div>

                <div class="md:hidden">
                    <button class="text-gray-500 hover:text-gray-900">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-gray-200 shadow-sm mb-8 animate-fade-in">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                <span class="text-sm font-medium text-gray-600">v2.0 is now live</span>
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 mb-8 animate-fade-in" style="animation-delay: 0.1s;">
                Manage your task <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-purple-600">with intelligence.</span>
            </h1>

            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 mb-10 animate-fade-in" style="animation-delay: 0.2s;">
                Streamline admissions, attendance, fees, and examinations in one unified cloud platform designed for modern institutions.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in" style="animation-delay: 0.3s;">
                <button onclick="toggleModal()" class="px-8 py-4 rounded-full bg-brand-600 text-white font-bold text-lg hover:bg-brand-700 transition-all shadow-xl shadow-brand-500/30 hover:-translate-y-1">
                    Get Started Free
                </button>
                <a href="#features" class="px-8 py-4 rounded-full bg-white text-gray-700 border border-gray-200 font-bold text-lg hover:bg-gray-50 transition-all hover:border-gray-300">
                    Explore Features
                </a>
            </div>

            <div class="mt-16 relative mx-auto max-w-5xl animate-fade-in" style="animation-delay: 0.5s;">
                <div class="rounded-2xl bg-gray-900 p-2 shadow-2xl">
                    <div class="rounded-xl bg-gray-800 overflow-hidden relative aspect-[16/9]">
                        <div class="absolute inset-0 bg-gray-800 flex flex-col">
                            <div class="h-12 border-b border-gray-700 flex items-center px-4 gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <div class="flex-1 p-8 grid grid-cols-4 gap-6">
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

    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Everything you need</h2>
                <p class="mt-4 text-lg text-gray-500">Powerful modules integrated into a single ecosystem.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group p-8 rounded-2xl bg-gray-50 hover:bg-brand-50 transition-colors duration-300 border border-gray-100 hover:border-brand-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Performance Analytics</h3>
                    <p class="text-gray-500 leading-relaxed">Real-time insights into student performance, course trends, and institutional health.</p>
                </div>

                <div class="group p-8 rounded-2xl bg-gray-50 hover:bg-purple-50 transition-colors duration-300 border border-gray-100 hover:border-purple-100">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-clipboard-user text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Emergency Management</h3>
                    <p class="text-gray-500 leading-relaxed">Quick response protocols and real-time incident tracking for campus safety.</p>
                </div>

                <div class="group p-8 rounded-2xl bg-gray-50 hover:bg-green-50 transition-colors duration-300 border border-gray-100 hover:border-green-100">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-chart-pie text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">AI Chatbots</h3>
                    <p class="text-gray-500 leading-relaxed">AI-powered conversational agents to assist students with queries, course information, and support.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="stats" class="py-20 bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-800">
                <div>
                    <div class="text-4xl font-bold text-brand-500 mb-2">50k+</div>
                    <div class="text-gray-400">Students Managed</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-brand-500 mb-2">120+</div>
                    <div class="text-gray-400">Institutions</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-brand-500 mb-2">99.9%</div>
                    <div class="text-gray-400">Uptime</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-brand-500 mb-2">24/7</div>
                    <div class="text-gray-400">Live Support</div>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact" class="bg-white border-t border-gray-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <span class="font-bold text-2xl tracking-tight text-gray-900">EdFlow<span class="text-brand-600">.</span></span>
                    <p class="mt-4 text-gray-500 max-w-sm">
                        Building the future of education technology. Empowering institutions to focus on what matters most - education.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Platform</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-brand-600">Features</a></li>
                        <li><a href="#" class="hover:text-brand-600">Pricing</a></li>
                        <li><a href="#" class="hover:text-brand-600">Demo</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Legal</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-brand-600">Privacy</a></li>
                        <li><a href="#" class="hover:text-brand-600">Terms</a></li>
                        <li><a href="#" class="hover:text-brand-600">Security</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-400">&copy; {{ date('Y') }} EdFlow Inc. All rights reserved.</p>
                <div class="flex space-x-6 text-gray-400">
                    <a href="#" class="hover:text-brand-600"><i class="fa-brands fa-twitter text-xl"></i></a>
                    <a href="#" class="hover:text-brand-600"><i class="fa-brands fa-linkedin text-xl"></i></a>
                    <a href="#" class="hover:text-brand-600"><i class="fa-brands fa-github text-xl"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <div id="loginModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleModal()"></div>
        
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-100">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
                        <button onclick="toggleModal()" class="text-gray-400 hover:text-gray-500">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    <p class="text-gray-500 mb-8">Select your account type to continue.</p>
                    
                    <div class="space-y-4">
                        <a href="{{ route('login') }}?type=student" class="flex items-center p-4 rounded-xl border border-gray-200 hover:border-brand-500 hover:bg-brand-50 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center mr-4 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Student</h3>
                                <p class="text-xs text-gray-500">Access course & results</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-auto text-gray-300 group-hover:text-brand-500"></i>
                        </a>

                        <a href="{{ route('login') }}?type=teacher" class="flex items-center p-4 rounded-xl border border-gray-200 hover:border-purple-500 hover:bg-purple-50 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mr-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-chalkboard-user"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Teacher</h3>
                                <p class="text-xs text-gray-500">Manage class & attendance</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-auto text-gray-300 group-hover:text-purple-500"></i>
                        </a>

                        <a href="{{ route('login') }}?type=admin" class="flex items-center p-4 rounded-xl border border-gray-200 hover:border-gray-900 hover:bg-gray-50 transition-all group">
                            <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center mr-4 group-hover:bg-gray-900 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Administrator</h3>
                                <p class="text-xs text-gray-500">System settings</p>
                            </div>
                            <i class="fa-solid fa-chevron-right ml-auto text-gray-300 group-hover:text-gray-900"></i>
                        </a>
                    </div>
                </div>
                <div class="bg-gray-50 p-4 text-center border-t border-gray-100">
                    <p class="text-xs text-gray-500">Need help? <a href="#" class="text-brand-600 hover:underline">Contact Support</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal Logic
        const modal = document.getElementById('loginModal');
        
        function toggleModal() {
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
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
            } else {
                navbar.classList.remove('glass');
                navbar.classList.remove('shadow-sm');
            }
        });
    </script>
</body>
</html>