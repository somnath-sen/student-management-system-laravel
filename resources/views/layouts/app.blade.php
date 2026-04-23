@php
    $theme = request()->cookie('theme', 'light');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth {{ $theme === 'dark' ? 'dark' : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* ================= CUSTOM STYLES ================= */
            
            /* Smooth Page Entrance */
            .animate-enter {
                animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                opacity: 0;
                transform: translateY(15px);
            }

            @keyframes fadeUp {
                to { opacity: 1; transform: translateY(0); }
            }

            /* Modern Scrollbar */
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: #f1f5f9; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

            /* Glassmorphism Utilities */
            .glass {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            }

            /* Skeleton Shimmer Animation */
            .shimmer {
                background: #f1f5f9;
                background-image: linear-gradient(
                    90deg,
                    rgba(255, 255, 255, 0) 0,
                    rgba(255, 255, 255, 0.6) 20%,
                    rgba(255, 255, 255, 0) 40%,
                    rgba(255, 255, 255, 0) 100%
                );
                background-repeat: no-repeat;
                background-size: 800px 100%;
                animation: shimmer 1.5s infinite linear forwards;
            }
            .dark .shimmer {
                background: #1e293b;
                background-image: linear-gradient(
                    90deg,
                    rgba(255, 255, 255, 0) 0,
                    rgba(255, 255, 255, 0.05) 20%,
                    rgba(255, 255, 255, 0) 40%,
                    rgba(255, 255, 255, 0) 100%
                );
            }
            @keyframes shimmer {
                0% { background-position: -468px 0; }
                100% { background-position: 468px 0; }
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-800 bg-gray-50 dark:bg-gray-900 dark:text-gray-100 selection:bg-indigo-500 selection:text-white transition-colors duration-300">
        
        <div class="fixed inset-0 -z-10 pointer-events-none">
            <div class="absolute top-0 left-0 right-0 h-96 bg-gradient-to-b from-indigo-50/50 to-transparent"></div>
        </div>

        <div class="min-h-screen flex flex-col">
            
            @include('layouts.navigation')

            @isset($header)
                <header class="glass sticky top-0 z-30 transition-all duration-300 shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            @if (session('success') || session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 animate-enter">
                    <div class="{{ session('error') ? 'bg-red-50 text-red-600 border-red-200' : 'bg-green-50 text-green-600 border-green-200' }} border px-4 py-3 rounded-lg shadow-sm flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full {{ session('error') ? 'bg-red-500' : 'bg-green-500' }}"></span>
                            <span class="font-medium">{{ session('success') ?? session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-sm opacity-60 hover:opacity-100">&times;</button>
                    </div>
                </div>
            @endif

            <main class="flex-1 animate-enter">
                <div class="py-8">
                    {{ $slot }}
                </div>
            </main>

            <footer class="py-6 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </footer>

        </div>

        <script>
            function toggleTheme() {
                const html = document.documentElement;
                const isDark = html.classList.contains('dark');
                const newTheme = isDark ? 'light' : 'dark';

                if (newTheme === 'dark') {
                    html.classList.add('dark');
                    document.getElementById('theme-icon-light')?.classList.remove('hidden');
                    document.getElementById('theme-icon-dark')?.classList.add('hidden');
                } else {
                    html.classList.remove('dark');
                    document.getElementById('theme-icon-light')?.classList.add('hidden');
                    document.getElementById('theme-icon-dark')?.classList.remove('hidden');
                }

                fetch('{{ route("preferences.theme") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ theme: newTheme })
                }).catch(err => console.error('Failed to save theme preference', err));
            }
        </script>
    </body>
</html>