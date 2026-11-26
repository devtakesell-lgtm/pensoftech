<?php

namespace App\Services;

use App\Enums\CourseApplicationStatus;
use App\Enums\EnrollmentStatus;
use App\Models\CourseApplication;
use App\Models\CourseEnrollment;
use App\Models\Learner;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CourseEnrollmentService
{
    /**
     * Convert a CourseApplication into a User (learner role), Learner profile, and CourseEnrollment.
     */
    public function enroll(CourseApplication $application): CourseEnrollment
    {
        return DB::transaction(function () use ($application): CourseEnrollment {
            $course = $application->course;

            // 1. Find or create User account and assign 'learner' role
            $user = User::firstOrCreate(
                ['email' => $application->email],
                [
                    'name' => $application->student_name,
                    'password' => Hash::make(Str::random(16)),
                    'is_active' => true,
                ]
            );

            if (! $user->hasRole('learner')) {
                $user->assignRole('learner');
            }

            // 2. Find or create Learner profile
            $learner = Learner::where('user_id', $user->id)
                ->orWhere('email', $application->email)
                ->first();

            if (! $learner) {
                $learner = Learner::create([
                    'user_id' => $user->id,
                    'learner_code' => $this->generateLearnerCode(),
                    'name' => $application->student_name,
                    'email' => $application->email,
                    'phone' => $application->phone,
                    'alt_phone' => $application->alt_phone,
                    'gender' => $application->gender,
                    'present_address' => $application->present_address,
                    'educational_qualification' => $application->educational_qualification,
                    'current_profession' => $application->current_profession,
                    'portfolio_or_github' => $application->portfolio_or_github,
                    'is_active' => true,
                ]);
            } elseif (! $learner->user_id) {
                $learner->update(['user_id' => $user->id]);
            }

            // 3. Create or update CourseEnrollment
            $enrollment = CourseEnrollment::firstOrCreate(
                [
                    'learner_id' => $learner->id,
                    'course_id' => $application->course_id,
                ],
                [
                    'course_application_id' => $application->id,
                    'batch_no' => $course?->batch_no,
                    'enrolled_at' => now(),
                    'progress_percent' => 0,
                    'status' => EnrollmentStatus::Active,
                ]
            );

            // 4. Sync application linkage and status
            $application->update([
                'user_id' => $user->id,
                'learner_id' => $learner->id,
                'status' => CourseApplicationStatus::Enrolled,
            ]);

            return $enrollment;
        });
    }

    private function generateLearnerCode(): string
    {
        $year = date('Y');
        $lastId = (Learner::withTrashed()->max('id') ?? 0) + 1;

        return sprintf('PST-LRN-%s-%04d', $year, $lastId);
    }
}
