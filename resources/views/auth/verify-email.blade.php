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

        /* Envelope Float Animation */
        .float-icon {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* Glass Effect Card */
        .verify-card {
            position: relative;
            z-index: 10;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
        }
    </style>

    <div class="verify-card p-6 rounded-2xl animate-enter max-w-md mx-auto shadow-xl">
        
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center float-icon shadow-sm">
                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path>
                </svg>
            </div>
        </div>

        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Verify Your Email') }}</h2>
            <div class="mt-4 text-sm text-gray-600 leading-relaxed">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-100 flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="text-sm font-medium text-green-700">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            </div>
        @endif

        <div class="mt-6 flex flex-col gap-4">
            
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-indigo-500/30 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-red-600 font-medium transition-colors duration-200 flex items-center justify-center gap-1 mx-auto group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path></svg>
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
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