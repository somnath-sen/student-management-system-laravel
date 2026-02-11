@extends('layouts.admin')

@section('title', 'Publish Results')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Publish Results</h1>

@if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Subject</th>
                <th class="p-3 text-left">Course</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Action</th>
            </tr>
        </thead>

        <tbody>
        @forelse($subjects as $subject)
            @php
                $published = $subject->marks->first()->is_published ?? false;
            @endphp

            <tr class="border-t">
                <td class="p-3">{{ $subject->name }}</td>
                <td class="p-3">{{ $subject->course->name }}</td>
                <td class="p-3">
                    @if($published)
                        <span class="text-green-600 font-medium">Published</span>
                    @else
                        <span class="text-red-600 font-medium">Unpublished</span>
                    @endif
                </td>
                <td class="p-3">
                    @if(! $published)
                        <form method="POST"
                              action="{{ route('admin.results.publish', $subject) }}">
                            @csrf
                            <button class="bg-blue-600 text-white px-3 py-1 rounded">
                                Publish
                            </button>
                        </form>
                    @else
                        <form method="POST"
                              action="{{ route('admin.results.unpublish', $subject) }}">
                            @csrf
                            <button class="bg-gray-600 text-white px-3 py-1 rounded">
                                Unpublish
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="p-4 text-center text-gray-500">
                    No locked results found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
