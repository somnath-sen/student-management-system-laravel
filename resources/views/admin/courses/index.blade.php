@extends('layouts.admin')

@section('title', 'Manage Courses')

@section('content')

<style>
    /* ================= ANIMATIONS ================= */
    .animate-enter {
        animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }

    /* Table Row Hover */
    .table-row {
        transition: background-color 0.2s ease, transform 0.2s ease;
    }
    .table-row:hover {
        background-color: #f9fafb; /* Gray-50 */
        transform: scale(1.002);
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        z-index: 10;
        position: relative;
    }
</style>

<div class="max-w-7xl mx-auto">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Courses</h1>
            <p class="text-gray-500 mt-1">Manage academic programs and curriculum.</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-64 text-sm" placeholder="Search courses...">
            </div>

            <a href="{{ route('admin.courses.create') }}" 
               class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New Course
            </a>
        </div>
    </div>

    <!-- Bulk Actions Bar -->
    <div id="bulk-actions" class="hidden mb-4 p-4 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-between animate-enter stagger-1">
        <div class="flex items-center gap-3">
            <div class="bg-indigo-600 text-white font-bold w-8 h-8 rounded-full flex items-center justify-center text-sm shadow-md">
                <span id="selected-count">0</span>
            </div>
            <span class="text-indigo-900 font-semibold text-sm">Courses Selected</span>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" onclick="clearSelection()" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                Cancel
            </button>
            <button type="button" onclick="confirmBulkDelete()" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring ring-red-300 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                <i class="fa-solid fa-trash-can mr-2"></i> Delete Selected
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 animate-enter stagger-1">
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm flex justify-between items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden animate-enter stagger-2">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4 w-12">
                            <input type="checkbox" id="select-all" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer">
                        </th>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Course ID</th>
                        <th class="px-6 py-4">Course Name</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($courses as $course)
                        <tr class="table-row">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="course-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 cursor-pointer" value="{{ $course->id }}">
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded bg-gray-100 text-gray-700 font-mono text-xs border border-gray-200 font-semibold tracking-wide">
                                    {{ $course->course_code ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                        {{ substr($course->name ?? 'C', 0, 2) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $course->name }}</div>
                                        <div class="text-xs text-gray-500">Created: {{ $course->created_at ? $course->created_at->format('M d, Y') : 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600 block max-w-xs truncate" title="{{ $course->description }}">
                                    {{ $course->description ?? 'No description provided.' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" 
                                          data-confirm="⚠️ Are you sure you want to delete this course? This action cannot be undone.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">No Courses Found</h3>
                                    <p class="text-gray-500 mt-1 max-w-sm">Get started by creating a new course curriculum for your institution.</p>
                                    <a href="{{ route('admin.courses.create') }}" class="mt-4 text-indigo-600 font-medium hover:underline">Add First Course &rarr;</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $courses->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.course-checkbox');
        const bulkActions = document.getElementById('bulk-actions');
        const selectedCountEl = document.getElementById('selected-count');

        // Update bulk actions visibility
        function updateBulkActions() {
            const selectedCount = document.querySelectorAll('.course-checkbox:checked').length;
            selectedCountEl.textContent = selectedCount;
            
            if (selectedCount > 0) {
                bulkActions.classList.remove('hidden');
            } else {
                bulkActions.classList.add('hidden');
                if (selectAll) selectAll.checked = false;
            }
            
            // Highlight rows
            checkboxes.forEach(cb => {
                const row = cb.closest('.table-row');
                if (cb.checked) {
                    row.classList.add('bg-indigo-50/50');
                } else {
                    row.classList.remove('bg-indigo-50/50');
                }
            });
        }

        // Select All toggle
        if (selectAll) {
            selectAll.addEventListener('change', function () {
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                updateBulkActions();
            });
        }

        // Individual checkbox toggle
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                if (!this.checked && selectAll) {
                    selectAll.checked = false;
                } else if (document.querySelectorAll('.course-checkbox:checked').length === checkboxes.length) {
                    if (selectAll) selectAll.checked = true;
                }
                updateBulkActions();
            });
        });

        // Expose functions globally for inline onclick handlers
        window.clearSelection = function () {
            if (selectAll) selectAll.checked = false;
            checkboxes.forEach(cb => cb.checked = false);
            updateBulkActions();
        };

        window.confirmBulkDelete = function () {
            const selectedIds = Array.from(document.querySelectorAll('.course-checkbox:checked')).map(cb => cb.value);
            
            if (selectedIds.length === 0) return;

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${selectedIds.length} selected course(s). This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Delete Selected',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch('{{ route('admin.courses.bulk-delete') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ course_ids: selectedIds })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`)
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    const data = result.value;
                    if (data.success) {
                        // Show toast notification
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: data.skipped > 0 ? 'warning' : 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                }
            });
        };
    });
</script>
@endsection