@extends('layouts.admin')

@section('title', 'Teachers')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <h2 class="text-xl font-semibold">Teachers</h2>

    <a href="{{ route('admin.teachers.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add Teacher
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white shadow rounded overflow-x-auto">
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">#</th>
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Employee ID</th>
                <th class="p-3">Subjects</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($teachers as $teacher)
               <tr class="border-t hover:bg-gray-50">
    <td class="p-3">{{ $loop->iteration }}</td>
    <td class="p-3">{{ $teacher->user->name }}</td>
    <td class="p-3">{{ $teacher->user->email }}</td>
    <td class="p-3">{{ $teacher->employee_id }}</td>
    <td class="p-3">
        {{ $teacher->subjects->pluck('name')->join(', ') }}
    </td>

    <td class="p-3">
        <div class="flex gap-3">
            <a href="{{ route('admin.teachers.edit', $teacher) }}"
               class="text-blue-600 hover:underline">
                Edit
            </a>

            <form method="POST"
                  action="{{ route('admin.teachers.destroy', $teacher) }}"
                  onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')

                <button class="text-red-600 hover:underline">
                    Delete
                </button>
            </form>
        </div>
    </td>
</tr>
            @empty
                <tr>
                    <td colspan="5"
                        class="p-4 text-center text-gray-500">
                        No teachers found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
