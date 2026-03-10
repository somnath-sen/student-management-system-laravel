@extends('layouts.admin')

@section('title', 'Fee Management')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Fee Structures</h1>
            <p class="text-slate-500 mt-1 font-medium">Create and manage institutional dues.</p>
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
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-file-invoice-dollar text-indigo-500"></i> Generate New Fee
                    </h2>
                </div>
                
                <form action="{{ route('admin.fees.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Fee Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" required placeholder="e.g. Semester 1 Tuition" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm font-medium">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Amount (₹) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-slate-400 font-bold">₹</span>
                            <input type="number" step="0.01" name="amount" required placeholder="50000.00" class="w-full pl-8 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm font-bold text-slate-800">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Due Date <span class="text-rose-500">*</span></label>
                        <input type="date" name="due_date" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Assign to Course</label>
                        <select name="course_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm font-medium text-slate-700 bg-white">
                            <option value="">All Students (Global Fee)</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Leave blank to apply to everyone.</p>
                    </div>

                    <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus"></i> Publish Fee
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Fee Details</th>
                                <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Amount</th>
                                <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Target</th>
                                <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Due By</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($fees as $fee)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-slate-900">{{ $fee->title }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5">Created {{ $fee->created_at->format('d M, Y') }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-bold border border-emerald-100">
                                            ₹{{ number_format($fee->amount, 2) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($fee->course_id)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-md border border-indigo-100">
                                                <i class="fa-solid fa-book-open"></i> {{ $fee->course->name }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-md border border-purple-100">
                                                <i class="fa-solid fa-globe"></i> Global
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="text-sm font-bold {{ \Carbon\Carbon::parse($fee->due_date)->isPast() ? 'text-rose-500' : 'text-slate-600' }}">
                                            {{ \Carbon\Carbon::parse($fee->due_date)->format('d M, Y') }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-16 text-center text-slate-500 font-medium">
                                        <div class="w-16 h-16 bg-slate-50 border border-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                                            <i class="fa-solid fa-receipt text-2xl"></i>
                                        </div>
                                        No fees generated yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-8">
        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight mb-4 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-indigo-500"></i> Recent Transactions
        </h2>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Student</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Fee Category</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">Amount Paid</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider">TXN ID / Method</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider text-right">Status / Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                            {{ substr($payment->student->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900">{{ $payment->student->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $payment->student->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-medium text-slate-700">{{ $payment->fee->title }}</td>
                                <td class="py-4 px-6">
                                    <span class="font-bold text-slate-900">₹{{ number_format($payment->amount_paid, 2) }}</span>
                                    
                                    @if($payment->status == 'pending')
                                        <span class="ml-2 px-2 py-0.5 bg-amber-100 text-amber-700 rounded text-[10px] font-bold uppercase tracking-wider">Pending</span>
                                    @else
                                        <span class="ml-2 px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded text-[10px] font-bold uppercase tracking-wider">Paid</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-mono text-xs text-slate-600 bg-slate-100 px-2 py-1 rounded inline-block">{{ $payment->transaction_id ?? 'No Ref' }}</div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1">{{ $payment->payment_method }}</div>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    @if($payment->status == 'pending')
                                        <div class="flex items-center justify-end gap-2">
                                            @if($payment->receipt_path)
                                                <a href="{{ asset('storage/' . $payment->receipt_path) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold rounded-lg transition-colors">
                                                    <i class="fa-solid fa-eye"></i> View Proof
                                                </a>
                                            @endif
                                            
                                            <form action="{{ route('admin.fees.approve', $payment->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="px-4 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                                                    Approve
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-sm font-medium text-slate-500">{{ $payment->created_at->format('d M Y') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-500 font-medium">No payments received yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
    .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection