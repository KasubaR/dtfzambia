<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_enrollment', function (Blueprint $table) {
            $table->string('status', 20)->default('pending')->after('price_at_enrollment');
            $table->timestamp('reviewed_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('course_enrollment', function (Blueprint $table) {
            $table->dropColumn(['status', 'reviewed_at']);
        });
    }
};
