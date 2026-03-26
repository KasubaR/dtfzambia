<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing tables in correct order (pivot first)
        Schema::dropIfExists('course_enrollment');
        Schema::dropIfExists('enrollments');

        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Personal Information
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('nrc')->unique();
            $table->string('age_range');
            $table->string('location');
            $table->string('education_level');
            $table->string('employment_status');
            $table->string('workplace')->nullable();

            // Enrollment Details
            $table->text('reason');
            $table->decimal('total_price', 10, 2);

            // Status & Tracking
            $table->enum('status', ['pending', 'approved', 'rejected', 'active', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('enrolled_at')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
        });

        Schema::create('course_enrollment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->decimal('price_at_enrollment', 10, 2);
            $table->timestamps();

            $table->unique(['enrollment_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_enrollment');
        Schema::dropIfExists('enrollments');
    }
};
