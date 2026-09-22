<section class="bg-[#f9fafb] py-10 md:py-24 overflow-hidden border-t border-gray-100 relative">
    <div class="max-w-7xl mx-auto px-5 lg:px-12 mb-6 md:mb-12 text-center">
        <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs md:text-sm mb-1.5 md:mb-3 block">Thought Leadership</span>
        <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">
            Latest Insights
        </h2>
        <p class="text-gray-500 mt-2 max-w-xl mx-auto text-xs md:text-base leading-relaxed">
            Exploring the intersection of SaaS growth, strategy, and innovation.
        </p>
    </div>

    @php
        $articles = [
            [
                'category' => 'SaaS Strategy',
                'title' => 'Scaling ARR: The 2025 Blueprint for B2B SaaS Growth',
                'desc' => 'Discover the core strategies and operational shifts required to predictably scale your annual recurring revenue in a competitive market.',
                'read_time' => '7 min read',
                'date' => 'Published Oct 12, 2025',
                'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'category' => 'Product Design',
                'title' => 'Maximizing Retention: The New User Onboarding Paradigm',
                'desc' => 'Why traditional onboarding is dead, and how data-driven, personalized product tours are driving unprecedented user retention.',
                'read_time' => '5 min read',
                'date' => 'Published Sep 28, 2025',
                'img' => 'https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&q=80&w=800'
            ],
            [
                'category' => 'Artificial Intelligence',
                'title' => 'Leveraging AI: Optimizing Customer Success in SaaS',
                'desc' => 'How leading enterprise platforms are using predictive AI models to identify churn risks and automate proactive customer success.',
                'read_time' => '8 min read',
                'date' => 'Published Sep 15, 2025',
                'img' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=800'
            ]
        ];
    @endphp

    <div class="max-w-7xl mx-auto px-5 lg:px-12">
        
        {{-- =========================================================
             MOBILE ONLY: Concept 1 (Modern Magazine List Cards)
             ========================================================= --}}
        <div class="md:hidden space-y-3.5">
            @foreach($articles as $article)
            <article class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden p-3.5 flex gap-3.5 items-center hover:border-[#4fd1c5] transition-all duration-300 group cursor-pointer">
                
                {{-- Left: Text / Content Info --}}
                <div class="flex flex-col justify-between flex-1 min-w-0 pr-1">
                    <div>
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="inline-block px-2 py-0.5 bg-[#4fd1c5]/10 text-[#2c988e] text-[9px] font-bold rounded-full uppercase tracking-wider">
                                {{ $article['category'] }}
                            </span>
                            <span class="text-[10px] font-medium text-gray-400">
                                {{ $article['read_time'] }}
                            </span>
                        </div>

                        <h3 class="text-xs font-extrabold text-gray-900 leading-snug line-clamp-2 group-hover:text-[#4fd1c5] transition-colors mb-2">
                            {{ $article['title'] }}
                        </h3>
                    </div>

                    <div class="flex items-center gap-1 text-[11px] font-bold text-[#4fd1c5]">
                        <span>Read Article</span>
                        <span class="text-sm transition-transform group-hover:translate-x-1">→</span>
                    </div>
                </div>

                {{-- Right: Rounded Thumbnail Image --}}
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-xl overflow-hidden flex-shrink-0 relative bg-gray-100 shadow-inner">
                    <img src="{{ $article['img'] }}" alt="{{ $article['title'] }}" class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110">
                </div>

            </article>
            @endforeach
        </div>

        {{-- =========================================================
             DESKTOP ONLY: Standard 3-Column Visual Grid
             ========================================================= --}}
        <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @foreach($articles as $article)
            <article class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.1)] transition-all duration-300 group flex flex-col h-full cursor-pointer">
                
                {{-- Image Container --}}
                <div class="relative w-full aspect-[16/10] overflow-hidden">
                    <img src="{{ $article['img'] }}" alt="{{ $article['title'] }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                    
                    {{-- Badge --}}
                    <div class="absolute top-4 left-4">
                        <span class="inline-block px-3 py-1 bg-white/90 backdrop-blur-sm rounded-full text-[#4fd1c5] text-xs font-bold uppercase tracking-wider shadow-sm">
                            {{ $article['category'] }}
                        </span>
                    </div>
                </div>

                {{-- Content Container --}}
                <div class="p-8 flex flex-col flex-grow">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-[#4fd1c5] transition-colors duration-300 leading-snug">
                        {{ $article['title'] }}
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-8 flex-grow">
                        {{ $article['desc'] }}
                    </p>
                    
                    {{-- Footer --}}
                    <div class="flex items-center justify-between text-xs font-medium text-gray-400 border-t border-gray-100 pt-6 mt-auto">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $article['read_time'] }}
                        </div>
                        <div class="text-[#4fd1c5] group-hover:translate-x-1 transition-transform duration-300 flex items-center gap-1 font-bold">
                            Read More <span class="text-lg leading-none">&rarr;</span>
                        </div>
                    </div>
                </div>

            </article>
            @endforeach

        </div>

        {{-- Browse All Button --}}
        <div class="text-center mt-8 md:mt-16">
            <a href="{{ url('/blog') }}" class="inline-flex items-center justify-center gap-2 px-6 md:px-8 py-3 md:py-4 rounded-full border-2 border-gray-200 bg-white text-gray-700 text-xs md:text-sm font-bold hover:border-[#4fd1c5] hover:text-[#4fd1c5] shadow-sm hover:shadow-md transition-all duration-300">
                <span>Browse All Articles</span>
                <span class="text-base font-extrabold">→</span>
            </a>
        </div>
    </div>
</section>
