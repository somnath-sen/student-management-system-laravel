<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Official Marksheet</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; line-height: 1.4; margin: 0; padding: 0; }
        .container { border: 5px double #000; padding: 30px; height: 95%; position: relative; }
        
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 20px; }
        .institute-name { font-size: 24px; font-weight: bold; text-transform: uppercase; margin: 0; color: #000; }
        .institute-sub { font-size: 12px; margin-top: 5px; }
        .doc-title { margin-top: 15px; font-size: 16px; font-weight: bold; text-decoration: underline; text-transform: uppercase; letter-spacing: 1px; }

        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .label { font-weight: bold; width: 120px; }

        .marks-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .marks-table th, .marks-table td { border: 1px solid #000; padding: 10px; text-align: center; }
        .marks-table th { background-color: #f0f0f0; text-transform: uppercase; font-size: 11px; }
        .marks-table td.subject-name { text-align: left; font-weight: bold; }

        .summary-box { float: right; width: 40%; border: 1px solid #000; padding: 10px; margin-bottom: 50px; }
        .summary-row { display: block; margin-bottom: 5px; border-bottom: 1px dashed #ccc; padding-bottom: 5px; }
        .summary-row:last-child { border-bottom: none; }
        .summary-label { font-weight: bold; float: left; }
        .summary-value { float: right; }
        .clearfix { clear: both; }

        .footer { position: absolute; bottom: 40px; width: 100%; }
        .signature-box { width: 30%; float: right; text-align: center; border-top: 1px solid #000; padding-top: 10px; font-weight: bold; }
        .date-box { width: 30%; float: left; text-align: left; padding-top: 10px; }
        .watermark { position: absolute; top: 40%; left: 25%; font-size: 60px; color: rgba(0,0,0,0.05); transform: rotate(-45deg); z-index: -1; font-weight: bold; }
    </style>
</head>
<body>

@php
    // Controller already filters by is_locked = true before rendering this PDF
    $publishedMarks = $marks;
    
    // ✅ FIXED: Using an anonymous function prevents PDF rendering crashes
    $getLetter = function($percent) {
        if($percent >= 90) return 'A+';
        if($percent >= 80) return 'A';
        if($percent >= 70) return 'B+';
        if($percent >= 60) return 'B';
        if($percent >= 50) return 'C';
        if($percent >= 40) return 'D';
        return 'F';
    };
@endphp

<div class="container">
    
    <div class="watermark">OFFICIAL COPY</div>

    <div class="header">
        <h1 class="institute-name">EdFlow Academy</h1>
        <p class="institute-sub">Technology Campus, Kolkata, West Bengal</p>
        <div class="doc-title">Statement of Marks</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="50%">
                <table>
                    <tr>
                        <td class="label">Student Name:</td>
                        <td>{{ $student->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Roll Number:</td>
                        <td>{{ $student->roll_number ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Course:</td>
                        <td>{{ $student->course->name ?? 'N/A' }}</td>
                    </tr>
                    @if($student->course && $student->course->course_code)
                    <tr>
                        <td class="label">Course ID:</td>
                        <td><strong>{{ $student->course->course_code }}</strong></td>
                    </tr>
                    @endif
                </table>
            </td>
            <td width="50%">
                <table>
                    <tr>
                        <td class="label">Session:</td>
                        <td>{{ date('Y') }} - {{ date('Y', strtotime('+1 year')) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Date of Issue:</td>
                        <td>{{ date('d M, Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="marks-table">
        <thead>
            <tr>
                <th width="8%">Sr. No.</th>
                <th width="15%">Code</th>
                <th width="42%">Subject Name</th>
                <th width="15%">Max Marks</th>
                <th width="12%">Obtained</th>
                <th width="8%">Grade</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $totalObtained = 0; 
                $totalMax = 0;
                $count = 1;
            @endphp
            
            @foreach($publishedMarks as $mark)
                @php 
                    $totalObtained += $mark->marks_obtained; 
                    $totalMax += $mark->total_marks;
                    $rowPercent = $mark->total_marks > 0 ? ($mark->marks_obtained / $mark->total_marks) * 100 : 0;
                @endphp
                @php $isFailed = $rowPercent < 40; @endphp
                <tr style="{{ $isFailed ? 'background:#fff1f2;' : '' }}">
                    <td>{{ $count++ }}</td>
                    <td style="font-weight:bold; font-size:10px;">{{ $mark->subject->subject_code ?? 'N/A' }}</td>
                    <td class="subject-name" style="{{ $isFailed ? 'color:#dc2626;' : '' }}">{{ $mark->subject->name }}</td>
                    <td>{{ $mark->total_marks }}</td>
                    <td style="{{ $isFailed ? 'color:#dc2626; font-weight:bold;' : '' }}">{{ $mark->marks_obtained }}</td>
                    <td style="{{ $isFailed ? 'color:#dc2626; font-weight:bold;' : '' }}">{{ $getLetter($rowPercent) }}</td>
                </tr>
            @endforeach
            
            @for($i = $count; $i <= 8; $i++)
                <tr>
                    <td style="color:transparent;">.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endfor
        </tbody>
    </table>

    @php
        $percentage = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 2) : 0;
        // FAIL if overall < 40% OR if any single subject < 40%
        $hasFailSubject = false;
        foreach($publishedMarks as $_m) {
            $sp = $_m->total_marks > 0 ? ($_m->marks_obtained / $_m->total_marks) * 100 : 0;
            if ($sp < 40) { $hasFailSubject = true; break; }
        }
        $result = ($percentage >= 40 && !$hasFailSubject) ? "PASS" : "FAIL";
    @endphp

    <div class="summary-box">
        <div class="summary-row">
            <span class="summary-label">Grand Total:</span>
            <span class="summary-value">{{ $totalObtained }} / {{ $totalMax }}</span>
            <div class="clearfix"></div>
        </div>
        <div class="summary-row">
            <span class="summary-label">Percentage:</span>
            <span class="summary-value">{{ $percentage }}%</span>
            <div class="clearfix"></div>
        </div>
        <div class="summary-row" style="border:none;">
            <span class="summary-label">Final Result:</span>
            <span class="summary-value" style="font-weight:bold;">{{ $result }}</span>
            <div class="clearfix"></div>
        </div>
    </div>
    
    <div class="clearfix"></div>

    <div class="footer">
        <div class="date-box">
            Place: Admin Block
        </div>
        <div class="signature-box">
            Controller of Examinations
        </div>
    </div>

</div>

</body>
</html>