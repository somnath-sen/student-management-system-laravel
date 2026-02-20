<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('marks', function (Blueprint $table) {
            // Check if the column exists first
            if (!Schema::hasColumn('marks', 'is_locked')) {
                $table->boolean('is_locked')
                      ->default(false)
                      ->after('total_marks');
            }
        });
    }

    public function down(): void
    {
        Schema::table('marks', function (Blueprint $table) {
            if (Schema::hasColumn('marks', 'is_locked')) {
                $table->dropColumn('is_locked');
            }
        });
    }
};