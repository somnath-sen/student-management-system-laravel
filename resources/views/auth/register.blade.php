<x-guest-layout>
    <div id="particles-js" class="fixed inset-0 z-0 pointer-events-none bg-gray-50"></div>

    <style>
        /* ================= ANIMATIONS ================= */
        .animate-enter {
            animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Shake animation on error */
        .animate-shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        /* Focus Ring Animation */
        .input-group:focus-within {
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
        
        .input-group:focus-within svg {
            color: #4f46e5; /* Indigo-600 */
        }

        /* Glass Effect Card */
        .register-card {
            position: relative;
            z-index: 10;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
        }
    </style>

    <div class="register-card p-2 rounded-2xl animate-enter {{ $errors->any() ? 'animate-shake' : '' }}">
        
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Create Account') }}</h2>
            <p class="text-sm text-gray-500 mt-2">{{ __('Join us to get started') }}</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="space-y-1">
                <x-input-label for="name" :value="__('Full Name')" class="sr-only" />
                <div class="relative input-group transition-all duration-300">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <x-text-input id="name" 
                                class="block w-full pl-10 pr-4 py-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white/80" 
                                type="text" 
                                name="name" 
                                :value="old('name')" 
                                placeholder="Full Name"
                                required autofocus autocomplete="name" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="space-y-1">
                <x-input-label for="email" :value="__('Email')" class="sr-only" />
                <div class="relative input-group transition-all duration-300">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <x-text-input id="email" 
                                class="block w-full pl-10 pr-4 py-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white/80" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                placeholder="Email Address"
                                required autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="space-y-1">
                <x-input-label for="password" :value="__('Password')" class="sr-only" />
                <div class="relative input-group transition-all duration-300" x-data="{ show: false }">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <x-text-input id="password" 
                                class="block w-full pl-10 pr-10 py-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white/80"
                                ::type="show ? 'text' : 'password'"
                                name="password"
                                placeholder="Password"
                                required autocomplete="new-password" />
                    
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-indigo-600 cursor-pointer focus:outline-none">
                        <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 013.999-5.325m-3.641 4.166l15.856 10.15m-1.857-1.857l1.857 1.857" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="space-y-1">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="sr-only" />
                <div class="relative input-group transition-all duration-300" x-data="{ show: false }">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    
                    <x-text-input id="password_confirmation" 
                                class="block w-full pl-10 pr-10 py-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white/80"
                                ::type="show ? 'text' : 'password'"
                                name="password_confirmation"
                                placeholder="Confirm Password"
                                required autocomplete="new-password" />
                                
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-indigo-600 cursor-pointer focus:outline-none">
                        <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 013.999-5.325m-3.641 4.166l15.856 10.15m-1.857-1.857l1.857 1.857" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-indigo-600 hover:text-indigo-800 font-medium hover:underline transition-colors" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-indigo-500/30 rounded-lg">
                    {{ __('Register') }}
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </x-primary-button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": { "value": 60, "density": { "enable": true, "value_area": 800 } },
                "color": { "value": "#6366f1" },
                "shape": { "type": "circle" },
                "opacity": { "value": 0.3, "random": false },
                "size": { "value": 3, "random": true },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#818cf8",
                    "opacity": 0.2,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 1.5,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": { "enable": true, "mode": "grab" },
                    "onclick": { "enable": false, "mode": "push" },
                    "resize": true
                },
                "modes": {
                    "grab": { "distance": 140, "line_linked": { "opacity": 0.5 } }
                }
            },
            "retina_detect": true
        });
    </script>
</x-guest-layout>