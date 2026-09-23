@extends('frontend.layouts.master')

@section('title', $blog->seo?->meta_title ?? $blog->title)
@section('meta_description', $blog->seo?->meta_description ?? $blog->excerpt)
@if($blog->seo?->meta_keywords)
@section('meta_keywords', $blog->seo->meta_keywords)
@endif

@section('content')
<main class="bg-white pt-32 pb-24 min-h-screen">
    
    {{-- Blog Header --}}
    <div class="max-w-4xl mx-auto px-5 lg:px-12 mb-12 text-center">
        <div class="flex items-center justify-center gap-3 mb-6">
            <span class="inline-block px-3 py-1 bg-[#4fd1c5]/10 text-[#2c988e] text-sm font-bold rounded-full uppercase tracking-wider">
                {{ $blog->category->name ?? 'Uncategorized' }}
            </span>
            <span class="text-sm font-medium text-gray-400">
                {{ $blog->published_at?->format('F d, Y') ?? 'Recently' }}
            </span>
        </div>

        <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight leading-tight mb-8">
            {{ $blog->title }}
        </h1>

        <div class="flex items-center justify-center gap-4">
            <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden shrink-0">
                @if($blog->author?->avatar)
                    <img src="{{ Storage::url($blog->author->avatar) }}" alt="{{ $blog->author->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-[#4fd1c5] text-white flex items-center justify-center text-lg font-bold">
                        {{ substr($blog->author?->name ?? 'A', 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="flex flex-col text-left">
                <span class="text-base font-bold text-gray-900">{{ $blog->author->name ?? 'Admin' }}</span>
                <span class="text-sm text-gray-500">{{ $blog->reading_time ?? 5 }} min read &bull; {{ $blog->views }} views</span>
            </div>
        </div>
    </div>

    {{-- Featured Image --}}
    <div class="max-w-5xl mx-auto px-5 lg:px-12 mb-16">
        <div class="w-full aspect-video rounded-3xl overflow-hidden shadow-2xl relative">
            @if($blog->featured_image)
                <img src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover">
            @else
                <img src="https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&q=80&w=1200" alt="{{ $blog->title }}" class="w-full h-full object-cover">
            @endif
        </div>
    </div>

    {{-- Blog Content (TinyMCE HTML) --}}
    <div class="max-w-3xl mx-auto px-5 lg:px-12 prose prose-lg md:prose-xl prose-a:text-[#4fd1c5] hover:prose-a:text-[#2c988e] prose-img:rounded-xl">
        {!! $blog->content !!}
    </div>

    {{-- Related Articles --}}
    @if($relatedBlogs->count() > 0)
    <div class="max-w-7xl mx-auto px-5 lg:px-12 mt-24 pt-16 border-t border-gray-100">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-3xl font-extrabold text-gray-900">Read More</h2>
            <a href="{{ route('blogs.index') }}" class="text-[#4fd1c5] font-bold hover:text-[#2c988e] transition-colors">View All &rarr;</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($relatedBlogs as $related)
            <a href="{{ route('blogs.single', $related->slug) }}" class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col h-full">
                
                {{-- Image --}}
                <div class="relative w-full aspect-[16/10] overflow-hidden">
                    @if($related->featured_image)
                        <img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                    @else
                        <img src="https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&q=80&w=800" alt="{{ $related->title }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                    @endif
                </div>

                {{-- Content --}}
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-2">
                        <span>{{ $related->category->name ?? 'Blog' }}</span>
                        <span>&bull;</span>
                        <span>{{ $related->reading_time ?? 5 }} min read</span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-[#4fd1c5] transition-colors duration-300 leading-snug">
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
