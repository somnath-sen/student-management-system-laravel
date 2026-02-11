@extends('layouts.admin')

@section('title', 'Edit Teacher')

@section('content')
<div class="max-w-xl bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Edit Teacher</h2>

    <form method="POST"
          action="{{ route('admin.teachers.update', $teacher) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('name', $teacher->user->name) }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('email', $teacher->user->email) }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Employee ID</label>
            <input type="text" name="employee_id"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('employee_id', $teacher->employee_id) }}" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium">Assign Subjects</label>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach($subjects as $subject)
                    <label class="flex items-center gap-2">
                        <input type="checkbox"
                               name="subjects[]"
                               value="{{ $subject->id }}"
                               {{ $teacher->subjects->contains($subject->id) ? 'checked' : '' }}>
                        <span>{{ $subject->name }}</span>
                    </label>
                @endforeach
            </div>

            @error('subjects')
                <p class="text-red-600 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>

            <a href="{{ route('admin.teachers.index') }}"
               class="px-4 py-2 rounded border">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
