<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentAnalysisController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Student\AttendanceController as StudentAttendanceController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Admin\ResultPublishController;
use App\Http\Controllers\Student\MarksheetController;
use App\Http\Controllers\Teacher\MarkController;
use App\Http\Controllers\Teacher\DetailsController;
use App\Http\Controllers\Student\ResultController;
use App\Http\Controllers\StudyAIController;
use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\FeeController as AdminFeeController;
use App\Http\Controllers\Student\FeeController as StudentFeeController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Student\LocationController;
use App\Http\Controllers\Student\SuggestionController;
use App\Http\Controllers\Teacher\BroadcastController as TeacherBroadcastController;
use App\Http\Controllers\Student\BroadcastController as StudentBroadcastController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\FacultyRegistrationController;
use App\Http\Controllers\Admin\FacultyRegistrationController as AdminFacultyRegistrationController;
// use App\Http\Controllers\Student\TimetableController;
// use App\Http\Controllers\Admin\TimetableController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Preference Routes (Cookies)
Route::post('/preferences/theme', [\App\Http\Controllers\PreferenceController::class, 'updateTheme'])->name('preferences.theme');
Route::post('/preferences/language', [\App\Http\Controllers\PreferenceController::class, 'updateLanguage'])->name('preferences.language');
Route::post('/preferences/clear', [\App\Http\Controllers\PreferenceController::class, 'clearPreferences'])->name('preferences.clear');



// Registration Routes
Route::get('/register/student', function () {
    if (!\App\Models\Setting::get('student_registration_enabled', true)) {
        return view('register.closed', ['type' => 'Student']);
    }
    $courses = \App\Models\Course::orderBy('name')->get();
    return view('register.student', compact('courses'));
});
Route::post('/register/student', [RegistrationController::class, 'store'])->name('register.student.store');

Route::get('/register/teacher', function () {
    if (!\App\Models\Setting::get('faculty_registration_enabled', true)) {
        return view('register.closed', ['type' => 'Faculty']);
    }
    $subjects = \App\Models\Subject::orderBy('name')->get();
    return view('register.teacher', compact('subjects'));
});
Route::post('/register/faculty', [FacultyRegistrationController::class, 'store'])->name('register.faculty.store');

