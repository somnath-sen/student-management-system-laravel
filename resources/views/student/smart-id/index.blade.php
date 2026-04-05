@extends('layouts.student')

@section('title', 'Smart Campus ID')

@section('content')

<style>
    .animate-enter { animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(20px); }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    .stagger-1 { animation-delay: 0.1s; }
    
    /* Premium ID Card Styling */
    .id-card {
        width: 300px;
        height: 480px;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.15), 0 0 0 1px rgba(0,0,0,0.05);
        overflow: hidden;
        position: relative;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .id-header {
        height: 120px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding-top: 20px;
        color: white;
    }
    .id-photo {
        width: 100px;
        height: 100px;
        background: #fff;
        border-radius: 50%;
        position: absolute;
        top: 70px;
        left: 50%;
        transform: translateX(-50%);
        border: 4px solid #ffffff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 900;
        color: #4f46e5;
    }
    .id-body {
        margin-top: 60px;
        text-align: center;
        padding: 0 20px;
    }
    .id-qr-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        background: #f8fafc;
        border-radius: 12px;
        width: max-content;
        margin-inline: auto;
        border: 1px dashed #cbd5e1;
    }
</style>

<div class="max-w-6xl mx-auto">

    <div class="flex items-center justify-between mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Smart Campus ID</h1>
            <p class="text-slate-500 mt-1 font-medium">Update your Guardian details to activate your scannable QR Identity Card.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3 animate-enter">
            <i class="fa-solid fa-circle-check text-xl"></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden animate-enter stagger-1">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-address-card text-indigo-500"></i> Identity Information
                    </h2>
                </div>
                
                <form action="{{ route('student.smart-id.update') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Parent / Guardian Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="parent_name" value="{{ old('parent_name', $student->parent_name) }}" required placeholder="e.g. John Doe" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-slate-800">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Emergency Phone No. <span class="text-rose-500">*</span></label>
                            <input type="text" name="emergency_phone" value="{{ old('emergency_phone', $student->emergency_phone) }}" required placeholder="+91 9876543210" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-slate-800">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1.5">Blood Group <span class="text-rose-500">*</span></label>
                            <select name="blood_group" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-slate-800 bg-white">
                                <option value="">Select Group...</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg)
                                    <option value="{{ $bg }}" {{ old('blood_group', $student->blood_group) == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Full Home Address <span class="text-rose-500">*</span></label>
                        <textarea name="home_address" required rows="3" placeholder="Enter complete residential address..." class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-slate-800 resize-none">{{ old('home_address', $student->home_address) }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-3 bg-slate-900 hover:bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-qrcode"></i> Save & Generate Smart ID
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 flex flex-col items-center justify-start animate-enter stagger-1">
            
            @if($student->parent_name && $student->emergency_phone)
                <div class="id-card" id="student-id-card">
                    <div class="id-header">
                        <p class="text-xs font-bold tracking-widest opacity-80 uppercase">EdFlow Academy</p>
                        <p class="text-[10px] font-medium opacity-60">Smart Campus ID</p>
                    </div>
                    
                    <div class="id-photo">
                        {{ substr($student->user->name, 0, 1) }}
                    </div>

                    <div class="id-body">
                        <h2 class="text-xl font-black text-slate-900 leading-tight">{{ $student->user->name }}</h2>
                        <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mt-1">{{ $student->course->name ?? 'Student' }}</p>
                        
                        <div class="mt-4 flex justify-center gap-4 text-left">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Roll No</p>
                                <p class="text-sm font-bold text-slate-800">{{ $student->roll_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Blood Group</p>
                                <p class="text-sm font-bold text-rose-600">{{ $student->blood_group }}</p>
                            </div>
                        </div>

                        <div class="id-qr-container">
                            {!! QrCode::size(110)->color(30, 41, 59)->generate($verifyUrl) !!}
                        </div>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-2">Scan to verify identity</p>
                    </div>
                </div>
                
                <div class="mt-6 flex flex-col items-center gap-4 w-full max-w-[300px]">
                    <button type="button" onclick="downloadIDCard()" id="download-btn" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-download"></i> Download as Image
                    </button>

                    <!-- Network URL info so user can verify what's in the QR -->
                    <div class="w-full bg-emerald-50 border border-emerald-200 rounded-xl p-3 text-center">
                        <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider mb-1">
                            <i class="fa-solid fa-wifi mr-1"></i> QR points to:
                        </p>
                        <p class="text-[11px] font-mono font-bold text-emerald-800 break-all">{{ $verifyUrl }}</p>
                        <p class="text-[10px] text-emerald-500 mt-1">Make sure your phone is on the same Wi-Fi network.</p>
                    </div>

                    <p class="text-xs font-medium text-slate-500 text-center">
                        <i class="fa-solid fa-mobile-screen-button text-indigo-500 mr-1"></i> Scan the QR code with any phone camera to view the verified emergency profile.
                    </p>
                </div>
            @else
                <div class="w-full h-full min-h-[400px] border-2 border-dashed border-slate-300 rounded-2xl flex flex-col items-center justify-center p-8 text-center bg-slate-50">
                    <div class="w-16 h-16 bg-slate-200 rounded-full flex items-center justify-center text-slate-400 mb-4">
                        <i class="fa-solid fa-id-card-clip text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-700">ID Card Inactive</h3>
                    <p class="text-sm text-slate-500 mt-2">Please fill out your identity and guardian information to generate your scannable Smart ID.</p>
                </div>
            @endif

        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    function downloadIDCard() {
        const btn = document.getElementById('download-btn');
        const originalText = btn.innerHTML;
        
        // Show loading state
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Generating...';
        btn.disabled = true;

        const cardElement = document.getElementById('student-id-card');

        // Capture the card element at 3x scale for crisp, high-resolution printing
        html2canvas(cardElement, {
            scale: 3, 
            useCORS: true,
            backgroundColor: null
        }).then(canvas => {
            // Convert to PNG and download
            const link = document.createElement('a');
            link.download = `Smart_ID_Card_{{ $student->roll_number ?? time() }}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();

            // Restore button state
            btn.innerHTML = originalText;
            btn.disabled = false;
        }).catch(err => {
            console.error("Error generating ID card:", err);
            alert("Sorry, an error occurred while generating the ID card.");
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
</script>

@endsection