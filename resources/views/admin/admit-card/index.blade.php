@extends('layouts.admin')

@section('title', 'Manage Admit Cards')

@section('content')
<div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 animate-enter">

    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Admit Card Publication</h1>
            <p class="text-slate-500 mt-1 font-medium">Control when students can download their hall tickets.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3 font-bold shadow-sm">
            <i class="fa-solid fa-circle-check text-xl animate-pulse"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($courses as $course)
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                
                <div class="p-6 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shadow-sm">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        @if($course->admit_cards_published)
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-black uppercase tracking-wider rounded-lg flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Published
                            </span>
                        @else
                            <span class="px-3 py-1 bg-slate-100 text-slate-500 text-xs font-black uppercase tracking-wider rounded-lg">
                                Draft Mode
                            </span>
                        @endif
                    </div>
                    
                    <h3 class="text-lg font-black text-slate-800 leading-tight mb-1">{{ $course->name }}</h3>
                    <p class="text-sm text-slate-500 font-bold"><i class="fa-solid fa-users mr-1"></i> {{ $course->students_count }} Students Enrolled</p>
                </div>

                <div class="p-4 border-t border-slate-100 bg-slate-50">
                    <form action="{{ route('admin.admit-card.toggle', $course) }}" method="POST" data-confirm="Are you sure you want to change the publication status for this course?">
                        @csrf
                        @if($course->admit_cards_published)
                            <button type="submit" class="w-full py-2.5 bg-white border-2 border-rose-200 text-rose-600 hover:bg-rose-50 hover:border-rose-300 font-bold rounded-xl transition-colors flex items-center justify-center gap-2">
                                <i class="fa-solid fa-ban"></i> Revoke Access
                            </button>
                        @else
                            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-paper-plane"></i> Publish Admit Cards
                            </button>
                        @endif
                    </form>
                </div>

            </div>
        @endforeach
    </div>

</div>

@endsection