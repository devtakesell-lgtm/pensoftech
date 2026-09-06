<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs_listings')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('cv_file');
            $table->text('cover_letter')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('status')->default('applied');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
