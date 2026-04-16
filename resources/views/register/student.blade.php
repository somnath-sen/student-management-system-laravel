<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Application | EdFlow</title>
    <meta name="description" content="Apply for student enrollment at EdFlow. Submit your application for admin review.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Outfit"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            900: '#134e4a',
                        }
                    },
                    animation: {
                        'blob': 'blob 10s infinite',
                        'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(40px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #fafaf9;
            color: #1c1917;
            min-height: 100vh;
        }

        /* Soft Glassmorphism */
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);
        }

        /* Light Input Styles */
        .input-field {
            background: #ffffff;
            border: 2px solid #f0fdfa;
            color: #1c1917;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02) inset;
        }
        .input-field:focus {
            background: #ffffff;
            border-color: #2dd4bf;
            box-shadow: 0 0 0 4px rgba(45, 212, 191, 0.15);
            outline: none;
        }
        .input-field::placeholder {
            color: #a8a29e;
        }
        
        select.input-field option {
            background: #ffffff;
            color: #1c1917;
        }
        select.input-field optgroup {
            background: #fafaf9;
            color: #57534e;
            font-weight: 700;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.1); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(0, 0, 0, 0.2); }

        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @keyframes scaleIn {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="relative overflow-x-hidden antialiased font-sans selection:bg-brand-100 selection:text-brand-900 bg-gradient-to-br from-orange-50 via-rose-50 to-teal-50">

    <!-- Light & Colorful Animated Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <!-- Pastel Blobs -->
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-pink-200/50 blur-[100px] animate-blob"></div>
        <div class="absolute top-[20%] right-[-10%] w-[450px] h-[450px] rounded-full bg-cyan-200/50 blur-[120px] animate-blob" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-[-20%] left-[10%] w-[600px] h-[600px] rounded-full bg-yellow-200/50 blur-[120px] animate-blob" style="animation-delay: 4s;"></div>
        <div class="absolute bottom-[10%] right-[20%] w-[350px] h-[350px] rounded-full bg-violet-200/50 blur-[90px] animate-blob" style="animation-delay: 6s;"></div>
        
        <!-- Subtle dot pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMCwwLDAsMC4wMikiLz48L3N2Zz4=')]"></div>
    </div>

    <div class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 relative z-10">
        
        <!-- Header / Nav -->
        <div class="w-full max-w-5xl flex justify-between items-center mb-8 animate-fade-in-up" style="animation-delay: 0.1s;">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-12 h-12 bg-white/80 backdrop-blur-sm rounded-2xl flex items-center justify-center text-brand-500 border border-white/60 group-hover:bg-white transition-all duration-300 group-hover:scale-110 group-hover:-rotate-6 shadow-sm">
                    <i class="fa-solid fa-graduation-cap text-xl"></i>
                </div>
                <span class="font-bold text-2xl tracking-tight text-gray-800 group-hover:text-brand-600 transition-colors">EdFlow<span class="text-brand-500">.</span></span>
            </a>
            
            <a href="/" class="px-5 py-2.5 rounded-full bg-white/80 hover:bg-white text-gray-700 text-sm font-semibold border border-white/60 backdrop-blur-md transition-all duration-300 hover:shadow-md flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Home
            </a>
        </div>

        <!-- Main Form Container -->
        <div class="w-full max-w-5xl glass-panel rounded-[2.5rem] p-6 sm:p-10 lg:p-14 relative overflow-hidden animate-fade-in-up shadow-2xl shadow-rose-100/50" style="animation-delay: 0.2s;">
            
            <!-- Colorful top accent -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-300 via-pink-400 to-cyan-400"></div>

            <div class="text-center mb-12 relative z-10">
                <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white border border-rose-100 text-pink-500 font-bold tracking-widest uppercase text-xs mb-6 shadow-sm animate-float">
                    <i class="fa-solid fa-sparkles text-yellow-400"></i> New Admission
                </div>
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-gray-800 mb-5">
                    Start Your <span class="bg-gradient-to-r from-pink-500 via-purple-500 to-cyan-500 gradient-text">Bright Future</span>
                </h1>
                <p class="text-gray-500 text-lg sm:text-xl max-w-2xl mx-auto font-medium">Join our vibrant campus and shape the career of your dreams. Fill out the application below.</p>
            </div>

            <!-- Form -->
            <form id="studentForm" class="relative z-10">
                @csrf
                <input type="hidden" name="type" value="Students">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                    
                    <!-- Left Column -->
                    <div class="space-y-8">
                        <!-- Personal Details -->
                        <div class="bg-gradient-to-br from-white to-rose-50/50 p-7 rounded-3xl border border-white/80 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-pink-100 rounded-full blur-3xl -mr-10 -mt-10"></div>
                            
                            <div class="flex items-center gap-4 mb-6 relative">
                                <div class="w-12 h-12 rounded-2xl bg-pink-100 flex items-center justify-center text-pink-500 shadow-sm border border-pink-200/50">
                                    <i class="fa-regular fa-id-card text-xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-800">Who are you?</h2>
                            </div>

                            <div class="space-y-5 relative">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Full Name <span class="text-pink-500">*</span></label>
                                    <input type="text" name="name" required placeholder="e.g. Emma Watson" class="input-field w-full px-5 py-4 rounded-2xl text-base font-medium">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Email Address <span class="text-pink-500">*</span></label>
                                    <input type="email" name="email" required placeholder="emma@example.com" class="input-field w-full px-5 py-4 rounded-2xl text-base font-medium">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Phone Number <span class="text-pink-500">*</span></label>
                                    <input type="tel" name="phone" required placeholder="+1 (555) 000-0000" class="input-field w-full px-5 py-4 rounded-2xl text-base font-medium">
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1 flex justify-between">
                                        <span>Registration No.</span> <span class="text-gray-400 font-medium normal-case tracking-normal">Optional</span>
                                    </label>
                                    <input type="text" name="roll" placeholder="e.g. 2026-CS-001" class="input-field w-full px-5 py-4 rounded-2xl text-base font-medium bg-gray-50/50">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-8">
                        <!-- Program Selection -->
                        <div class="bg-gradient-to-br from-white to-cyan-50/50 p-7 rounded-3xl border border-white/80 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-100 rounded-full blur-3xl -mr-10 -mt-10"></div>
                            
                            <div class="flex items-center gap-4 mb-6 relative">
                                <div class="w-12 h-12 rounded-2xl bg-cyan-100 flex items-center justify-center text-cyan-600 shadow-sm border border-cyan-200/50">
                                    <i class="fa-solid fa-laptop-code text-xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-800">What will you study?</h2>
                            </div>

                            <div class="relative">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Desired Program <span class="text-cyan-500">*</span></label>
                                <div class="relative">
                                    <select name="course" required class="input-field w-full px-5 py-4 rounded-2xl text-base font-medium appearance-none cursor-pointer pr-10">
                                        <option value="" disabled selected>Select an awesome program...</option>
                                        @if(isset($courses) && $courses->count() > 0)
                                            @foreach($courses as $course)
                                                <option value="{{ $course->name }}">{{ $course->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" disabled>No programs available at the moment</option>
                                        @endif
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-cyan-500">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Parent Details -->
                        <div class="bg-gradient-to-br from-white to-amber-50/50 p-7 rounded-3xl border border-white/80 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-100 rounded-full blur-3xl -mr-10 -mt-10"></div>
                            
                            <div class="flex items-center gap-4 mb-6 relative">
                                <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-600 shadow-sm border border-amber-200/50">
                                    <i class="fa-solid fa-people-roof text-xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-800">Guardian Details</h2>
                            </div>

                            <div class="space-y-5 relative">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Parent's Full Name <span class="text-amber-500">*</span></label>
                                    <input type="text" name="parent_name" required placeholder="e.g. Richard Watson" class="input-field w-full px-5 py-4 rounded-2xl text-base font-medium">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 ml-1">Parent's Email <span class="text-amber-500">*</span></label>
                                    <input type="email" name="parent_email" required placeholder="richard@example.com" class="input-field w-full px-5 py-4 rounded-2xl text-base font-medium">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms & Submit -->
                <div class="mt-12 pt-8 border-t border-gray-100 max-w-3xl mx-auto flex flex-col items-center gap-6">

                    <!-- Google reCAPTCHA -->
                    <div class="w-full flex flex-col items-center">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                        @error('g-recaptcha-response')
                            <p class="text-rose-500 text-xs font-bold mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <label class="flex items-start gap-4 cursor-pointer group bg-white p-5 rounded-2xl border border-rose-100 hover:border-brand-300 hover:bg-brand-50/30 transition-all w-full shadow-sm">
                        <div class="relative flex items-center justify-center mt-0.5 shrink-0">
                            <input type="checkbox" required class="peer appearance-none w-6 h-6 border-2 border-gray-200 rounded-lg checked:bg-brand-500 checked:border-brand-500 transition-all cursor-pointer bg-gray-50">
                            <i class="fa-solid fa-check absolute text-white text-sm opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"></i>
                        </div>
                        <span class="text-base text-gray-600 group-hover:text-gray-800 transition-colors leading-relaxed font-medium">
                            I verify that all information provided is completely accurate. I understand that my journey at EdFlow begins with this commitment to truth.
                        </span>
                    </label>

                    <button type="submit" id="submitBtn" class="w-full sm:w-auto min-w-[300px] relative group/btn inline-flex items-center justify-center px-10 py-5 font-bold text-white rounded-full overflow-hidden shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 transition-all hover:-translate-y-1 focus:outline-none">
                        <div class="absolute inset-0 bg-gradient-to-r from-brand-400 via-cyan-400 to-brand-500 transition-all duration-300 group-hover/btn:scale-105"></div>
                        <span class="relative z-10 flex items-center gap-3 text-lg">
                            <span id="btnText">Submit Application</span>
                            <i id="btnIcon" class="fa-solid fa-rocket text-base transform group-hover/btn:translate-x-1 group-hover/btn:-translate-y-1 transition-transform"></i>
                            <i id="btnLoader" class="fa-solid fa-circle-notch animate-spin text-base hidden"></i>
                        </span>
                    </button>
                </div>
            </form>

            <!-- Success State Panel (Hidden by default) -->
            <div id="successMessage" class="hidden absolute inset-0 z-50 glass-panel bg-white/95 backdrop-blur-3xl flex flex-col items-center justify-center p-8 text-center border-none">
                <div class="relative w-28 h-28 mb-8">
                    <div class="absolute inset-0 bg-brand-200 rounded-full animate-ping opacity-60"></div>
                    <div class="relative w-full h-full bg-gradient-to-br from-brand-400 to-cyan-500 rounded-full flex items-center justify-center text-white text-5xl shadow-xl shadow-brand-500/30 transform scale-0 animate-[scaleIn_0.6s_cubic-bezier(0.16,1,0.3,1)_forwards]">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
                
                <h2 class="text-4xl sm:text-5xl font-black text-gray-800 mb-5 transform translate-y-4 opacity-0 animate-[fadeInUp_0.5s_0.2s_forwards]">You're on the list!</h2>
                <p class="text-gray-500 text-xl max-w-lg mx-auto mb-10 transform translate-y-4 opacity-0 animate-[fadeInUp_0.5s_0.3s_forwards] leading-relaxed font-medium">
                    We've received your application. Get ready for an amazing journey! Check your inbox soon for the next steps.
                </p>
                
                <a href="/" class="px-8 py-4 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold shadow-sm transition-all hover:-translate-y-1 transform translate-y-4 opacity-0 animate-[fadeInUp_0.5s_0.4s_forwards] flex items-center gap-2">
                    <i class="fa-solid fa-home"></i> Back to Homepage
                </a>
            </div>

        </div>
    </div>

    <script>
        const scriptURL = "{{ route('register.student.store') }}";

        const form          = document.getElementById("studentForm");
        const submitBtn     = document.getElementById("submitBtn");
        const btnText       = document.getElementById("btnText");
        const btnIcon       = document.getElementById("btnIcon");
        const btnLoader     = document.getElementById("btnLoader");
        const successPanel  = document.getElementById("successMessage");

        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            submitBtn.disabled = true;
            btnText.innerText  = "Sending Magic...";
            btnIcon.classList.add('hidden');
            btnLoader.classList.remove('hidden');
            submitBtn.classList.add('opacity-90', 'cursor-not-allowed', 'scale-95');

            try {
                const formData = new FormData(this);
                const response = await fetch(scriptURL, {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    form.style.opacity = '0';
                    form.style.transition = 'opacity 0.4s ease';
                    setTimeout(() => {
                        successPanel.classList.remove('hidden');
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }, 400);
                } else {
                    let msg = result.message || "An error occurred during submission.";
                    if (result.errors) { msg = Object.values(result.errors)[0][0]; }
                    alert("Oops: " + msg);
                }
            } catch (err) {
                alert("Network error. Please check your connection and try again.");
                console.error(err);
            } finally {
                submitBtn.disabled = false;
                btnText.innerText  = "Submit Application";
                btnIcon.classList.remove('hidden');
                btnLoader.classList.add('hidden');
                submitBtn.classList.remove('opacity-90', 'cursor-not-allowed', 'scale-95');
                form.style.opacity = '1';
            }
        });
    </script>
</body>
</html>