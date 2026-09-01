<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faculty_registrations', function (Blueprint $table) {
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
            $table->string('marital_status', 50)->nullable()->after('blood_group');
            $table->string('photo_path', 500)->nullable()->after('marital_status');

            // Step 2 – Contact
            $table->string('alternate_phone', 20)->nullable()->after('phone');
            $table->string('whatsapp_number', 20)->nullable()->after('alternate_phone');
            $table->text('address')->nullable()->after('whatsapp_number');
            $table->string('city', 100)->nullable()->after('address');
            $table->string('state', 100)->nullable()->after('city');
            $table->string('postal_code', 20)->nullable()->after('state');
            $table->string('country', 100)->nullable()->default('India')->after('postal_code');

            // Step 3 – Professional
            $table->string('designation', 150)->nullable()->after('department');
            $table->string('years_experience', 20)->nullable()->after('designation');
            $table->string('current_institution', 255)->nullable()->after('years_experience');
            $table->enum('teaching_mode', ['classroom', 'online', 'hybrid'])->nullable()->after('current_institution');
            $table->text('professional_summary')->nullable()->after('teaching_mode');

            // Step 5 – Identity
            $table->text('aadhaar_encrypted')->nullable()->after('professional_summary');

            // Audit fields
            $table->timestamp('submitted_at')->nullable()->after('reject_reason');
            $table->timestamp('reviewed_at')->nullable()->after('submitted_at');
            $table->unsignedBigInteger('reviewed_by')->nullable()->after('reviewed_at');
            $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
            $table->timestamp('rejected_at')->nullable()->after('approved_by');
            $table->unsignedBigInteger('rejected_by')->nullable()->after('rejected_at');
        });
    }

    public function down(): void
    {
        Schema::table('faculty_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'application_no', 'first_name', 'middle_name', 'last_name',
                'date_of_birth', 'gender', 'nationality', 'blood_group',
                'marital_status', 'photo_path', 'alternate_phone', 'whatsapp_number',
                'address', 'city', 'state', 'postal_code', 'country',
                'designation', 'years_experience', 'current_institution',
                'teaching_mode', 'professional_summary', 'aadhaar_encrypted',
                'submitted_at', 'reviewed_at', 'reviewed_by',
                'approved_by', 'rejected_at', 'rejected_by',
            ]);
        });
    }
};
