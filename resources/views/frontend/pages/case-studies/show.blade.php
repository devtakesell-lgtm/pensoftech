@extends('frontend.layouts.front-master')

@if ($caseStudy->seo)
    @section('title', ($caseStudy->seo->meta_title ?? $caseStudy->title) . ' — PenSoftTech')
    @section('meta_description', $caseStudy->seo->meta_description)
    @section('meta_keywords', $caseStudy->seo->meta_keywords)
@else
    @section('title', $caseStudy->title . ' — PenSoftTech Case Studies')
    @section('meta_description', Str::limit(strip_tags($caseStudy->result ?? $caseStudy->content), 160))
@endif

@section('content')
    <main class="bg-black text-white min-h-screen pt-36 md:pt-44 pb-24 relative overflow-hidden">
        {{-- Ambient Lighting --}}
        <div class="absolute top-1/4 -right-48 w-96 h-96 bg-[#4fd1c5]/10 rounded-full blur-[140px] pointer-events-none">
        </div>
        <div class="absolute top-2/3 -left-48 w-96 h-96 bg-[#319795]/10 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-5 lg:px-12 relative z-10">
            {{-- Breadcrumb Navigation --}}
            <nav class="flex items-center gap-2 text-xs font-semibold text-gray-400 mb-8 uppercase tracking-wider"
                aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span>/</span>
                <a href="{{ route('case-studies.index') }}" class="hover:text-white transition-colors">Case Studies</a>
                <span>/</span>
                <span class="text-[#4fd1c5] truncate max-w-[200px] sm:max-w-md">{{ $caseStudy->title }}</span>
            </nav>

            {{-- Case Study Hero Header --}}
            <div class="max-w-5xl mb-12 md:mb-16">
                <div class="flex flex-wrap items-center gap-2.5 mb-6">
                    @if ($caseStudy->project?->industry)
                        <span
                            class="px-3.5 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-[#4fd1c5]/10 text-[#4fd1c5] border border-[#4fd1c5]/25">
                            {{ $caseStudy->project->industry->name }}
                        </span>
                    @endif
                    @if ($caseStudy->project?->client)
                        <span
                            class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/5 text-gray-300 border border-white/10">
                            {{ $caseStudy->project->client->company_name }}
                        </span>
                    @endif
                    @if ($caseStudy->published_at)
                        <span
                            class="px-3.5 py-1 rounded-full text-xs font-medium text-gray-400 bg-white/[0.02] border border-white/5">
                            {{ $caseStudy->published_at->format('F Y') }}
                        </span>
                    @endif
                </div>

                <h1 class="text-3xl sm:text-5xl md:text-6xl font-black text-white tracking-tight leading-[1.15] mb-8"
                    data-aos="fade-up">
                    {{ $caseStudy->title }}
                </h1>

                @if ($caseStudy->result)
                    <div class="p-6 md:p-8 rounded-2xl bg-white/[0.03] border border-[#4fd1c5]/20 text-gray-300 text-base md:text-xl font-normal leading-relaxed relative overflow-hidden"
                        data-aos="fade-up" data-aos-delay="100">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#4fd1c5]"></div>
                        <p class="font-semibold text-white mb-2 text-xs uppercase tracking-wider text-[#4fd1c5]">Executive
                            Impact Summary</p>
                        <p>{{ $caseStudy->result }}</p>
                    </div>
                @endif
            </div>

            {{-- Cinematic Featured Visual --}}
            @php
                $heroImage = $caseStudy->featured_image
                    ? (filter_var($caseStudy->featured_image, FILTER_VALIDATE_URL)
                        ? $caseStudy->featured_image
                        : Storage::url($caseStudy->featured_image))
                    : 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1600&q=80';
            @endphp
            <div class="w-full aspect-[21/9] sm:aspect-[21/8] rounded-[2rem] md:rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/10 relative mb-14 md:mb-16"
                data-aos="zoom-in">
                <img src="{{ $heroImage }}" alt="{{ $caseStudy->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent"></div>
            </div>

            {{-- Key Metrics KPI Strip --}}
            @if ($caseStudy->metrics->isNotEmpty())
                <div class="mb-16 md:mb-24" data-aos="fade-up">
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min($caseStudy->metrics->count(), 4) }} gap-4 md:gap-6">
                        @foreach ($caseStudy->metrics as $metric)
                            <div
                                class="p-6 md:p-8 rounded-2xl bg-[#0b0f19] border border-white/10 hover:border-[#4fd1c5]/40 transition-colors shadow-xl">
                                <span class="text-4xl md:text-5xl font-black text-[#4fd1c5] tracking-tight block mb-2">
                                    {{ $metric->metric_value }}{{ $metric->metric_suffix }}
                                </span>
                                <span class="text-xs sm:text-sm font-bold text-gray-300 uppercase tracking-wider block">
                                    {{ $metric->metric_name }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Deep Dive Layout: Narrative + Sticky Meta Sidebar --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">

                {{-- Main Content Narrative (8 Columns) --}}
                <div class="lg:col-span-8 space-y-12 md:space-y-16">

                    {{-- Challenges Matrix --}}
                    @if ($caseStudy->challenges->isNotEmpty())
                        <section class="space-y-6" data-aos="fade-up">
                            <div class="flex items-center gap-3">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#4fd1c5]"></span>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                                    The Challenge & Problem Space
                                </h2>
                            </div>

                            @foreach ($caseStudy->challenges as $challenge)
                                <div class="p-6 md:p-8 rounded-3xl bg-[#0b0f19] border border-white/10 space-y-6">
                                    <div>
                                        <h3 class="text-xl font-bold text-white mb-2">{{ $challenge->title }}</h3>
                                        <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
                                            {{ $challenge->description }}</p>
                                    </div>

                                    {{-- Solutions for this Challenge --}}
                                    @if ($challenge->solutions->isNotEmpty())
                                        <div class="pt-6 border-t border-white/10">
                                            <h4 class="text-xs font-bold text-[#4fd1c5] uppercase tracking-widest mb-4">
                                                Engineered Solutions
                                            </h4>
                                            <div class="space-y-3">
                                                @foreach ($challenge->solutions as $solution)
                                                    <div
                                                        class="p-4 rounded-xl bg-white/[0.02] border border-white/5 flex items-start gap-3">
                                                        <svg class="w-5 h-5 text-[#4fd1c5] mt-0.5 shrink-0" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        <div class="flex-1">
                                                            <p class="text-sm text-gray-200 leading-relaxed">
                                                                {{ $solution->description }}</p>
                                                            @if ($solution->status)
                                                                <span
                                                                    class="inline-block mt-2 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-[#4fd1c5]/10 text-[#4fd1c5]">
                                                                    {{ ucfirst($solution->status->value ?? $solution->status) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </section>
                    @endif

                    {{-- Full Technical Execution / Rich Content --}}
                    @if ($caseStudy->content)
                        <section class="space-y-6" data-aos="fade-up">
                            <div class="flex items-center gap-3">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#4fd1c5]"></span>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                                    Implementation & Architecture
                                </h2>
                            </div>

                            <div class="prose prose-invert prose-lg max-w-none text-gray-300 leading-relaxed font-normal">
                                {!! $caseStudy->content !!}
                            </div>
                        </section>
                    @endif

                </div>

                {{-- Sticky Meta Sidebar (4 Columns) --}}
                <aside class="lg:col-span-4">
                    <div class="sticky top-32 space-y-6">
                        {{-- Project Blueprint Card --}}
                        <div class="p-6 sm:p-8 rounded-3xl bg-[#0b0f19] border border-white/10 shadow-2xl">
                            <h3
                                class="text-lg font-bold text-white mb-6 pb-4 border-b border-white/10 flex items-center justify-between">
                                <span>Project Overview</span>
                                <span class="w-2 h-2 rounded-full bg-[#4fd1c5]"></span>
                            </h3>

                            <dl class="space-y-6 text-sm">
                                @if ($caseStudy->project?->client)
                                    <div>
                                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Client
                                        </dt>
                                        <dd class="text-base font-bold text-white">
                                            {{ $caseStudy->project->client->company_name }}</dd>
                                    </div>
                                @endif

                                @if ($caseStudy->project?->industry)
                                    <div>
                                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Industry
                                        </dt>
                                        <dd class="text-base font-bold text-white">
                                            {{ $caseStudy->project->industry->name }}</dd>
                                    </div>
                                @endif

                                @if ($caseStudy->project && ($caseStudy->project->start_date || $caseStudy->project->completion_date))
                                    <div>
                                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Timeline
                                        </dt>
                                        <dd class="text-base font-bold text-white">
                                            {{ $caseStudy->project->start_date?->format('M Y') }} -
                                            {{ $caseStudy->project->completion_date ? $caseStudy->project->completion_date->format('M Y') : 'Present' }}
                                        </dd>
                                    </div>
                                @endif

                                @if ($caseStudy->project && $caseStudy->project->services->isNotEmpty())
                                    <div>
                                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2.5">Services
                                            Provided</dt>
                                        <dd class="flex flex-wrap gap-1.5">
                                            @foreach ($caseStudy->project->services as $service)
                                                <span
                                                    class="px-2.5 py-1 rounded-lg text-xs font-medium bg-white/5 border border-white/10 text-gray-300">
                                                    {{ $service->name }}
                                                </span>
                                            @endforeach
                                        </dd>
                                    </div>
                                @endif

                                @if ($caseStudy->project?->project_url)
                                    <div class="pt-4 border-t border-white/10">
                                        <a href="{{ $caseStudy->project->project_url }}" target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center gap-2 text-xs font-bold text-[#4fd1c5] hover:underline">
                                            <span>Visit Live Application</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </dl>

                            {{-- Link to full Project Portfolio View --}}
                            @if ($caseStudy->project)
                                <div class="mt-8 pt-6 border-t border-white/10">
                                    <a href="{{ route('projects.single', $caseStudy->project->slug) }}"
                                        class="block w-full text-center py-3 px-4 rounded-xl bg-white/5 hover:bg-white/10 text-white text-xs font-bold border border-white/10 transition-colors">
                                        View Full Project Blueprint
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- High-Conversion Pitch Card --}}
                        <div
                            class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-slate-900 to-black border border-[#4fd1c5]/30 text-center shadow-2xl">
                            <span class="text-xs font-extrabold uppercase tracking-widest text-[#4fd1c5] block mb-2">Need
                                Similar Growth?</span>
                            <h4 class="text-xl font-black text-white mb-3 leading-snug">Let's build your next digital
                                breakthrough.</h4>
                            <p class="text-xs sm:text-sm text-gray-400 mb-6 leading-relaxed">
                                Schedule a high-impact discovery session with our engineering directors.
                            </p>
                            <a href="{{ route('start-project') }}"
                                class="block w-full py-3.5 px-6 rounded-xl bg-[#4fd1c5] hover:bg-[#319795] text-black font-extrabold text-sm transition-all shadow-lg shadow-[#4fd1c5]/25">
                                Start a Project
                            </a>
                        </div>
                    </div>
                </aside>
            </div>

            {{-- Related Case Studies --}}
            @if ($relatedCaseStudies->isNotEmpty())
                <div class="mt-28 md:mt-36 pt-16 border-t border-white/10">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
                        <div>
                            <span
                                class="text-[#4fd1c5] font-bold text-xs uppercase tracking-widest block mb-2">Portfolio</span>
                            <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">More Success Stories
                            </h2>
                        </div>
                        <a href="{{ route('case-studies.index') }}"
                            class="text-sm font-bold text-[#4fd1c5] hover:underline inline-flex items-center gap-1.5">
                            <span>View All Case Studies</span>
                            <span class="text-base">→</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach ($relatedCaseStudies as $related)
                            @php
                                $relatedMetric = $related->metrics->first();
                                $relatedImage = $related->featured_image
                                    ? (filter_var($related->featured_image, FILTER_VALIDATE_URL)
                                        ? $related->featured_image
                                        : Storage::url($related->featured_image))
                                    : 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80';
                            @endphp
                            <a href="{{ route('case-studies.show', $related->slug) }}"
                                class="flex flex-col bg-[#0b0f19] border border-white/10 rounded-3xl overflow-hidden hover:border-[#4fd1c5]/40 hover:-translate-y-1.5 transition-all duration-300 group shadow-xl">
                                <div class="aspect-[16/9] w-full overflow-hidden relative bg-slate-900">
                                    <img src="{{ $relatedImage }}" alt="{{ $related->title }}"
                                        class="w-full h-full object-cover opacity-65 group-hover:scale-105 transition-transform duration-500">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-[#0b0f19] via-transparent to-transparent">
                                    </div>
                                    @if ($relatedMetric)
                                        <div
                                            class="absolute bottom-4 left-4 bg-black/80 backdrop-blur-md border border-[#4fd1c5]/30 rounded-xl px-3 py-1.5">
                                            <span
                                                class="text-xl font-black text-[#4fd1c5]">{{ $relatedMetric->metric_value }}{{ $relatedMetric->metric_suffix }}</span>
                                            <span
                                                class="text-[10px] font-bold text-white uppercase ml-1">{{ $relatedMetric->metric_name }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6 flex flex-col flex-1">
                                    <h3
                                        class="text-xl font-bold text-white group-hover:text-[#4fd1c5] transition-colors mb-2 leading-snug">
                                        {{ $related->title }}
                                    </h3>
                                    <p class="text-gray-400 text-xs sm:text-sm line-clamp-2 leading-relaxed mb-4">
                                        {{ $related->result ?? Str::limit(strip_tags($related->content), 100) }}
                                    </p>
                                    <span class="text-xs font-bold text-[#4fd1c5] mt-auto inline-flex items-center gap-1">
                                        Read Story →
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection
