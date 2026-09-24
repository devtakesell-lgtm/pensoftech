@extends('frontend.layouts.front-master')

@section('title', $blog->seo?->meta_title ?? $blog->title)
@section('meta_description', $blog->seo?->meta_description ?? $blog->excerpt)
@if ($blog->seo?->meta_keywords)
    @section('meta_keywords', $blog->seo->meta_keywords)
@endif

@section('content')
    <main class="bg-white pb-24 min-h-screen" style="padding-top: 180px;">

        {{-- Blog Header --}}
        <div class="max-w-4xl mx-auto px-5 lg:px-12 mb-12 text-center">
            <div class="flex items-center justify-center gap-3 mb-6">
                <span
                    class="inline-block px-3 py-1 bg-[#4fd1c5]/10 text-[#2c988e] text-sm font-bold rounded-full uppercase tracking-wider">
                    {{ $blog->category->name ?? 'Uncategorized' }}
                </span>
                <span class="text-sm font-medium text-gray-400">
                    {{ $blog->published_at?->format('F d, Y') ?? 'Recently' }}
                </span>
            </div>

            <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight leading-tight mb-6">
                {{ $blog->title }}
            </h1>

            @if ($blog->excerpt)
                <p class="text-xl md:text-2xl text-gray-600 font-medium leading-relaxed max-w-3xl mx-auto mb-8">
                    {{ $blog->excerpt }}
                </p>
            @endif

            <div class="flex items-center justify-center gap-4">
                <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden shrink-0">
                    @if ($blog->author?->avatar)
                        <img src="{{ Storage::url($blog->author->avatar) }}" alt="{{ $blog->author->name }}"
                            class="w-full h-full object-cover">
                    @else
                        <div
                            class="w-full h-full bg-[#4fd1c5] text-white flex items-center justify-center text-lg font-bold">
                            {{ substr($blog->author?->name ?? 'A', 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-base font-bold text-gray-900">{{ $blog->author->name ?? 'Admin' }}</span>
                    <span class="text-sm text-gray-500">{{ $blog->reading_time ?? 50 }} min read &bull; {{ $blog->views }}
                        views</span>
                </div>
            </div>
        </div>

        {{-- Featured Image --}}
        <div class="max-w-5xl mx-auto px-5 lg:px-12 mb-16">
            <div class="w-full aspect-video rounded-3xl overflow-hidden shadow-2xl relative">
                @if ($blog->featured_image)
                    @if(filter_var($blog->featured_image, FILTER_VALIDATE_URL))
                        <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}"
                            class="w-full h-full object-cover">
                    @else
                        <img src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}"
                            class="w-full h-full object-cover">
                    @endif
                @else
                    <img src="https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&q=80&w=1200"
                        alt="{{ $blog->title }}" class="w-full h-full object-cover">
                @endif
            </div>
        </div>

        {{-- Blog Content (TinyMCE HTML) --}}
        <div class="max-w-3xl mx-auto px-5 lg:px-12 service-content">
            {!! $blog->content !!}
        </div>

        {{-- Tags --}}
        @if($blog->tags->count() > 0)
        <div class="max-w-3xl mx-auto px-5 lg:px-12 mt-12 flex flex-wrap gap-2">
            @foreach($blog->tags as $tag)
                <span class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition">#{{ $tag->name }}</span>
            @endforeach
        </div>
        @endif

        {{-- Author Bio Card --}}
        <div class="max-w-3xl mx-auto px-5 lg:px-12 mt-16">
            <div class="bg-gray-50 rounded-3xl p-8 flex flex-col md:flex-row items-center md:items-start gap-6 border border-gray-100">
                <div class="w-24 h-24 rounded-full bg-gray-200 overflow-hidden shrink-0 shadow-inner">
                    @if ($blog->author?->avatar)
                        <img src="{{ Storage::url($blog->author->avatar) }}" alt="{{ $blog->author->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-[#4fd1c5] to-[#2c988e] text-white flex items-center justify-center text-3xl font-extrabold">
                            {{ substr($blog->author?->name ?? 'A', 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="text-center md:text-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $blog->author->name ?? 'Admin' }}</h3>
                    <p class="text-gray-500 mb-4 leading-relaxed">
                        {{ $blog->author->bio ?? 'Content creator and digital enthusiast sharing insights on technology, strategy, and design.' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Comments Section --}}
        <div class="max-w-3xl mx-auto px-5 lg:px-12 mt-20" x-data="{ replyTo: null }">
            <h3 class="text-3xl font-extrabold text-gray-900 mb-10 border-b pb-4">
                Comments ({{ $blog->comments->count() + $blog->comments->flatMap->replies->count() }})
            </h3>
            
            @if(session('success'))
                <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-8 border border-green-100 font-medium">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-8 border border-red-100 font-medium">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Comment Form --}}
            <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 mb-12">
                <h4 class="text-xl font-bold text-gray-900 mb-2">Leave a comment</h4>
                
                @guest
                    <p class="text-sm text-gray-500 mb-6">
                        Commenting as a guest. <a href="{{ route('login') }}" class="text-[#4fd1c5] font-bold hover:underline">Login here</a> to auto-approve your comment.
                    </p>
                @else
                    <p class="text-sm text-gray-500 mb-6">
                        Commenting as <span class="font-bold text-gray-900">{{ auth()->user()->name }}</span>.
                    </p>
                @endguest

                <form action="{{ route('blogs.comments.store', $blog->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @guest
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Name *</label>
                                <input type="text" name="name" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#4fd1c5]/50 focus:border-[#4fd1c5] transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                                <input type="email" name="email" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#4fd1c5]/50 focus:border-[#4fd1c5] transition-all">
                            </div>
                        </div>
                    @endguest
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                        <textarea name="content" required rows="4" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#4fd1c5]/50 focus:border-[#4fd1c5] transition-all resize-none"></textarea>
                    </div>
                    <button type="submit" class="bg-gray-900 hover:bg-[#4fd1c5] text-white font-bold py-3 px-8 rounded-xl transition-colors duration-300 w-full md:w-auto inline-flex items-center justify-center gap-2">
                        Post Comment
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>

            {{-- Comments List --}}
            <div class="space-y-10">
                @forelse($blog->comments as $comment)
                    <div class="flex flex-col gap-4">
                        {{-- Main Comment --}}
                        <div class="flex gap-4 group">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center text-gray-600 font-bold text-lg shrink-0 overflow-hidden">
                                {{ substr($comment->name, 0, 1) }}
                            </div>
                            <div class="flex-grow">
                                <div class="bg-gray-50 p-5 rounded-2xl rounded-tl-none border border-gray-100">
                                    <div class="flex items-center justify-between mb-2">
                                        <h5 class="font-bold text-gray-900">{{ $comment->name }}</h5>
                                        <span class="text-xs font-medium text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-600 leading-relaxed">{{ $comment->content }}</p>
                                </div>
                                <button @click="replyTo = replyTo === {{ $comment->id }} ? null : {{ $comment->id }}" class="text-sm font-bold text-gray-400 hover:text-[#4fd1c5] mt-2 ml-2 transition-colors inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                    Reply
                                </button>
                            </div>
                        </div>

                        {{-- Reply Form (Hidden by default) --}}
                        <div x-show="replyTo === {{ $comment->id }}" x-collapse class="ml-16 mt-2 mb-4">
                            <form action="{{ route('blogs.comments.store', $blog->id) }}" method="POST" class="bg-white p-5 rounded-2xl shadow-lg border border-gray-100 relative">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <button type="button" @click="replyTo = null" class="absolute top-4 right-4 text-gray-400 hover:text-red-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                                <h5 class="text-sm font-bold text-gray-900 mb-2">Reply to {{ $comment->name }}</h5>
                                @guest
                                    <p class="text-xs text-gray-500 mb-4">
                                        Commenting as a guest. <a href="{{ route('login') }}" class="text-[#4fd1c5] font-bold hover:underline">Login</a>
                                    </p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <input type="text" name="name" required placeholder="Your Name" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:ring-[#4fd1c5]">
                                        <input type="email" name="email" required placeholder="Your Email" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:ring-[#4fd1c5]">
                                    </div>
                                @endguest
                                <textarea name="content" required rows="3" placeholder="Write your reply..." class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-sm focus:ring-[#4fd1c5] resize-none mb-3"></textarea>
                                <button type="submit" class="bg-[#4fd1c5] hover:bg-[#2c988e] text-white font-bold py-2 px-6 rounded-lg text-sm transition-colors">Submit Reply</button>
                            </form>
                        </div>

                        {{-- Replies --}}
                        @if($comment->replies->count() > 0)
                            <div class="ml-16 space-y-4 mt-2">
                                @foreach($comment->replies as $reply)
                                    <div class="flex gap-4">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#4fd1c5]/20 to-[#4fd1c5]/30 flex items-center justify-center text-[#2c988e] font-bold text-sm shrink-0">
                                            {{ substr($reply->name, 0, 1) }}
                                        </div>
                                        <div class="flex-grow">
                                            <div class="bg-gray-50 p-4 rounded-2xl rounded-tl-none border border-gray-100">
                                                <div class="flex items-center justify-between mb-1">
                                                    <h5 class="font-bold text-gray-900 text-sm">{{ $reply->name }}</h5>
                                                    <span class="text-[10px] font-medium text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-gray-600 text-sm leading-relaxed">{{ $reply->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-10 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <p class="text-gray-500 font-medium">No comments yet. Be the first to share your thoughts!</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Related Articles --}}
        @if ($relatedBlogs->count() > 0)
            <div class="max-w-7xl mx-auto px-5 lg:px-12 mt-24 pt-16 border-t border-gray-100">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="text-3xl font-extrabold text-gray-900">Read More</h2>
                    <a href="{{ route('blogs.index') }}"
                        class="text-[#4fd1c5] font-bold hover:text-[#2c988e] transition-colors">View All &rarr;</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($relatedBlogs as $related)
                        <a href="{{ route('blogs.single', $related->slug) }}"
                            class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col h-full">

                            {{-- Image --}}
                            <div class="relative w-full aspect-[16/10] overflow-hidden">
                                @if ($related->featured_image)
                                    @if(filter_var($related->featured_image, FILTER_VALIDATE_URL))
                                        <img src="{{ $related->featured_image }}" alt="{{ $related->title }}"
                                            class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                                    @else
                                        <img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->title }}"
                                            class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                                    @endif
                                @else
                                    <img src="https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&q=80&w=800"
                                        alt="{{ $related->title }}"
                                        class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-2">
                                    <span>{{ $related->category->name ?? 'Blog' }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $related->reading_time ?? 50 }} min read</span>
                                </div>

                                <h3
                                    class="text-lg font-bold text-gray-900 mb-2 group-hover:text-[#4fd1c5] transition-colors duration-300 leading-snug">
                                    {{ $related->title }}
                                </h3>
                            </div>

                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </main>
@endsection
