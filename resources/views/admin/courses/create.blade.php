@extends('layouts.admin')

@section('title', 'Add Course')

@section('content')
<div class="max-w-xl bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Add New Course</h2>

    <form method="POST" action="{{ route('admin.courses.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-medium">Course Name</label>
            <input type="text" name="name"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description"
                      class="w-full border rounded px-3 py-2"
                      rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save
            </button>
            <a href="{{ route('admin.courses.index') }}"
               class="px-4 py-2 rounded border">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
