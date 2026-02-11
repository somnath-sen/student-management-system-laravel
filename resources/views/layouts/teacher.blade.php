<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Teacher Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-900 text-white min-h-screen">
        <div class="p-4 font-semibold text-lg">🎓 Teacher Panel</div>

        <nav class="px-4 space-y-2">
            <a href="{{ route('teacher.dashboard') }}"
               class="block px-3 py-2 rounded
               {{ request()->is('teacher/dashboard')
                    ? 'bg-gray-700'
                    : 'hover:bg-gray-700' }}">
                Dashboard
            </a>

            <a href="{{ route('teacher.attendance.create') }}"
               class="block px-3 py-2 rounded hover:bg-gray-700">
               Mark Attendance
            </a>

            <a href="{{ route('teacher.marks.index') }}"class="flex items-center gap-3 px-4 py-2 rounded {{ request()->is('teacher/marks*')? 'bg-gray-700 text-white': 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <span>Marks</span>
            </a>


            <a href="{{ route('teacher.details') }}"class="flex items-center gap-3 px-4 py-2 rounded {{ request()->is('teacher/details*')? 'bg-gray-700 text-white': 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
               <span>Details</span>
            </a>

        </nav>
    </aside>

    {{-- Content --}}
    <main class="flex-1 p-6">
        @yield('content')
    </main>

</body>
</html>
