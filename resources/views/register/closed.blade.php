<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admissions Closed | EdFlow</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
                            500: '#14b8a6',
                            600: '#0d9488',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(40px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="relative min-h-screen bg-slate-50 flex items-center justify-center p-4 selection:bg-brand-500 selection:text-white antialiased font-sans overflow-hidden">
    
    <!-- Background Patterns -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-200/40 blur-[100px]"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[600px] h-[600px] rounded-full bg-rose-200/40 blur-[120px]"></div>
    </div>

    <div class="w-full max-w-2xl bg-white/80 backdrop-blur-2xl rounded-[3rem] p-8 sm:p-14 text-center shadow-2xl border border-white relative z-10 animate-fade-in-up">
        
        <!-- Icon -->
        <div class="w-32 h-32 mx-auto bg-gradient-to-br from-slate-100 to-slate-200 rounded-full flex items-center justify-center mb-8 shadow-inner animate-float border-4 border-white">
            <i class="fa-solid fa-lock text-5xl text-slate-400"></i>
        </div>

        <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-slate-100 border border-slate-200 text-slate-600 font-bold tracking-widest uppercase text-xs mb-6 shadow-sm">
            <i class="fa-solid fa-circle-info text-indigo-500"></i> Notice
        </div>

        <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-800 mb-6 group">
            Admissions <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-indigo-600">Closed</span>
        </h1>
        
        <p class="text-slate-500 text-lg sm:text-xl max-w-md mx-auto leading-relaxed mb-10 font-medium">
            Thank you for your interest in {{ $type ?? 'our institution' }}. Admissions are currently closed at this time. Please check back later for future intakes.
        </p>

        <a href="/" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-full transition-all hover:scale-105 shadow-xl shadow-slate-900/20 group">
            <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            Return to Homepage
        </a>
    </div>

</body>
</html>
