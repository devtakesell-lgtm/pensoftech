<section class="bg-[#050505] py-24 md:py-32 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 text-center mb-16 relative z-10">
        <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">
            The Tools of Transformation
        </h2>
        <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto">
            We combine best-in-class frameworks with emerging technologies to turn ambitious ideas into robust reality.
        </p>
    </div>

    {{-- CSS Marquee Definitions --}}
    <style>
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        @keyframes marquee-reverse {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0%); }
        }
        .animate-marquee {
            animation: marquee 40s linear infinite;
        }
        .animate-marquee-reverse {
            animation: marquee-reverse 40s linear infinite;
        }
        /* Pause on hover */
        .marquee-container:hover .animate-marquee,
        .marquee-container:hover .animate-marquee-reverse {
            animation-play-state: paused;
        }
        
        .tech-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* When hovering the container, dim all cards */
        .marquee-container:hover .tech-card {
            opacity: 0.3;
            transform: scale(0.95);
        }
        
        /* Highlight the specifically hovered card */
        .marquee-container .tech-card:hover {
            opacity: 1;
            transform: scale(1.1) translateY(-10px);
            z-index: 20;
            box-shadow: 0 0 40px rgba(118,85,255,0.4);
            border-color: rgba(118,85,255,0.6);
        }
    </style>

    <div class="relative w-full marquee-container" data-cursor-expand>
        {{-- Gradient Fades --}}
        <div class="absolute top-0 left-0 h-full w-32 bg-gradient-to-r from-[#050505] to-transparent z-10 pointer-events-none"></div>
        <div class="absolute top-0 right-0 h-full w-32 bg-gradient-to-l from-[#050505] to-transparent z-10 pointer-events-none"></div>

        @php
            $techs = [
                ['name' => 'Laravel', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg', 'desc' => 'Enterprise Backend'],
                ['name' => 'React', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg', 'desc' => 'Dynamic Interfaces'],
                ['name' => 'Tailwind', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/tailwindcss/tailwindcss-original.svg', 'desc' => 'Utility CSS'],
                ['name' => 'Python', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg', 'desc' => 'AI & Data Science'],
                ['name' => 'Next.js', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nextjs/nextjs-original.svg', 'desc' => 'Fullstack React'],
                ['name' => 'PostgreSQL', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg', 'desc' => 'Relational Database'],
                ['name' => 'AWS', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/amazonwebservices/amazonwebservices-original-wordmark.svg', 'desc' => 'Cloud Infrastructure'],
                ['name' => 'Docker', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/docker/docker-original.svg', 'desc' => 'Containerization'],
            ];
            // Double the array for seamless scrolling
            $scrollingTechs = array_merge($techs, $techs);
        @endphp

        {{-- Row 1: Left to Right --}}
        <div class="flex w-[200%] animate-marquee mb-8">
            @foreach($scrollingTechs as $tech)
            <div class="w-1/2 flex-none px-4" style="width: 250px;">
                <div class="tech-card h-full bg-[#111] border border-white/10 rounded-2xl p-6 cursor-crosshair">
                    <div class="w-12 h-12 bg-white/5 rounded-full p-2 mb-4 flex items-center justify-center">
                        <img src="{{ $tech['icon'] }}" alt="{{ $tech['name'] }}" class="w-full h-full object-contain" loading="lazy" />
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">{{ $tech['name'] }}</h3>
                    <p class="text-sm text-gray-500">{{ $tech['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Row 2: Right to Left --}}
        <div class="flex w-[200%] animate-marquee-reverse">
            @foreach(array_reverse($scrollingTechs) as $tech)
            <div class="w-1/2 flex-none px-4" style="width: 250px;">
                <div class="tech-card h-full bg-[#111] border border-white/10 rounded-2xl p-6 cursor-crosshair">
                    <div class="w-12 h-12 bg-white/5 rounded-full p-2 mb-4 flex items-center justify-center">
                        <img src="{{ $tech['icon'] }}" alt="{{ $tech['name'] }}" class="w-full h-full object-contain" loading="lazy" />
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">{{ $tech['name'] }}</h3>
                    <p class="text-sm text-gray-500">{{ $tech['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
