<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->boolean('is_panicking')->default(false)->after('location_updated_at');
            $table->decimal('panic_lat', 10, 8)->nullable()->after('is_panicking');
            $table->decimal('panic_lng', 11, 8)->nullable()->after('panic_lat');
            $table->timestamp('panic_triggered_at')->nullable()->after('panic_lng');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['is_panicking', 'panic_lat', 'panic_lng', 'panic_triggered_at']);
        });
    }
};
