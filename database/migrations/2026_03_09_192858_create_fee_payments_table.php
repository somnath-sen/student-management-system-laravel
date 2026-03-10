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
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The Student
            $table->decimal('amount_paid', 10, 2);
            
            // Payment Details
            $table->string('payment_method'); // 'Razorpay', 'Cash', 'Bank Transfer'
            $table->string('transaction_id')->nullable(); // Razorpay TXN ID or Bank Ref No
            $table->string('receipt_path')->nullable(); // For offline payment proof uploads
            
            // Status: 'pending' (offline waiting for admin), 'completed' (online success or admin verified), 'failed'
            $table->string('status')->default('pending'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
