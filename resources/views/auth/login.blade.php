<x-guest-layout>
    <div id="particles-js" class="fixed inset-0 z-0 pointer-events-none bg-gray-50"></div>

    <style>
        /* ================= EXISTING ANIMATIONS ================= */
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

        /* Ensure form sits above particles with slight transparency */
        .login-card {
            position: relative;
            z-index: 10;
            background-color: rgba(255, 255, 255, 0.9); /* Slight transparency */
            backdrop-filter: blur(8px); /* Glass effect */
        }
    </style>

    <div class="login-card p-2 rounded-2xl animate-enter {{ $errors->any() ? 'animate-shake' : '' }}">
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Welcome Back') }}</h2>
            <p class="text-sm text-gray-500 mt-2">{{ __('Please sign in to your account') }}</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div class="space-y-1">
                <x-input-label for="email" :value="__('Email')" class="sr-only" />
                
                <div class="relative input-group transition-all duration-300">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <x-text-input id="email" 
                                class="block w-full pl-10 pr-4 py-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-shadow bg-white/80" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                placeholder="Email Address"
                                required autofocus autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="space-y-1">
                <x-input-label for="password" :value="__('Password')" class="sr-only" />

                <div class="relative input-group transition-all duration-300" x-data="{ show: false }">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    
                    <x-text-input id="password" 
                                class="block w-full pl-10 pr-10 py-3 border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-shadow bg-white/80"
                                ::type="show ? 'text' : 'password'"
                                name="password"
                                placeholder="Password"
                                required autocomplete="current-password" />
                    
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

            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 group-hover:border-indigo-500 transition-colors" name="remember">
                    <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:text-indigo-800 font-medium hover:underline transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                @endif
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full flex justify-center py-3 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-indigo-500/30 rounded-lg">
                    {{ __('Log in') }}
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </x-primary-button>
            </div>
            
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": { "value": 60, "density": { "enable": true, "value_area": 800 } },
                "color": { "value": "#6366f1" }, /* Indigo-500 */
                "shape": { "type": "circle" },
                "opacity": { "value": 0.3, "random": false },
                "size": { "value": 3, "random": true },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#818cf8", /* Indigo-400 */
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