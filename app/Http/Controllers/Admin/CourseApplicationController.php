<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CourseApplicationStatus;
use App\Enums\CoursePaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCourseApplicationRequest;
use App\Models\Course;
use App\Models\CourseApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CourseApplicationController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('view-course-applications');

        $filters = $request->only(['search', 'course_id', 'status', 'payment_status']);

        $query = CourseApplication::with(['course', 'currency', 'coupon'])->latest();

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('application_no', 'like', "%{$search}%")
                    ->orWhere('student_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['course_id'])) {
            $query->where('course_id', $filters['course_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        $applications = $query->paginate(10)->withQueryString();

        $statusCounts = CourseApplication::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.pages.course-applications.index')->with([
            'applications' => $applications,
            'courses' => Course::select('id', 'title', 'batch_no')->orderBy('title')->get(),
            'statuses' => CourseApplicationStatus::cases(),
            'paymentStatuses' => CoursePaymentStatus::cases(),
            'statusCounts' => $statusCounts,
            'totalApplications' => CourseApplication::count(),
            'currentSearch' => $filters['search'] ?? '',
            'currentCourse' => $filters['course_id'] ?? '',
            'currentStatus' => $filters['status'] ?? '',
            'currentPaymentStatus' => $filters['payment_status'] ?? '',
        ]);
    }

    public function show(CourseApplication $courseApplication): View
    {
        Gate::authorize('view-course-applications');

        $courseApplication->load(['course.category', 'coupon', 'currency']);

        return view('admin.pages.course-applications.show')->with([
            'application' => $courseApplication,
            'statuses' => CourseApplicationStatus::cases(),
            'paymentStatuses' => CoursePaymentStatus::cases(),
        ]);
    }

    public function update(UpdateCourseApplicationRequest $request, CourseApplication $courseApplication): RedirectResponse
    {
        $courseApplication->update($request->validated());

        return redirect()->route('admin.course-applications.show', $courseApplication)
            ->with('success', "Application {$courseApplication->application_no} updated successfully.");
    }

    public function destroy(CourseApplication $courseApplication): RedirectResponse
    {
        Gate::authorize('delete-course-applications');

        $appNo = $courseApplication->application_no;
        $courseApplication->delete();

        return redirect()->route('admin.course-applications.index')
            ->with('success', "Application {$appNo} deleted successfully.");
    }
}
