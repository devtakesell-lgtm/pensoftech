<section class="bg-gray-50 py-10 md:py-24">
    <div class="max-w-7xl mx-auto px-5 lg:px-12" x-data="{ activeTab: 'web-development', mobileAccordion: 'web-development' }">
        
        <div class="text-center mb-6 md:mb-10">
            <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs md:text-sm mb-1.5 md:mb-3 block">Our Expertise</span>
            <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">
                Our Services
            </h2>
            <p class="text-gray-500 mt-2 max-w-xl mx-auto text-xs md:text-base leading-relaxed">
                We deliver scalable, world-class technology solutions tailored to your business needs.
            </p>
        </div>

        {{-- =========================================================
             MOBILE ONLY: Option C (Collapsible Category Accordions)
             ========================================================= --}}
        <div class="md:hidden space-y-3.5">
            
            @foreach($serviceCategories as $category)
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden transition-all duration-300">
                <button @click="mobileAccordion = (mobileAccordion === '{{ $category->slug }}' ? null : '{{ $category->slug }}')" 
                        class="w-full flex items-center justify-between p-4 text-left font-bold text-gray-900 bg-white transition-colors"
                        :class="mobileAccordion === '{{ $category->slug }}' ? 'border-b border-gray-100' : ''">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-[#4fd1c5]/10 text-[#4fd1c5] flex items-center justify-center text-base">{{ $category->icon ?? '✨' }}</span>
                        <span class="text-sm font-extrabold">{{ $category->name }}</span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">{{ $category->services->count() }} Services</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-300" 
                         :class="mobileAccordion === '{{ $category->slug }}' ? 'rotate-180 text-[#4fd1c5]' : ''" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div x-show="mobileAccordion === '{{ $category->slug }}'" 
                     x-collapse
                     class="p-3.5 bg-gray-50/50 space-y-3"
                     style="display: none;">
                    
                    @foreach($category->services as $service)
                    <div class="bg-white rounded-xl p-3.5 border border-gray-100 shadow-sm">
                        <div class="flex items-start justify-between gap-3 mb-1.5">
                            <h4 class="text-sm font-bold text-gray-900">{{ $service->icon ?? '✨' }} {{ $service->name }}</h4>
                            <a href="{{ route('services.single', [$category->slug, $service->slug]) }}" class="text-[#4fd1c5] font-bold text-sm">→</a>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ Str::limit($service->short_description, 80) }}</p>
                    </div>
                    @endforeach

                </div>
            </div>
            @endforeach

        </div>

        {{-- =========================================================
             DESKTOP ONLY: Standard Tab & Multi-Column Grid
             ========================================================= --}}
        <div class="hidden md:block">
            {{-- Category Tabs (Desktop) --}}
            <div class="flex flex-wrap justify-center gap-3 mb-10">
                @foreach($serviceCategories as $category)
                <button @click="activeTab = '{{ $category->slug }}'" 
                        :class="activeTab === '{{ $category->slug }}' ? 'bg-[#4fd1c5] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                        class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300">
                    {{ $category->icon ?? '✨' }} {{ $category->name }}
                </button>
                @endforeach
            </div>

            {{-- Service Grids (Desktop) --}}
            <div class="relative min-h-[350px]">
                
                @foreach($serviceCategories as $category)
                <div x-show="activeTab === '{{ $category->slug }}'" x-cloak
                     x-transition:enter="transition ease-out duration-500 delay-100"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-300 absolute top-0 left-0 w-full"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="grid grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    @foreach($category->services as $service)
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-[#4fd1c5]/10 flex items-center justify-center mb-6 text-[#4fd1c5] text-2xl group-hover:scale-110 transition-transform duration-300">
                            {{ $service->icon ?? '✨' }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $service->name }}</h3>
                        <p class="text-gray-500 mb-6 leading-relaxed">{{ Str::limit($service->short_description, 120) }}</p>
                        <a href="{{ route('services.single', [$category->slug, $service->slug]) }}" class="text-[#4fd1c5] font-semibold inline-flex items-center gap-1.5 group-hover:gap-2.5 transition-all">
                            Learn More <span class="text-lg">→</span>
                        </a>
                    </div>
                    @endforeach
                    
                </div>
                @endforeach

            </div>
        </div>

    </div>
</section>
