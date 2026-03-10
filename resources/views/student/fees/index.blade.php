@extends('layouts.student')

@section('title', 'My Fees')

@section('content')
<div class="max-w-7xl mx-auto relative">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Fee Management</h1>
            <p class="text-slate-500 mt-1 font-medium">View and pay your institutional dues securely.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3 animate-fade-in">
            <i class="fa-solid fa-circle-check text-xl"></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($fees as $fee)
            @php
                $isPaid = in_array($fee->id, $paidFeeIds);
                $isPending = in_array($fee->id, $pendingFeeIds ?? []);
                $isOverdue = !$isPaid && !$isPending && \Carbon\Carbon::parse($fee->due_date)->isPast();
            @endphp

            <div class="bg-white rounded-2xl shadow-sm border {{ $isPaid ? 'border-emerald-200' : ($isPending ? 'border-amber-200' : ($isOverdue ? 'border-rose-200' : 'border-slate-200')) }} overflow-hidden hover:shadow-md transition-all relative flex flex-col">
                
                <div class="h-1.5 w-full {{ $isPaid ? 'bg-emerald-500' : ($isPending ? 'bg-amber-500' : ($isOverdue ? 'bg-rose-500' : 'bg-indigo-500')) }}"></div>

                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 rounded-xl {{ $isPaid ? 'bg-emerald-50 text-emerald-600' : ($isPending ? 'bg-amber-50 text-amber-600' : 'bg-indigo-50 text-indigo-600') }}">
                            <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                        </div>
                        
                        @if($isPaid)
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-lg flex items-center gap-1">
                                <i class="fa-solid fa-check-circle"></i> Paid
                            </span>
                        @elseif($isPending)
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-lg flex items-center gap-1 animate-pulse">
                                <i class="fa-solid fa-hourglass-half"></i> Verifying...
                            </span>
                        @elseif($isOverdue)
                            <span class="px-3 py-1 bg-rose-100 text-rose-700 text-xs font-bold rounded-lg flex items-center gap-1 animate-pulse">
                                <i class="fa-solid fa-circle-exclamation"></i> Overdue
                            </span>
                        @else
                            <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg flex items-center gap-1">
                                <i class="fa-regular fa-clock"></i> Unpaid
                            </span>
                        @endif
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $fee->title }}</h3>
                    <p class="text-sm text-slate-500 mb-6 line-clamp-2 flex-1">{{ $fee->description ?? 'No additional details provided.' }}</p>

                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Amount Due</p>
                            <p class="text-2xl font-black text-slate-900">₹{{ number_format($fee->amount, 2) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Due Date</p>
                            <p class="text-sm font-bold {{ $isOverdue ? 'text-rose-600' : 'text-slate-700' }}">
                                {{ \Carbon\Carbon::parse($fee->due_date)->format('d M, Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-auto">
                        @if($isPaid)
                            <a href="{{ route('student.fees.receipt', $fee->id) }}" target="_blank" class="w-full py-3 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 hover:border-emerald-300 rounded-xl font-bold text-sm border border-emerald-200 transition-all flex items-center justify-center gap-2 group">
                                <i class="fa-solid fa-download group-hover:-translate-y-0.5 transition-transform"></i> Download Receipt
                            </a>
                        @elseif($isPending)
                            <button disabled class="w-full py-3 bg-amber-50 text-amber-500 rounded-xl font-bold text-sm border border-amber-200 cursor-not-allowed flex items-center justify-center gap-2">
                                <i class="fa-solid fa-clock"></i> Pending Admin Approval
                            </button>
                        @else
                            <button onclick="payOnline({{ $fee->id }}, {{ $fee->amount }}, '{{ $fee->title }}')" class="w-full py-3 bg-slate-900 hover:bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 mb-3 group">
                                <i class="fa-solid fa-credit-card group-hover:scale-110 transition-transform"></i> Pay Online
                            </button>
                            <button onclick="openOfflineModal({{ $fee->id }}, {{ $fee->amount }})" class="w-full py-2.5 bg-white hover:bg-slate-50 text-slate-600 rounded-xl font-bold text-sm border border-slate-200 transition-all flex items-center justify-center gap-2 group">
                                <i class="fa-solid fa-building-columns text-slate-400 group-hover:text-indigo-500 transition-colors"></i> Submit Bank/Cash Receipt
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-500 font-medium bg-white rounded-2xl border border-slate-200">
                <div class="w-16 h-16 bg-slate-50 border border-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <i class="fa-solid fa-check-double text-2xl"></i>
                </div>
                You have no pending fees at this moment.
            </div>
        @endforelse
    </div>
</div>

<div id="offlineModal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeOfflineModal()"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8 relative pointer-events-auto transform transition-all">
            <button onclick="closeOfflineModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
            
            <h2 class="text-2xl font-extrabold text-slate-900 mb-1">Offline Payment</h2>
            <p class="text-slate-500 text-sm mb-6 font-medium">Submit your transaction details for verification.</p>
            
            <form action="{{ route('student.fees.offline') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <input type="hidden" name="fee_id" id="offline_fee_id">
                <input type="hidden" name="amount" id="offline_amount">
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Payment Method <span class="text-rose-500">*</span></label>
                    <select name="payment_method" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 bg-white text-sm font-medium text-slate-700 outline-none transition-all">
                        <option value="Bank Transfer (NEFT/IMPS)">Bank Transfer (NEFT/IMPS)</option>
                        <option value="UPI Direct">UPI Direct to College Bank</option>
                        <option value="Cash at Counter">Cash at Counter</option>
                        <option value="Demand Draft / Cheque">Demand Draft / Cheque</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Transaction/Reference Number</label>
                    <input type="text" name="transaction_id" placeholder="e.g. UTR Number or Receipt No." class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none transition-all text-sm">
                    <p class="text-xs text-slate-500 mt-1.5">Leave blank if paying cash at the counter.</p>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Upload Receipt (Proof) <span class="text-rose-500">*</span></label>
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-4 text-center hover:bg-slate-50 transition-colors">
                        <input type="file" name="receipt" accept=".jpg,.jpeg,.png,.pdf" required class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    </div>
                    <p class="text-xs font-bold text-rose-500 mt-1.5">Max size: 2MB (JPG, PNG, PDF)</p>
                </div>
                
                <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all text-sm mt-2 flex justify-center items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Submit for Verification
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    // --- Offline Modal Logic ---
    function openOfflineModal(feeId, amount) {
        document.getElementById('offline_fee_id').value = feeId;
        document.getElementById('offline_amount').value = amount;
        document.getElementById('offlineModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }
    
    function closeOfflineModal() {
        document.getElementById('offlineModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // --- Online Razorpay Logic ---
    async function payOnline(feeId, amount, feeTitle) {
        const btn = event.currentTarget;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
        btn.disabled = true;

        try {
            const orderResponse = await fetch("{{ route('student.fees.order') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ fee_id: feeId })
            });

            const orderData = await orderResponse.json();

            var options = {
                "key": orderData.key, 
                "amount": orderData.amount, 
                "currency": "INR",
                "name": "EdFlow Academy",
                "description": "Payment for: " + feeTitle,
                "image": "https://cdn-icons-png.flaticon.com/512/3135/3135810.png", 
                "order_id": orderData.order_id, 
                "handler": async function (response) {
                    const verifyResponse = await fetch("{{ route('student.fees.verify') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature,
                            fee_id: feeId,
                            amount: amount
                        })
                    });

                    const verifyData = await verifyResponse.json();

                    if(verifyData.success) {
                        alert("Payment Successful! Your receipt has been recorded.");
                        window.location.reload(); 
                    } else {
                        alert("Payment verification failed. Please contact admin.");
                    }
                },
                "prefill": {
                    "name": orderData.user_name,
                    "email": orderData.user_email,
                },
                "theme": {
                    "color": "#4f46e5"
                }
            };

            var rzp1 = new Razorpay(options);
            rzp1.on('payment.failed', function (response){
                alert("Payment Failed: " + response.error.description);
            });
            rzp1.open();

        } catch (error) {
            alert("Something went wrong. Please try again.");
            console.error(error);
        } finally {
            btn.innerHTML = originalHtml;
            btn.disabled = false;
        }
    }
</script>
@endsection