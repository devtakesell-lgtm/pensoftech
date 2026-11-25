<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInstructorRequest;
use App\Http\Requests\Admin\UpdateInstructorRequest;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class InstructorController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('view-instructors');

        $query = Instructor::with('user')->withCount('courses');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        $instructors = $query->latest()->paginate(10)->withQueryString();

        return view('admin.pages.instructors.index')->with([
            'instructors' => $instructors,
            'currentSearch' => $request->input('search', ''),
        ]);
    }

    private function getFormData(): array
    {
        return [
            'users' => User::select('id', 'name', 'email')->orderBy('name')->get(),
        ];
    }

    public function create(): View
    {
        Gate::authorize('create-instructors');

        return view('admin.pages.instructors.create')->with($this->getFormData());
    }

    public function store(StoreInstructorRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        if (! empty($validated['skills']) && is_string($validated['skills'])) {
            $validated['skills'] = array_map('trim', explode(',', $validated['skills']));
        }

        $instructor = Instructor::create($validated);

        return redirect()->route('admin.instructors.index')
            ->with('success', "Instructor '{$instructor->name}' created successfully.");
    }

    public function edit(Instructor $instructor): View
    {
        Gate::authorize('edit-instructors');

        return view('admin.pages.instructors.edit')->with(
            array_merge($this->getFormData(), ['instructor' => $instructor])
        );
    }

    public function update(UpdateInstructorRequest $request, Instructor $instructor): RedirectResponse
    {
        $validated = $request->validated();
        if (! empty($validated['skills']) && is_string($validated['skills'])) {
            $validated['skills'] = array_map('trim', explode(',', $validated['skills']));
        }

        $instructor->update($validated);

        return redirect()->route('admin.instructors.index')
            ->with('success', "Instructor '{$instructor->name}' updated successfully.");
    }

    public function destroy(Instructor $instructor): RedirectResponse
    {
        Gate::authorize('delete-instructors');

        if ($instructor->courses()->count() > 0) {
            return redirect()->route('admin.instructors.index')
                ->with('error', "Cannot delete instructor '{$instructor->name}' because they are assigned to active courses.");
        }

        $instructor->delete();

        return redirect()->route('admin.instructors.index')
            ->with('success', "Instructor '{$instructor->name}' deleted successfully.");
    }
}
