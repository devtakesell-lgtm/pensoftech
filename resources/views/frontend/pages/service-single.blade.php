@extends('frontend.layouts.front-master')

@section('title', isset($service) && $service->seo ? $service->seo->title : $service->name . ' — ' . $category->name . ' — PenSoftTech')
@section('description', isset($service) && $service->seo ? $service->seo->description : $service->short_description)

@section('content')
    <main class="bg-[#FAFBFD] text-slate-900 min-h-screen pt-28 pb-24">
        
        {{-- Hero Header Section --}}
        <section class="max-w-7xl mx-auto px-6 lg:px-12 pt-6 pb-12">
            
            {{-- Breadcrumb --}}
            <nav class="flex items-center flex-wrap gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-8" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-slate-900 transition-colors">Home</a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('services') }}" class="hover:text-slate-900 transition-colors">Services</a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('services.category', $category->slug) }}" class="text-[#0d9488] hover:underline font-bold">
                    {{ $category->name }}
                </a>
            </nav>

            {{-- Service Headline --}}
            <div class="max-w-4xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-50 text-[#0d9488] border border-teal-200/60 text-xs font-bold uppercase tracking-widest mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#0d9488]"></span>
                    {{ $category->name }}
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15] mb-6">
                    {{ $service->name }}
                </h1>
                @if($service->short_description)
                <p class="text-xl sm:text-2xl text-slate-600 font-normal leading-relaxed">
                    {{ $service->short_description }}
                </p>
                @endif
            </div>

            {{-- 1. Full-Width Banner Image Showcase --}}
            <div class="relative mt-12 rounded-3xl overflow-hidden shadow-2xl shadow-slate-200/80 border border-slate-200/90 bg-slate-900">
                <img src="{{ $service->banner_image ? asset('storage/' . $service->banner_image) : 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=2400&q=80' }}" 
                     alt="{{ $service->name }} Banner" 
                     class="w-full h-[320px] md:h-[420px] lg:h-[480px] object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent"></div>
                <div class="absolute bottom-6 left-6 md:bottom-10 md:left-10 text-white max-w-xl">
                    <span class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md px-3.5 py-1.5 rounded-full text-xs font-semibold tracking-wider uppercase mb-2 border border-white/20">
                        <span class="w-2 h-2 rounded-full bg-[#4fd1c5] animate-pulse"></span> Enterprise Service
                    </span>
                    <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white drop-shadow">
                        {{ $service->name }}
                    </h2>
                </div>
            </div>

        </section>

        {{-- 2. Editorial Content & Sticky Sidebar Grid --}}
        <section class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                
                {{-- Left Column: Featured Image & Rich Text Content --}}
                <div class="lg:col-span-8">
                    
                    {{-- Featured Image Showcase (if available) --}}
                    @if($service->featured_image)
                    <div class="mb-10 rounded-3xl overflow-hidden border border-slate-200/80 shadow-md bg-white p-3">
                        <img src="{{ asset('storage/' . $service->featured_image) }}" 
                             alt="{{ $service->name }} Overview" 
                             class="w-full h-auto max-h-[500px] object-cover rounded-2xl">
                    </div>
                    @endif

                    {{-- Main TinyMCE Rich Text Content --}}
                    <div class="bg-white p-8 sm:p-12 rounded-3xl border border-slate-200/80 shadow-sm">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-[#0d9488] mb-6">Service Overview &amp; Capabilities</h3>
                        <div class="service-content">
                            {!! $service->description ?? '<p class="text-slate-500">Service documentation is currently being finalized.</p>' !!}
                        </div>
                    </div>

                </div>

                {{-- Right Column: Sticky Premium CTA & Related Services --}}
                <div class="lg:col-span-4 lg:sticky lg:top-28 space-y-8">
                    
                    {{-- Premium Action Card --}}
                    <div class="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-xl shadow-slate-100/80 relative overflow-hidden">
                        {{-- Top Accent Bar --}}
                        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#0d9488] via-[#14b8a6] to-[#0284c7]"></div>
                        
                        <span class="inline-block text-[#0d9488] bg-teal-50 border border-teal-200/60 font-bold text-xs uppercase tracking-widest px-3 py-1 rounded-full mb-4">
                            Work With Us
                        </span>
                        
                        <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight mb-3">
                            Start Your Project
                        </h3>
                        
                        <p class="text-slate-500 text-sm leading-relaxed mb-6">
                            Ready to accelerate your roadmap with our {{ $service->name }} specialists?
                        </p>

                        {{-- Value Highlights --}}
                        <ul class="space-y-3 mb-8 text-sm text-slate-600 font-medium">
                            <li class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-teal-100 text-[#0d9488] flex items-center justify-center shrink-0 text-xs font-bold">✓</div>
                                <span>Senior Engineering Team</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-teal-100 text-[#0d9488] flex items-center justify-center shrink-0 text-xs font-bold">✓</div>
                                <span>Fixed Milestone Deliverables</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-teal-100 text-[#0d9488] flex items-center justify-center shrink-0 text-xs font-bold">✓</div>
                                <span>Complete Codebase Ownership</span>
                            </li>
                        </ul>

                        {{-- Premium Button --}}
                        <a href="{{ route('contact') }}" class="group relative flex items-center justify-between w-full px-6 py-4 text-base font-bold text-white transition-all duration-300 bg-slate-900 rounded-2xl overflow-hidden hover:bg-[#0d9488] hover:shadow-lg hover:shadow-teal-500/25">
                            <span>Discuss Your Project</span>
                            <span class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center group-hover:translate-x-1 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </a>

                        <p class="text-center text-xs text-slate-400 mt-4">
                            Response guaranteed within 24 business hours
                        </p>
                    </div>

                    {{-- Other Services in This Category --}}
                    @if(isset($relatedServices) && $relatedServices->count() > 0)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4 px-2">
                            More in {{ $category->name }}
                        </h4>
                        <div class="space-y-1">
                            @foreach($relatedServices as $related)
                            <a href="{{ route('services.single', ['category_slug' => $category->slug, 'service_slug' => $related->slug]) }}" 
                               class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors group">
                                <span class="text-sm font-semibold text-slate-700 group-hover:text-[#0d9488] transition-colors">
                                    {{ $related->name }}
                                </span>
                                <svg class="w-4 h-4 text-slate-300 group-hover:text-[#0d9488] group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

            </div>
        </section>

    </main>
@endsection
