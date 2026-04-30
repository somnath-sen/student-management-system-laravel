<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeduplicateAcademicData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edflow:deduplicate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up duplicated courses and subjects from the database safely.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Database Deduplication...');

        $courseNames = \Illuminate\Support\Facades\DB::table('courses')
            ->select('name')
            ->distinct()
            ->pluck('name');

        $totalDeletedCourses = 0;
        $totalDeletedSubjects = 0;

        foreach ($courseNames as $name) {
            $courses = \App\Models\Course::where('name', $name)->orderBy('id')->get();
            
            if ($courses->count() <= 1) {
                continue;
            }

            $this->info("Found {$courses->count()} instances of Course: {$name}");
            
            // Keep the first one, delete the rest
            $originalCourse = $courses->first();
            $duplicateCourses = $courses->slice(1);

            foreach ($duplicateCourses as $duplicate) {
                // 1. Move students to original course
                \Illuminate\Support\Facades\DB::table('students')
                    ->where('course_id', $duplicate->id)
                    ->update(['course_id' => $originalCourse->id]);

                // 2. Handle duplicated subjects
                $duplicateSubjects = \App\Models\Subject::where('course_id', $duplicate->id)->get();
                
                foreach ($duplicateSubjects as $ds) {
                    $originalSubject = \App\Models\Subject::where('course_id', $originalCourse->id)
                        ->where('name', $ds->name)
                        ->first();
                    
                    if ($originalSubject) {
                        // Move dependencies
                        \Illuminate\Support\Facades\DB::table('marks')
                            ->where('subject_id', $ds->id)
                            ->update(['subject_id' => $originalSubject->id]);
                            
                        \Illuminate\Support\Facades\DB::table('attendances')
                            ->where('subject_id', $ds->id)
                            ->update(['subject_id' => $originalSubject->id]);
                            
                        \Illuminate\Support\Facades\DB::table('subject_teacher')
                            ->where('subject_id', $ds->id)
                            ->update(['subject_id' => $originalSubject->id]);
                    }
                }

                // Delete the duplicate course (cascade will delete its subjects)
                $duplicate->delete();
                $totalDeletedCourses++;
                $totalDeletedSubjects += $duplicateSubjects->count();
            }
        }

        $this->info("✅ Deduplication Complete!");
        $this->info("Deleted Courses: {$totalDeletedCourses}");
        $this->info("Deleted Subjects: {$totalDeletedSubjects}");
    }
}
