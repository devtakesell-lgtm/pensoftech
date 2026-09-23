@extends('frontend.layouts.front-master')

@section('title', isset($page) && $page->seo ? $page->seo->title : 'Our Services — PenSoftTech')
@section('description', isset($page) && $page->seo ? $page->seo->description : 'Explore our world-class software development, digital marketing, and cloud solutions.')

@section('content')

    <main class="bg-black">
        {{-- 1. Services Hero (Dark) --}}
        @include('frontend.components.services.hero')

        {{-- Dynamic Service Categories --}}
        @if(isset($categories) && $categories->count() > 0)
            @foreach($categories as $category)
                @if($loop->even)
                    @include('frontend.components.services.category-light', ['category' => $category, 'index' => $loop->iteration])
                @else
                    @include('frontend.components.services.category-dark', ['category' => $category, 'index' => $loop->iteration])
                @endif
            @endforeach
        @endif

        {{-- 5. Call to Action (Dark) --}}
        @include('frontend.components.global.cta')
    </main>

@endsection
