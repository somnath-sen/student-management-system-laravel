<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_documents', function (Blueprint $table) {
            $table->id();
            $table->enum('application_type', ['student', 'faculty']);
            $table->unsignedBigInteger('application_id');   // polymorphic reference
            $table->string('document_type', 100);           // 'photo', 'aadhaar', 'marksheet_10', etc.
            $table->string('document_label', 150)->nullable(); // Human-readable label
            $table->string('original_name', 255);
            $table->string('stored_path', 500);             // relative to disk root
            $table->string('disk', 50)->default('local');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('file_size')->nullable(); // bytes
            $table->timestamp('uploaded_at')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable(); // NULL = applicant self-upload
            $table->timestamps();

            // Index for lookups by application
            $table->index(['application_type', 'application_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_documents');
    }
};
