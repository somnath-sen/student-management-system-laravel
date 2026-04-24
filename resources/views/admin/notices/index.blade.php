@extends('layouts.admin')

@section('title', 'Notice Board')

@section('content')

<style>
    .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Campus Notice Board</h1>
            <p class="text-slate-500 mt-1 font-medium">Broadcast announcements to all students and staff.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3 animate-fade-in">
            <i class="fa-solid fa-circle-check text-xl"></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-6">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-indigo-500"></i> Compose Notice
                    </h2>
                </div>
                
                <form action="{{ route('admin.notices.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Notice Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" required placeholder="e.g. Final Semester Exam Schedule" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm font-medium outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Category <span class="text-rose-500">*</span></label>
                        <select name="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm font-medium outline-none bg-white">
                            <option value="General">📢 General Update</option>
                            <option value="Exam">📝 Examination</option>
                            <option value="Holiday">🌴 Holiday / Vacation</option>
                            <option value="Urgent">🚨 Urgent Alert</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Message Content <span class="text-rose-500">*</span></label>
                        <textarea name="content" required rows="5" placeholder="Type your announcement here..." class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm font-medium outline-none resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Publish Now
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight mb-4 flex items-center gap-2">
                <i class="fa-solid fa-rss text-slate-400"></i> Live Broadcast Feed
            </h2>
            
            <div class="space-y-4">
                @forelse($notices as $notice)
                    @php
                        // Determine badge color based on category
                        $badgeColors = [
                            'Urgent' => 'bg-rose-100 text-rose-700 border-rose-200',
                            'Exam' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                            'Holiday' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'General' => 'bg-blue-100 text-blue-700 border-blue-200',
                        ];
                        $colorClass = $badgeColors[$notice->category] ?? $badgeColors['General'];
                    @endphp

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-shadow relative group">
                        
                        <form action="{{ route('admin.notices.destroy', $notice) }}" method="POST" class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transition-opacity" data-confirm="Delete this notice permanently?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 rounded-full bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white flex items-center justify-center transition-colors">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>

                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider border {{ $colorClass }}">
                                {{ $notice->category }}
                            </span>
                            <span class="text-xs font-bold text-slate-400">
                                <i class="fa-regular fa-clock mr-1"></i> {{ $notice->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 mb-2 pr-8">{{ $notice->title }}</h3>
                        
                        <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-wrap">{{ $notice->content }}</p>
                        
                        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-[10px] font-bold">
                                {{ substr($notice->author->name ?? 'A', 0, 1) }}
                            </div>
                            <span class="text-xs font-medium text-slate-500">Posted by {{ $notice->author->name ?? 'Administrator' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl border border-slate-200 border-dashed p-12 text-center">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                            <i class="fa-solid fa-inbox text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">No Active Notices</h3>
                        <p class="text-slate-500 text-sm mt-1">Use the form on the left to broadcast your first announcement.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection