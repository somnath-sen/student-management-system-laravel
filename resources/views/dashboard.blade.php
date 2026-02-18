<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .animate-fade-up {
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Floating Background Shapes */
        .blob {
            position: absolute;
            filter: blur(40px);
            opacity: 0.4;
            animation: float 10s infinite ease-in-out;
            z-index: 0;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-20px, 20px); }
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl overflow-hidden text-white p-8 animate-fade-up">
                <div class="blob bg-blue-400 w-64 h-64 rounded-full -top-10 -left-10 mix-blend-multiply"></div>
                <div class="blob bg-pink-400 w-64 h-64 rounded-full -bottom-10 -right-10 mix-blend-multiply animation-delay-2000"></div>

                <div class="relative z-10 flex items-start sm:items-center justify-between flex-col sm:flex-row gap-4">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-white/20 backdrop-blur-sm rounded-lg shadow-inner">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold tracking-tight">
                                {{ __('Welcome back,') }} {{ Auth::user()->name }}!
                            </h3>
                            <p class="text-indigo-100 mt-1 font-medium">
                                {{ __("You are successfully logged in.") }}
                            </p>
                        </div>
                    </div>
                    
                    <span class="px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-sm font-medium backdrop-blur-md">
                        {{ now()->format('l, F jS') }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 hover:shadow-md transition-all duration-300 hover:-translate-y-1 animate-fade-up delay-100">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800">My Profile</h4>
                            <a href="{{ route('profile.edit') }}" class="text-sm text-gray-500 hover:text-indigo-600">Manage account &rarr;</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 hover:shadow-md transition-all duration-300 hover:-translate-y-1 animate-fade-up delay-200">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-full bg-emerald-50 text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800">System Status</h4>
                            <span class="text-sm text-green-600 font-medium">All systems operational</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100 hover:shadow-md transition-all duration-300 hover:-translate-y-1 animate-fade-up delay-300">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-full bg-amber-50 text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800">Notifications</h4>
                            <p class="text-sm text-gray-500">You have 0 new messages</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>