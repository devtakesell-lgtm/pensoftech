<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('jobs_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('job_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('employment_type')->nullable();
            $table->string('location')->nullable();
            $table->string('experience')->nullable();
            $table->unsignedInteger('vacancy')->default(1);
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->date('deadline')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('jobs_listings');
    }
};
