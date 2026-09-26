@extends('frontend.layouts.front-master')

@section('title', 'Client Success Stories & Case Studies — PenSoftTech')
@section('meta_description', 'Explore our portfolio of scalable software engineering case studies, enterprise
    architecture transformations, and measurable digital growth.')

@section('content')
    <main class="bg-black min-h-screen pt-36 md:pt-44 pb-24 relative overflow-hidden">
        {{-- Ambient Background Glows --}}
        <div class="absolute top-1/4 -left-48 w-96 h-96 bg-[#4fd1c5]/10 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute top-1/3 -right-48 w-96 h-96 bg-[#319795]/10 rounded-full blur-[140px] pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-5 lg:px-12 relative z-10">
            {{-- Hero Header --}}
            <div class="text-center max-w-4xl mx-auto mb-16 md:mb-20">
                <span
                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#4fd1c5]/10 border border-[#4fd1c5]/25 text-[#4fd1c5] text-xs font-bold uppercase tracking-widest mb-6"
                    data-aos="fade-down">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5] animate-pulse"></span>
                    Proven ROI & Impact
                </span>

                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-[1.1] mb-6"
                    data-aos="fade-up">
                    Transformative Stories, <br class="hidden sm:inline" />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4fd1c5] via-teal-300 to-[#2c988e]">
                        Measurable Impact
                    </span>
                </h1>

                <p class="text-base sm:text-lg md:text-xl text-gray-400 font-normal leading-relaxed max-w-2xl mx-auto"
                    data-aos="fade-up" data-aos-delay="100">
                    Explore in-depth case studies on how we partner with world-class SaaS, enterprise, and high-growth
                    brands to engineer scalable digital systems that drive revenue.
                </p>

                {{-- High-Impact KPI Ribbon --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-8 mt-12 pt-8 border-t border-white/10 max-w-3xl mx-auto"
                    data-aos="fade-up" data-aos-delay="150">
                    <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/5 backdrop-blur-sm">
                        <p class="text-3xl sm:text-4xl font-black text-[#4fd1c5] mb-1">150+</p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Enterprise Launches</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/5 backdrop-blur-sm">
                        <p class="text-3xl sm:text-4xl font-black text-[#4fd1c5] mb-1">99.99%</p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Uptime & Scalability</p>
                    </div>
                    <div
                        class="col-span-2 md:col-span-1 p-4 rounded-2xl bg-white/[0.03] border border-white/5 backdrop-blur-sm">
                        <p class="text-3xl sm:text-4xl font-black text-[#4fd1c5] mb-1">4.2X</p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Average ROI Multiplier</p>
                    </div>
                </div>
            </div>

            {{-- Filter Pills by Industry --}}
            @if ($industries->isNotEmpty())
                <div class="flex items-center justify-center flex-wrap gap-2.5 mb-14 md:mb-20" data-aos="fade-up">
                    <a href="{{ route('case-studies.index') }}"
                        class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 {{ empty($selectedIndustry) ? 'bg-[#4fd1c5] text-black shadow-lg shadow-[#4fd1c5]/25' : 'bg-white/5 text-gray-400 hover:text-white hover:bg-white/10 border border-white/10' }}">
                        All Stories
                    </a>
                    @foreach ($industries as $industry)
                        <a href="{{ route('case-studies.index', ['industry' => $industry->slug]) }}"
                            class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all duration-300 {{ $selectedIndustry === $industry->slug ? 'bg-[#4fd1c5] text-black shadow-lg shadow-[#4fd1c5]/25' : 'bg-white/5 text-gray-400 hover:text-white hover:bg-white/10 border border-white/10' }}">
                            {{ $industry->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Case Studies Grid --}}
            @if ($caseStudies->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                    @foreach ($caseStudies as $study)
                        @php
                            $primaryMetric = $study->metrics->first();
                            $secondaryMetric = $study->metrics->skip(1)->first();
                            $clientName = $study->project?->client?->company_name ?? 'Confidential Enterprise';
                            $industryName = $study->project?->industry?->name ?? 'Technology';
                            $imageUrl = $study->featured_image
                                ? (filter_var($study->featured_image, FILTER_VALIDATE_URL)
                                    ? $study->featured_image
                                    : Storage::url($study->featured_image))
                                : 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1200&q=80';
                        @endphp

                        <article
                            class="flex flex-col bg-[#0b0f19] border border-white/10 rounded-3xl overflow-hidden hover:border-[#4fd1c5]/40 hover:-translate-y-2 transition-all duration-500 group shadow-2xl relative"
                            data-aos="fade-up">
                            {{-- Visual Media Header --}}
                            <div class="relative w-full aspect-[16/10] overflow-hidden bg-slate-900">
                                <img src="{{ $imageUrl }}" alt="{{ $study->title }}"
                                    class="w-full h-full object-cover opacity-70 group-hover:opacity-90 group-hover:scale-105 transition-all duration-700">

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-[#0b0f19] via-[#0b0f19]/40 to-transparent">
                                </div>

                                {{-- Floating Industry & Client Tag --}}
                                <div class="absolute top-4 left-4 right-4 flex items-center justify-between gap-2 z-10">
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-black/60 backdrop-blur-md text-[#4fd1c5] border border-white/15">
                                        {{ $industryName }}
                                    </span>
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-semibold text-gray-300 bg-black/60 backdrop-blur-md border border-white/10 truncate max-w-[150px]">
                                        {{ $clientName }}
                                    </span>
                                </div>

                                {{-- Primary Metric Floating Pill --}}
                                @if ($primaryMetric)
                                    <div
                                        class="absolute bottom-4 left-4 z-10 bg-black/80 backdrop-blur-md border border-[#4fd1c5]/30 rounded-2xl px-4 py-2 flex items-baseline gap-2">
                                        <span class="text-2xl lg:text-3xl font-black text-[#4fd1c5] tracking-tight">
                                            {{ $primaryMetric->metric_value }}{{ $primaryMetric->metric_suffix }}
                                        </span>
                                        <span
                                            class="text-[10px] font-bold text-white uppercase tracking-wider line-clamp-1">
                                            {{ $primaryMetric->metric_name }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Card Content Body --}}
                            <div class="p-6 sm:p-8 flex flex-col flex-1">
                                <h2
                                    class="text-xl sm:text-2xl font-bold text-white group-hover:text-[#4fd1c5] transition-colors leading-snug mb-3">
                                    <a href="{{ route('case-studies.show', $study->slug) }}" class="focus:outline-none">
                                        {{ $study->title }}
                                    </a>
                                </h2>

                                @if ($study->result)
                                    <p class="text-gray-400 text-sm leading-relaxed mb-6 line-clamp-3 flex-1 font-normal">
                                        {{ $study->result }}
                                    </p>
                                @else
                                    <p class="text-gray-400 text-sm leading-relaxed mb-6 line-clamp-3 flex-1 font-normal">
                                        {{ Str::limit(strip_tags($study->content), 140) }}
                                    </p>
                                @endif

                                {{-- Secondary Metric Pill if available --}}
                                @if ($secondaryMetric)
                                    <div
                                        class="mb-6 p-3 rounded-xl bg-white/[0.02] border border-white/5 flex items-center justify-between">
                                        <span
                                            class="text-xs text-gray-400 font-medium">{{ $secondaryMetric->metric_name }}</span>
                                        <span class="text-sm font-extrabold text-[#4fd1c5]">
                                            {{ $secondaryMetric->metric_value }}{{ $secondaryMetric->metric_suffix }}
                                        </span>
                                    </div>
                                @endif

                                {{-- Services Tags --}}
                                @if ($study->project && $study->project->services->isNotEmpty())
                                    <div class="flex flex-wrap gap-1.5 mb-6">
                                        @foreach ($study->project->services->take(3) as $service)
                                            <span
                                                class="px-2.5 py-1 rounded-md text-[10px] font-semibold bg-white/5 text-gray-300 border border-white/5">
                                                {{ $service->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Action Footer --}}
                                <div class="pt-4 border-t border-white/10 mt-auto flex items-center justify-between">
                                    <a href="{{ route('case-studies.show', $study->slug) }}"
                                        class="text-sm font-bold text-[#4fd1c5] inline-flex items-center gap-2 group-hover:underline">
                                        <span>Read Full Case Study</span>
                                        <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination Links --}}
                <div class="mt-16 flex justify-center">
                    {{ $caseStudies->links('pagination::tailwind') }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-20 px-6 rounded-3xl bg-white/[0.02] border border-white/5 max-w-xl mx-auto">
                    <div
                        class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mx-auto mb-4 text-[#4fd1c5]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No Case Studies Found</h3>
                    <p class="text-gray-400 text-sm mb-6">There are currently no case studies published in this specific
                        category.</p>
                    <a href="{{ route('case-studies.index') }}"
                        class="inline-flex items-center px-6 py-3 rounded-full bg-[#4fd1c5] text-black font-bold text-sm hover:bg-[#319795] transition-colors">
                        View All Case Studies
                    </a>
                </div>
            @endif

            {{-- Bottom Conversion Pitch --}}
            <div class="mt-28 md:mt-36 p-10 md:p-16 rounded-[2.5rem] bg-gradient-to-br from-slate-900 via-black to-[#050505] border border-white/10 text-center relative overflow-hidden shadow-2xl"
                data-aos="fade-up">
                <div
                    class="absolute -top-32 left-1/2 -translate-x-1/2 w-96 h-96 bg-[#4fd1c5]/15 rounded-full blur-[120px] pointer-events-none">
                </div>

                <div class="relative z-10 max-w-3xl mx-auto">
                    <span class="text-[#4fd1c5] font-bold text-xs uppercase tracking-widest mb-3 block">Next Success
                        Story</span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-white tracking-tight mb-6">
                        Ready to achieve exceptional digital growth?
                    </h2>
                    <p class="text-gray-400 text-base sm:text-lg mb-8 max-w-xl mx-auto leading-relaxed">
                        Partner with our world-class engineering and product teams to bring your high-scale product vision
                        to life.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('start-project') }}"
                            class="w-full sm:w-auto px-8 py-4 rounded-full bg-[#4fd1c5] hover:bg-[#319795] text-black font-extrabold text-sm transition-all shadow-lg shadow-[#4fd1c5]/20">
                            Start Your Project
                        </a>
                        <a href="{{ route('contact') }}"
                            class="w-full sm:w-auto px-8 py-4 rounded-full bg-white/10 hover:bg-white/15 text-white font-bold text-sm border border-white/15 transition-all">
                            Talk with Our Team
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
