<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CourseDeliveryMode;
use App\Enums\CourseStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCourseRequest;
use App\Http\Requests\Admin\UpdateCourseRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Currency;
use App\Models\Instructor;
use App\Traits\HandlesImageUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CourseController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        Gate::authorize('view-courses');

        $query = Course::with(['category', 'instructor', 'currency'])
            ->withCount(['modules', 'applications'])
            ->latest();

        $filters = $request->only(['search', 'status', 'category_id', 'delivery_mode']);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('batch_no', 'like', "%{$search}%")
                    ->orWhere('venue', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['category_id'])) {
            $query->where('course_category_id', $filters['category_id']);
        }

        if (! empty($filters['delivery_mode'])) {
            $query->where('delivery_mode', $filters['delivery_mode']);
        }

        $courses = $query->paginate(10)->withQueryString();

        return view('admin.pages.courses.index')->with([
            'courses' => $courses,
            'categories' => CourseCategory::select('id', 'name')->orderBy('name')->get(),
            'currentSearch' => $filters['search'] ?? '',
            'currentStatus' => $filters['status'] ?? '',
            'currentCategory' => $filters['category_id'] ?? '',
            'currentMode' => $filters['delivery_mode'] ?? '',
            'statuses' => CourseStatus::cases(),
            'deliveryModes' => CourseDeliveryMode::cases(),
        ]);
    }

    private function getFormData(): array
    {
        return [
            'categories' => CourseCategory::select('id', 'name')->orderBy('name')->get(),
            'instructors' => Instructor::select('id', 'name', 'designation')->where('is_active', true)->orderBy('name')->get(),
            'currencies' => Currency::select('id', 'name', 'code', 'symbol')->where('is_active', true)->get(),
            'deliveryModes' => CourseDeliveryMode::cases(),
            'statuses' => CourseStatus::cases(),
        ];
    }

    public function create(): View
    {
        Gate::authorize('create-courses');

        return view('admin.pages.courses.create')->with($this->getFormData());
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Process array inputs (prerequisites & what_you_will_learn)
        if (isset($validated['prerequisites']) && is_array($validated['prerequisites'])) {
            $validated['prerequisites'] = array_values(array_filter(array_map('trim', $validated['prerequisites'])));
        }

        if (isset($validated['what_you_will_learn']) && is_array($validated['what_you_will_learn'])) {
            $validated['what_you_will_learn'] = array_values(array_filter(array_map('trim', $validated['what_you_will_learn'])));
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->handleImageUpload($request->file('thumbnail'), 'courses', 1200);
        }

        $course = Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', "Course '{$course->title}' created successfully.");
    }

    public function edit(Course $course): View
    {
        Gate::authorize('edit-courses');

        return view('admin.pages.courses.edit')->with(
            array_merge($this->getFormData(), ['course' => $course])
        );
    }

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $validated = $request->validated();

        if (isset($validated['prerequisites']) && is_array($validated['prerequisites'])) {
            $validated['prerequisites'] = array_values(array_filter(array_map('trim', $validated['prerequisites'])));
        }

        if (isset($validated['what_you_will_learn']) && is_array($validated['what_you_will_learn'])) {
            $validated['what_you_will_learn'] = array_values(array_filter(array_map('trim', $validated['what_you_will_learn'])));
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $this->handleImageUpload($request->file('thumbnail'), 'courses', 1200, $course->thumbnail);
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', "Course '{$course->title}' updated successfully.");
    }

    public function destroy(Course $course): RedirectResponse
    {
        Gate::authorize('delete-courses');

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', "Course '{$course->title}' deleted successfully.");
    }
}
