@extends('layouts.admin')

@section('title', 'Exam Calendar')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Exam Calendar</h2>
            <p class="text-sm font-medium text-slate-500 mt-1">Manage exam schedules and visibility for courses.</p>
        </div>
        <div class="flex gap-3">
            <button onclick="openScheduleModal('', '')" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md transition-colors flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Add Custom Exam
            </button>
        </div>
    </div>

    <!-- Course Filter -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <form action="{{ route('admin.exams.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="w-full sm:w-96">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Filter by Course</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-graduation-cap text-slate-400"></i>
                    </div>
                    <select name="course_id" onchange="this.form.submit()" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none">
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $selectedCourseId == $course->id ? 'selected' : '' }}>
                                {{ $course->name }} ({{ $course->course_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    <!-- Exams Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        @if($subjects->count() > 0 || $exams->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Visibility</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @php
                            $matchedExamIds = [];
                        @endphp
                        
                        @foreach($subjects as $subject)
                            @php
                                $exam = $exams->firstWhere('subject_name', $subject->name);
                                if ($exam) $matchedExamIds[] = $exam->id;
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-slate-800">{{ $subject->name }}</p>
                                    <p class="text-xs font-medium text-indigo-600 mt-0.5">{{ $subject->subject_code ?? 'N/A' }}</p>
                                </td>
                                
                                @if($exam)
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex flex-col items-center justify-center flex-shrink-0">
                                                <span class="text-xs font-black leading-none">{{ $exam->exam_date->format('d') }}</span>
                                                <span class="text-[9px] font-bold uppercase tracking-wider mt-0.5">{{ $exam->exam_date->format('M') }}</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $exam->exam_date->format('l') }}</p>
                                                <p class="text-xs font-medium text-slate-500 flex items-center gap-1.5 mt-0.5">
                                                    <i class="fa-regular fa-clock"></i> {{ $exam->exam_time }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.exams.toggle', $exam) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $exam->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}">
                                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $exam->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                            </button>
                                            <p class="text-[10px] font-bold mt-1 {{ $exam->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                                                {{ $exam->is_active ? 'Visible' : 'Hidden' }}
                                            </p>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button onclick="openEditModal({{ $exam->toJson() }})" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors tooltip-btn" data-tippy-content="Edit">
                                                <i class="fa-solid fa-pen text-xs"></i>
                                            </button>
                                            <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="inline-block" data-confirm="Are you sure you want to delete this exam?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition-colors tooltip-btn" data-tippy-content="Delete">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @else
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-slate-400">
                                            <i class="fa-regular fa-calendar-xmark"></i>
                                            <span class="text-sm font-medium">Not Scheduled</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-slate-300">-</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button onclick="openScheduleModal('{{ addslashes($subject->name) }}', '{{ addslashes($subject->subject_code ?? '') }}')" class="px-4 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 text-xs font-bold rounded-lg transition-colors inline-flex items-center gap-1.5">
                                            <i class="fa-solid fa-calendar-plus"></i> Schedule
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        {{-- Display custom exams that don't match any subjects --}}
                        @foreach($exams->whereNotIn('id', $matchedExamIds) as $exam)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-slate-800">{{ $exam->subject_name }}</p>
                                    <p class="text-xs font-medium text-indigo-600 mt-0.5">{{ $exam->subject_code ?? 'Custom' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex flex-col items-center justify-center flex-shrink-0">
                                            <span class="text-xs font-black leading-none">{{ $exam->exam_date->format('d') }}</span>
                                            <span class="text-[9px] font-bold uppercase tracking-wider mt-0.5">{{ $exam->exam_date->format('M') }}</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800">{{ $exam->exam_date->format('l') }}</p>
                                            <p class="text-xs font-medium text-slate-500 flex items-center gap-1.5 mt-0.5">
                                                <i class="fa-regular fa-clock"></i> {{ $exam->exam_time }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.exams.toggle', $exam) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $exam->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $exam->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                        <p class="text-[10px] font-bold mt-1 {{ $exam->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                                            {{ $exam->is_active ? 'Visible' : 'Hidden' }}
                                        </p>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button onclick="openEditModal({{ $exam->toJson() }})" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors tooltip-btn" data-tippy-content="Edit">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </button>
                                        <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="inline-block" data-confirm="Are you sure you want to delete this exam?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition-colors tooltip-btn" data-tippy-content="Delete">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-regular fa-calendar-xmark text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">No Subjects or Exams found</h3>
                <p class="text-sm font-medium text-slate-500">There are no subjects or exams for this course yet.</p>
                <button onclick="openScheduleModal('', '')" class="mt-4 px-4 py-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 text-sm font-bold rounded-lg transition-colors">
                    Add Custom Exam
                </button>
            </div>
        @endif
    </div>

</div>

<!-- Add Exam Modal -->
<div id="addExamModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="document.getElementById('addExamModal').classList.add('hidden')"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-lg">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100 animate-content">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-lg">Add New Exam</h3>
                <button onclick="document.getElementById('addExamModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.exams.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $selectedCourseId }}">
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Subject Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="subject_name" id="add_subject_name" required placeholder="e.g., Database Management" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Subject Code</label>
                        <input type="text" name="subject_code" id="add_subject_code" placeholder="e.g., CS-401" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Exam Date <span class="text-rose-500">*</span></label>
                            <input type="date" name="exam_date" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Time <span class="text-rose-500">*</span></label>
                            <input type="text" name="exam_time" required placeholder="10:00 AM - 1:00 PM" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                            <span class="text-sm font-bold text-slate-700">Make visible to students immediately</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('addExamModal').classList.add('hidden')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md transition-colors">
                            Save Exam
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Exam Modal -->
<div id="editExamModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="document.getElementById('editExamModal').classList.add('hidden')"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-lg">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100 animate-content">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 text-lg">Edit Exam</h3>
                <button onclick="document.getElementById('editExamModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="editExamForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="course_id" value="{{ $selectedCourseId }}">
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Subject Name <span class="text-rose-500">*</span></label>
                        <input type="text" id="edit_subject_name" name="subject_name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Subject Code</label>
                        <input type="text" id="edit_subject_code" name="subject_code" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Exam Date <span class="text-rose-500">*</span></label>
                            <input type="date" id="edit_exam_date" name="exam_date" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Time <span class="text-rose-500">*</span></label>
                            <input type="text" id="edit_exam_time" name="exam_time" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('editExamModal').classList.add('hidden')" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md transition-colors">
                            Update Exam
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openScheduleModal(subjectName, subjectCode) {
        document.getElementById('add_subject_name').value = subjectName;
        document.getElementById('add_subject_code').value = subjectCode;
        
        // If subject is selected, make fields readonly (or just prepopulated)
        if (subjectName) {
            document.getElementById('add_subject_name').readOnly = true;
            document.getElementById('add_subject_name').classList.add('bg-slate-100', 'text-slate-500');
        } else {
            document.getElementById('add_subject_name').readOnly = false;
            document.getElementById('add_subject_name').classList.remove('bg-slate-100', 'text-slate-500');
        }
        
        if (subjectCode) {
            document.getElementById('add_subject_code').readOnly = true;
            document.getElementById('add_subject_code').classList.add('bg-slate-100', 'text-slate-500');
        } else {
            document.getElementById('add_subject_code').readOnly = false;
            document.getElementById('add_subject_code').classList.remove('bg-slate-100', 'text-slate-500');
        }

        document.getElementById('addExamModal').classList.remove('hidden');
    }

    function openEditModal(exam) {
        document.getElementById('editExamForm').action = `/admin/exams/${exam.id}`;
        document.getElementById('edit_subject_name').value = exam.subject_name;
        document.getElementById('edit_subject_code').value = exam.subject_code || '';
        document.getElementById('edit_exam_date').value = exam.exam_date.split('T')[0];
        document.getElementById('edit_exam_time').value = exam.exam_time;
        document.getElementById('editExamModal').classList.remove('hidden');
    }
</script>

@endsection
