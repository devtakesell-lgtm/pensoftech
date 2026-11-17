<section class="bg-gray-50 py-10 md:py-24 overflow-hidden border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-5 lg:px-12 mb-6 md:mb-12 text-center">
        <span
            class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs md:text-sm mb-1.5 md:mb-3 block">Impact</span>
        <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">
            Client Success Stories
        </h2>
        <p class="text-gray-500 mt-2 max-w-xl mx-auto text-xs md:text-base leading-relaxed">
            Explore how we help leading SaaS companies achieve exceptional growth.
        </p>
    </div>

    @if (isset($caseStudies) && $caseStudies->count() > 0)
        <div class="max-w-7xl mx-auto px-5 lg:px-12">
            {{-- =========================================================
             MOBILE ONLY: Compact Split-Cards (Left Metric + Right Info)
             ========================================================= --}}
            <div class="md:hidden space-y-3.5">
                @foreach ($caseStudies as $caseStudy)
                    @php
                        $primaryMetric = $caseStudy->metrics->first();
                        $metricValue = $primaryMetric
                            ? $primaryMetric->metric_value . $primaryMetric->metric_suffix
                            : 'ROI';
                        $metricLabel = $primaryMetric ? $primaryMetric->metric_name : 'Growth';
                        $clientName = $caseStudy->project?->client?->company_name ?? 'Client Story';
                        $industryName = $caseStudy->project?->industry?->name ?? 'Enterprise';
                    @endphp
                    <a href="{{ route('case-studies.show', $caseStudy->slug) }}"
                        class="flex bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden hover:border-[#4fd1c5] transition-all duration-300 group p-3 gap-3.5 items-center">

                        {{-- Left Metric Area --}}
                        <div
                            class="bg-slate-900 w-24 h-24 sm:w-28 sm:h-28 rounded-xl flex-shrink-0 flex flex-col items-center justify-center relative overflow-hidden text-center p-2">
                            <div
                                class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiLz48L3N2Zz4=')]">
                            </div>
                            <span
                                class="text-2xl sm:text-3xl font-black text-[#4fd1c5] tracking-tight leading-none mb-1 relative z-10">{{ $metricValue }}</span>
                            <span
                                class="text-[10px] font-bold text-white uppercase tracking-wider leading-tight relative z-10 line-clamp-1">{{ $metricLabel }}</span>
                        </div>

                        {{-- Right Content Area --}}
                        <div class="flex flex-col justify-center flex-1 min-w-0 pr-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span
                                    class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 uppercase tracking-wider">
                                    {{ $industryName }}
                                </span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider truncate">
                                    {{ $clientName }}
                                </span>
                            </div>

                            <h4
                                class="text-xs font-bold text-gray-900 leading-snug line-clamp-2 mb-2 group-hover:text-[#4fd1c5] transition-colors">
                                {{ $caseStudy->title }}
                            </h4>

                            <div class="flex items-center gap-1 text-[11px] font-bold text-[#4fd1c5]">
                                <span>Read Story</span>
                                <span class="text-sm transition-transform group-hover:translate-x-1">→</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- =========================================================
             DESKTOP ONLY: Standard Multi-Column Grid
             ========================================================= --}}
            <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($caseStudies as $caseStudy)
                    @php
                        $primaryMetric = $caseStudy->metrics->first();
                        $metricValue = $primaryMetric
                            ? $primaryMetric->metric_value . $primaryMetric->metric_suffix
                            : 'ROI';
                        $metricLabel = $primaryMetric ? $primaryMetric->metric_name : 'Growth';
                        $clientName = $caseStudy->project?->client?->company_name ?? 'Client Story';
                        $industryName = $caseStudy->project?->industry?->name ?? 'Enterprise';
                    @endphp
                    <a href="{{ route('case-studies.show', $caseStudy->slug) }}"
                        class="flex flex-col bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group cursor-pointer">

                        {{-- Top Metric Area with Optional Background Image --}}
                        <div class="bg-slate-900 p-8 flex flex-col justify-end aspect-[4/3] relative overflow-hidden">
                            @if ($caseStudy->featured_image)
                                <img src="{{ filter_var($caseStudy->featured_image, FILTER_VALIDATE_URL) ? $caseStudy->featured_image : Storage::url($caseStudy->featured_image) }}"
                                    alt="{{ $caseStudy->title }}"
                                    class="absolute inset-0 w-full h-full object-cover opacity-25 group-hover:scale-105 transition-transform duration-700">
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/80 to-transparent">
                            </div>
                            <div
                                class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiLz48L3N2Zz4=')]">
                            </div>

                            <div class="relative z-10">
                                <h3 class="text-5xl lg:text-6xl font-black text-[#4fd1c5] mb-1 tracking-tighter">
                                    {{ $metricValue }}</h3>
                                <h4
                                    class="text-xl lg:text-2xl font-bold text-white uppercase tracking-tight line-clamp-1">
                                    {{ $metricLabel }}</h4>
                            </div>
                        </div>

                        {{-- Bottom Content Area --}}
                        <div class="p-8 flex flex-col flex-1">
                            <div class="mb-4">
                                <span
                                    class="inline-block px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full uppercase tracking-wider mb-3">
                                    {{ $industryName }}
                                </span>
                                <h5 class="text-sm font-bold text-gray-400 uppercase tracking-wider">
                                    {{ $clientName }}</h5>
                            </div>

                            <p class="text-gray-900 font-bold text-lg mb-8 leading-snug flex-1 line-clamp-2">
                                {{ $caseStudy->title }}
                            </p>

                            <div
                                class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between group-hover:border-gray-200 transition-colors">
                                <span
                                    class="text-sm font-bold text-gray-900 group-hover:text-[#4fd1c5] transition-colors">Read
                                    Case Study</span>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-[#4fd1c5] group-hover:translate-x-1 transition-all"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- See More / View All Button --}}
            <div class="text-center mt-6 md:mt-16">
                <a href="{{ route('case-studies.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 md:px-8 py-3 md:py-4 rounded-full border-2 border-gray-200 bg-white text-gray-700 text-xs md:text-sm font-bold hover:border-[#4fd1c5] hover:text-[#4fd1c5] hover:shadow-md transition-all duration-300">
                    <span>See More Success Stories</span>
                    <span class="text-base font-extrabold">→</span>
                </a>
            </div>
        </div>
    @endif
</section>
