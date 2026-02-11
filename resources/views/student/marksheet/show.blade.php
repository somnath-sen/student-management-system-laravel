@extends('layouts.student')

@section('title', 'My Marksheet')

@section('content')

<h1 class="text-2xl font-semibold mb-4">My Marksheet</h1>

{{-- Error Message --}}
@if(session('error'))
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

{{-- Download Button --}}
@if($marks->where('is_published', true)->count() > 0)
    <a href="{{ route('student.marksheet.pdf') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4 inline-block transition">
       ⬇️ Download PDF
    </a>
@else
    <button
        class="bg-gray-400 text-white px-4 py-2 rounded mb-4 cursor-not-allowed"
        onclick="alert('Sorry, your result has not been published yet.')">
        ⬇️ Download PDF
    </button>
@endif

{{-- Marks Table --}}
<div class="bg-white rounded shadow p-4">
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Subject</th>
                <th class="p-2 text-left">Marks</th>
                <th class="p-2 text-left">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($marks as $mark)
                <tr class="border-t">
                    <td class="p-2">{{ $mark->subject->name }}</td>
                    <td class="p-2">{{ $mark->marks_obtained }}</td>
                    <td class="p-2">{{ $mark->total_marks }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">
                        No results available.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
