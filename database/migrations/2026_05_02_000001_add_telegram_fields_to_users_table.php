<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telegram_chat_id')->nullable()->after('remember_token');
            $table->string('telegram_connect_token')->nullable()->unique()->after('telegram_chat_id');
            $table->timestamp('telegram_connected_at')->nullable()->after('telegram_connect_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telegram_chat_id', 'telegram_connect_token', 'telegram_connected_at']);
        });
    }
};
