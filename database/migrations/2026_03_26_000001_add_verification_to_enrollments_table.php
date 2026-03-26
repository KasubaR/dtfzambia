<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table): void {
            $table->string('verification_code', 6)->nullable()->after('status');
            $table->timestamp('verification_expires_at')->nullable()->after('verification_code');
        });

        // Add pending_verification to the status enum (MySQL only)
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement(
                "ALTER TABLE enrollments MODIFY COLUMN status ENUM("
                . "'pending','approved','rejected','active','completed','cancelled','partial','pending_verification'"
                . ") NOT NULL DEFAULT 'pending'"
            );
        }
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table): void {
            $table->dropColumn(['verification_code', 'verification_expires_at']);
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement(
                "ALTER TABLE enrollments MODIFY COLUMN status ENUM("
                . "'pending','approved','rejected','active','completed','cancelled','partial'"
                . ") NOT NULL DEFAULT 'pending'"
            );
        }
    }
};
