<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_registration_guardians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_registration_id');
            $table->enum('guardian_type', ['primary', 'secondary', 'emergency']);
            $table->string('full_name', 255);
            $table->string('relationship', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('occupation', 150)->nullable();
            $table->string('annual_income', 50)->nullable();
            $table->text('aadhaar_encrypted')->nullable();
            $table->timestamps();

            $table->foreign('student_registration_id')
                  ->references('id')->on('student_registrations')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_registration_guardians');
    }
};
