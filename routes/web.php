<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Student\AttendanceController as StudentAttendanceController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Admin\ResultPublishController;
use App\Http\Controllers\Student\MarksheetController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth Dashboard (Breeze default)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Role: Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    /* Dashboard */
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    /* Courses CRUD */
    Route::get('/admin/courses', [CourseController::class, 'index'])
        ->name('admin.courses.index');
    Route::get('/admin/courses/create', [CourseController::class, 'create'])
        ->name('admin.courses.create');
    Route::post('/admin/courses', [CourseController::class, 'store'])
        ->name('admin.courses.store');
    Route::get('/admin/courses/{course}/edit', [CourseController::class, 'edit'])
        ->name('admin.courses.edit');
    Route::put('/admin/courses/{course}', [CourseController::class, 'update'])
        ->name('admin.courses.update');
    Route::delete('/admin/courses/{course}', [CourseController::class, 'destroy'])
        ->name('admin.courses.destroy');

    /* Subjects CRUD */
    Route::get('/admin/subjects', [SubjectController::class, 'index'])
        ->name('admin.subjects.index');
    Route::get('/admin/subjects/create', [SubjectController::class, 'create'])
        ->name('admin.subjects.create');
    Route::post('/admin/subjects', [SubjectController::class, 'store'])
        ->name('admin.subjects.store');
    Route::get('/admin/subjects/{subject}/edit', [SubjectController::class, 'edit'])
        ->name('admin.subjects.edit');
    Route::put('/admin/subjects/{subject}', [SubjectController::class, 'update'])
        ->name('admin.subjects.update');
    Route::delete('/admin/subjects/{subject}', [SubjectController::class, 'destroy'])
        ->name('admin.subjects.destroy');

    /* Students */
    Route::get('/admin/students', [StudentController::class, 'index'])
        ->name('admin.students.index');
    Route::get('/admin/students/create', [StudentController::class, 'create'])
        ->name('admin.students.create');
    Route::post('/admin/students', [StudentController::class, 'store'])
        ->name('admin.students.store');
    Route::get('/admin/students/{student}/edit', [StudentController::class, 'edit'])
        ->name('admin.students.edit');
    Route::put('/admin/students/{student}', [StudentController::class, 'update'])
        ->name('admin.students.update');
    Route::delete('/admin/students/{student}', [StudentController::class, 'destroy'])
        ->name('admin.students.destroy');

    /* Teachers */
    Route::get('/admin/teachers', [TeacherController::class, 'index'])
        ->name('admin.teachers.index');
    Route::get('/admin/teachers/create', [TeacherController::class, 'create'])
        ->name('admin.teachers.create');
    Route::post('/admin/teachers', [TeacherController::class, 'store'])
        ->name('admin.teachers.store');
    Route::get('/admin/teachers/{teacher}/edit', [TeacherController::class, 'edit'])
        ->name('admin.teachers.edit');
    Route::put('/admin/teachers/{teacher}', [TeacherController::class, 'update'])
        ->name('admin.teachers.update');
    Route::delete('/admin/teachers/{teacher}', [TeacherController::class, 'destroy'])
        ->name('admin.teachers.destroy');

    // Result publish
    Route::get('/admin/results', [ResultPublishController::class, 'index'])
        ->name('admin.results.index');
    Route::post('/admin/results/{subject}/publish', [ResultPublishController::class, 'publish'])
        ->name('admin.results.publish');
    Route::post('/admin/results/{subject}/unpublish', [ResultPublishController::class, 'unpublish'])
        ->name('admin.results.unpublish');

    /* Analytics */
    Route::get('/admin/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])
        ->name('admin.analytics.index');
    Route::get('/admin/analytics/export', [\App\Http\Controllers\Admin\AnalyticsController::class, 'export'])
        ->name('admin.analytics.export');

});

/*
|--------------------------------------------------------------------------
| TEACHER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:teacher'])->group(function () {

    Route::get('/teacher/dashboard', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])
        ->name('teacher.dashboard');

    // Attendance
    Route::get('/teacher/attendance/create', [\App\Http\Controllers\Teacher\AttendanceController::class, 'create'])
        ->name('teacher.attendance.create');
    Route::post('/teacher/attendance/store', [\App\Http\Controllers\Teacher\AttendanceController::class, 'store'])
        ->name('teacher.attendance.store');
    
    // Details
    Route::get('/teacher/details', [\App\Http\Controllers\Teacher\DetailsController::class, 'index'])
        ->name('teacher.details');

    // Marks
    Route::get('/teacher/marks/create', [\App\Http\Controllers\Teacher\MarkController::class, 'create'])
        ->name('teacher.marks.create');
    Route::post('/teacher/marks', [\App\Http\Controllers\Teacher\MarkController::class, 'store'])
        ->name('teacher.marks.store');
    Route::get('/teacher/marks', [\App\Http\Controllers\Teacher\MarkController::class, 'index'])
        ->name('teacher.marks.index');
    Route::get('/teacher/marks/{subject}', [\App\Http\Controllers\Teacher\MarkController::class, 'edit'])
        ->name('teacher.marks.edit');
    Route::put('/teacher/marks/{subject}', [\App\Http\Controllers\Teacher\MarkController::class, 'update'])
        ->name('teacher.marks.update');
    Route::post('/teacher/marks/{subject}/lock', [\App\Http\Controllers\Teacher\MarkController::class, 'lock'])
        ->name('teacher.marks.lock');

    /* Performance Analysis */
    Route::get('/teacher/performance', [\App\Http\Controllers\Teacher\PerformanceController::class, 'index'])
        ->name('teacher.performance.index');
    Route::get('/teacher/performance/{subject}', [\App\Http\Controllers\Teacher\PerformanceController::class, 'show'])
        ->name('teacher.performance.show');

});

/*
|--------------------------------------------------------------------------
| STUDENT ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:student'])->group(function () {
    
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
        ->name('student.dashboard');

    /* Attendance (Read-only) */
    Route::get('/student/attendance', [\App\Http\Controllers\Student\AttendanceController::class, 'index'])
        ->name('student.attendance.index');

    Route::get('/student/details', [\App\Http\Controllers\Student\DetailsController::class, 'index'])
        ->name('student.details');

    // Results
    Route::get('/student/results', [\App\Http\Controllers\Student\ResultController::class, 'index'])
        ->name('student.results.index');

    // Marksheet PDF
    Route::get('/student/marksheet', [MarksheetController::class, 'show'])
        ->name('student.marksheet.show');
    Route::get('/student/marksheet/pdf', [MarksheetController::class, 'download'])
        ->name('student.marksheet.pdf');

    /* Performance Analysis */
    Route::get('/student/performance', [\App\Http\Controllers\Student\PerformanceController::class, 'index'])
        ->name('student.performance.index');

});