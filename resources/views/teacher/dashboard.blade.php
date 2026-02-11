@extends('layouts.teacher')

@section('title', 'Teacher Dashboard')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
    Welcome, {{ auth()->user()->name }}
</h1>

<div class="bg-white p-6 rounded shadow">
    <h2 class="font-semibold mb-3">My Subjects</h2>

    @if($subjects->count())
        <ul class="list-disc ml-5">
            @foreach($subjects as $subject)
                <li>{{ $subject->name }}</li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">No subjects assigned.</p>
    @endif
</div>

@endsection
