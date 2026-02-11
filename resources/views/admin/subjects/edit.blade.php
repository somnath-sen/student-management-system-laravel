@extends('layouts.admin')

@section('title', 'Edit Subject')

@section('content')
<div class="max-w-xl bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Edit Subject</h2>

    <form method="POST"
          action="{{ route('admin.subjects.update', $subject) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-medium">Course</label>
            <select name="course_id"
                    class="w-full border rounded px-3 py-2" required>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}"
                        {{ $subject->course_id == $course->id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Subject Name</label>
            <input type="text"
                   name="name"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('name', $subject->name) }}"
                   required>
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>

            <a href="{{ route('admin.subjects.index') }}"
               class="px-4 py-2 rounded border">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
