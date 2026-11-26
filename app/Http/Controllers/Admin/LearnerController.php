<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Learner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class LearnerController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('view-learners');

        $filters = $request->only(['search', 'is_active']);

        $query = Learner::with('user')
            ->withCount('enrollments')
            ->latest();

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('learner_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $filters['is_active'] === '1');
        }

        return view('admin.pages.learners.index')->with([
            'learners' => $query->paginate(10)->withQueryString(),
            'currentSearch' => $filters['search'] ?? '',
            'currentActive' => $filters['is_active'] ?? '',
        ]);
    }

    public function show(Learner $learner): View
    {
        Gate::authorize('view-learners');

        $learner->load(['user', 'enrollments.course', 'applications.course']);

        return view('admin.pages.learners.show')->with([
            'learner' => $learner,
        ]);
    }

    public function toggleStatus(Learner $learner): RedirectResponse
    {
        Gate::authorize('edit-learners');

        $learner->update(['is_active' => ! $learner->is_active]);

        return back()->with('success', "Learner '{$learner->name}' status updated successfully.");
    }
}
