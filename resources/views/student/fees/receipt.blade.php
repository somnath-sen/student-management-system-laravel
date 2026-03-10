<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $payment->transaction_id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        @media print {
            body { background: white; }
            .no-print { display: none !important; }
            .print-border { border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 2rem; }
        }
    </style>
</head>
<body class="p-8 text-slate-800">

    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex justify-end gap-3 no-print">
            <button onclick="window.close()" class="px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50">Close</button>
            <button onclick="window.print()" class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">Print / Save as PDF</button>
        </div>

        <div class="bg-white p-10 rounded-2xl shadow-sm border border-slate-200 print-border relative overflow-hidden">
            
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

            <div class="flex justify-between items-start mb-12 mt-2">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">EdFlow<span class="text-indigo-600">.</span></h1>
                    <p class="text-sm text-slate-500 font-medium mt-1">Official Payment Receipt</p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Receipt No.</p>
                    <p class="font-mono font-bold text-slate-900">{{ strtoupper(substr(md5($payment->id), 0, 8)) }}-{{ date('Y') }}</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mt-3">Date Paid</p>
                    <p class="font-medium text-slate-800">{{ $payment->created_at->format('d M, Y h:i A') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mb-12">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Billed To</p>
                    <h3 class="font-bold text-slate-900 text-lg">{{ $student->name }}</h3>
                    <p class="text-sm text-slate-600">{{ $student->email }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Payment Details</p>
                    <p class="text-sm text-slate-600"><span class="font-medium">Method:</span> {{ $payment->payment_method }}</p>
                    <p class="text-sm text-slate-600"><span class="font-medium">TXN ID:</span> <span class="font-mono text-xs">{{ $payment->transaction_id }}</span></p>
                    <p class="text-sm font-bold text-emerald-600 mt-1">Status: SUCCESS</p>
                </div>
            </div>

            <table class="w-full text-left mb-8 border-t border-b border-slate-200">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Description</th>
                        <th class="py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="py-4 px-4">
                            <p class="font-bold text-slate-900">{{ $payment->fee->title }}</p>
                            <p class="text-xs text-slate-500 mt-1">Due Date: {{ \Carbon\Carbon::parse($payment->fee->due_date)->format('d M, Y') }}</p>
                        </td>
                        <td class="py-4 px-4 text-right font-medium text-slate-800">
                            ₹{{ number_format($payment->amount_paid, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-end">
                <div class="w-1/2">
                    <div class="flex justify-between py-2 text-sm font-medium text-slate-600">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($payment->amount_paid, 2) }}</span>
                    </div>
                    <div class="flex justify-between py-2 text-sm font-medium text-slate-600">
                        <span>Tax</span>
                        <span>₹0.00</span>
                    </div>
                    <div class="flex justify-between py-3 border-t border-slate-200 mt-2">
                        <span class="font-bold text-slate-900">Total Paid</span>
                        <span class="font-black text-slate-900 text-lg">₹{{ number_format($payment->amount_paid, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-16 pt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-400">This is a computer-generated document. No signature is required.</p>
                <p class="text-xs text-slate-400 mt-1">If you have any questions, please contact administration.</p>
            </div>
        </div>
    </div>

</body>
</html>