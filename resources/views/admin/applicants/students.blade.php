@extends('layouts.admin')

@section('title', 'Student Applications')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Student Applications</h1>
            <p class="text-slate-500 mt-1 font-medium">Live sync from Google Sheets CRM.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#F0EBE1] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#FDFBF7] border-b border-[#F0EBE1]">
                        <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Date</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Applicant Info</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Course</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Documents</th>
                        <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F0EBE1]">
                    @forelse($applicants as $app)
                        @php
                            // Check if this email already exists in the Laravel database
                            $isApproved = \App\Models\User::where('email', $app['Email'])->exists();
                        @endphp

                        <tr class="hover:bg-slate-50 transition-colors {{ $isApproved ? 'opacity-75 bg-slate-50/50' : '' }}">
                            <td class="py-4 px-6 text-sm text-slate-500 font-medium whitespace-nowrap">
                                {{ date('d M, Y', strtotime($app['Timestamp'] ?? 'now')) }}
                                <div class="text-xs text-slate-400 mt-0.5">{{ date('h:i A', strtotime($app['Timestamp'] ?? 'now')) }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $app['Name'] ?? 'N/A' }}</div>
                                <div class="text-sm text-slate-500 mt-0.5">{{ $app['Email'] ?? 'N/A' }}</div>
                                <div class="text-xs text-indigo-500 font-bold mt-1.5 flex items-center gap-1.5">
                                    <i class="fa-solid fa-phone"></i> {{ $app['Phone'] ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-bold border border-indigo-100 shadow-sm inline-block">
                                    {{ $app['Course'] ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex gap-2">
                                    <a href="{{ $app['Photo'] ?? '#' }}" target="_blank" class="w-9 h-9 rounded-xl bg-[#FDFBF7] border border-[#F0EBE1] text-slate-500 flex items-center justify-center hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm group" title="View Photo">
                                        <i class="fa-solid fa-camera group-hover:scale-110 transition-transform"></i>
                                    </a>
                                    <a href="{{ $app['Signature'] ?? '#' }}" target="_blank" class="w-9 h-9 rounded-xl bg-[#FDFBF7] border border-[#F0EBE1] text-slate-500 flex items-center justify-center hover:bg-purple-600 hover:text-white hover:border-purple-600 transition-all shadow-sm group" title="View Signature">
                                        <i class="fa-solid fa-signature group-hover:scale-110 transition-transform"></i>
                                    </a>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right">
                                @if($isApproved)
                                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 text-slate-400 font-bold text-sm rounded-lg border border-slate-200 cursor-not-allowed select-none">
                                        <i class="fa-solid fa-check-double text-emerald-500"></i> Added
                                    </span>
                                @else
                                    <a href="{{ route('admin.students.create', ['name' => $app['Name'] ?? '', 'email' => $app['Email'] ?? '']) }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 font-bold text-sm rounded-lg border border-emerald-200 hover:bg-emerald-500 hover:text-white transition-all duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 group">
                                        <i class="fa-solid fa-user-check group-hover:scale-110 transition-transform"></i> Approve
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center">
                                <div class="w-16 h-16 bg-[#FDFBF7] border border-[#F0EBE1] rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                    <i class="fa-solid fa-inbox text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-700 mb-1">No Student Applications</h3>
                                <p class="text-slate-500 text-sm font-medium">New submissions from the landing page will appear here instantly.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection