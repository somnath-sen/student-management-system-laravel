<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Marksheet</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
        .center { text-align: center; }
    </style>
</head>
<body>

<h2 class="center">OFFICIAL MARKSHEET</h2>

<p>
<strong>Student:</strong> {{ $student->user->name }} <br>
<strong>Roll:</strong> {{ $student->roll_number }}
</p>

<table>
    <thead>
        <tr>
            <th>Subject</th>
            <th>Marks</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach($marks as $mark)
            @php $total += $mark->marks_obtained; @endphp
            <tr>
                <td>{{ $mark->subject->name }}</td>
                <td>{{ $mark->marks_obtained }}</td>
                <td>{{ $mark->total_marks }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Total Marks:</strong> {{ $total }}</p>

<br><br>
<p class="center">_________________________<br>Controller of Examination</p>

</body>
</html>
