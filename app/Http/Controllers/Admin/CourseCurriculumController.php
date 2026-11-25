<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LessonType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCourseLessonRequest;
use App\Http\Requests\Admin\StoreCourseModuleRequest;
use App\Http\Requests\Admin\UpdateCourseLessonRequest;
use App\Http\Requests\Admin\UpdateCourseModuleRequest;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseModule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CourseCurriculumController extends Controller
{
    public function index(Course $course): View
    {
        Gate::authorize('edit-courses');

        $course->load(['modules.lessons']);

        return view('admin.pages.courses.curriculum')->with([
            'course' => $course,
            'lessonTypes' => LessonType::cases(),
        ]);
    }

    public function storeModule(StoreCourseModuleRequest $request, Course $course): RedirectResponse
    {
        $data = $request->validated();

        if (empty($data['order'])) {
            $data['order'] = ($course->modules()->max('order') ?? 0) + 1;
        }

        $course->modules()->create($data);

        return redirect()->route('admin.courses.curriculum', $course)
            ->with('success', 'Module added to curriculum successfully.');
    }

    public function updateModule(UpdateCourseModuleRequest $request, Course $course, CourseModule $module): RedirectResponse
    {
        abort_if($module->course_id !== $course->id, 404);

        $module->update($request->validated());

        return redirect()->route('admin.courses.curriculum', $course)
            ->with('success', 'Module updated successfully.');
    }

    public function destroyModule(Course $course, CourseModule $module): RedirectResponse
    {
        Gate::authorize('edit-courses');
        abort_if($module->course_id !== $course->id, 404);

        foreach ($module->lessons as $lesson) {
            if ($lesson->attachment_file && Storage::disk('public')->exists($lesson->attachment_file)) {
                Storage::disk('public')->delete($lesson->attachment_file);
            }
        }

        $module->delete();

        return redirect()->route('admin.courses.curriculum', $course)
            ->with('success', 'Module and its lessons deleted successfully.');
    }

    public function storeLesson(StoreCourseLessonRequest $request, Course $course, CourseModule $module): RedirectResponse
    {
        abort_if($module->course_id !== $course->id, 404);

        $data = $request->validated();

        if (empty($data['order'])) {
            $data['order'] = ($module->lessons()->max('order') ?? 0) + 1;
        }

        if ($request->hasFile('attachment_file')) {
            $data['attachment_file'] = $request->file('attachment_file')->store('course-materials', 'public');
        }

        $module->lessons()->create($data);

        return redirect()->route('admin.courses.curriculum', $course)
            ->with('success', 'Lesson added successfully.');
    }

    public function updateLesson(UpdateCourseLessonRequest $request, Course $course, CourseLesson $lesson): RedirectResponse
    {
        abort_if($lesson->module->course_id !== $course->id, 404);

        $data = $request->validated();

        if ($request->hasFile('attachment_file')) {
            if ($lesson->attachment_file && Storage::disk('public')->exists($lesson->attachment_file)) {
                Storage::disk('public')->delete($lesson->attachment_file);
            }

            $data['attachment_file'] = $request->file('attachment_file')->store('course-materials', 'public');
        }

        $lesson->update($data);

        return redirect()->route('admin.courses.curriculum', $course)
            ->with('success', 'Lesson updated successfully.');
    }

    public function destroyLesson(Course $course, CourseLesson $lesson): RedirectResponse
    {
        Gate::authorize('edit-courses');
        abort_if($lesson->module->course_id !== $course->id, 404);

        if ($lesson->attachment_file && Storage::disk('public')->exists($lesson->attachment_file)) {
            Storage::disk('public')->delete($lesson->attachment_file);
        }

        $lesson->delete();

        return redirect()->route('admin.courses.curriculum', $course)
            ->with('success', 'Lesson deleted successfully.');
    }
}
