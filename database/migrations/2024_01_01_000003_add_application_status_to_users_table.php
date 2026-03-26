<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // application_status: null = never applied, pending, approved, rejected
            $table->enum('application_status', ['pending', 'approved', 'rejected'])
                  ->nullable()
                  ->default(null)
                  ->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('application_status');
        });
    }
};
