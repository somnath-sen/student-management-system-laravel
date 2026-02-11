@extends('layouts.admin')

@section('title', 'Students')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <h2 class="text-xl font-semibold">Students</h2>

    <a href="{{ route('admin.students.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add Student
    </a>
</div>

<div class="bg-white shadow rounded overflow-x-auto">
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">#</th>
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Roll No</th>
                <th class="p-3">Course</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($students as $student)
                <tr class="border-t hover:bg-gray-50">
                <td class="p-3">{{ $loop->iteration }}</td>
                <td class="p-3">{{ $student->user->name }}</td>
                <td class="p-3">{{ $student->user->email }}</td>
                <td class="p-3">{{ $student->roll_number }}</td>
                <td class="p-3">{{ $student->course->name }}</td>

        <td class="p-3">
        <div class="flex gap-3">
            <a href="{{ route('admin.students.edit', $student) }}"
               class="text-blue-600 hover:underline">
                Edit
            </a>

            <form method="POST"
                  action="{{ route('admin.students.destroy', $student) }}"
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
                        No students found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
