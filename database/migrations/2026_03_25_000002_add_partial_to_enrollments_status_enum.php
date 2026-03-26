<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement(
                "ALTER TABLE enrollments MODIFY COLUMN status ENUM("
                . "'pending','approved','rejected','active','completed','cancelled','partial'"
                . ") NOT NULL DEFAULT 'pending'"
            );

            return;
        }

        if ($driver === 'sqlite') {
            // Laravel `enum()` on SQLite adds a CHECK that omits `partial`; use a plain string column.
            Schema::table('enrollments', function (Blueprint $table): void {
                $table->string('status')->default('pending')->change();
            });
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement(
                "ALTER TABLE enrollments MODIFY COLUMN status ENUM("
                . "'pending','approved','rejected','active','completed','cancelled'"
                . ") NOT NULL DEFAULT 'pending'"
            );

            return;
        }

        if ($driver === 'sqlite') {
            Schema::table('enrollments', function (Blueprint $table): void {
                $table->enum('status', ['pending', 'approved', 'rejected', 'active', 'completed', 'cancelled'])
                    ->default('pending')
                    ->change();
            });
        }
    }
};
