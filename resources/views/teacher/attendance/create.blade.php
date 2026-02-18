@extends('layouts.teacher')

@section('title', 'Mark Attendance')

@section('content')

<style>
    /* ================= PAGE ANIMATIONS ================= */
    .animate-enter {
        animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }

    /* ================= TOGGLE BUTTON STYLING ================= */
    .toggle-radio { display: none; }
    
    .toggle-label {
        transition: all 0.2s ease;
        cursor: pointer;
        opacity: 0.6;
        transform: scale(0.95);
    }

    /* Present State */
    .toggle-radio[value="1"]:checked + .toggle-label {
        background-color: #10b981; /* Green-500 */
        color: white;
        opacity: 1;
        transform: scale(1);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        border-color: #10b981;
    }

    /* Absent State */
    .toggle-radio[value="0"]:checked + .toggle-label {
        background-color: #ef4444; /* Red-500 */
        color: white;
        opacity: 1;
        transform: scale(1);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        border-color: #ef4444;
    }

    /* Table Row Highlighting */
    .row-present { background-color: rgba(16, 185, 129, 0.05); }
    .row-absent { background-color: rgba(239, 68, 68, 0.05); }

    /* ================= SUCCESS MODAL ANIMATION ================= */
    .modal-overlay {
        background-color: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(4px);
        transition: opacity 0.3s ease;
    }

    .modal-content {
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform: scale(0.8);
        opacity: 0;
    }

    .modal-active .modal-content {
        transform: scale(1);
        opacity: 1;
    }

    /* Checkmark Animation */
    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #10b981;
        fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .checkmark {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #fff;
        stroke-miterlimit: 10;
        margin: 10% auto;
        box-shadow: inset 0px 0px 0px #10b981;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }

    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
    }

    @keyframes stroke {
        100% { stroke-dashoffset: 0; }
    }
    @keyframes fill {
        100% { box-shadow: inset 0px 0px 0px 30px #10b981; }
    }
    @keyframes scale {
        0%, 100% { transform: none; }
        50% { transform: scale3d(1.1, 1.1, 1); }
    }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800 p-6 font-sans">
    
    <div class="max-w-5xl mx-auto">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 animate-enter">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Mark Attendance</h1>
                <p class="text-gray-500 mt-1">Select subject and date to record student presence.</p>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <button type="button" onclick="markAll(1)" class="text-sm font-medium px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Mark All Present
                </button>
                <button type="button" onclick="markAll(0)" class="text-sm font-medium px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Mark All Absent
                </button>
            </div>
        </div>

        <form id="attendanceForm" method="POST" action="{{ route('teacher.attendance.store') }}" class="space-y-6">
            @csrf

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 animate-enter stagger-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Select Subject</label>
                        <div class="relative">
                            <select name="subject_id" class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow appearance-none bg-white" required>
                                <option value="" disabled selected>-- Choose Subject --</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Attendance Date</label>
                        <input type="date" name="date" 
                               value="{{ date('Y-m-d') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow" 
                               required>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden animate-enter stagger-2">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h2 class="font-bold text-gray-800">Student List</h2>
                    <span class="text-xs font-medium text-gray-500">Ensure all students are marked</span>
                </div>

                @php
                    $students = \App\Models\Student::all(); 
                @endphp

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Student Name</th>
                                <th class="px-6 py-3 font-semibold text-center w-64">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="studentTableBody">
                            @foreach($students as $student)
                                <tr class="transition-colors hover:bg-gray-50 group" id="row-{{ $student->id }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm">
                                                {{ substr($student->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $student->user->name }}</p>
                                                <p class="text-xs text-gray-400">ID: {{ $student->roll_number ?? $student->id }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-center bg-gray-100 rounded-lg p-1 gap-1">
                                            <label class="flex-1">
                                                <input type="radio" 
                                                       name="attendance[{{ $student->id }}]" 
                                                       value="1" 
                                                       class="toggle-radio" 
                                                       onchange="highlightRow({{ $student->id }}, 1)"
                                                       required>
                                                <div class="toggle-label w-full text-center py-2 rounded-md text-sm font-semibold border border-transparent select-none">
                                                    Present
                                                </div>
                                            </label>

                                            <label class="flex-1">
                                                <input type="radio" 
                                                       name="attendance[{{ $student->id }}]" 
                                                       value="0" 
                                                       class="toggle-radio"
                                                       onchange="highlightRow({{ $student->id }}, 0)"
                                                       required>
                                                <div class="toggle-label w-full text-center py-2 rounded-md text-sm font-semibold border border-transparent select-none">
                                                    Absent
                                                </div>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        Save Attendance Record
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<div id="successModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 modal-overlay opacity-0" id="modalBackdrop"></div>
    
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full relative z-10 modal-content text-center">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
        </svg>

        <h3 class="text-2xl font-bold text-gray-900 mt-4 mb-2">Saved Successfully!</h3>
        <p class="text-gray-500 text-sm">Attendance records have been updated in the system.</p>
        
        <div class="mt-6 flex justify-center">
            <div class="h-1 w-24 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 animate-[width_2s_ease-in-out_forwards]" style="width: 0%"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Highlight Row Logic
    function highlightRow(id, status) {
        const row = document.getElementById('row-' + id);
        row.classList.remove('row-present', 'row-absent');
        if (status == 1) {
            row.classList.add('row-present');
        } else {
            row.classList.add('row-absent');
        }
    }

    // 2. Mark All Logic
    function markAll(status) {
        const radios = document.querySelectorAll(`input[type="radio"][value="${status}"]`);
        radios.forEach(radio => {
            radio.checked = true;
            radio.dispatchEvent(new Event('change'));
        });
    }

    // 3. Form Submission Interception & Animation
    document.getElementById('attendanceForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Stop immediate submission

        // Check if form is valid (HTML5 validation)
        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        const modal = document.getElementById('successModal');
        const backdrop = document.getElementById('modalBackdrop');
        const form = this;

        // Show Modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Trigger Animations (small timeout to allow display:flex to render)
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            modal.classList.add('modal-active');
        }, 10);

        // Wait 2 seconds for animation, then submit real form
        setTimeout(() => {
            form.submit();
        }, 2200);
    });
</script>

@endsection