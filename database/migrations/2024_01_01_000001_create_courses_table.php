<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('duration')->default('10 Days');     // e.g. "10 Days", "30 Days"
            $table->string('mode')->default('Hybrid');          // "Hybrid", "Online", "In-Person"
            $table->unsignedInteger('price')->default(1750);    // in Kwacha
            $table->string('icon')->default('menu_book');       // Material Symbol name
            $table->json('modules')->nullable();                // ["Module 1", "Module 2", ...]
            $table->unsignedInteger('seats_remaining')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_recommended')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
