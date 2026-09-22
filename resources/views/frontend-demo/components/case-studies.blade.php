<section class="bg-gray-50 py-10 md:py-24 overflow-hidden border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-5 lg:px-12 mb-6 md:mb-12 text-center">
        <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs md:text-sm mb-1.5 md:mb-3 block">Impact</span>
        <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">
            Client Success Stories
        </h2>
        <p class="text-gray-500 mt-2 max-w-xl mx-auto text-xs md:text-base leading-relaxed">
            Explore how we help leading SaaS companies achieve exceptional growth.
        </p>
    </div>

    @php
        $demoCaseStudies = [
            [
                'metric' => '315%',
                'metric_label' => 'Growth',
                'client' => 'Innovate Analytics',
                'industry' => 'Fintech',
                'title' => 'Achieving 315% User Growth with DataFlow AI',
                'theme' => 'bg-slate-900',
            ],
            [
                'metric' => '6X',
                'metric_label' => 'ARR',
                'client' => 'CloudCorp',
                'industry' => 'Fintech',
                'title' => 'Accelerating ARR by 6X with Cloud Services',
                'theme' => 'bg-[#111827]',
            ],
            [
                'metric' => '4.2X',
                'metric_label' => 'ROI',
                'client' => 'SwiftLogistics',
                'industry' => 'Logistics',
                'title' => 'Optimizing Supply Chain for 4.2X ROI',
                'theme' => 'bg-[#0f172a]',
            ],
            [
                'metric' => '120k',
                'metric_label' => 'Users Added',
                'client' => 'Zenith Corp',
                'industry' => 'SaaS',
                'title' => 'Scaling to 120k Active Users in 6 Months',
                'theme' => 'bg-slate-800',
            ],
            [
                'metric' => '98%',
                'metric_label' => 'Satisfaction',
                'client' => 'NexGen SaaS',
                'industry' => 'Software',
                'title' => 'Boosting Customer Satisfaction to 98%',
                'theme' => 'bg-gray-900',
            ],
            [
                'metric' => '1.3X',
                'metric_label' => 'Conversion',
                'client' => 'PeakPerformance',
                'industry' => 'Retail',
                'title' => 'Increasing Conversion Rates by 1.3X',
                'theme' => 'bg-slate-900',
            ],
        ];
    @endphp

    <div class="max-w-7xl mx-auto px-5 lg:px-12">
        {{-- =========================================================
             MOBILE ONLY: Compact Split-Cards (Left Metric + Right Info)
             ========================================================= --}}
        <div class="md:hidden space-y-3.5">
            @foreach($demoCaseStudies as $index => $caseStudy)
            <a href="{{ url('/case-studies') }}" class="flex bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden hover:border-[#4fd1c5] transition-all duration-300 group p-3 gap-3.5 items-center">
                
                {{-- Left Metric / Image Area --}}
                <div class="{{ $caseStudy['theme'] }} w-24 h-24 sm:w-28 sm:h-28 rounded-xl flex-shrink-0 flex flex-col items-center justify-center relative overflow-hidden text-center p-2">
                    <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiLz48L3N2Zz4=')]"></div>
                    <span class="text-2xl sm:text-3xl font-black text-[#4fd1c5] tracking-tight leading-none mb-1 relative z-10">{{ $caseStudy['metric'] }}</span>
                    <span class="text-[10px] font-bold text-white uppercase tracking-wider leading-tight relative z-10">{{ $caseStudy['metric_label'] }}</span>
                </div>

                {{-- Right Content Area --}}
                <div class="flex flex-col justify-center flex-1 min-w-0 pr-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 uppercase tracking-wider">
                            {{ $caseStudy['industry'] }}
                        </span>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider truncate">
                            {{ $caseStudy['client'] }}
                        </span>
                    </div>

                    <h4 class="text-xs font-bold text-gray-900 leading-snug line-clamp-2 mb-2 group-hover:text-[#4fd1c5] transition-colors">
                        {{ $caseStudy['title'] }}
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
            @foreach($demoCaseStudies as $caseStudy)
            {{-- Uniform Case Study Card --}}
            <a href="{{ url('/case-studies') }}" class="flex flex-col bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group cursor-pointer">
                
                {{-- Top Metric Area --}}
                <div class="{{ $caseStudy['theme'] }} p-8 flex flex-col justify-end aspect-[4/3] relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiLz48L3N2Zz4=')]"></div>
                    
                    <div class="relative z-10">
                        <h3 class="text-6xl font-bold text-[#4fd1c5] mb-1 tracking-tighter">{{ $caseStudy['metric'] }}</h3>
                        <h4 class="text-2xl font-bold text-white uppercase tracking-tight">{{ $caseStudy['metric_label'] }}</h4>
                    </div>
                </div>

                {{-- Bottom Content Area --}}
                <div class="p-8 flex flex-col flex-1">
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full uppercase tracking-wider mb-3">
                            {{ $caseStudy['industry'] }}
                        </span>
                        <h5 class="text-sm font-bold text-gray-400 uppercase tracking-wider">{{ $caseStudy['client'] }}</h5>
                    </div>
                    
                    <p class="text-gray-900 font-bold text-lg mb-8 leading-snug flex-1">
                        {{ $caseStudy['title'] }}
                    </p>
                    
                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between group-hover:border-gray-200 transition-colors">
                        <span class="text-sm font-bold text-gray-900 group-hover:text-[#4fd1c5] transition-colors">Read Case Study</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-[#4fd1c5] group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- See More / View All Button --}}
        <div class="text-center mt-6 md:mt-16">
            <a href="{{ url('/case-studies') }}" class="inline-flex items-center justify-center gap-2 px-6 md:px-8 py-3 md:py-4 rounded-full border-2 border-gray-200 bg-white text-gray-700 text-xs md:text-sm font-bold hover:border-[#4fd1c5] hover:text-[#4fd1c5] hover:shadow-md transition-all duration-300">
                <span>See More Success Stories</span>
                <span class="text-base font-extrabold">→</span>
            </a>
        </div>
    </div>
</section>
