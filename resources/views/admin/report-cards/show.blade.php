@extends('layouts.admin')

@section('title', 'Manage Report Card')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.report-cards.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-indigo-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manage Report Card</h1>
            <p class="text-sm text-slate-500 mt-1">Generate or send report card for {{ $student->user->name }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-check text-emerald-500 mr-3"></i>
                <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Student Info Card -->
        <div class="md:col-span-1 bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-500 text-white flex items-center justify-center text-3xl font-black mb-4 shadow-lg shadow-indigo-500/30">
                    {{ substr($student->user->name, 0, 1) }}
                </div>
                <h3 class="text-lg font-bold text-slate-800">{{ $student->user->name }}</h3>
                <p class="text-sm text-slate-500">{{ $student->roll_number }}</p>
                <div class="mt-3 px-3 py-1 bg-slate-100 rounded-lg text-xs font-bold text-slate-600">
                    {{ $student->course->name ?? 'No Course' }}
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-slate-100">
                    <span class="text-sm text-slate-500">Total Subjects</span>
                    <span class="text-sm font-bold text-slate-800">{{ $marks->count() }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-100">
                    <span class="text-sm text-slate-500">Attendance</span>
                    <span class="text-sm font-bold text-indigo-600">{{ $attendancePercentage }}%</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-100">
                    <span class="text-sm text-slate-500">Parents Linked</span>
                    <span class="text-sm font-bold text-slate-800">{{ $student->parents->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Actions & Remark Form -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Actions</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('admin.report-cards.generate', $student->id) }}" class="flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-md shadow-indigo-500/20">
                        <i class="fa-solid fa-download"></i>
                        Download PDF
                    </a>
                    
                    <form action="{{ route('admin.report-cards.send', $student->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold transition-all shadow-md shadow-emerald-500/20" onclick="return confirm('Send report card email to parent(s)?')">
                            <i class="fa-solid fa-paper-plane"></i>
                            Send to Parent
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Teacher / Admin Remark</h3>
                <form action="{{ route('admin.report-cards.remark', $student->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Remark for Report Card</label>
                        <textarea name="report_card_remark" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm text-slate-700" placeholder="e.g. Excellent performance this term. Keep it up!">{{ old('report_card_remark', $student->report_card_remark) }}</textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold transition-all text-sm">
                            Save Remark
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
