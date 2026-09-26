<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreReviewRequest;
use App\Http\Requests\Admin\UpdateReviewRequest;
use App\Models\Review;
use App\Traits\HandlesImageUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ReviewController extends Controller
{
    use HandlesImageUploads;

    /**
     * Display a listing of reviews and testimonials.
     */
    public function index(Request $request): View
    {
        Gate::authorize('view-reviews');

        $query = Review::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $reviews = $query->orderBy('sort_order', 'asc')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.reviews.index')->with([
            'reviews' => $reviews,
            'currentSearch' => $request->input('search'),
            'currentStatus' => $request->input('status'),
            'totalCount' => Review::count(),
            'activeCount' => Review::where('is_active', true)->count(),
            'averageRating' => round(Review::avg('rating') ?? 5, 1),
        ]);
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(): View
    {
        Gate::authorize('create-reviews');

        return view('admin.pages.reviews.create');
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(StoreReviewRequest $request): RedirectResponse
    {
        Gate::authorize('create-reviews');

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->handleImageUpload($request->file('avatar'), 'reviews', 400);
        }

        Review::create($data);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review created successfully.');
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review): View
    {
        Gate::authorize('edit-reviews');

        return view('admin.pages.reviews.edit')->with([
            'review' => $review,
        ]);
    }

    /**
     * Update the specified review in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review): RedirectResponse
    {
        Gate::authorize('edit-reviews');

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->handleImageUpload($request->file('avatar'), 'reviews', 400, $review->avatar);
        }

        $review->update($data);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review): RedirectResponse
    {
        Gate::authorize('delete-reviews');

        if ($review->avatar) {
            $this->deleteImage($review->avatar);
        }

        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
