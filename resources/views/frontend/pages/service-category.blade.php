@extends('frontend.layouts.front-master')

@section('title', $category->name . ' Services — PenSoftTech')
@section('description', $category->short_description)

@section('content')

    <main class="bg-black">
        {{-- Hero --}}
        <section class="relative w-full h-[60vh] min-h-[500px] overflow-hidden bg-black flex items-center justify-center pt-20">
            <div class="absolute inset-0 z-0 w-full h-full">
                <img class="absolute inset-0 w-full h-full object-cover opacity-30 scale-105" 
                     src="{{ $category->image ? asset('storage/' . $category->image) : 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=2850&q=80' }}" 
                     alt="{{ $category->name }} Background">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-black/30"></div>
            </div>
            <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-12 flex flex-col justify-center h-full pb-10 text-center">
                <h1 class="text-white text-5xl sm:text-6xl md:text-7xl font-bold tracking-tighter uppercase mb-6" data-aos="fade-up">
                    {{ $category->name }}
                </h1>
                <p class="text-base sm:text-lg md:text-2xl text-white/80 max-w-3xl mx-auto font-medium leading-relaxed" data-aos="fade-up" data-aos-delay="100">
                    {{ $category->description ?? $category->short_description }}
                </p>
            </div>
        </section>

        {{-- Services Details Loop --}}
        @if(isset($category->services) && $category->services->count() > 0)
            @foreach($category->services as $service)
                @if($loop->odd)
                    {{-- Light Block --}}
                    <section class="py-14 lg:py-16 bg-white text-black relative z-20" id="{{ $service->slug ?? '' }}">
                        <div class="max-w-7xl mx-auto px-6 lg:px-12">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                                <div data-aos="fade-right">
                                    <span class="text-[#0d9488] font-bold tracking-widest uppercase text-xs mb-3 block">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ $category->name }}</span>
                                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-4 text-slate-900">{{ $service->name }}</h2>
                                    <p class="text-slate-600 text-base md:text-lg mb-8 leading-relaxed">
                                        {{ $service->short_description }}
                                    </p>
                                    <a href="{{ route('services.single', ['category_slug' => $category->slug, 'service_slug' => $service->slug]) }}" class="inline-flex items-center justify-center bg-slate-900 text-white px-7 py-3.5 rounded-full font-bold hover:bg-[#0d9488] hover:text-white transition-all duration-300 group shadow-sm hover:shadow-md">
                                        <span>Learn More</span>
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                                <div class="relative" data-aos="fade-left">
                                    <div class="h-[260px] sm:h-[320px] lg:h-[360px] w-full rounded-2xl md:rounded-3xl overflow-hidden bg-slate-100 shadow-xl border border-slate-200/60 relative">
                                        <img src="{{ $service->featured_image ? asset('storage/' . $service->featured_image) : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80' }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    {{-- Dark Block --}}
                    <section class="py-14 lg:py-16 bg-[#0a0a0a] text-white relative z-20" id="{{ $service->slug ?? '' }}">
                        <div class="max-w-7xl mx-auto px-6 lg:px-12">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                                <div class="order-2 lg:order-1 relative" data-aos="fade-right">
                                    <div class="h-[260px] sm:h-[320px] lg:h-[360px] w-full rounded-2xl md:rounded-3xl overflow-hidden bg-gray-900 shadow-[0_0_40px_rgba(79,209,197,0.12)] border border-white/10 relative">
                                        <img src="{{ $service->featured_image ? asset('storage/' . $service->featured_image) : 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80' }}" alt="{{ $service->name }}" class="w-full h-full object-cover opacity-90 transition-all duration-700">
                                    </div>
                                </div>
                                <div class="order-1 lg:order-2" data-aos="fade-left">
                                    <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs mb-3 block">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ $category->name }}</span>
                                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-4">{{ $service->name }}</h2>
                                    <p class="text-gray-400 text-base md:text-lg mb-8 leading-relaxed">
                                        {{ $service->short_description }}
                                    </p>
                                    <a href="{{ route('services.single', ['category_slug' => $category->slug, 'service_slug' => $service->slug]) }}" class="inline-flex items-center justify-center bg-white text-black px-7 py-3.5 rounded-full font-bold hover:bg-[#4fd1c5] transition-all duration-300 group shadow-sm">
                                        <span>Learn More</span>
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @endforeach
        @endif

        {{-- Call to Action (Shared) --}}
        @include('frontend.components.global.cta')
    </main>

@endsection
