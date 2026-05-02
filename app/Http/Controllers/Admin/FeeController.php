<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\Request;


class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::with('course')->latest()->get();
        $courses = Course::all();

        // Fetch all successful payments with student details
        $payments = FeePayment::with(['student', 'fee'])->latest()->get();
        
        return view('admin.fees.index', compact('fees', 'courses', 'payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date|after_or_equal:today',
            'course_id' => 'nullable|exists:courses,id',
            'description' => 'nullable|string'
        ]);

        $fee = Fee::create($request->all());

        // ── Telegram Notifications ───────────────────────────────────────────
        try {
            $telegram = app(TelegramService::class);
            $dueDate  = $fee->due_date ? \Carbon\Carbon::parse($fee->due_date)->format('d M Y') : 'N/A';

            // Query relevant students (course-specific or all)
            $query = Student::with(['user', 'parents']);
            if ($fee->course_id) {
                $query->where('course_id', $fee->course_id);
            }

            $query->each(function ($student) use ($telegram, $fee, $dueDate) {
                if ($student->user && $student->user->telegram_chat_id) {
                    $telegram->sendMessage(
                        $student->user->telegram_chat_id,
                        "💰 *Fee Payment Required*\n\nHello {$student->user->name},\n\nA new fee has been added:\n*{$fee->title}* — ₹{$fee->amount}\nDue: *{$dueDate}*\n\nPlease log in to EdFlow to make your payment.",
                        'fee_created',
                        'student',
                        $student->user->id
                    );
                }
                foreach ($student->parents as $parent) {
                    if ($parent->telegram_chat_id) {
                        $telegram->sendMessage(
                            $parent->telegram_chat_id,
                            "💰 *Fee Payment Reminder*\n\nDear Parent,\n\nA fee has been assigned to your child *{$student->user->name}*:\n*{$fee->title}* — ₹{$fee->amount}\nDue: *{$dueDate}*\n\nKindly ensure timely payment.",
                            'fee_created',
                            'parent',
                            $parent->id
                        );
                    }
                }
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('[Fee] Telegram dispatch failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Fee structure created successfully!');

    }
    public function approvePayment(FeePayment $payment)
    {
        $payment->update(['status' => 'completed']);
        return back()->with('success', 'Payment approved and receipt generated!');
    }
}