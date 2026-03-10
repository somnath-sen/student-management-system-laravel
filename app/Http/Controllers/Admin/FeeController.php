<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\FeePayment;
use App\Models\Course;
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

        Fee::create($request->all());

        return back()->with('success', 'Fee structure created successfully!');
    }
    public function approvePayment(FeePayment $payment)
    {
        $payment->update(['status' => 'completed']);
        return back()->with('success', 'Payment approved and receipt generated!');
    }
}