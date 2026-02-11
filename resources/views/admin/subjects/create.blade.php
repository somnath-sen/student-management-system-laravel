@extends('layouts.admin')

@section('title', 'Add Subject')

@section('content')
<div class="max-w-xl bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Add New Subject</h2>

    <form method="POST" action="{{ route('admin.subjects.store') }}">
        @csrf

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

            @error('course_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Subject Name</label>
            <input type="text"
                   name="name"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('name') }}"
                   required>

            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save
            </button>

            <a href="{{ route('admin.subjects.index') }}"
               class="px-4 py-2 rounded border">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
