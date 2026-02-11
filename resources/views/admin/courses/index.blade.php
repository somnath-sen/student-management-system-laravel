@extends('layouts.admin')

@section('title', 'Courses')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <h2 class="text-xl font-semibold">Courses</h2>

    <a href="{{ route('admin.courses.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add Course
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
                <th class="p-3">Description</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($courses as $course)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration }}</td>

                    <td class="p-3 font-medium">
                        {{ $course->name }}
                    </td>

                    <td class="p-3 text-gray-600">
                        {{ $course->description }}
                    </td>

                    <td class="p-3">
                        <div class="flex gap-3">

                            <!-- Edit -->
                            <a href="{{ route('admin.courses.edit', $course) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <!-- Delete -->
                            <form method="POST"
                                  action="{{ route('admin.courses.destroy', $course) }}"
                                  onsubmit="return confirm('Are you sure you want to delete this course?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4"
                        class="p-4 text-center text-gray-500">
                        No courses found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
