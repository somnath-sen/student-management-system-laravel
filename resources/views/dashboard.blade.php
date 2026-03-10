<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account Status') }}
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

                <div class="relative z-10 flex items-start sm:items-center justify-between flex-col sm:flex-row gap-6">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-white/20 backdrop-blur-sm rounded-xl shadow-inner">
                            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold tracking-tight">
                                Hello, {{ Auth::user()->name }}!
                            </h3>
                            <p class="text-indigo-100 mt-1 font-medium">
                                Your account is currently pending role assignment.
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <span class="hidden md:inline-block px-4 py-2 rounded-lg bg-white/10 border border-white/20 text-sm font-medium backdrop-blur-md">
                            {{ now()->format('M j, Y') }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-white text-indigo-600 hover:bg-indigo-50 rounded-lg font-bold transition-colors shadow-lg">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out
                            </button>
                        </form>
                    </div>
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
                            <a href="{{ route('profile.edit') }}" class="text-sm text-gray-500 hover:text-indigo-600 font-medium">Manage account &rarr;</a>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 bg-amber-50 overflow-hidden shadow-sm sm:rounded-xl p-6 border border-amber-100 animate-fade-up delay-200">
                    <div class="flex items-start gap-4">
                        <div class="p-3 rounded-full bg-amber-100 text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-amber-900">What happens next?</h4>
                            <p class="text-sm text-amber-800 mt-1">
                                Your account has been created successfully. Please wait for the system administrator to verify your application and assign you to a Student or Faculty portal. Once approved, your specific dashboard will unlock automatically.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>