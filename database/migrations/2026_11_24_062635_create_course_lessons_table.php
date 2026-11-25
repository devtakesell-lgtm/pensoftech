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
        Schema::create('course_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_module_id')->constrained('course_modules')->cascadeOnDelete();
            $table->string('title');
            $table->string('lesson_type')->default('offline_class');
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->dateTime('class_date_time')->nullable();
            $table->string('meeting_link')->nullable();
            $table->string('video_provider')->nullable();
            $table->string('video_url')->nullable();
            $table->string('attachment_file')->nullable();
            $table->longText('notes')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lessons');
    }
};
