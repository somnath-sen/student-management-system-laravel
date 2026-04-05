<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Application | EdFlow</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #FDFBF7; 
        }
        
        /* 1. Professional Dot Pattern */
        .bg-dots {
            background-image: radial-gradient(rgba(99, 102, 241, 0.15) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* 2. Large Animated Blobs */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 15s infinite alternate;
        }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        .animation-delay-6000 { animation-delay: 6s; }

        /* 3. Floating Micro-Particles */
        @keyframes floatUp {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; transform: translateY(80vh) scale(1); }
            90% { opacity: 1; }
            100% { transform: translateY(-10vh) scale(0); opacity: 0; }
        }
        .particle {
            position: absolute;
            border-radius: 50%;
            animation: floatUp linear infinite;
            bottom: -10%;
        }

        /* Custom Scrollbar for dropdown */
        select::-webkit-scrollbar { width: 8px; }
        select::-webkit-scrollbar-thumb { background-color: #c7d2fe; border-radius: 4px; }
        
        /* Optgroup styling */
        optgroup { font-weight: 700; color: #4f46e5; background: #FDFBF7; }
        option { font-weight: 500; color: #334155; }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-indigo-500 selection:text-white relative">

    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0 bg-dots">
        <div class="absolute top-[-10%] left-[-10%] w-[40vw] h-[40vw] rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob bg-indigo-300"></div>
        <div class="absolute top-[20%] right-[-10%] w-[35vw] h-[35vw] rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-2000 bg-purple-300"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-[45vw] h-[45vw] rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-4000 bg-pink-300"></div>
        <div class="absolute bottom-[10%] right-[10%] w-[30vw] h-[30vw] rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-6000 bg-emerald-200"></div>
        
        <div class="particle bg-indigo-400/20" style="left: 10%; width: 20px; height: 20px; animation-duration: 12s; animation-delay: 0s;"></div>
        <div class="particle bg-purple-400/20" style="left: 30%; width: 40px; height: 40px; animation-duration: 18s; animation-delay: 2s;"></div>
        <div class="particle bg-pink-400/20" style="left: 60%; width: 15px; height: 15px; animation-duration: 10s; animation-delay: 5s;"></div>
        <div class="particle bg-emerald-400/20" style="left: 80%; width: 30px; height: 30px; animation-duration: 22s; animation-delay: 1s;"></div>
        <div class="particle bg-indigo-400/20" style="left: 45%; width: 25px; height: 25px; animation-duration: 16s; animation-delay: 7s;"></div>
        <div class="particle bg-purple-400/20" style="left: 85%; width: 10px; height: 10px; animation-duration: 14s; animation-delay: 3s;"></div>
        <div class="particle bg-emerald-400/20" style="left: 20%; width: 35px; height: 35px; animation-duration: 20s; animation-delay: 8s;"></div>
        <div class="particle bg-pink-400/20" style="left: 70%; width: 18px; height: 18px; animation-duration: 15s; animation-delay: 4s;"></div>
    </div>

    <div class="relative z-10 min-h-screen py-12 px-4 sm:px-6 lg:px-8 flex flex-col justify-center">
        <div class="max-w-3xl mx-auto w-full">
            
            <div class="text-center mb-10">
                <a href="/" class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/80 backdrop-blur-sm text-indigo-600 mb-4 hover:bg-white transition-all shadow-md hover:shadow-lg hover:-translate-y-1 border border-indigo-100">
                    <i class="fa-solid fa-user-graduate text-2xl"></i>
                </a>
                <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight drop-shadow-sm">Student Application Portal</h2>
                <p class="mt-3 text-slate-600 font-medium text-lg drop-shadow-sm">Please fill out all details carefully. Documents must be clear and legible.</p>
            </div>

            <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/50 overflow-hidden relative">
                
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                <form id="studentForm" class="p-8 space-y-8">
                    @csrf
                    <input type="hidden" name="type" value="Students">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/60 pb-2 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Full Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 transition-all outline-none shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Email Address <span class="text-rose-500">*</span></label>
                                <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 transition-all outline-none shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Phone Number <span class="text-rose-500">*</span></label>
                                <input type="tel" name="phone" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 transition-all outline-none shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Roll Number <span class="text-slate-400 font-normal">(Optional)</span></label>
                                <input type="text" name="roll" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 transition-all outline-none shadow-sm placeholder-slate-300" placeholder="e.g. 2023-CSE-001">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Desired Course <span class="text-rose-500">*</span></label>
                                <select name="course" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 transition-all outline-none shadow-sm cursor-pointer text-sm">
                                    <option value="" disabled selected>Select a program...</option>
                                    
                                    <optgroup label="Professional & Management">
                                        <option value="BCA">Bachelor of Computer Applications (BCA)</option>
                                        <option value="MCA">Master of Computer Applications (MCA)</option>
                                        <option value="BBA">Bachelor of Business Administration (BBA)</option>
                                        <option value="MBA">Master of Business Administration (MBA)</option>
                                    </optgroup>
                                    
                                    <optgroup label="Engineering (B.Tech / B.E.)">
                                        <option value="Computer Science and Engineering (CSE)">Computer Science & Engineering (CSE)</option>
                                        <option value="Information Technology (IT)">Information Technology (IT)</option>
                                        <option value="Electronics and Communication Engineering (ECE)">Electronics & Communication Engg (ECE)</option>
                                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                                        <option value="Civil Engineering">Civil Engineering</option>
                                        <option value="Electrical Engineering">Electrical Engineering</option>
                                        <option value="Artificial Intelligence and Data Science">Artificial Intelligence & Data Science</option>
                                        <option value="Biotechnology Engineering">Biotechnology Engineering</option>
                                        <option value="Chemical Engineering">Chemical Engineering</option>
                                        <option value="Aerospace Engineering">Aerospace / Aeronautical Engineering</option>
                                        <option value="Marine Engineering">Marine Engineering</option>
                                        <option value="Food Technology">Food Technology</option>
                                    </optgroup>

                                    <optgroup label="Bachelor of Science (B.Sc.)">
                                        <option value="B.Sc. Computer Science">B.Sc. Computer Science</option>
                                        <option value="B.Sc. Information Technology">B.Sc. Information Technology</option>
                                        <option value="B.Sc. Data Science">B.Sc. Data Science</option>
                                        <option value="B.Sc. Mathematics">B.Sc. Mathematics</option>
                                        <option value="B.Sc. Physics">B.Sc. Physics</option>
                                        <option value="B.Sc. Chemistry">B.Sc. Chemistry</option>
                                        <option value="B.Sc. Biotechnology">B.Sc. Biotechnology</option>
                                        <option value="B.Sc. Microbiology">B.Sc. Microbiology</option>
                                        <option value="B.Sc. Botany">B.Sc. Botany</option>
                                        <option value="B.Sc. Zoology">B.Sc. Zoology</option>
                                        <option value="B.Sc. Statistics">B.Sc. Statistics</option>
                                        <option value="B.Sc. Electronics">B.Sc. Electronics</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/60 pb-2 mb-4">Parent / Guardian Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Parent's Full Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="parent_name" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 transition-all outline-none shadow-sm">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Parent's Email Address <span class="text-rose-500">*</span></label>
                                <input type="email" name="parent_email" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white/50 transition-all outline-none shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div class="bg-indigo-50/50 backdrop-blur-sm p-5 rounded-xl border border-indigo-100 shadow-inner">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" required class="mt-1 w-5 h-5 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500 cursor-pointer">
                            <span class="text-sm text-slate-700 leading-relaxed font-medium group-hover:text-indigo-900 transition-colors">
                                I hereby declare that all the information and documents provided are true and correct to the best of my knowledge. I understand that my application may be rejected if any information is found to be false.
                            </span>
                        </label>
                    </div>

                    <button type="submit" id="submitBtn" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-indigo-500/30 transition-all flex items-center justify-center gap-2 hover:-translate-y-0.5">
                        <span id="btnText">Submit Application</span>
                        <i class="fa-solid fa-spinner fa-spin hidden" id="btnLoader"></i>
                    </button>
                </form>
                
                <div id="successMessage" class="hidden p-12 text-center bg-white/90 backdrop-blur-md">
                    <div class="w-24 h-24 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                        <i class="fa-solid fa-check text-5xl"></i>
                    </div>
                    <h3 class="text-3xl font-extrabold text-slate-900 mb-3 drop-shadow-sm">Application Received!</h3>
                    <p class="text-slate-600 font-medium text-lg max-w-md mx-auto">Your application has been securely sent to the administration for review. We will contact you via email shortly.</p>
                    <a href="/" class="mt-8 inline-flex items-center px-6 py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-colors shadow-lg hover:-translate-y-0.5">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Return to Home
                    </a>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <a href="/" class="text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors drop-shadow-sm bg-white/50 px-4 py-2 rounded-full backdrop-blur-sm border border-white">Cancel and return to home</a>
            </div>
        </div>
    </div>

    <script>
        const scriptURL = "{{ route('register.student.store') }}"; 
        
        const form = document.getElementById("studentForm");
        const submitBtn = document.getElementById("submitBtn");
        const btnText = document.getElementById("btnText");
        const btnLoader = document.getElementById("btnLoader");
        const successMessage = document.getElementById("successMessage");

        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            btnText.innerText = "Submitting Application...";
            btnLoader.classList.remove('hidden');

            try {
                let formData = new FormData(this);

                const response = await fetch(scriptURL, { 
                    method: "POST", 
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });
                
                const result = await response.json();
                
                if(response.ok && result.success) {
                    form.classList.add('hidden');
                    successMessage.classList.remove('hidden');
                    window.scrollTo({ top: 0, behavior: 'smooth' }); 
                } else {
                    let errorMessage = result.message || "An error occurred during submission.";
                    if (result.errors) {
                        const firstError = Object.values(result.errors)[0][0];
                        errorMessage = firstError;
                    }
                    alert("Error: " + errorMessage);
                }
            } catch (error) {
                alert("Something went wrong. Please check your internet connection and try again.");
                console.error(error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                btnText.innerText = "Submit Application";
                btnLoader.classList.add('hidden');
            }
        });
    </script>
</body>
</html>