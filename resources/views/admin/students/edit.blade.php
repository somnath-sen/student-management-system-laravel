@extends('layouts.admin')

@section('title', 'Edit Student')

@section('content')
<div class="max-w-xl bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Edit Student</h2>

    <form method="POST" action="{{ route('admin.students.update', $student) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('name', $student->user->name) }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('email', $student->user->email) }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Roll Number</label>
            <input type="text" name="roll_number"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('roll_number', $student->roll_number) }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Course</label>
            <select name="course_id"
                    class="w-full border rounded px-3 py-2" required>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}"
                        {{ $student->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>

            <a href="{{ route('admin.students.index') }}"
               class="px-4 py-2 rounded border">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
