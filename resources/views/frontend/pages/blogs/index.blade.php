@extends('frontend.layouts.master')

@section('title', 'Insights & Blog')
@section('meta_description', 'Read the latest insights and news from our team.')

@section('content')
<main class="bg-gray-50 pt-32 pb-24 min-h-screen">
    
    {{-- Hero Section --}}
    <div class="max-w-7xl mx-auto px-5 lg:px-12 mb-16 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight mb-6">
            Insights & <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4fd1c5] to-[#2c988e]">Blog</span>
        </h1>
        <p class="text-gray-500 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
            Discover our latest thoughts on strategy, technology, and design.
        </p>
    </div>

    {{-- Featured/Latest Blog (if exists) --}}
    @if($blogs->count() > 0)
        @php
            $featured = $blogs->first();
            $remainingBlogs = $blogs->skip(1);
        @endphp

        <div class="max-w-7xl mx-auto px-5 lg:px-12 mb-16">
            <a href="{{ route('blogs.single', $featured->slug) }}" class="group block relative bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500">
                <div class="flex flex-col md:flex-row h-full">
                    
                    {{-- Image Side --}}
                    <div class="w-full md:w-1/2 relative overflow-hidden aspect-video md:aspect-auto">
                        @if($featured->featured_image)
                            <img src="{{ Storage::url($featured->featured_image) }}" alt="{{ $featured->title }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                        @else
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800" alt="{{ $featured->title }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>

                    {{-- Content Side --}}
                    <div class="w-full md:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-block px-3 py-1 bg-[#4fd1c5]/10 text-[#2c988e] text-xs font-bold rounded-full uppercase tracking-wider">
                                {{ $featured->category->name ?? 'Featured' }}
                            </span>
                            <span class="text-xs font-medium text-gray-400">
                                {{ $featured->published_at?->format('M d, Y') ?? 'Recently' }}
                            </span>
                        </div>
                        
                        <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-900 mb-6 group-hover:text-[#4fd1c5] transition-colors leading-tight">
                            {{ $featured->title }}
                        </h2>
                        
                        <p class="text-gray-500 text-base md:text-lg leading-relaxed mb-8">
                            {{ Str::limit($featured->excerpt, 200) }}
                        </p>
                        
                        <div class="flex items-center gap-4 mt-auto border-t border-gray-100 pt-6">
                            <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden shrink-0">
                                @if($featured->author?->avatar)
                                    <img src="{{ Storage::url($featured->author->avatar) }}" alt="{{ $featured->author->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-[#4fd1c5] text-white flex items-center justify-center font-bold">
                                        {{ substr($featured->author?->name ?? 'A', 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-900">{{ $featured->author->name ?? 'Admin' }}</span>
                                <span class="text-xs text-gray-400">{{ $featured->reading_time ?? 5 }} min read</span>
                            </div>
                            <div class="ml-auto text-[#4fd1c5] font-bold group-hover:translate-x-1 transition-transform">
                                Read Article &rarr;
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endif

    {{-- Grid for Remaining Blogs --}}
    @if(isset($remainingBlogs) && $remainingBlogs->count() > 0)
        <div class="max-w-7xl mx-auto px-5 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @foreach($remainingBlogs as $blog)
                <a href="{{ route('blogs.single', $blog->slug) }}" class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col h-full">
                    
                    {{-- Image --}}
                    <div class="relative w-full aspect-[16/10] overflow-hidden">
                        @if($blog->featured_image)
                            <img src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                        @else
                            <img src="https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&q=80&w=800" alt="{{ $blog->title }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-[#4fd1c5] text-xs font-bold uppercase tracking-wider shadow-sm">
                                {{ $blog->category->name ?? 'Blog' }}
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-8 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-3">
                            <span>{{ $blog->published_at?->format('M d, Y') ?? 'Recently' }}</span>
                            <span>&bull;</span>
                            <span>{{ $blog->reading_time ?? 5 }} min read</span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-[#4fd1c5] transition-colors duration-300 leading-snug">
                            {{ $blog->title }}
                        </h3>
                        
                        <p class="text-gray-500 text-sm leading-relaxed mb-6 flex-grow">
                            {{ Str::limit($blog->excerpt, 120) }}
                        </p>
                        
                        <div class="flex items-center gap-3 border-t border-gray-100 pt-6 mt-auto">
                            <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden shrink-0">
                                @if($blog->author?->avatar)
                                    <img src="{{ Storage::url($blog->author->avatar) }}" alt="{{ $blog->author->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-[#4fd1c5] text-white flex items-center justify-center text-xs font-bold">
                                        {{ substr($blog->author?->name ?? 'A', 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <span class="text-xs font-bold text-gray-900">{{ $blog->author->name ?? 'Admin' }}</span>
                        </div>
                    </div>

                </a>
                @endforeach

            </div>

            {{-- Pagination --}}
            <div class="mt-16 flex justify-center">
                {{ $blogs->links() }}
            </div>
        </div>
    @elseif($blogs->count() === 0)
        <div class="text-center text-gray-500 py-12">
            No articles found. Check back later!
        </div>
    @endif

</main>
@endsection
