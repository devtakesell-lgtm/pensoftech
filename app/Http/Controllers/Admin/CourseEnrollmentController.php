<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EnrollmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CourseEnrollmentController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('view-course-enrollments');

        $filters = $request->only(['search', 'course_id', 'status']);

        $query = CourseEnrollment::with(['learner', 'course', 'application'])->latest('enrolled_at');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereHas('learner', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('learner_code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['course_id'])) {
            $query->where('course_id', $filters['course_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return view('admin.pages.course-enrollments.index')->with([
            'enrollments' => $query->paginate(10)->withQueryString(),
            'courses' => Course::select('id', 'title', 'batch_no')->orderBy('title')->get(),
            'statuses' => EnrollmentStatus::cases(),
            'currentSearch' => $filters['search'] ?? '',
            'currentCourse' => $filters['course_id'] ?? '',
            'currentStatus' => $filters['status'] ?? '',
        ]);
    }

    public function updateStatus(Request $request, CourseEnrollment $courseEnrollment): RedirectResponse
    {
        Gate::authorize('edit-course-enrollments');

        $validated = $request->validate([
            'status' => ['required', 'string', Rule::enum(EnrollmentStatus::class)],
        ]);

        $data = ['status' => $validated['status']];

        if ($validated['status'] === EnrollmentStatus::Completed->value && ! $courseEnrollment->completed_at) {
            $data['completed_at'] = now();
            $data['progress_percent'] = 100;
        }

        $courseEnrollment->update($data);

        return back()->with('success', 'Enrollment status updated successfully.');
    }
}
