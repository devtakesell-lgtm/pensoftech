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
        Schema::create('course_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->nullOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->nullOnDelete();
            $table->string('application_no')->unique();
            $table->string('student_name');
            $table->string('email');
            $table->string('phone');
            $table->string('alt_phone')->nullable();
            $table->string('gender')->nullable();
            $table->text('present_address')->nullable();
            $table->string('educational_qualification')->nullable();
            $table->string('current_profession')->nullable();
            $table->string('experience_level')->nullable();
            $table->text('why_this_course')->nullable();
            $table->string('portfolio_or_github')->nullable();
            $table->decimal('course_fee', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('payable_amount', 10, 2)->default(0);
            $table->string('payment_method')->default('free');
            $table->string('transaction_id')->nullable();
            $table->string('sender_phone_number')->nullable();
            $table->string('payment_status')->default('waived_for_free');
            $table->string('status')->default('pending');
            $table->date('interview_date')->nullable();
            $table->time('interview_time')->nullable();
            $table->string('interview_venue')->nullable();
            $table->text('interview_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_applications');
    }
};
