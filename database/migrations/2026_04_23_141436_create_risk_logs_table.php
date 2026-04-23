<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->decimal('risk_score', 5, 2)->default(0);
            $table->enum('risk_level', ['safe', 'at_risk', 'high_risk'])->default('safe');
            $table->decimal('attendance_score', 5, 2)->default(0);
            $table->decimal('marks_score', 5, 2)->default(0);
            $table->decimal('engagement_score', 5, 2)->default(0);
            $table->json('insights')->nullable();
            $table->json('suggestions')->nullable();
            $table->timestamp('last_evaluated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_logs');
    }
};
