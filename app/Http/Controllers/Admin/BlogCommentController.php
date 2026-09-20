<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogComment;
use App\Enums\CommentStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class BlogCommentController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('view-blogs');

        $query = BlogComment::with(['blog', 'user', 'parent'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $comments = $query->paginate(10)->withQueryString();

        $totalCount = BlogComment::count();
        $approvedCount = BlogComment::where('status', CommentStatus::Approved)->count();
        $pendingCount = BlogComment::where('status', CommentStatus::Pending)->count();
        $spamCount = BlogComment::where('status', CommentStatus::Spam)->count();
        // dd($comments);

        return view('admin.pages.blog-comments.index')->with([
            'comments' => $comments,
            'totalCount' => $totalCount,
            'approvedCount' => $approvedCount,
            'pendingCount' => $pendingCount,
            'spamCount' => $spamCount,
        ]);
    }

    public function updateStatus(Request $request, BlogComment $comment)
    {
        Gate::authorize('edit-blogs');
        $request->validate([
            'status' => ['required', Rule::enum(CommentStatus::class)],
        ]);

        $comment->update(['status' => $request->status]);

        return back()->with('success', 'Comment status updated successfully.');
    }

    public function reply(Request $request, BlogComment $comment)
    {
        Gate::authorize('edit-blogs');
        $request->validate([
            'content' => 'required|string',
        ]);

        BlogComment::create([
            'blog_id' => $comment->blog_id,
            'user_id' => auth()->id(),
            'parent_id' => $comment->id,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'content' => $request->content,
            'status' => CommentStatus::Approved,
        ]);

        return back()->with('success', 'Reply posted successfully.');
    }

    public function destroy(BlogComment $comment)
    {
        Gate::authorize('delete-blogs');
        $comment->delete();
        return back()->with('success', 'Comment deleted successfully.');
    }
}
