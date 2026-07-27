<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // The app-level uniqueness check already excludes rejected/waitlisted/
        // pending_verification enrollments (see EnrollmentController::store),
        // but this hard DB constraint still blocked re-applying with the same
        // NRC after a rejection, causing a QueryException on resubmit.
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropUnique(['nrc']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->unique('nrc');
        });
    }
};
