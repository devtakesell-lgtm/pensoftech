<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts and articles.
     */
    public function index(): View
    {
        Gate::authorize('view-blogs');

        $blogs = Blog::with(['category', 'author'])->latest()->get();

        return view('admin.pages.blog')->with([
            'blogs' => $blogs,
        ]);
    }
}
