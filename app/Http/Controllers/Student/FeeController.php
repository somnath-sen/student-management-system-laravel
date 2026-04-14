<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class FeeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $fees = Fee::where(function($query) use ($user) {
            if ($user->student) {
                $query->where('course_id', $user->student->course_id);
            } else {
                $query->where('course_id', -1); // No student profile
            }
        })
        ->orWhereNull('course_id')
        ->latest()
        ->get();

        $paidFeeIds = FeePayment::where('user_id', $user->id)->where('status', 'completed')->pluck('fee_id')->toArray();
        // ADD THIS: Track pending payments
        $pendingFeeIds = FeePayment::where('user_id', $user->id)->where('status', 'pending')->pluck('fee_id')->toArray();

        return view('student.fees.index', compact('fees', 'paidFeeIds', 'pendingFeeIds'));
    }

    // ADD THIS NEW METHOD AT THE BOTTOM:
    public function submitOfflinePayment(Request $request)
    {
        $request->validate([
            'fee_id' => 'required|exists:fees,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
        ]);

        // Save the uploaded receipt
        $path = $request->file('receipt')->store('receipts', 'public');

        FeePayment::create([
            'fee_id' => $request->fee_id,
            'user_id' => Auth::id(),
            'amount_paid' => $request->amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'receipt_path' => $path,
            'status' => 'pending', // Marks it for Admin approval
        ]);

        return back()->with('success', 'Offline payment details submitted! Waiting for Admin verification.');
    }

    public function createOrder(Request $request)
    {
        try {
            $fee = Fee::findOrFail($request->fee_id);
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $orderData = [
                'receipt'         => 'rcptid_' . $fee->id . '_' . Auth::id(),
                'amount'          => $fee->amount * 100, // Razorpay needs the amount in Paise/Cents
                'currency'        => 'INR',
                'payment_capture' => 1 // Auto-capture the payment
            ];

            $razorpayOrder = $api->order->create($orderData);

            return response()->json([
                'order_id' => $razorpayOrder['id'],
                'amount' => $orderData['amount'],
                'key' => config('services.razorpay.key'),
                'user_name' => Auth::user()->name,
                'user_email' => Auth::user()->email,
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay Order Creation Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // This verifies the payment was real and saves it to your database
    public function verifyPayment(Request $request)
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];
            
            // Verifies the math to ensure no one hacked the request
            $api->utility->verifyPaymentSignature($attributes);

            // Record the successful payment
            FeePayment::create([
                'fee_id' => $request->fee_id,
                'user_id' => Auth::id(),
                'amount_paid' => $request->amount,
                'payment_method' => 'Razorpay Online',
                'transaction_id' => $request->razorpay_payment_id,
                'status' => 'completed',
            ]);

            return response()->json(['success' => true, 'message' => 'Payment Successful!']);

        } catch (\Exception $e) {
            Log::error('Razorpay Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Payment verification failed.'], 400);
        }
    }
    // Add this method to generate the receipt
    public function receipt($feeId)
    {
        $student = Auth::user();
        
        $payment = FeePayment::where('fee_id', $feeId)
                             ->where('user_id', $student->id)
                             ->where('status', 'completed')
                             ->with('fee')
                             ->firstOrFail();

        return view('student.fees.receipt', compact('payment', 'student'));
    }
}