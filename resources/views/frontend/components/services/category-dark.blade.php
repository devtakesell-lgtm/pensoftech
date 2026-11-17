<section class="py-14 lg:py-16 bg-[#0a0a0a] text-white relative z-20" id="{{ $category->slug ?? '' }}">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <div class="order-2 lg:order-1 relative" data-aos="fade-right">
                <div class="h-[260px] sm:h-[320px] lg:h-[360px] w-full rounded-2xl md:rounded-3xl overflow-hidden bg-gray-900 shadow-[0_0_40px_rgba(79,209,197,0.12)] border border-white/10 relative">
                    <img src="{{ $category->image ? asset('storage/' . $category->image) : 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80' }}" alt="{{ $category->name }}" class="w-full h-full object-cover opacity-90 transition-all duration-700">
                </div>
            </div>
            <div class="order-1 lg:order-2" data-aos="fade-left">
                <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs mb-3 block">{{ str_pad($index, 2, '0', STR_PAD_LEFT) }} / {{ $category->name }}</span>
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-4">{{ $category->name }}</h2>
                <p class="text-gray-400 text-base md:text-lg mb-6 leading-relaxed">
                    {{ $category->description ?? $category->short_description }}
                </p>
                
                @if(isset($category->services) && $category->services->count() > 0)
                <ul class="space-y-3 mb-8">
                    @foreach($category->services as $service)
                    <li class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded-full bg-[#4fd1c5] text-black flex items-center justify-center shrink-0 text-xs font-bold">✓</div>
                        <span class="font-semibold text-gray-200 text-sm md:text-base">{{ $service->name }}</span>
                    </li>
                    @endforeach
                </ul>
                @endif

                <a href="{{ route('services.category', $category->slug) }}" class="inline-flex items-center justify-center bg-white text-black px-7 py-3.5 rounded-full font-bold hover:bg-[#4fd1c5] transition-all duration-300 group shadow-sm">
                    <span>Learn More</span>
                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</section>
