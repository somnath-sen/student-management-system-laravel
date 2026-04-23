@extends('layouts.student')

@section('title', 'Admit Card')

@section('content')

<style>
    /* Security Watermark Styling */
    .watermark-container {
        position: relative;
        overflow: hidden;
    }

    /* Create the repeating diagonal text pattern */
    .watermark-container::before {
        content: "EDFLOW ACADEMY OFFICIAL ADMIT CARD - REPRODUCTION PROHIBITED - ";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        
        /* Rotated, repeated, very faint text */
        transform: rotate(-35deg);
        display: flex;
        align-items: center;
        justify-content: center;
        
        /* Font styling for watermark */
        font-size: 10px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: rgba(99, 102, 241, 0.04); /* Indigo very faint on screen */
        
        /* Key for repeating: background-repeat doesn't work well on content, 
           so we generate a large block of text. 
           Alternatively, for extreme security, use an SVG background image here.
           This method repeats the string visually. */
        line-height: 4;
        word-spacing: 1em;
        pointer-events-none; /* Ensures it doesn't interfere with selects/clicks */
        z-index: 0;
    }

    /* Hack to repeat text: just make the content string super long */
    .watermark-container::before {
        content: "EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234 EDFLOW OFFICIAL F1234";
    }

    /* Ensure z-index works for content above watermark */
    .print-content {
        position: relative;
        z-index: 10;
        background: transparent !important;
    }

    /* Print specific styles to hide sidebar and nav during printing */
    @media print {
        body { background-color: white !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        aside, header, #print-btn { display: none !important; }
        .flex-1 { padding: 0 !important; margin: 0 !important; overflow: visible !important; }
        .main-container { padding: 0 !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; }
        .print-container { width: 100% !important; margin: 0 !important; box-shadow: none !important; border: none !important; border-radius: 0 !important; padding: 1cm !important; }
        @page { size: A4 portrait; margin: 0; }

        /* Force watermark to print faintly */
        .watermark-container::before {
            color: rgba(0, 0, 0, 0.05) !important; /* Force light gray for print */
        }
    }
</style>

<div class="main-container max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
    
    <div class="flex justify-between items-center mb-6 no-print" id="print-btn">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Exam Admit Card</h1>
            <p class="text-slate-500 text-sm">Final Semester Examinations 2026</p>
        </div>
        <button onclick="window.print()" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition-colors flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Print / Save PDF
        </button>
    </div>

    <div class="print-container watermark-container bg-white p-8 md:p-12 rounded-2xl shadow-xl border border-slate-200 relative">
        
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.02] pointer-events-none z-0">
            <i class="fa-solid fa-graduation-cap text-[30rem]"></i>
        </div>

        <div class="print-content relative z-10">
            <div class="flex items-center justify-between border-b-2 border-slate-800 pb-6 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-slate-900 rounded-xl flex items-center justify-center text-white text-3xl shadow-md">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight uppercase">EdFlow Academy</h2>
                        <p class="text-sm font-bold text-slate-500 tracking-widest">Kolkata, West Bengal</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="inline-block px-3 py-1 bg-rose-100 text-rose-800 font-black text-xs uppercase tracking-widest border border-rose-200 rounded-md shadow-sm">
                        Hall Ticket
                    </span>
                </div>
            </div>

            <h3 class="text-center text-lg font-bold text-slate-800 uppercase tracking-widest mb-6 relative z-10">
                Term End Examination - May 2026
            </h3>

            <div class="grid grid-cols-4 gap-6 mb-8 relative z-10">
                <div class="col-span-3 grid grid-cols-2 gap-y-4 gap-x-6 bg-slate-50 p-5 rounded-xl border border-slate-200 shadow-inner">
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Candidate Name</p>
                        <p class="font-black text-slate-900 text-lg uppercase">{{ $student->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Roll Number</p>
                        <p class="font-black text-slate-900 text-lg uppercase">{{ $student->roll_number }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Course / Programme</p>
                        <p class="font-bold text-slate-800">{{ $student->course->name ?? 'Master of Computer Applications' }}</p>
                        @if($student->course && $student->course->course_code)
                            <p class="text-xs font-bold text-indigo-600 uppercase">{{ $student->course->course_code }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Examination Center</p>
                        <p class="font-bold text-slate-800">EdFlow Main Campus</p>
                    </div>
                </div>

                <div class="col-span-1 flex flex-col items-center justify-center gap-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode($student->roll_number . '-' . $student->user->name . '-' . $student->course->name)}}" alt="QR" class="w-24 h-24 border-4 border-white shadow-md rounded-lg">
                    <p class="text-[9px] font-bold text-slate-400 tracking-wider">SCAN TO VERIFY</p>
                </div>
            </div>

            <div class="mb-10 relative z-10">
                <h4 class="font-black text-slate-800 mb-3 border-l-4 border-indigo-500 pl-3">Examination Schedule</h4>
                <div class="overflow-hidden border border-slate-200 rounded-xl shadow-sm bg-white">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-100 text-slate-600 text-xs uppercase tracking-wider border-b border-slate-200">
                                <th class="px-4 py-3 font-bold">Date</th>
                                <th class="px-4 py-3 font-bold">Time</th>
                                <th class="px-4 py-3 font-bold">Subject Code</th>
                                <th class="px-4 py-3 font-bold">Subject Name</th>
                                <th class="px-4 py-3 font-bold text-center">Invigilator Sign</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-medium text-slate-800">
                            @foreach($exams as $exam)
                                <tr class="border-b border-slate-100 hover:bg-indigo-50/50 transition-colors">
                                    <td class="px-4 py-3 font-bold text-slate-900">{{ $exam['date'] }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $exam['time'] }}</td>
                                    <td class="px-4 py-3 font-mono text-indigo-600">{{ $exam['code'] }}</td>
                                    <td class="px-4 py-3">{{ $exam['subject'] }}</td>
                                    <td class="px-4 py-3 border-l border-slate-100"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 relative z-10">
                <div class="text-[10px] text-slate-500 space-y-1 pr-6 bg-slate-50 p-4 rounded-lg border border-slate-100">
                    <p class="font-bold text-slate-700 uppercase tracking-wider mb-2">Important Instructions:</p>
                    <p>1. Candidates must carry this Admit Card along with a valid College ID.</p>
                    <p>2. Electronic gadgets, including smartwatches, are strictly prohibited.</p>
                    <p>3. Report to the examination hall 30 minutes prior to the start time.</p>
                </div>
                
                <div class="flex justify-between items-end pl-6">
                    <div class="text-center">
                        <div class="w-40 h-10 border-b-2 border-slate-300 mb-2"></div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Candidate's Signature</p>
                    </div>
                    <div class="text-center relative">
                        <div class="absolute -top-6 -left-6 opacity-[0.08] text-rose-600 rotate-12 pointer-events-none">
                            <i class="fa-solid fa-stamp text-6xl"></i>
                        </div>
                        <div class="w-40 h-10 flex items-end justify-center mb-2 relative z-10">
                            <span class="font-[cursive] text-2xl text-blue-800 -rotate-3">Somnath Sen</span>
                        </div>
                        <div class="w-40 border-t-2 border-slate-300 mx-auto pt-1 relative z-10">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Controller of Exams</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection