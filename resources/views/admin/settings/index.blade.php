@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8 animate-content">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">System Settings</h1>
        <p class="text-slate-500 mt-2 font-medium">Control global parameters and registration access here.</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-slate-200 animate-content" style="animation-delay: 0.1s;">
        
        <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-door-open text-indigo-500"></i> Admission Controls
        </h2>

        <div class="space-y-6">
            <!-- Student Registration Toggle -->
            <div class="flex items-center justify-between p-5 rounded-2xl border border-slate-100 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Student Admissions</h3>
                    <p class="text-sm text-slate-500 mt-1">Allow new students to fill the application form.</p>
                </div>
                <div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer toggle-setting" data-key="student_registration_enabled" {{ $studentEnabled ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-500 shadow-inner"></div>
                    </label>
                </div>
            </div>

            <!-- Faculty Registration Toggle -->
            <div class="flex items-center justify-between p-5 rounded-2xl border border-slate-100 bg-slate-50 hover:bg-slate-100/50 transition-colors">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Faculty Admissions</h3>
                    <p class="text-sm text-slate-500 mt-1">Allow new teachers to apply for joining.</p>
                </div>
                <div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer toggle-setting" data-key="faculty_registration_enabled" {{ $facultyEnabled ? 'checked' : '' }}>
                        <div class="w-14 h-7 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-500 shadow-inner"></div>
                    </label>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Toast Notification Container -->
<div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleInputs = document.querySelectorAll('.toggle-setting');

        toggleInputs.forEach(input => {
            input.addEventListener('change', async function () {
                const key = this.dataset.key;
                const value = this.checked ? 1 : 0;
                
                try {
                    const response = await fetch("{{ route('admin.settings.update') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ key, value })
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        showToast(`Setting updating: ${key.replace(/_/g, ' ')} is now ${this.checked ? 'ENABLED' : 'DISABLED'}`, 'success');
                    } else {
                        showToast('Failed to update settings. It is reverting.', 'error');
                        this.checked = !this.checked; // Revert
                    }
                } catch (error) {
                    showToast('Network error while updating settings.', 'error');
                    this.checked = !this.checked; // Revert
                }
            });
        });

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            // Design the toast based on type
            const bgColor = type === 'success' ? 'bg-emerald-500' : 'bg-red-500';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-triangle-exclamation';

            toast.className = `${bgColor} text-white px-5 py-3 rounded-xl shadow-xl flex items-center gap-3 transform translate-y-10 opacity-0 transition-all duration-300`;
            toast.innerHTML = `<i class="fa-solid ${icon}"></i> <span class="font-medium text-sm">${message}</span>`;
            
            container.appendChild(toast);

            // Animate In
            setTimeout(() => {
                toast.classList.remove('translate-y-10', 'opacity-0');
            }, 10);

            // Animate Out & Remove
            setTimeout(() => {
                toast.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }
    });
</script>

@endsection
