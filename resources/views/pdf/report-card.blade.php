<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Card - {{ $student->user->name }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }
        .watermark {
            position: fixed;
            top: 30%;
            left: 10%;
            font-size: 100px;
            color: rgba(0, 0, 0, 0.05);
            transform: rotate(-45deg);
            z-index: -1;
            white-space: nowrap;
        }
        .container {
            padding: 40px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #4F46E5;
            font-size: 28px;
            letter-spacing: 2px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }
        .student-info {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        .student-info td {
            padding: 8px;
            border-bottom: 1px dashed #ccc;
        }
        .student-info td strong {
            color: #555;
        }
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            background-color: #f3f4f6;
            padding: 10px;
            border-radius: 5px;
        }
        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .marks-table th, .marks-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        .marks-table th {
            background-color: #4F46E5;
            color: #fff;
            font-weight: bold;
        }
        .marks-table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .summary-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .summary-box td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            width: 33.33%;
            background-color: #f3f4f6;
        }
        .summary-box td h3 {
            margin: 0 0 5px 0;
            font-size: 14px;
            color: #555;
        }
        .summary-box td p {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #4F46E5;
        }
        .remarks-section {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background-color: #fff;
            margin-bottom: 50px;
            min-height: 80px;
        }
        .remarks-section h4 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #4F46E5;
        }
        .footer {
            width: 100%;
            position: relative;
        }
        .signature-box {
            display: inline-block;
            width: 30%;
            text-align: center;
            border-top: 1px solid #333;
            padding-top: 5px;
            margin-top: 50px;
        }
        .left-sig { float: left; }
        .right-sig { float: right; }
        .qr-code {
            text-align: center;
            margin-top: 40px;
            clear: both;
        }
        .qr-code img {
            width: 100px;
            height: 100px;
        }
        .grade-a { color: #10B981; font-weight: bold; }
        .grade-b { color: #3B82F6; font-weight: bold; }
        .grade-c { color: #F59E0B; font-weight: bold; }
        .grade-d { color: #EF4444; font-weight: bold; }
    </style>
</head>
<body>

    @php
        $getGrade = function($percent) {
            if($percent >= 90) return 'A+';
            if($percent >= 80) return 'A';
            if($percent >= 70) return 'B+';
            if($percent >= 60) return 'B';
            if($percent >= 50) return 'C';
            if($percent >= 40) return 'D';
            return 'F';
        };

        $getGradeClass = function($grade) {
            if(str_contains($grade, 'A')) return 'grade-a';
            if(str_contains($grade, 'B')) return 'grade-b';
            if(str_contains($grade, 'C')) return 'grade-c';
            return 'grade-d';
        };
    @endphp

    <div class="watermark">EDFLOW ACADEMY</div>

    <div class="container">
        
        <div class="header">
            <h1>EDFLOW ACADEMY</h1>
            <p>Empowering the Future, Today.</p>
            <p>123 Education Lane, Knowledge City, Country</p>
        </div>

        <div class="title">Official Report Card</div>

        <table class="student-info">
            <tr>
                <td><strong>Student Name:</strong> {{ $student->user->name }}</td>
                <td><strong>Roll Number:</strong> {{ $student->roll_number }}</td>
            </tr>
            <tr>
                <td><strong>Course/Class:</strong> {{ $student->course->name ?? 'N/A' }}</td>
                <td><strong>Academic Year:</strong> {{ date('Y') }}</td>
            </tr>
        </table>

        <table class="marks-table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Max Marks</th>
                    <th>Marks Obtained</th>
                    <th>Percentage</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($marks as $mark)
                    @php
                        $subPercent = $mark->total_marks > 0 ? round(($mark->marks_obtained / $mark->total_marks) * 100, 2) : 0;
                        $subGrade = $getGrade($subPercent);
                    @endphp
                    <tr>
                        <td style="text-align: left;">{{ $mark->subject->name }}</td>
                        <td>{{ $mark->total_marks }}</td>
                        <td>{{ $mark->marks_obtained }}</td>
                        <td>{{ $subPercent }}%</td>
                        <td class="{{ $getGradeClass($subGrade) }}">{{ $subGrade }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="summary-box">
            <tr>
                <td>
                    <h3>Overall Result</h3>
                    <p>{{ $overallPercentage >= 40 ? 'PASS' : 'FAIL' }}</p>
                    <span style="font-size: 12px; color: #666;">({{ $overallPercentage }}%)</span>
                </td>
                <td>
                    <h3>Class Rank</h3>
                    <p>{{ $rank }}</p>
                    <span style="font-size: 12px; color: #666;">Out of peers</span>
                </td>
                <td>
                    <h3>Attendance</h3>
                    <p>{{ $attendancePercentage }}%</p>
                    <span style="font-size: 12px; color: #666;">({{ $attendedClasses }}/{{ $totalClasses }})</span>
                </td>
            </tr>
        </table>

        <div class="remarks-section">
            <h4>Teacher's Remarks:</h4>
            <p>{{ $student->report_card_remark ?? 'No remarks provided.' }}</p>
        </div>

        <div class="footer">
            <div class="signature-box left-sig">
                Class Teacher
            </div>
            
            <div class="signature-box right-sig">
                Principal / Admin
            </div>
        </div>

        <div class="qr-code">
            <p style="font-size: 10px; color: #999; margin-bottom: 5px;">Scan to Verify Document</p>
            <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(100)->generate(route('verify.student', $student->id))) }}" alt="QR Code">
        </div>

    </div>

</body>
</html>
