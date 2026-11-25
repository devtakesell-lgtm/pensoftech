<?php

namespace Database\Seeders;

use App\Enums\CourseDeliveryMode;
use App\Enums\CourseStatus;
use App\Enums\LessonType;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLesson;
use App\Models\CourseModule;
use App\Models\Currency;
use App\Models\Instructor;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $bdt = Currency::where('code', 'BDT')->first();
        $webCategory = CourseCategory::where('slug', 'web-development')->first();
        $instructor = Instructor::first();

        if (! $webCategory || ! $instructor) {
            return;
        }

        // 1. Free In-Person Batch Course (as requested by user)
        $freeCourse = Course::firstOrCreate(
            ['slug' => 'practical-laravel-fullstack-bootcamp-batch-1'],
            [
                'course_category_id' => $webCategory->id,
                'instructor_id' => $instructor->id,
                'currency_id' => $bdt?->id,
                'title' => 'Practical Laravel Full-Stack Bootcamp (Batch 01)',
                'subtitle' => 'ইন-পারসন অফিস ক্লাস — হাতে কলমে বাস্তব প্রজেক্ট ভিত্তিক ফুলস্ট্যাক ওয়েব ডেভেলপমেন্ট।',
                'description' => '<p>পেনসফটটেক একাডেমির এই বুটক্যাম্পটি মূলত যারা ফ্রেশ গ্র্যাজুয়েট বা ডিপ্লোমা কমপ্লিট করেছেন এবং রিয়েল ইন্ডাস্ট্রি সফটওয়্যার এজেন্সিতে সরাসরি বসে প্রজেক্টে কাজ করার দক্ষতা অর্জন করতে চান তাদের জন্য।</p><p>কোর্সে সম্পূর্ণ বিনামূল্যে আবেদন করা যাবে। আবেদনকারীদের মধ্য থেকে প্রাইমারি স্ক্রিনিং ও অফিস ইন্টারভিউয়ের মাধ্যমে সীমিত সংখ্যক শিক্ষার্থী বাছাই করা হবে।</p>',
                'delivery_mode' => CourseDeliveryMode::Offline,
                'venue' => 'PenSoftTech Office Training Lab, Floor 4, Banani, Dhaka',
                'batch_no' => 'Batch 01',
                'class_schedule' => 'শনি ও মঙ্গলবার — সন্ধ্যা ৭:০০টা থেকে রাত ৯:০০টা',
                'start_date' => now()->addDays(20),
                'end_date' => now()->addDays(80),
                'enrollment_deadline' => now()->addDays(15),
                'total_classes' => 24,
                'duration_weeks' => 10,
                'max_seats' => 15,
                'is_free' => true,
                'price' => 0.00,
                'discount_price' => null,
                'prerequisites' => [
                    'বেসিক HTML, CSS এবং JavaScript এর ধারণা',
                    'যেকোনো প্রোগ্রামিং ল্যাঙ্গুয়েজের বেসিক লুপ ও ফাংশন সম্পর্কে নলেজ',
                    'সপ্তাহে অন্তত ২টি ক্লাসে পেনসফটটেক অফিসে উপস্থিত থাকার মানসিকতা',
                ],
                'what_you_will_learn' => [
                    'PHP 8.3 OOP এবং আধুনিক ফিচারসমূহ',
                    'Laravel 11 আর্কিটেকচার, রুটস, কন্ট্রোলার ও Eloquent ORM',
                    'Tailwind CSS ও Bootstrap দিয়ে আধুনিক ইন্টারফেস ডিজাইন',
                    'Spatie Role-Permission দিয়ে এন্টারপ্রাইজ অথরাইজেশন',
                    'এজেন্সি লেভেল রিয়েল-ওয়ার্ল্ড ক্লায়েন্ট প্রজেক্ট ডেভেলপমেন্ট',
                    'Git, GitHub টিম কোলাবোরেশন ও ডিপ্লয়মেন্ট গাইড',
                ],
                'status' => CourseStatus::Published,
                'is_featured' => true,
            ]
        );

        // Add sample modules and lessons for this course
        if ($freeCourse->modules()->count() === 0) {
            $m1 = CourseModule::create([
                'course_id' => $freeCourse->id,
                'title' => 'Module 01: Foundations & PHP 8.3 Core',
                'description' => 'PHP 8.3 Features, Object-Oriented Programming, and Composer Setup.',
                'order' => 1,
            ]);

            CourseLesson::create([
                'course_module_id' => $m1->id,
                'title' => 'Class 01: Orientation & Modern Web Architecture',
                'lesson_type' => LessonType::OfflineClass,
                'duration_minutes' => 120,
                'order' => 1,
            ]);

            CourseLesson::create([
                'course_module_id' => $m1->id,
                'title' => 'Class 02: Deep Dive into OOP & Design Patterns',
                'lesson_type' => LessonType::OfflineClass,
                'duration_minutes' => 120,
                'order' => 2,
            ]);

            $m2 = CourseModule::create([
                'course_id' => $freeCourse->id,
                'title' => 'Module 02: Laravel 11 Deep Dive & Database Architecture',
                'description' => 'Migrations, Seeders, Eloquent Relationships, and Form Requests.',
                'order' => 2,
            ]);

            CourseLesson::create([
                'course_module_id' => $m2->id,
                'title' => 'Class 03: Laravel Request Lifecycle & Controllers',
                'lesson_type' => LessonType::OfflineClass,
                'duration_minutes' => 120,
                'order' => 1,
            ]);
        }
    }
}
