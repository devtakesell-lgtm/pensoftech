<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Nullable: a fresh inquiry isn't a client yet. Once converted, link it
    // to the existing (or newly created) client record.
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('industry_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained()->nullOnDelete();
            $table->string('lead_source')->nullable();
            $table->string('lead_type')->nullable();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->text('message')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('status')->default('new');
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_content')->nullable();
            $table->string('gclid')->nullable();
            $table->string('fbclid')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
