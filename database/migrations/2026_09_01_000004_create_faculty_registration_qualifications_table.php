<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty_registration_qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faculty_registration_id');
            $table->string('degree', 150);           // Bachelor's, Master's, PhD, B.Ed, etc.
            $table->string('institution', 255);
            $table->string('university', 255)->nullable();
            $table->string('specialization', 150)->nullable();
            $table->string('passing_year', 10)->nullable();
            $table->string('percentage_cgpa', 20)->nullable();
            $table->timestamps();

            $table->foreign('faculty_registration_id', 'fac_reg_quals_fac_reg_id_fk')
                  ->references('id')->on('faculty_registrations')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculty_registration_qualifications');
    }
};