// Put this at the BOTTOM of web.php (Outside Auth middleware!)
Route::get('/verify/student/{id}', function($id) {
    $student = \App\Models\Student::with(['user', 'course'])->findOrFail($id);
    return view('public.verify-student', compact('student'));
})->name('verify.student');


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
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
    /* Student Registrations */
    Route::get('/admin/registrations', [AdminRegistrationController::class, 'index'])->name('admin.registrations.index');
    Route::post('/admin/registrations/{id}/approve', [AdminRegistrationController::class, 'approve'])->name('admin.registrations.approve');
    Route::post('/admin/registrations/{id}/reject', [AdminRegistrationController::class, 'reject'])->name('admin.registrations.reject');

    /* Faculty Registrations */
    Route::get('/admin/faculty-registrations', [AdminFacultyRegistrationController::class, 'index'])->name('admin.faculty-registrations.index');
    Route::post('/admin/faculty-registrations/{id}/approve', [AdminFacultyRegistrationController::class, 'approve'])->name('admin.faculty-registrations.approve');
    Route::post('/admin/faculty-registrations/{id}/reject', [AdminFacultyRegistrationController::class, 'reject'])->name('admin.faculty-registrations.reject');
    Route::post('/admin/faculty-registrations/{id}/resend', [AdminFacultyRegistrationController::class, 'resend'])->name('admin.faculty-registrations.resend');

    /* System Settings */
    Route::get('/admin/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/settings/update', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
        
    /* Courses CRUD */
    Route::get('/admin/courses', [CourseController::class, 'index'])->name('admin.courses.index');
    Route::get('/admin/courses/create', [CourseController::class, 'create'])->name('admin.courses.create');
    Route::post('/admin/courses', [CourseController::class, 'store'])->name('admin.courses.store');
    Route::get('/admin/courses/{course}/edit', [CourseController::class, 'edit'])->name('admin.courses.edit');
    Route::put('/admin/courses/{course}', [CourseController::class, 'update'])->name('admin.courses.update');
    Route::delete('/admin/courses/{course}', [CourseController::class, 'destroy'])->name('admin.courses.destroy');

    /* Subjects CRUD */
    Route::get('/admin/subjects', [SubjectController::class, 'index'])->name('admin.subjects.index');
    Route::get('/admin/subjects/create', [SubjectController::class, 'create'])->name('admin.subjects.create');
    Route::post('/admin/subjects', [SubjectController::class, 'store'])->name('admin.subjects.store');
    Route::get('/admin/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('admin.subjects.edit');
    Route::put('/admin/subjects/{subject}', [SubjectController::class, 'update'])->name('admin.subjects.update');
    Route::delete('/admin/subjects/{subject}', [SubjectController::class, 'destroy'])->name('admin.subjects.destroy');

    /* Students */
    Route::get('/admin/students', [StudentController::class, 'index'])->name('admin.students.index');
    Route::get('/admin/students/create', [StudentController::class, 'create'])->name('admin.students.create');
    Route::post('/admin/students', [StudentController::class, 'store'])->name('admin.students.store');
    Route::get('/admin/students/{student}/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
    Route::put('/admin/students/{student}', [StudentController::class, 'update'])->name('admin.students.update');
    Route::delete('/admin/students/{student}', [StudentController::class, 'destroy'])->name('admin.students.destroy');

    /* Teachers */
    Route::get('/admin/teachers', [TeacherController::class, 'index'])->name('admin.teachers.index');
    Route::get('/admin/teachers/create', [TeacherController::class, 'create'])->name('admin.teachers.create');
    Route::post('/admin/teachers', [TeacherController::class, 'store'])->name('admin.teachers.store');
    Route::get('/admin/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('admin.teachers.edit');
    Route::put('/admin/teachers/{teacher}', [TeacherController::class, 'update'])->name('admin.teachers.update');
    Route::delete('/admin/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('admin.teachers.destroy');

    /* Applications (Secured inside Admin Middleware) */
    Route::get('/admin/applicants/students', [ApplicantController::class, 'students'])->name('admin.applicants.students');
    Route::get('/admin/applicants/teachers', [ApplicantController::class, 'teachers'])->name('admin.applicants.teachers');

    // Result publish (Course-wise)
    Route::get('/admin/results', [ResultPublishController::class, 'index'])->name('admin.results.index');
    Route::post('/admin/results/{course}/publish', [ResultPublishController::class, 'publish'])->name('admin.results.publish');
    Route::post('/admin/results/{course}/unpublish', [ResultPublishController::class, 'unpublish'])->name('admin.results.unpublish');

    /* Analytics */
    Route::get('/admin/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('admin.analytics.index');
    Route::get('/admin/analytics/export', [\App\Http\Controllers\Admin\AnalyticsController::class, 'export'])->name('admin.analytics.export');

    /* Student Analysis (New Feature) */
    Route::get('/admin/student-analysis', [StudentAnalysisController::class, 'index'])->name('admin.student-analysis.index');
    Route::post('/admin/student-analysis/{student}/status', [StudentAnalysisController::class, 'updateStatus'])->name('admin.student-analysis.update-status');
    
    // Fee Management Routes
    Route::get('/admin/fees', [AdminFeeController::class, 'index'])->name('admin.fees.index');
    Route::post('/admin/fees', [AdminFeeController::class, 'store'])->name('admin.fees.store');
    Route::post('/admin/fees/approve/{payment}', [AdminFeeController::class, 'approvePayment'])->name('admin.fees.approve');

    // Notice Board Routes
    Route::get('/admin/notices', [NoticeController::class, 'index'])->name('admin.notices.index');
    Route::post('/admin/notices', [NoticeController::class, 'store'])->name('admin.notices.store');
    Route::delete('/admin/notices/{notice}', [NoticeController::class, 'destroy'])->name('admin.notices.destroy');

    // Admin Timetable Builder
    Route::get('/admin/timetable', [\App\Http\Controllers\Admin\TimetableController::class, 'index'])->name('admin.timetable.index');
    Route::post('/admin/timetable', [\App\Http\Controllers\Admin\TimetableController::class, 'store'])->name('admin.timetable.store');
    Route::delete('/admin/timetable/{timetable}', [\App\Http\Controllers\Admin\TimetableController::class, 'destroy'])->name('admin.timetable.destroy');


    // Admin Admit Card Manager
    Route::get('/admin/admit-cards', [\App\Http\Controllers\Admin\AdmitCardController::class, 'index'])->name('admin.admit-card.index');
    Route::post('/admin/admit-cards/{course}/toggle', [\App\Http\Controllers\Admin\AdmitCardController::class, 'togglePublish'])->name('admin.admit-card.toggle');

});

/*
|--------------------------------------------------------------------------
| TEACHER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:teacher'])->group(function () {

    Route::get('/teacher/dashboard', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('teacher.dashboard');

    // Attendance
    Route::get('/teacher/attendance/create', [TeacherAttendanceController::class, 'create'])->name('teacher.attendance.create');
    Route::post('/teacher/attendance/store', [TeacherAttendanceController::class, 'store'])->name('teacher.attendance.store');
    
    // Details
    Route::get('/teacher/details', [DetailsController::class, 'index'])->name('teacher.details');

    // Marks
    Route::get('/teacher/marks/create', [MarkController::class, 'create'])->name('teacher.marks.create');
    Route::post('/teacher/marks', [MarkController::class, 'store'])->name('teacher.marks.store');
    Route::get('/teacher/marks', [MarkController::class, 'index'])->name('teacher.marks.index');
    Route::get('/teacher/marks/{subject}', [MarkController::class, 'edit'])->name('teacher.marks.edit');
    Route::put('/teacher/marks/{subject}', [MarkController::class, 'update'])->name('teacher.marks.update');
    Route::post('/teacher/marks/{subject}/lock', [MarkController::class, 'lock'])->name('teacher.marks.lock');

    /* Performance Analysis */
    Route::get('/teacher/performance', [\App\Http\Controllers\Teacher\PerformanceController::class, 'index'])->name('teacher.performance.index');
    Route::get('/teacher/performance/{subject}', [\App\Http\Controllers\Teacher\PerformanceController::class, 'show'])->name('teacher.performance.show');

    /* Emergency Contact */
    Route::get('/teacher/emergency', function () {
        return view('teacher.emergency');
    })->name('teacher.emergency');

    // Teacher Timetable
    Route::get('/teacher/timetable', [\App\Http\Controllers\Teacher\TimetableController::class, 'index'])->name('teacher.timetable');

    // Broadcast Messaging
    Route::get('/teacher/broadcast/{subject}', [TeacherBroadcastController::class, 'index'])->name('teacher.broadcast.index');
    Route::post('/teacher/broadcast/{subject}', [TeacherBroadcastController::class, 'store'])->name('teacher.broadcast.store');
    Route::delete('/teacher/broadcast/message/{message}', [TeacherBroadcastController::class, 'destroy'])->name('teacher.broadcast.destroy');
    Route::get('/teacher/broadcast/message/{message}/seen-count', [TeacherBroadcastController::class, 'seenCount'])->name('teacher.broadcast.seen-count');

});

/*
|--------------------------------------------------------------------------
| STUDENT ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:student'])->group(function () {
    
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');

    /* Attendance (Read-only) */
    Route::get('/student/attendance', [StudentAttendanceController::class, 'index'])->name('student.attendance.index');

    Route::get('/student/details', [\App\Http\Controllers\Student\DetailsController::class, 'index'])->name('student.details');

    // Results
    Route::get('/student/results', [ResultController::class, 'index'])->name('student.results.index');

    // Marksheet PDF
    Route::get('/student/marksheet', [MarksheetController::class, 'show'])->name('student.marksheet.show');
    Route::get('/student/marksheet/pdf', [MarksheetController::class, 'download'])->name('student.marksheet.pdf');

    /* Performance Analysis */
    Route::get('/student/performance', [\App\Http\Controllers\Student\PerformanceController::class, 'index'])->name('student.performance.index');

    /* Emergency Contact */
    Route::get('/student/emergency', function () {
        return view('student.emergency');
    })->name('student.emergency');

    // Student Fee Routes
    Route::get('/student/fees', [StudentFeeController::class, 'index'])->name('student.fees.index');
    Route::post('/student/fees/create-order', [StudentFeeController::class, 'createOrder'])->name('student.fees.order');
    Route::post('/student/fees/verify', [StudentFeeController::class, 'verifyPayment'])->name('student.fees.verify');

    // ADD THIS NEW ROUTE:
    Route::get('/student/fees/{fee}/receipt', [StudentFeeController::class, 'receipt'])->name('student.fees.receipt');
    Route::post('/student/fees/offline', [StudentFeeController::class, 'submitOfflinePayment'])->name('student.fees.offline');

    //Notice
    Route::get('/student/notices/{notice}', [StudentDashboardController::class, 'showNotice'])->name('student.notices.show');

    
    // Digital Smart ID Card Routes
    Route::get('/student/smart-id', [\App\Http\Controllers\Student\SmartIdController::class, 'index'])->name('student.smart-id');
    Route::post('/student/smart-id', [\App\Http\Controllers\Student\SmartIdController::class, 'update'])->name('student.smart-id.update');
    
    // Location Tracker Routes
    Route::get('/student/location', [LocationController::class, 'index'])->name('student.location');
    Route::post('/student/location', [LocationController::class, 'update'])->name('student.location.update');
    Route::post('/student/location/panic', [LocationController::class, 'panic'])->name('student.location.panic');
    Route::post('/student/location/cancel-panic', [LocationController::class, 'cancelPanic'])->name('student.location.cancel-panic');

    // Timetable Route
    Route::get('/student/timetable', [\App\Http\Controllers\Student\TimetableController::class, 'index'])->name('student.timetable');

    // Admit Card Route
    Route::get('/student/admit-card', [\App\Http\Controllers\Student\AdmitCardController::class, 'show'])->name('student.admit-card.show');

    // AI Suggestion Engine
    Route::get('/student/suggestions', [SuggestionController::class, 'index'])->name('student.suggestions');
    Route::post('/student/suggestions/refresh', [SuggestionController::class, 'refresh'])->name('student.suggestions.refresh');

    // Broadcast Messaging (Read-only)
    Route::get('/student/broadcast/unread-count', [StudentBroadcastController::class, 'unreadCount'])->name('student.broadcast.unread');
    Route::get('/student/broadcast/{subject}', [StudentBroadcastController::class, 'index'])->name('student.broadcast.index');
    Route::post('/student/broadcast/seen/{message}', [StudentBroadcastController::class, 'markSeen'])->name('student.broadcast.seen');
});

/*
|--------------------------------------------------------------------------
| STUDENT ROUTES + TEACHER ROUTES   [STUDYAI]
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:teacher,student'])->group(function () {

    Route::get('/studyai', [StudyAIController::class, 'index'])->name('studyai.index');
    Route::post('/studyai/send', [StudyAIController::class, 'send'])->name('studyai.send');

});

/*
|--------------------------------------------------------------------------
| PARENT ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/parent/dashboard', [\App\Http\Controllers\Parent\DashboardController::class, 'index'])->name('parent.dashboard');
});