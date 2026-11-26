<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\CourseApplicationStatus;
use App\Enums\CourseDeliveryMode;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Currency;
use Illuminate\Http\Request;
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
}
