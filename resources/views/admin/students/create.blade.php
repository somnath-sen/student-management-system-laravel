@extends('layouts.admin')

@section('title', 'Add Student')

@section('content')
<div class="max-w-xl bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Add New Student</h2>

    <form method="POST" action="{{ route('admin.students.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-medium">Student Name</label>
            <input type="text" name="name"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('name') }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('email') }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Roll Number</label>
            <input type="text" name="roll_number"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('roll_number') }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Course</label>
            <select name="course_id"
                    class="w-full border rounded px-3 py-2" required>
                <option value="">-- Select Course --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save
            </button>

            <a href="{{ route('admin.students.index') }}"
               class="px-4 py-2 rounded border">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
