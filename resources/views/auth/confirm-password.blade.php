<x-guest-layout>
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

        /* Error Shake Animation */
        .animate-shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        /* Input Focus Glow */
        .input-focus-effect:focus {
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2); /* Indigo glow */
            border-color: #6366f1;
            transform: translateY(-1px);
        }
    </style>

    <div class="animate-enter {{ $errors->any() ? 'animate-shake' : '' }}">
        
        <div class="flex justify-center mb-6">
            <div class="p-4 bg-indigo-50 rounded-full ring-8 ring-indigo-50/50">
                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
        </div>

        <div class="text-center mb-6">
            <h2 class="text-xl font-bold text-gray-900">{{ __('Secure Area') }}</h2>
            <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
            @csrf

            <div class="relative group">
                <x-input-label for="password" :value="__('Password')" class="sr-only" />

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>

                    <x-text-input id="password" 
                                class="block w-full pl-10 pr-4 py-3 border-gray-300 rounded-lg input-focus-effect transition-all duration-300"
                                type="password"
                                name="password"
                                placeholder="Enter your password"
                                required autocomplete="current-password" 
                                autofocus />
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-center" />
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-0.5">
                    {{ __('Confirm Password') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>