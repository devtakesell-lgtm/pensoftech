<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\CourseApplicationStatus;
use App\Enums\CourseDeliveryMode;
use App\Enums\CoursePaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreCourseApplicationRequest;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\CourseApplication;
use App\Models\CourseCategory;
use App\Models\Currency;
use App\Services\CourseEnrollmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category', 'mode', 'pricing']);

        $query = Course::published()
            ->with(['category', 'instructor', 'currency'])
            ->withCount('modules');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('subtitle', 'like', "%{$search}%")
                    ->orWhere('batch_no', 'like', "%{$search}%")
                    ->orWhere('venue', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['category'])) {
            $categorySlug = $filters['category'];
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if (! empty($filters['mode'])) {
            $query->where('delivery_mode', $filters['mode']);
        }

        if (! empty($filters['pricing'])) {
            if ($filters['pricing'] === 'free') {
                $query->where('is_free', true);
            } elseif ($filters['pricing'] === 'paid') {
                $query->where('is_free', false);
            }
        }

        $courses = $query->orderByDesc('is_featured')
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $categories = CourseCategory::active()
            ->select('id', 'name', 'slug')
            ->withCount(['courses' => fn ($q) => $q->published()])
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $defaultCurrency = rescue(fn () => Currency::default(), null, report: false);

        return view('frontend.pages.courses.index')->with([
            'courses' => $courses,
            'categories' => $categories,
            'deliveryModes' => CourseDeliveryMode::cases(),
            'defaultCurrency' => $defaultCurrency,
            'totalCourses' => Course::published()->count(),
            'currentSearch' => $filters['search'] ?? '',
            'currentCategory' => $filters['category'] ?? '',
            'currentMode' => $filters['mode'] ?? '',
            'currentPricing' => $filters['pricing'] ?? '',
        ]);
    }

    public function show(string $slug): View
    {
        $course = Course::published()
            ->with(['category', 'instructor', 'currency', 'modules.lessons', 'seo'])
            ->where('slug', $slug)
            ->firstOrFail();

        $enrolledCount = $course->applications()
            ->whereIn('status', [CourseApplicationStatus::Selected, CourseApplicationStatus::Enrolled])
            ->count();

        $defaultCurrency = rescue(fn () => Currency::default(), null, report: false);

        $relatedCourses = Course::published()
            ->with(['category', 'instructor', 'currency'])
            ->where('id', '!=', $course->id)
            ->where('course_category_id', $course->course_category_id)
            ->take(3)
            ->get();

        return view('frontend.pages.courses.show')->with([
            'course' => $course,
            'enrolledCount' => $enrolledCount,
            'defaultCurrency' => $defaultCurrency,
            'relatedCourses' => $relatedCourses,
        ]);
    }

    public function apply(string $slug): View
    {
        $course = Course::published()
            ->with(['category', 'instructor', 'currency'])
            ->where('slug', $slug)
            ->firstOrFail();

        $defaultCurrency = rescue(fn () => Currency::default(), null, report: false);

        return view('frontend.pages.courses.apply')->with([
            'course' => $course,
            'defaultCurrency' => $defaultCurrency,
        ]);
    }

    public function validateCoupon(Request $request, string $slug): JsonResponse
    {
        $course = Course::published()->where('slug', $slug)->firstOrFail();

        if ($course->is_free) {
            return response()->json([
                'valid' => false,
                'message' => 'Coupons are not applicable for free courses.',
            ], 422);
        }

        $code = Str::upper(trim((string) $request->input('code', '')));
        if (empty($code)) {
            return response()->json([
                'valid' => false,
                'message' => 'Please enter a coupon code.',
            ], 422);
        }

        $coupon = Coupon::where('code', $code)->first();
        $coursePrice = $course->effectivePrice();

        if (! $coupon || ! $coupon->isValidFor($course, $coursePrice)) {
            return response()->json([
                'valid' => false,
                'message' => 'This coupon code is invalid, expired, or not applicable to this course.',
            ], 422);
        }

        $discount = $coupon->calculateDiscount($coursePrice);
        $payable = max(0, $coursePrice - $discount);

        return response()->json([
            'valid' => true,
            'code' => $coupon->code,
            'discount' => $discount,
            'payable' => $payable,
            'message' => 'Coupon applied successfully!',
        ]);
    }

    public function storeApplication(StoreCourseApplicationRequest $request, string $slug, CourseEnrollmentService $enrollmentService): RedirectResponse
    {
        $course = Course::published()->with('currency')->where('slug', $slug)->firstOrFail();
        $validated = $request->validated();

        // Prevent duplicate non-rejected application for the same course and email
        $existingApplication = CourseApplication::where('course_id', $course->id)
            ->where('email', $validated['email'])
            ->where('status', '!=', CourseApplicationStatus::Rejected)
            ->first();

        if ($existingApplication) {
            return back()
                ->withInput()
                ->with('error', "An application ({$existingApplication->application_no}) with this email already exists for this course.");
        }

        $application = DB::transaction(function () use ($course, $validated, $enrollmentService): CourseApplication {
            $courseFee = $course->effectivePrice();
            $discountAmount = 0.0;
            $couponId = null;

            if (! $course->is_free && ! empty($validated['coupon_code'])) {
                $code = Str::upper(trim($validated['coupon_code']));
                $coupon = Coupon::where('code', $code)->lockForUpdate()->first();

                if ($coupon && $coupon->isValidFor($course, $courseFee)) {
                    $discountAmount = $coupon->calculateDiscount($courseFee);
                    $couponId = $coupon->id;
                    $coupon->increment('used_count');
                }
            }

            $payableAmount = max(0, $courseFee - $discountAmount);
            $defaultCurrency = rescue(fn () => Currency::default(), null, report: false);

            $year = date('Y');
            $nextNumber = (CourseApplication::withTrashed()->max('id') ?? 0) + 1;
            $applicationNo = sprintf('PST-APP-%s-%04d', $year, $nextNumber);

            $isFreeCourse = $course->is_free;

            $application = CourseApplication::create([
                'course_id' => $course->id,
                'coupon_id' => $couponId,
                'currency_id' => $course->currency_id ?? $defaultCurrency?->id,
                'application_no' => $applicationNo,
                'student_name' => $validated['student_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'alt_phone' => $validated['alt_phone'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'present_address' => $validated['present_address'],
                'educational_qualification' => $validated['educational_qualification'],
                'current_profession' => $validated['current_profession'],
                'experience_level' => $validated['experience_level'],
                'why_this_course' => $validated['why_this_course'],
                'portfolio_or_github' => $validated['portfolio_or_github'] ?? null,
                'course_fee' => $courseFee,
                'discount_amount' => $discountAmount,
                'payable_amount' => $payableAmount,
                'payment_method' => $isFreeCourse ? 'free' : ($payableAmount > 0 ? ($validated['payment_method'] ?? 'manual') : 'free'),
                'transaction_id' => $isFreeCourse ? null : ($validated['transaction_id'] ?? null),
                'sender_phone_number' => $isFreeCourse ? null : ($validated['sender_phone_number'] ?? null),
                'payment_status' => ($isFreeCourse || $payableAmount <= 0) ? CoursePaymentStatus::WaivedForFree : CoursePaymentStatus::Pending,
                'status' => $isFreeCourse ? CourseApplicationStatus::Pending : CourseApplicationStatus::Enrolled,
            ]);

            // Paid courses automatically enroll as Learner in the same DB transaction
            if (! $isFreeCourse) {
                $enrollmentService->enroll($application);
            }

            return $application;
        });

        return redirect()->route('courses.apply.success', $application->application_no);
    }

    public function applicationSuccess(string $applicationNo): View
    {
        $application = CourseApplication::with(['course', 'currency', 'learner', 'enrollment'])
            ->where('application_no', $applicationNo)
            ->firstOrFail();

        $defaultCurrency = rescue(fn () => Currency::default(), null, report: false);

        return view('frontend.pages.courses.application-success')->with([
            'application' => $application,
            'defaultCurrency' => $defaultCurrency,
        ]);
    }
}
