<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_type'); // 'student', 'parent', 'admin'
            $table->unsignedBigInteger('recipient_id')->nullable(); // user_id
            $table->string('chat_id')->nullable();
            $table->string('event_type')->nullable(); // 'attendance', 'result', 'notice', 'fee', 'sos', 'broadcast'
            $table->text('message');
            $table->string('status')->default('pending'); // 'sent', 'failed', 'pending'
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_logs');
    }
};
