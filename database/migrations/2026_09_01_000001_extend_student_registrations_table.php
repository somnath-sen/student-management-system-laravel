<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_registrations', function (Blueprint $table) {
            // Application reference
            $table->string('application_no', 30)->nullable()->unique()->after('id');

            // Step 1 – Personal
            $table->string('first_name', 100)->nullable()->after('application_no');
            $table->string('middle_name', 100)->nullable()->after('first_name');
            $table->string('last_name', 100)->nullable()->after('middle_name');
            $table->date('date_of_birth')->nullable()->after('last_name');
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not'])->nullable()->after('date_of_birth');
            $table->string('nationality', 100)->nullable()->after('gender');
            $table->string('blood_group', 10)->nullable()->after('nationality');
            $table->string('category', 50)->nullable()->after('blood_group');  // General/OBC/SC/ST
            $table->string('religion', 50)->nullable()->after('category');
            $table->string('photo_path', 500)->nullable()->after('religion');

            // Step 2 – Contact
            $table->string('alternate_phone', 20)->nullable()->after('phone');
            $table->string('whatsapp_number', 20)->nullable()->after('alternate_phone');
            $table->text('permanent_address')->nullable()->after('whatsapp_number');
            $table->text('current_address')->nullable()->after('permanent_address');
            $table->string('city', 100)->nullable()->after('current_address');
            $table->string('state', 100)->nullable()->after('city');
            $table->string('postal_code', 20)->nullable()->after('state');
            $table->string('country', 100)->nullable()->default('India')->after('postal_code');

            // Step 4 – Academic (course_id is the correct FK; course string column kept for BC)
            $table->unsignedBigInteger('course_id')->nullable()->after('course');
            $table->string('last_institution', 255)->nullable()->after('course_id');
            $table->string('board_university', 255)->nullable()->after('last_institution');
            $table->string('last_qualification', 100)->nullable()->after('board_university');
            $table->string('passing_year', 10)->nullable()->after('last_qualification');
            $table->string('percentage_cgpa', 20)->nullable()->after('passing_year');
            $table->string('roll_registration_no', 100)->nullable()->after('percentage_cgpa');
            $table->string('stream', 100)->nullable()->after('roll_registration_no');

            // Step 5 – Identity (Aadhaar encrypted)
            $table->text('aadhaar_encrypted')->nullable()->after('stream');

            // Audit fields
            $table->timestamp('submitted_at')->nullable()->after('reject_reason');
            $table->timestamp('reviewed_at')->nullable()->after('submitted_at');
            $table->unsignedBigInteger('reviewed_by')->nullable()->after('reviewed_at');
            $table->timestamp('approved_at')->nullable()->after('reviewed_by');
            $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
            $table->timestamp('rejected_at')->nullable()->after('approved_by');
            $table->unsignedBigInteger('rejected_by')->nullable()->after('rejected_at');

            // FK for course_id
            $table->foreign('course_id')->references('id')->on('courses')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('student_registrations', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropColumn([
                'application_no', 'first_name', 'middle_name', 'last_name',
                'date_of_birth', 'gender', 'nationality', 'blood_group', 'category',
                'religion', 'photo_path', 'alternate_phone', 'whatsapp_number',
                'permanent_address', 'current_address', 'city', 'state', 'postal_code',
                'country', 'course_id', 'last_institution', 'board_university',
                'last_qualification', 'passing_year', 'percentage_cgpa',
                'roll_registration_no', 'stream', 'aadhaar_encrypted',
                'submitted_at', 'reviewed_at', 'reviewed_by',
                'approved_at', 'approved_by', 'rejected_at', 'rejected_by',
            ]);
        });
    }
};
