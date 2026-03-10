<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Semester 1 Tuition", "Library Fee"
            $table->decimal('amount', 10, 2); // e.g., 50000.00
            $table->date('due_date');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade'); // If null, applies to all students
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
