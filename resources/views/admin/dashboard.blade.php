@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    {{-- Total Students --}}
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-gray-500">Total Students</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalStudents }}</p>
    </div>

    {{-- Total Teachers --}}
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-gray-500">Total Teachers</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalTeachers }}</p>
    </div>

    {{-- Courses --}}
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-gray-500">Courses</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalCourses }}</p>
    </div>

    {{-- Subjects --}}
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-gray-500">Subjects</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalStudents }}</p>
    </div>

</div>
@endsection
