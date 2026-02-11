<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Student Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 min-h-screen text-white">
        <div class="p-4 text-xl font-bold border-b border-gray-700">
            🎓 Student Panel
        </div>

        <nav class="p-4 space-y-2">
            <a href="{{ route('student.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2 rounded
               {{ request()->is('student/dashboard')
                    ? 'bg-gray-700'
                    : 'hover:bg-gray-700' }}">
                Dashboard
            </a>

            <!-- Attendance link -->
            <a href="{{ route('student.attendance.index') }}"
               class="flex items-center gap-3 px-4 py-2 rounded
               {{ request()->is('student/attendance*')
                    ? 'bg-gray-700'
                    : 'hover:bg-gray-700' }}">
                Attendance
            </a>


            <!-- Student MarksResults link -->
            <a href="{{ route('student.results.index') }}"class="flex items-center gap-3 px-4 py-2 rounded transition-all{{ request()->is('student/results*')? 'bg-gray-700 text-white': 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <span>Results</span>
            </a>


            
            <!-- Student MarksResults download -->
            <a href="{{ route('student.marksheet.show') }}"class="flex items-center gap-3 px-4 py-2 rounded{{ request()->is('student/marksheet*')? 'bg-gray-700 text-white': 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <span>Marksheet</span>
            </a>




            <!-- Student Details link -->
            <a href="{{ route('student.details') }}"class="flex items-center gap-3 px-4 py-2 rounded{{ request()->is('student/details*')? 'bg-gray-700 text-white': 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <span>Details</span>
            </a>

        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>

</body>
</html>
