@extends('layouts.teacher')

@section('title', 'Enter Marks')

@section('content')

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

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }

    /* Input Styling */
    .mark-input {
        transition: all 0.2s ease;
        text-align: center;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .mark-input:focus {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        border-color: #4f46e5;
    }

    /* Table Row Hover */
    .student-row {
        transition: background-color 0.2s ease;
    }
    .student-row:hover {
        background-color: #f9fafb;
    }
    .student-row:focus-within {
        background-color: #eef2ff; /* Light Indigo background when typing */
        border-left: 4px solid #4f46e5;
    }

    /* Grade Badge transition */
    .grade-badge {
        transition: all 0.3s ease;
    }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800 p-6 font-sans">
    
    <div class="max-w-5xl mx-auto">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 animate-enter">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Enter Student Marks</h1>
                <p class="text-gray-500 mt-1">Record examination results for the current semester.</p>
            </div>
            
            <div class="mt-4 md:mt-0 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200 flex items-center gap-3">
                <div class="text-right">
                    <p class="text-xs text-gray-500 uppercase font-bold">Class Average</p>
                    <p class="text-xl font-bold text-indigo-600" id="classAverage">0.0</p>
                </div>
                <div class="h-8 w-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('teacher.marks.store') }}" class="space-y-6">
            @csrf

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 animate-enter stagger-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Select Subject</label>
                        <div class="relative">
                            <select name="subject_id" class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white cursor-pointer" required>
                                <option value="" disabled selected>-- Choose Subject --</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 flex justify-between items-center">
                        <span class="text-sm text-gray-500 font-medium">Maximum Marks</span>
                        <span class="text-lg font-bold text-gray-900">100</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden animate-enter stagger-2">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h2 class="font-bold text-gray-800">Student List</h2>
                    <span class="text-xs text-gray-400 italic">Tab key navigates to next student</span>
                </div>

                @php
                    $students = \App\Models\Student::all();
                @endphp

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Student Name</th>
                                <th class="px-6 py-3 font-semibold text-center w-32">Marks Obt.</th>
                                <th class="px-6 py-3 font-semibold text-center w-32">Grade</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($students as $student)
                                <tr class="student-row group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                                {{ substr($student->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $student->user->name }}</p>
                                                <p class="text-xs text-gray-400">ID: {{ $student->roll_number ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <input type="number" 
                                               name="marks[{{ $student->id }}]" 
                                               class="mark-input w-24 px-2 py-2 border border-gray-300 rounded-lg focus:outline-none" 
                                               min="0" 
                                               max="100" 
                                               step="0.01"
                                               placeholder="0"
                                               required
                                               oninput="updateGrade(this)">
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span class="grade-badge inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-400 w-12">
                                            -
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                    <p class="text-sm text-gray-500">Double check values before saving.</p>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Save Marks
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function updateGrade(input) {
        const val = parseFloat(input.value);
        const row = input.closest('tr');
        const badge = row.querySelector('.grade-badge');
        
        // Remove old styles
        badge.className = 'grade-badge inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-bold w-12 transition-all duration-300';

        if (isNaN(val) || input.value === '') {
            badge.innerText = '-';
            badge.classList.add('bg-gray-100', 'text-gray-400');
        } else {
            // Validate Max
            if(val > 100) {
                input.value = 100;
                updateGrade(input);
                return;
            }
            // Validate Min
            if(val < 0) {
                input.value = 0;
                updateGrade(input);
                return;
            }

            // Assign Grade Logic
            if (val >= 90) {
                badge.innerText = 'A+';
                badge.classList.add('bg-green-100', 'text-green-700');
            } else if (val >= 80) {
                badge.innerText = 'A';
                badge.classList.add('bg-green-50', 'text-green-600');
            } else if (val >= 70) {
                badge.innerText = 'B';
                badge.classList.add('bg-blue-100', 'text-blue-700');
            } else if (val >= 60) {
                badge.innerText = 'C';
                badge.classList.add('bg-yellow-100', 'text-yellow-700');
            } else if (val >= 40) {
                badge.innerText = 'D';
                badge.classList.add('bg-orange-100', 'text-orange-700');
            } else {
                badge.innerText = 'F';
                badge.classList.add('bg-red-100', 'text-red-700');
            }
        }
        
        calculateClassAverage();
    }

    function calculateClassAverage() {
        const inputs = document.querySelectorAll('.mark-input');
        let total = 0;
        let count = 0;

        inputs.forEach(inp => {
            const val = parseFloat(inp.value);
            if (!isNaN(val)) {
                total += val;
                count++;
            }
        });

        const avg = count > 0 ? (total / count).toFixed(2) : '0.0';
        const avgElement = document.getElementById('classAverage');
        
        // Animate number change slightly
        avgElement.style.opacity = 0.5;
        setTimeout(() => {
            avgElement.innerText = avg;
            avgElement.style.opacity = 1;
        }, 150);
    }
</script>

@endsection