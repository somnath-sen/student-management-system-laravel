<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->longText('analysis_json')->nullable();   // raw per-subject analysis
            $table->longText('suggestions_json')->nullable(); // AI-generated suggestions array
            $table->string('overall_level')->default('Average'); // Strong/Average/Weak/VeryWeak
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();

            $table->unique('user_id');  // one cache row per student
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};
