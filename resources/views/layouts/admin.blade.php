<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind (already included by Breeze) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white">
        <div class="p-6 text-xl font-bold text-white flex items-center gap-2 border-b border-gray-700">
            <span class="text-2xl">🎓</span>
            <span>Admin Panel</span>
        </div>


        <nav class="p-4 space-y-2">
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-2 rounded transition-all duration-200 {{ request()->is('admin/dashboard')? 'bg-gray-700 text-white': 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 opacity-80"></i>
                <span>Dashboard</span>
            </a>


            <a href="{{ route('admin.courses.index') }}"class="flex items-center gap-3 px-4 py-2 rounded transition-all duration-200{{ request()->is('admin/courses*')? 'bg-gray-700 text-white': 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i data-lucide="book-open" class="w-5 h-5 opacity-80"></i>
                <span>Courses</span>
            </a>


            <a href="{{ route('admin.subjects.index') }}"class="flex items-center gap-3 px-4 py-2 rounded transition-all duration-200{{ request()->is('admin/subjects*')? 'bg-gray-700 text-white': 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i data-lucide="layers" class="w-5 h-5 opacity-80"></i>
                <span>Subjects</span>
            </a>



            <a href="{{ route('admin.students.index') }}"class="flex items-center gap-3 px-4 py-2 rounded transition-all duration-200{{ request()->is('admin/students*')? 'bg-gray-700 text-white': 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i data-lucide="users" class="w-5 h-5 opacity-80"></i>
                <span>Students</span>
            </a>



            <a href="{{ route('admin.teachers.index') }}"class="flex items-center gap-3 px-4 py-2 rounded transition-all duration-200{{ request()->is('admin/teachers*')? 'bg-gray-700 text-white': 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i data-lucide="graduation-cap" class="w-5 h-5 opacity-80"></i>
                <span>Teachers</span>
            </a>


            <a href="{{ route('admin.results.index') }}"class="flex items-center gap-3 px-4 py-2 rounded{{ request()->is('admin/results*')? 'bg-gray-700 text-white': 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <i data-lucide="book-open-text" class="w-5 h-5 opacity-80"></i>
                <span>Publish Results</span>
            </a>



        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Top Navbar -->
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold">@yield('title')</h1>

            <div class="flex items-center gap-4">
                <span class="text-gray-600">{{ auth()->user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-600 hover:underline">Logout</button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6">
            @yield('content')
        </main>

    </div>
</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>
