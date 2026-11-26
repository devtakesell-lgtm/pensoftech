<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_applications', function (Blueprint $table) {
            $table->foreignId('learner_id')->nullable()->after('user_id')->constrained('learners')->nullOnDelete();
        });

        Schema::table('course_certificates', function (Blueprint $table) {
            $table->foreignId('learner_id')->nullable()->after('user_id')->constrained('learners')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('course_applications', function (Blueprint $table) {
            $table->dropConstrainedForeignId('learner_id');
        });

        Schema::table('course_certificates', function (Blueprint $table) {
            $table->dropConstrainedForeignId('learner_id');
        });
    }
};
