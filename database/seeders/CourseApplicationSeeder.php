<?php

namespace Database\Seeders;

use App\Enums\CourseApplicationStatus;
use App\Enums\CoursePaymentStatus;
use App\Models\Course;
use App\Models\CourseApplication;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CourseApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::first();
        $bdt = Currency::where('code', 'BDT')->first();

        if (! $course) {
            return;
        }

        $applications = [
            [
                'application_no' => 'PST-APP-2026-0001',
                'student_name' => 'Rakibul Hasan',
                'email' => 'rakibul.hasan@example.com',
                'phone' => '01711223344',
                'alt_phone' => '01811223344',
                'gender' => 'Male',
                'present_address' => 'Mirpur 10, Dhaka',
                'educational_qualification' => 'B.Sc in CSE (Final Year)',
                'current_profession' => 'Student @ Daffodil International University',
                'experience_level' => 'Beginner',
                'why_this_course' => 'আমি ভার্সিটির পাশাপাশি রিয়েল-ওয়ার্ল্ড Laravel প্রজেক্ট শিখতে চাই এবং অফিসে সিনিয়র ডেভেলপারদের সাথে হাতে-কলমে কাজ করার অভিজ্ঞতা নিতে চাই।',
                'portfolio_or_github' => 'https://github.com/rakibul-dev',
                'status' => CourseApplicationStatus::Pending,
                'payment_status' => CoursePaymentStatus::WaivedForFree,
            ],
            [
                'application_no' => 'PST-APP-2026-0002',
                'student_name' => 'Nusrat Jahan',
                'email' => 'nusrat.jahan@example.com',
                'phone' => '01912345678',
                'alt_phone' => null,
                'gender' => 'Female',
                'present_address' => 'Uttara Sector 7, Dhaka',
                'educational_qualification' => 'Diploma in Computer Science',
                'current_profession' => 'Fresh Graduate',
                'experience_level' => 'Beginner',
                'why_this_course' => 'HTML, CSS ও বেসিক PHP শিখেছি। এখন Laravel দিয়ে প্রফেশনাল ক্যারিয়ার শুরু করার জন্য এই বুটক্যাম্পে জয়েন করতে চাই।',
                'portfolio_or_github' => 'https://github.com/nusrat-code',
                'status' => CourseApplicationStatus::Shortlisted,
                'payment_status' => CoursePaymentStatus::WaivedForFree,
                'admin_notes' => 'Good GitHub profile with basic HTML/CSS projects.',
            ],
            [
                'application_no' => 'PST-APP-2026-0003',
                'student_name' => 'Mehedi Hasan Shuvo',
                'email' => 'mehedi.shuvo@example.com',
                'phone' => '01688776655',
                'alt_phone' => null,
                'gender' => 'Male',
                'present_address' => 'Banani, Dhaka',
                'educational_qualification' => 'B.Sc in Software Engineering',
                'current_profession' => 'Junior Frontend Intern',
                'experience_level' => 'Intermediate',
                'why_this_course' => 'ফ্রন্টএন্ড নিয়ে কিছু কাজ করেছি, এখন ব্যাকএন্ড ও ফুল-স্ট্যাক আর্কিটেকচার শিখে নিজের স্কিল আপগ্রেড করতে চাই।',
                'portfolio_or_github' => 'https://github.com/mehedi-shuvo',
                'status' => CourseApplicationStatus::InterviewScheduled,
                'payment_status' => CoursePaymentStatus::WaivedForFree,
                'interview_date' => now()->addDays(3)->format('Y-m-d'),
                'interview_time' => '15:30',
                'interview_venue' => 'PenSoftTech Office, Meeting Room 2, Banani',
                'admin_notes' => 'Called and confirmed interview slot.',
            ],
            [
                'application_no' => 'PST-APP-2026-0004',
                'student_name' => 'Tanvir Mahmud',
                'email' => 'tanvir.mahmud@example.com',
                'phone' => '01555667788',
                'alt_phone' => null,
                'gender' => 'Male',
                'present_address' => 'Dhanmondi 27, Dhaka',
                'educational_qualification' => 'B.Sc in CSE',
                'current_profession' => 'Freelance Web Designer',
                'experience_level' => 'Intermediate',
                'why_this_course' => 'আমি ওয়েব ডিজাইন করি, এখন Laravel শিখে ফুল-স্ট্যাক সলিউশন দিতে চাই। নিয়মিত অফিসে এসে ক্লাস করতে পারব।',
                'portfolio_or_github' => 'https://github.com/tanvir-mahmud',
                'status' => CourseApplicationStatus::Selected,
                'payment_status' => CoursePaymentStatus::WaivedForFree,
                'interview_date' => now()->subDays(2)->format('Y-m-d'),
                'interview_time' => '16:00',
                'interview_venue' => 'PenSoftTech Office, Banani',
                'interview_notes' => 'Strong problem solving and OOP basics. Very dedicated. Recommended for Batch 01.',
            ],
            [
                'application_no' => 'PST-APP-2026-0005',
                'student_name' => 'Sadia Afrin',
                'email' => 'sadia.afrin@example.com',
                'phone' => '01844556677',
                'alt_phone' => '01744556677',
                'gender' => 'Female',
                'present_address' => 'Mohakhali DOHS, Dhaka',
                'educational_qualification' => 'B.Sc in CS',
                'current_profession' => 'Fresh Graduate',
                'experience_level' => 'Beginner',
                'why_this_course' => 'ইন্ডাস্ট্রি স্ট্যান্ডার্ড কোডিং ও টিমওয়ার্ক শেখার জন্য পেনসফটটেকের অফলাইন বুটক্যাম্পে ভর্তি হতে চাই।',
                'portfolio_or_github' => 'https://github.com/sadia-afrin',
                'status' => CourseApplicationStatus::Enrolled,
                'payment_status' => CoursePaymentStatus::WaivedForFree,
                'interview_date' => now()->subDays(4)->format('Y-m-d'),
                'interview_time' => '11:00',
                'interview_venue' => 'PenSoftTech Office, Banani',
                'interview_notes' => 'Excellent attitude and fundamentals. Seat confirmed.',
            ],
            [
                'application_no' => 'PST-APP-2026-0006',
                'student_name' => 'Kamrul Islam',
                'email' => 'kamrul.islam@example.com',
                'phone' => '01311998877',
                'alt_phone' => null,
                'gender' => 'Male',
                'present_address' => 'Gazipur',
                'educational_qualification' => 'HSC',
                'current_profession' => 'Other',
                'experience_level' => 'Beginner',
                'why_this_course' => 'কোর্সটি করতে চাই।',
                'portfolio_or_github' => null,
                'status' => CourseApplicationStatus::Rejected,
                'payment_status' => CoursePaymentStatus::WaivedForFree,
                'admin_notes' => 'Cannot attend in-person evening classes in Dhaka.',
            ],
        ];

        foreach ($applications as $app) {
            CourseApplication::firstOrCreate(
                ['application_no' => $app['application_no']],
                array_merge($app, [
                    'course_id' => $course->id,
                    'currency_id' => $bdt?->id,
                    'course_fee' => $course->is_free ? 0 : ($course->price ?? 0),
                    'discount_amount' => 0,
                    'payable_amount' => $course->is_free ? 0 : ($course->price ?? 0),
                    'payment_method' => $course->is_free ? 'free' : 'manual',
                ])
            );
        }
    }
}
