<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty_registration_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faculty_registration_id');
            $table->string('institution', 255);
            $table->string('designation', 150)->nullable();
            $table->string('department', 150)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->text('responsibilities')->nullable();
            $table->timestamps();

            $table->foreign('faculty_registration_id', 'fac_reg_exps_fac_reg_id_fk')
                  ->references('id')->on('faculty_registrations')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculty_registration_experiences');
    }
};
