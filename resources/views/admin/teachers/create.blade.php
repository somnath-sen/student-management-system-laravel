@extends('layouts.admin')

@section('title', 'Add Teacher')

@section('content')
<div class="max-w-xl bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Add New Teacher</h2>

    <form method="POST" action="{{ route('admin.teachers.store') }}">
        @csrf

        {{-- Name --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('name') }}">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('email') }}">
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded px-3 py-2">
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Employee ID --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Employee ID</label>
            <input type="text" name="employee_id"
                   class="w-full border rounded px-3 py-2"
                   value="{{ old('employee_id') }}">
            @error('employee_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Subjects --}}
        <div class="mb-4">
            <label class="block mb-2 font-medium">Assign Subjects</label>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                @foreach($subjects as $subject)
                    <label class="flex items-center gap-2">
                        <input type="checkbox"
                               name="subjects[]"
                               value="{{ $subject->id }}"
                               {{ in_array($subject->id, old('subjects', [])) ? 'checked' : '' }}>
                        <span>{{ $subject->name }}</span>
                    </label>
                @endforeach
            </div>

            @error('subjects')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex gap-2">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save
            </button>

            <a href="{{ route('admin.teachers.index') }}"
               class="px-4 py-2 rounded border">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
