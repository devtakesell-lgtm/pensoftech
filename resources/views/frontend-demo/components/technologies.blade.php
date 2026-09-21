<section class="bg-white py-16 border-t border-gray-100 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 mb-8 text-center">
        <span class="text-gray-400 font-semibold tracking-widest uppercase text-sm">Technologies We Master</span>
    </div>

    {{-- CSS Marquee --}}
    <style>
        .tech-marquee-wrapper {
            display: flex;
            width: 200%;
            animation: marquee 30s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .tech-marquee-item {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 150px;
            height: 60px;
            margin: 0 2rem;
            filter: grayscale(100%) opacity(50%);
            transition: all 0.3s ease;
        }
        .tech-marquee-item:hover {
            filter: grayscale(0%) opacity(100%);
        }
        .tech-marquee-item img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>

    <div class="relative w-full overflow-hidden">
        {{-- Fade gradients for edges --}}
        <div class="absolute inset-y-0 left-0 w-24 bg-gradient-to-r from-white to-transparent z-10"></div>
        <div class="absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-white to-transparent z-10"></div>

        <div class="tech-marquee-wrapper">
            @php
                $logos = [
                    'https://upload.wikimedia.org/wikipedia/commons/a/a7/React-icon.svg', // React
                    'https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg', // Laravel
                    'https://upload.wikimedia.org/wikipedia/commons/9/93/Amazon_Web_Services_Logo.svg', // AWS
                    'https://upload.wikimedia.org/wikipedia/commons/c/c3/Python-logo-notext.svg', // Python
                    'https://upload.wikimedia.org/wikipedia/commons/d/d9/Node.js_logo.svg', // Node
                    'https://upload.wikimedia.org/wikipedia/commons/1/17/Google-flutter-logo.png', // Flutter
                    'https://upload.wikimedia.org/wikipedia/commons/0/0a/MySQL_textlogo.svg', // MySQL
                    'https://upload.wikimedia.org/wikipedia/commons/e/e3/Amazon_Web_Services_Logo.svg', // AWS
                ];
            @endphp

            {{-- First Set --}}
            @foreach($logos as $logo)
                <div class="tech-marquee-item">
                    <img src="{{ $logo }}" alt="Tech Logo" loading="lazy">
                </div>
            @endforeach

            {{-- Second Set (Duplicate for infinite loop) --}}
            @foreach($logos as $logo)
                <div class="tech-marquee-item">
                    <img src="{{ $logo }}" alt="Tech Logo" loading="lazy">
                </div>
            @endforeach
        </div>
    </div>
</section>
