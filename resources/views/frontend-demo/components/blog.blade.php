<section class="bg-[#f9fafb] py-24 md:py-32 overflow-hidden border-t border-gray-100 relative">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 mb-16 text-center">
        <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-sm mb-4 block">Thought Leadership</span>
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
            Latest Insights
        </h2>
        <p class="text-gray-500 mt-6 max-w-2xl mx-auto text-lg">
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

    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
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
                        <div class="text-[#4fd1c5] group-hover:translate-x-1 transition-transform duration-300 flex items-center gap-1">
                            Read More <span class="text-lg leading-none">&rarr;</span>
                        </div>
                    </div>
                </div>

            </article>
            @endforeach

        </div>

        <div class="text-center mt-16">
            <a href="#" class="inline-flex items-center justify-center px-8 py-4 rounded-full border border-gray-200 bg-white text-gray-700 font-bold hover:border-[#4fd1c5] hover:text-[#4fd1c5] shadow-sm hover:shadow-md transition-all duration-300">
                Browse All Articles
            </a>
        </div>
    </div>
</section>
