<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Old demo emails from previous seeder versions that must be
     * cleaned up before re-seeding to avoid unique-key conflicts.
     * These are ONLY the old auto-generated test accounts — never real user data.
     */
    private array $legacyDemoEmails = [
        // Old numbered teacher accounts (previous seeder format)
        'teacher1@edflow.com',
        'teacher2@edflow.com',
        'teacher3@edflow.com',
        'teacher4@edflow.com',
        'teacher5@edflow.com',
        // Old numbered student accounts
        'student1@edflow.com',
        'student2@edflow.com',
        'student3@edflow.com',
        'student4@edflow.com',
        'student5@edflow.com',
        'student6@edflow.com',
        'student7@edflow.com',
        'student8@edflow.com',
        'student9@edflow.com',
        'student10@edflow.com',
        // Old parent accounts
        'parent1@edflow.com',
        'parent2@edflow.com',
        'parent3@edflow.com',
        // Old generic demo accounts
        'demo@teacher.com',
        'demo@student.com',
        'demo@parent.com',
        'admin@admin.com',
        'teacher@teacher.com',
        'student@student.com',
    ];

    /**
     * Seed the application's database.
     * Safe to re-run on existing production databases.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // ── Clean up old demo accounts from previous seeder versions ──────
        $this->cleanupLegacyAccounts();

        // ── 1. Foundation ─────────────────────────────────────────────────
        $this->call([
            RoleSeeder::class,
            BadgeSeeder::class,
        ]);

        // ── 2. Admin users ────────────────────────────────────────────────
        $this->call([
            AdminSeeder::class,
        ]);

        // ── 3. Academic Structure ─────────────────────────────────────────
        $this->call([
            AcademicStructureSeeder::class,
        ]);

        // ── 4. People ─────────────────────────────────────────────────────
        $this->call([
            TeacherSeeder::class,
            StudentSeeder::class,
            ParentSeeder::class,
        ]);

        // ── 5. Academic Data ──────────────────────────────────────────────
        $this->call([
            AcademicDataSeeder::class,
        ]);

        // ── 6. Communications & Settings ──────────────────────────────────
        $this->call([
            NoticeSeeder::class,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Remove old numbered/legacy demo accounts so the new named
     * demo accounts can be seeded cleanly without key conflicts.
     */
    private function cleanupLegacyAccounts(): void
    {
        foreach ($this->legacyDemoEmails as $email) {
            $user = User::where('email', $email)->first();
            if (!$user) continue;

            $student = DB::table('students')->where('user_id', $user->id)->first();
            $teacher = DB::table('teachers')->where('user_id', $user->id)->first();

            // Remove related academic data if they were a student
            if ($student) {
                DB::table('attendances')->where('student_id', $student->id)->delete();
                DB::table('marks')->where('student_id', $student->id)->delete();
                DB::table('risk_logs')->where('student_id', $student->id)->delete();
                DB::table('students')->where('id', $student->id)->delete();
            }

            // Remove related academic data if they were a teacher
            if ($teacher) {
                DB::table('attendances')->where('teacher_id', $teacher->id)->delete();
                DB::table('marks')->where('teacher_id', $teacher->id)->delete();
                DB::table('subject_teacher')->where('teacher_id', $teacher->id)->delete();
                DB::table('teachers')->where('id', $teacher->id)->delete();
            }

            // Remove direct user relations
            DB::table('fee_payments')->where('user_id', $user->id)->delete();
            DB::table('parent_student')->where('parent_id', $user->id)->delete();
            DB::table('gamification_stats')->where('user_id', $user->id)->delete();
            DB::table('badge_user')->where('user_id', $user->id)->delete();
            DB::table('suggestions')->where('user_id', $user->id)->delete();

            $user->delete();
        }
    }
}