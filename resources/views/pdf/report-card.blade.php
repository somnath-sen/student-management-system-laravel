<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Report Card – {{ $student->user->name }}</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'DejaVu Sans', Arial, sans-serif;
    font-size: 10.5px;
    color: #1f2937;
    background: #fff;
}

/* Watermark */
.watermark {
    position: fixed;
    top: 38%;
    left: 8%;
    font-size: 88px;
    color: rgba(79, 70, 229, 0.045);
    transform: rotate(-38deg);
    z-index: -1;
    font-weight: 900;
    letter-spacing: 8px;
    white-space: nowrap;
}

/* Page wrapper */
.wrap {
    padding: 20px 26px 18px;
}

/* Top rule */
.top-bar {
    height: 5px;
    background: #4338ca;
    margin-bottom: 14px;
}

/* ── HEADER ────────────────────────────────────────────── */
.hdr-table { width: 100%; border-collapse: collapse; }
.hdr-logo-td { width: 50px; vertical-align: middle; }
.hdr-info-td { vertical-align: middle; padding-left: 10px; }
.hdr-qr-td   { width: 82px; vertical-align: top; text-align: right; }

.logo-box {
    width: 44px;
    height: 44px;
    background: #4338ca;
    border-radius: 6px;
    text-align: center;
    line-height: 44px;
    font-size: 20px;
    color: #fff;
    font-weight: 900;
}
.college-name  { font-size: 15px; font-weight: 900; color: #111827; line-height: 1.2; }
.college-sub   { font-size: 8px; color: #6366f1; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; margin-top: 2px; }
.college-addr  { font-size: 8px; color: #6b7280; margin-top: 3px; }

.qr-wrap {
    border: 1px solid #d1d5db;
    padding: 3px;
    display: inline-block;
    text-align: center;
    background: #f9fafb;
}
.qr-wrap img   { width: 68px; height: 68px; display: block; }
.qr-label      { font-size: 6px; color: #9ca3af; letter-spacing: 0.5px; margin-top: 2px; }
.qr-verify     { font-size: 6px; color: #4338ca; font-weight: 700; }

/* ── DIVIDER ───────────────────────────────────────────── */
.divider { border: none; border-top: 1px solid #e5e7eb; margin: 10px 0; }

/* ── TITLE BAND ────────────────────────────────────────── */
.title-band {
    background: #4338ca;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 12px;
}

/* ── SECTION LABEL ─────────────────────────────────────── */
.sec-label {
    font-size: 7.5px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: #4338ca;
    border-bottom: 1px solid #e0e7ff;
    padding-bottom: 3px;
    margin-bottom: 7px;
}

/* ── STUDENT INFO TABLE ─────────────────────────────────── */
.info-tbl { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
.info-tbl td {
    padding: 4px 8px;
    border-bottom: 1px solid #f3f4f6;
    font-size: 9.5px;
    vertical-align: top;
}
.info-tbl tr:last-child td { border-bottom: none; }
.info-tbl .lbl { color: #6b7280; font-weight: 700; width: 100px; font-size: 8.5px; text-transform: uppercase; letter-spacing: 0.4px; }
.info-tbl .val { color: #111827; font-weight: 600; }
.info-row-alt  { background: #f9fafb; }

/* ── MARKS TABLE ───────────────────────────────────────── */
.marks-tbl { width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 9.5px; }
.marks-tbl th {
    background: #4338ca;
    color: #fff;
    padding: 5px 8px;
    text-align: center;
    font-size: 8px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.marks-tbl th.left { text-align: left; }
.marks-tbl td {
    padding: 5px 8px;
    text-align: center;
    border-bottom: 1px solid #f3f4f6;
    color: #374151;
}
.marks-tbl td.left { text-align: left; font-weight: 600; color: #111827; }
.marks-tbl tr:nth-child(even) td { background: #fafafa; }
.marks-tbl tr:last-child td { border-bottom: 2px solid #e5e7eb; }

/* Grade chips using simple borders */
.grade { display: inline-block; padding: 1px 7px; border: 1px solid; font-size: 8.5px; font-weight: 700; }
.ga  { color: #059669; border-color: #6ee7b7; background: #ecfdf5; }
.gb  { color: #2563eb; border-color: #bfdbfe; background: #eff6ff; }
.gc  { color: #d97706; border-color: #fde68a; background: #fffbeb; }
.gd  { color: #ea580c; border-color: #fdba74; background: #fff7ed; }
.gf  { color: #fff;    border-color: #dc2626; background: #dc2626; }

/* ── SUMMARY TABLE ─────────────────────────────────────── */
.sum-tbl { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
.sum-tbl td {
    width: 25%;
    border: 1px solid #e5e7eb;
    padding: 8px 6px;
    text-align: center;
    vertical-align: middle;
}
.sum-lbl { font-size: 7.5px; color: #6b7280; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
.sum-val { font-size: 15px; font-weight: 900; color: #4338ca; margin-top: 2px; line-height: 1; }
.sum-sub { font-size: 7.5px; color: #9ca3af; margin-top: 2px; }
.pass { color: #059669; }
.fail { color: #dc2626; }

/* ── REMARKS ───────────────────────────────────────────── */
.remarks-box {
    border-left: 3px solid #4338ca;
    padding: 6px 10px;
    background: #f5f3ff;
    margin-bottom: 14px;
    min-height: 36px;
}
.remarks-box .rlbl { font-size: 7.5px; color: #4338ca; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3px; }
.remarks-box p { font-size: 9.5px; color: #374151; font-style: italic; line-height: 1.5; }

/* ── SIGNATURE SECTION ─────────────────────────────────── */
.sig-tbl { width: 100%; border-collapse: collapse; margin-top: 8px; }
.sig-tbl td { width: 33.33%; text-align: center; vertical-align: bottom; padding: 0 10px; }

.stamp-ring {
    width: 66px;
    height: 66px;
    border: 2px dashed #9ca3af;
    margin: 0 auto 8px auto;
    text-align: center;
    line-height: 1.2;
    padding-top: 22px;
}
.stamp-ring.blue   { border-color: #93c5fd; }
.stamp-ring.purple { border-color: #c4b5fd; }
.stamp-ring.indigo { border-color: #4338ca; border-style: solid; }
.stamp-txt { font-size: 6.5px; color: #9ca3af; font-weight: 700; letter-spacing: 0.3px; }
.stamp-txt.ind { color: #4338ca; }

.sig-line { border-top: 1px solid #374151; width: 85%; margin: 0 auto 4px; }
.sig-line.ind { border-color: #4338ca; }
.sig-name { font-size: 8.5px; font-weight: 800; color: #111827; text-transform: uppercase; letter-spacing: 0.8px; }
.sig-title { font-size: 8px; color: #6b7280; margin-top: 1px; }

/* ── BOTTOM ────────────────────────────────────────────── */
.bottom-bar { height: 4px; background: #4338ca; margin-top: 12px; }
.footer-txt { text-align: center; font-size: 7px; color: #9ca3af; margin-top: 5px; letter-spacing: 0.3px; }
</style>
</head>
<body>

@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;

    $getGrade = function($p) {
        if ($p >= 80) return ['lbl'=>'A',  'cls'=>'ga'];
        if ($p >= 65) return ['lbl'=>'B+', 'cls'=>'gb'];
        if ($p >= 50) return ['lbl'=>'B',  'cls'=>'gc'];
        if ($p >= 40) return ['lbl'=>'C',  'cls'=>'gd'];
        return ['lbl'=>'F', 'cls'=>'gf'];
    };

    $cn   = \App\Models\Setting::get('college_name',   'EdFlow College of Technology & Management');
    $ca   = \App\Models\Setting::get('college_address','Salt Lake, Sector V, Kolkata – 700091');
    $cp   = \App\Models\Setting::get('college_phone',  '+91 9933750793');
    $ce   = \App\Models\Setting::get('college_email',  'info@edflow.edu.in');
    $prin = \App\Models\Setting::get('principal_name', 'Prof. Dr. Ashok Mukherjee');
    $ay   = \App\Models\Setting::get('academic_year',  date('Y').'-'.(date('Y')+1));
    $url  = route('verify.student', $student->id);
    $par  = $student->parents->first()->name ?? ($student->parent_name ?? 'Parent / Guardian');
    $initials = strtoupper(substr($cn, 0, 2));

    // PASS/FAIL: fail if overall < 40% OR any single subject < 40%
    $hasFailSub = $marks->contains(function($m) {
        $p = $m->total_marks > 0 ? ($m->marks_obtained / $m->total_marks) * 100 : 0;
        return $p < 40;
    });
    $isPassed = $overallPercentage >= 40 && !$hasFailSub;
@endphp

<div class="watermark">{{ strtoupper(explode(' ', $cn)[0] ?? 'EDFLOW') }}</div>

<div class="wrap">

{{-- Top Rule --}}
<div class="top-bar"></div>

{{-- ── HEADER ─────────────────────────────────────────────────────────── --}}
<table class="hdr-table">
    <tr>
        <td class="hdr-logo-td">
            <div class="logo-box">{{ $initials }}</div>
        </td>
        <td class="hdr-info-td">
            <div class="college-name">{{ $cn }}</div>
            <div class="college-sub">Empowering Futures · Building Leaders</div>
            <div class="college-addr">{{ $ca }} &nbsp;|&nbsp; {{ $cp }} &nbsp;|&nbsp; {{ $ce }}</div>
        </td>
        <td class="hdr-qr-td">
            <div class="qr-wrap">
                <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(68)->generate($url)) }}" alt="QR Code">
                <div class="qr-label">SCAN TO VERIFY</div>
                <div class="qr-verify">✓ Official Document</div>
            </div>
        </td>
    </tr>
</table>

<hr class="divider">
<div class="title-band">Official Academic Report Card</div>

{{-- ── STUDENT INFORMATION ──────────────────────────────────────────── --}}
<div class="sec-label">Student Information</div>
<table class="info-tbl">
    <tr>
        <td class="lbl">Name</td>
        <td class="val">{{ $student->user->name }}</td>
        <td class="lbl">Roll Number</td>
        <td class="val">{{ $student->roll_number }}</td>
    </tr>
    <tr class="info-row-alt">
        <td class="lbl">Course</td>
        <td class="val">{{ $student->course->name ?? 'N/A' }}</td>
        <td class="lbl">Academic Year</td>
        <td class="val">{{ $ay }}</td>
    </tr>
    <tr>
        <td class="lbl">Email</td>
        <td class="val">{{ $student->user->email }}</td>
        <td class="lbl">Date of Issue</td>
        <td class="val">{{ now()->format('d M, Y') }}</td>
    </tr>
    <tr class="info-row-alt">
        <td class="lbl">Parent / Guardian</td>
        <td class="val">{{ $par }}</td>
        <td class="lbl">Blood Group</td>
        <td class="val">{{ $student->blood_group ?? '—' }}</td>
    </tr>
</table>

{{-- ── MARKS ──────────────────────────────────────────────────────────── --}}
<div class="sec-label">Subject-wise Performance</div>
<table class="marks-tbl">
    <thead>
        <tr>
            <th class="left" style="width:40%;">Subject</th>
            <th>Max Marks</th>
            <th>Obtained</th>
            <th>Percentage</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        @foreach($marks as $mark)
            @php
                $pct   = $mark->total_marks > 0 ? round(($mark->marks_obtained / $mark->total_marks) * 100, 1) : 0;
                $g     = $getGrade($pct);
                $rowFailed = $pct < 40;
            @endphp
            <tr style="{{ $rowFailed ? 'background:#fff1f2;' : '' }}">
                <td class="left" style="{{ $rowFailed ? 'color:#dc2626;' : '' }}">{{ $mark->subject->name ?? '—' }}</td>
                <td>{{ $mark->total_marks }}</td>
                <td style="font-weight:700; {{ $rowFailed ? 'color:#dc2626;' : '' }}">{{ $mark->marks_obtained }}</td>
                <td style="{{ $rowFailed ? 'color:#dc2626; font-weight:700;' : '' }}">{{ $pct }}%</td>
                <td><span class="grade {{ $g['cls'] }}">{{ $g['lbl'] }}</span></td>
            </tr>
        @endforeach
        {{-- Totals row --}}
        <tr style="background:#f0f0ff;">
            <td class="left" style="font-weight:900; color:#4338ca;">TOTAL</td>
            <td style="font-weight:900; color:#4338ca;">{{ $totalMaxMarks }}</td>
            <td style="font-weight:900; color:#4338ca;">{{ $totalMarksObtained }}</td>
            <td style="font-weight:900; color:#4338ca;">{{ $overallPercentage }}%</td>
            <td>
                @php $og = $getGrade($overallPercentage); @endphp
                <span class="grade {{ $og['cls'] }}">{{ $og['lbl'] }}</span>
            </td>
        </tr>
    </tbody>
</table>

{{-- ── SUMMARY ─────────────────────────────────────────────────────────── --}}
<div class="sec-label">Result Summary</div>
<table class="sum-tbl">
    <tr>
        <td>
            <div class="sum-lbl">Result</div>
            <div class="sum-val {{ $isPassed ? 'pass' : 'fail' }}">
                {{ $isPassed ? 'PASS' : 'FAIL' }}
            </div>
            <div class="sum-sub">{{ $overallPercentage }}% overall{{ $hasFailSub ? ' · F in subject' : '' }}</div>
        </td>
        <td>
            <div class="sum-lbl">Total Marks</div>
            <div class="sum-val">{{ $totalMarksObtained }}<span style="font-size:9px;color:#9ca3af;">/{{ $totalMaxMarks }}</span></div>
            <div class="sum-sub">Combined score</div>
        </td>
        <td>
            <div class="sum-lbl">Class Rank</div>
            <div class="sum-val">#{{ $rank }}</div>
            <div class="sum-sub">In your programme</div>
        </td>
        <td>
            <div class="sum-lbl">Attendance</div>
            <div class="sum-val">{{ $attendancePercentage }}%</div>
            <div class="sum-sub">{{ $attendedClasses }} / {{ $totalClasses }}</div>
        </td>
    </tr>
</table>

{{-- ── REMARKS ─────────────────────────────────────────────────────────── --}}
<div class="sec-label">Teacher / Admin Remarks</div>
<div class="remarks-box">
    <div class="rlbl">Academic Remark</div>
    <p>{{ $student->report_card_remark ?? 'The student has demonstrated consistent academic effort throughout the semester. We encourage continued focus on studies and participation in co-curricular activities.' }}</p>
</div>

{{-- ── SIGNATURES ───────────────────────────────────────────────────────── --}}
<div class="sec-label">Authorised Signatures</div>
<table class="sig-tbl">
    <tr>
        {{-- Parent --}}
        <td>
            <div class="stamp-ring blue">
                <div class="stamp-txt">PARENT<br>STAMP</div>
            </div>
            <div class="sig-line"></div>
            <div class="sig-name">Parent / Guardian</div>
            <div class="sig-title">{{ $par }}</div>
        </td>

        {{-- HoD --}}
        <td>
            <div class="stamp-ring purple">
                <div class="stamp-txt">OFFICIAL<br>STAMP</div>
            </div>
            <div class="sig-line"></div>
            <div class="sig-name">Head of Department</div>
            <div class="sig-title">Dept. of {{ $student->course->name ?? 'Studies' }}</div>
        </td>

        {{-- Principal --}}
        <td>
            <div class="stamp-ring indigo">
                <div class="stamp-txt ind">PRINCIPAL<br>SEAL</div>
            </div>
            <div class="sig-line ind"></div>
            <div class="sig-name" style="color:#4338ca;">Principal</div>
            <div class="sig-title">{{ $prin }}</div>
        </td>
    </tr>
</table>

{{-- Bottom --}}
<div class="bottom-bar"></div>
<div class="footer-txt">
    This is a computer-generated official document. &nbsp;|&nbsp; Verify at: {{ $url }} &nbsp;|&nbsp; {{ $cn }}
</div>

</div>
</body>
</html>
