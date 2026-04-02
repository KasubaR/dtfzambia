<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite stores enums as strings — no ALTER needed for the pivot table.
        // For MySQL we'd need to modify the column, but since we're using SQLite
        // the string column already accepts any value.

        // enrollments.status — add 'waitlisted' to the allowed set (MySQL only).
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE enrollments MODIFY COLUMN status ENUM(
                'pending_verification','pending','approved','partial','rejected',
                'active','completed','cancelled','waitlisted'
            ) NOT NULL DEFAULT 'pending_verification'");

            DB::statement("ALTER TABLE course_enrollment MODIFY COLUMN status ENUM(
                'pending','accepted','rejected','waitlisted'
            ) NOT NULL DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE enrollments MODIFY COLUMN status ENUM(
                'pending_verification','pending','approved','partial','rejected',
                'active','completed','cancelled'
            ) NOT NULL DEFAULT 'pending_verification'");

            DB::statement("ALTER TABLE course_enrollment MODIFY COLUMN status ENUM(
                'pending','accepted','rejected'
            ) NOT NULL DEFAULT 'pending'");
        }
    }
};
