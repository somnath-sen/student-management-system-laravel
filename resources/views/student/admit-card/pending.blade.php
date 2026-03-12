@extends('layouts.student')

@section('title', 'Admit Card')

@section('content')

<div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 flex items-center justify-center min-h-[70vh]">
    <div class="bg-white p-10 rounded-3xl shadow-xl border border-slate-200 text-center max-w-md w-full animate-enter">
        
        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner border border-slate-100 relative">
            <i class="fa-solid fa-file-circle-xmark text-4xl text-slate-400"></i>
            <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-indigo-50 rounded-full border-[3px] border-white flex items-center justify-center shadow-sm">
                <i class="fa-solid fa-lock text-indigo-500 text-sm"></i>
            </div>
        </div>

        <h2 class="text-2xl font-black text-slate-900 mb-2">Not Yet Available</h2>
        <p class="text-slate-500 font-medium leading-relaxed mb-8">
            Admit cards for your course have not been published by the examination department yet. You will be notified once they are released.
        </p>

        <a href="{{ route('student.dashboard') }}" class="inline-block w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-md transition-colors">
            Return to Dashboard
        </a>
    </div>
</div>

@endsection