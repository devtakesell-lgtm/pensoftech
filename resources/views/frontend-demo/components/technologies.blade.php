<section class="bg-[#0a0a0a] py-12 md:py-16 border-t border-b border-white/10 overflow-hidden relative">
    {{-- Eyebrow matching other sections --}}
    <div class="max-w-7xl mx-auto px-6 mb-8 text-center">
        <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-sm block">Technologies We Master</span>
    </div>

    {{-- Seamless Infinite Marquee --}}
    <style>
        .tech-marquee-container {
            display: flex;
            overflow: hidden;
            user-select: none;
            position: relative;
            width: 100%;
            padding: 16px 0; /* Ensures scaled borders never get clipped */
        }

        .tech-marquee-content {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: space-around;
            min-width: 100%;
            gap: 2rem;
            padding: 4px 0;
            animation: techScroll 25s linear infinite;
        }

        @media (min-width: 768px) {
            .tech-marquee-content {
                gap: 3.5rem;
                animation-duration: 30s;
            }
        }

        .tech-marquee-container:hover .tech-marquee-content {
            animation-play-state: paused;
        }

        @keyframes techScroll {
            from { transform: translateX(0); }
            to { transform: translateX(calc(-100% - 2rem)); }
        }

        @media (min-width: 768px) {
            @keyframes techScroll {
                from { transform: translateX(0); }
                to { transform: translateX(calc(-100% - 3.5rem)); }
            }
        }

        .tech-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .tech-item:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: #4fd1c5;
            box-shadow: 0 0 16px rgba(79, 209, 197, 0.35);
            transform: translateY(-2px) scale(1.05);
        }
        .tech-item:last-child {
            margin-right: 3rem;
        }   

        .tech-item svg {
            width: 28px;
            height: 28px;
            flex-shrink: 0;
        }

        @media (min-width: 768px) {
            .tech-item svg {
                width: 32px;
                height: 32px;
            }
        }
    </style>

    <div class="relative w-full overflow-hidden flex">
        {{-- Side fade gradient masks --}}
        <div class="absolute inset-y-0 left-0 w-16 md:w-32 bg-gradient-to-r from-[#0a0a0a] via-[#0a0a0a]/80 to-transparent z-10 pointer-events-none"></div>
        <div class="absolute inset-y-0 right-0 w-16 md:w-32 bg-gradient-to-l from-[#0a0a0a] via-[#0a0a0a]/80 to-transparent z-10 pointer-events-none"></div>

        <div class="tech-marquee-container">
            {{-- Track 1 --}}
            <div class="tech-marquee-content">
                {{-- React --}}
                <div class="tech-item">
                    <svg viewBox="-11.5 -10.23174 23 20.46348">
                        <circle cx="0" cy="0" r="2.05" fill="#61dafb"/>
                        <g stroke="#61dafb" stroke-width="1" fill="none">
                            <ellipse rx="11" ry="4.2"/>
                            <ellipse rx="11" ry="4.2" transform="rotate(60)"/>
                            <ellipse rx="11" ry="4.2" transform="rotate(120)"/>
                        </g>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">React</span>
                </div>

                {{-- Laravel --}}
                <div class="tech-item">
                    <svg viewBox="0 0 700 700">
                        <path fill="#FF2D20" d="M350,50 L610,200 L610,500 L350,650 L90,500 L90,200 Z" opacity="0.1"/>
                        <path fill="#FF2D20" d="M350 120 L550 235 L550 465 L350 580 L150 465 L150 235 Z"/>
                        <path fill="#ffffff" d="M350 200 L470 270 L470 410 L350 480 L230 410 L230 270 Z"/>
                        <path fill="#FF2D20" d="M350 240 L430 286 L430 380 L350 426 L270 380 L270 286 Z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Laravel</span>
                </div>

                {{-- Python --}}
                <div class="tech-item">
                    <svg viewBox="0 0 110 110">
                        <path fill="#3776AB" d="M54.5 5.5c-24.3 0-22.8 10.5-22.8 10.5l.02 10.9h23.2v3.3H22.5S5.5 28.2 5.5 52.4c0 24.3 14.8 23.4 14.8 23.4h8.8v-12.4s-.5-14.8 14.6-14.8h22.6s14.1.2 14.1-13.7V19.6S81.9 5.5 54.5 5.5zm-12.7 7.4a4.1 4.1 0 1 1 0 8.2 4.1 4.1 0 0 1 0-8.2z"/>
                        <path fill="#FFD438" d="M55.5 104.5c24.3 0 22.8-10.5 22.8-10.5l-.02-10.9H55.1v-3.3h32.4s17 2 17-22.2c0-24.3-14.8-23.4-14.8-23.4h-8.8v12.4s.5 14.8-14.6 14.8H43.7s-14.1-.2-14.1 13.7v15.3s-1.5 14.1 25.9 14.1zm12.7-7.4a4.1 4.1 0 1 1 0-8.2 4.1 4.1 0 0 1 0 8.2z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Python</span>
                </div>

                {{-- Node.js --}}
                <div class="tech-item">
                    <svg viewBox="0 0 256 289">
                        <path fill="#539E43" d="M128 0L0 74v148l128 74 128-74V74L128 0zm0 33l99 57v115l-99 57-99-57V90l99-57z"/>
                        <path fill="#539E43" d="M128 50l75 43v87l-75 43-75-43V93l75-43z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Node.js</span>
                </div>

                {{-- TypeScript --}}
                <div class="tech-item">
                    <svg viewBox="0 0 128 128">
                        <rect width="128" height="128" rx="16" fill="#3178C6"/>
                        <path fill="#ffffff" d="M72.2 89.2c2.1 3.2 5.5 5.2 9.7 5.2 5.3 0 8.8-2.7 8.8-6.6 0-4.3-3.4-5.9-9.5-8.5-8.9-3.8-14.7-8.1-14.7-17.7 0-9.7 7.7-17.1 19.3-17.1 7.7 0 13.2 2.7 17.2 9.1l-7.7 4.9c-2.3-3.8-5.3-5.2-9.4-5.2-5.1 0-8.1 2.8-8.1 6.1 0 4 3 5.4 9 7.9 9.9 4.2 15.3 8.6 15.3 18.2 0 11.2-8.6 17.9-20.7 17.9-9.7 0-16.7-3.7-20.3-10.6l8.1-3.6zM26.4 55.8h37.4v9.6H46.7v36.8H35.4V65.4H26.4v-9.6z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">TypeScript</span>
                </div>

                {{-- Flutter --}}
                <div class="tech-item">
                    <svg viewBox="0 0 166 202">
                        <path fill="#47C5FB" d="M100.8 0L0 100.8l31.2 31.2L163.2 0z"/>
                        <path fill="#02569B" d="M100.8 132.8L69.6 164l31.2 31.2 62.4-62.4H100.8z"/>
                        <path fill="#0175C2" d="M52.8 147.2l31.2-31.2 31.2 31.2-31.2 31.2z"/>
                        <path fill="#00B4AB" d="M115.2 84.8L62.4 137.6l38.4 38.4 62.4-62.4z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Flutter</span>
                </div>

                {{-- Docker --}}
                <div class="tech-item">
                    <svg viewBox="0 0 24 24">
                        <path fill="#2496ED" d="M13.983 11.078h2.119a.186.186 0 00.186-.185V9.006a.186.186 0 00-.186-.186h-2.119a.185.185 0 00-.185.186v1.887c0 .102.083.185.185.185zm-2.954-5.43h2.118a.186.186 0 00.186-.186V3.574a.186.186 0 00-.186-.185h-2.118a.185.185 0 00-.185.185v1.888c0 .102.082.185.185.185zm0 2.716h2.118a.187.187 0 00.186-.186V6.29a.186.186 0 00-.186-.185h-2.118a.185.185 0 00-.185.185v1.887c0 .102.082.186.185.186zm-2.93 0h2.12a.186.186 0 00.184-.186V6.29a.185.185 0 00-.185-.185H8.1a.185.185 0 00-.185.185v1.887c0 .102.083.186.185.186zm-2.964 0h2.119a.186.186 0 00.185-.186V6.29a.185.185 0 00-.185-.185H5.136a.186.186 0 00-.186.185v1.887c0 .102.084.186.186.186zm5.893 2.715h2.119a.186.186 0 00.186-.185V9.006a.186.186 0 00-.186-.186h-2.119a.185.185 0 00-.185.186v1.887c0 .102.082.185.185.185zm-2.93 0h2.12a.185.185 0 00.184-.185V9.006a.185.185 0 00-.184-.186h-2.12a.185.185 0 00-.184.186v1.887c0 .102.083.185.185.185zm-2.964 0h2.119a.185.185 0 00.185-.185V9.006a.185.185 0 00-.185-.186h-2.119a.186.186 0 00-.186.186v1.887c0 .102.084.185.186.185zm-2.92 0h2.12a.185.185 0 00.184-.185V9.006a.185.185 0 00-.184-.186h-2.12a.185.185 0 00-.184.186v1.887c0 .102.082.185.185.185zM23.77 12.33c-.37-.775-1.574-.95-2.288-.737-.09-.283-.243-.53-.448-.735-.783-.78-2.023-.687-2.673.125-.97-.565-2.164-.53-3.13.064-.24.148-.44.33-.61.532H1.002a.85.85 0 00-.85.85c0 1.942.348 3.864 1.026 5.666.868 2.302 2.373 4.142 4.35 5.32 2.12 1.264 4.593 1.886 7.046 1.77 4.962-.234 9.387-2.968 11.45-7.46.305-.662.39-1.397.246-2.11-.1-.497-.36-.934-.73-1.285z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Docker</span>
                </div>

                {{-- Vue.js --}}
                <div class="tech-item">
                    <svg viewBox="0 0 261 226">
                        <path fill="#42b883" d="M161.096.001l-30.625 53.042L99.846.001H0l130.471 226L260.942 0z"/>
                        <path fill="#35495e" d="M161.096.001l-30.625 53.042L99.846.001H52.246l78.225 135.49L208.696.001z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Vue.js</span>
                </div>

                {{-- Tailwind CSS --}}
                <div class="tech-item">
                    <svg viewBox="0 0 48 48">
                        <path fill="#06B6D4" d="M24 10c-6.627 0-10.828 3.314-12.604 9.941 2.651-3.313 5.745-4.556 9.284-3.727 2.02.473 3.463 1.94 5.06 3.562C28.344 22.42 31.428 25.556 38 25.556c6.627 0 10.828-3.314 12.604-9.942-2.651 3.314-5.745 4.557-9.284 3.728-2.02-.473-3.463-1.94-5.06-3.562C33.656 13.136 30.572 10 24 10zM10 24.556C3.373 24.556-.828 27.87-2.604 34.497c2.651-3.314 5.745-4.557 9.284-3.728 2.02.473 3.463 1.94 5.06 3.562C14.344 36.976 17.428 40.112 24 40.112c6.627 0 10.828-3.314 12.604-9.942-2.651 3.314-5.745 4.557-9.284 3.728-2.02-.473-3.463-1.94-5.06-3.562C19.656 27.692 16.572 24.556 10 24.556z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Tailwind CSS</span>
                </div>
            </div>

            {{-- Track 2 (Duplicate for smooth infinite marquee) --}}
            <div class="tech-marquee-content" aria-hidden="true">
                {{-- React --}}
                <div class="tech-item">
                    <svg viewBox="-11.5 -10.23174 23 20.46348">
                        <circle cx="0" cy="0" r="2.05" fill="#61dafb"/>
                        <g stroke="#61dafb" stroke-width="1" fill="none">
                            <ellipse rx="11" ry="4.2"/>
                            <ellipse rx="11" ry="4.2" transform="rotate(60)"/>
                            <ellipse rx="11" ry="4.2" transform="rotate(120)"/>
                        </g>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">React</span>
                </div>

                {{-- Laravel --}}
                <div class="tech-item">
                    <svg viewBox="0 0 700 700">
                        <path fill="#FF2D20" d="M350,50 L610,200 L610,500 L350,650 L90,500 L90,200 Z" opacity="0.1"/>
                        <path fill="#FF2D20" d="M350 120 L550 235 L550 465 L350 580 L150 465 L150 235 Z"/>
                        <path fill="#ffffff" d="M350 200 L470 270 L470 410 L350 480 L230 410 L230 270 Z"/>
                        <path fill="#FF2D20" d="M350 240 L430 286 L430 380 L350 426 L270 380 L270 286 Z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Laravel</span>
                </div>

                {{-- Python --}}
                <div class="tech-item">
                    <svg viewBox="0 0 110 110">
                        <path fill="#3776AB" d="M54.5 5.5c-24.3 0-22.8 10.5-22.8 10.5l.02 10.9h23.2v3.3H22.5S5.5 28.2 5.5 52.4c0 24.3 14.8 23.4 14.8 23.4h8.8v-12.4s-.5-14.8 14.6-14.8h22.6s14.1.2 14.1-13.7V19.6S81.9 5.5 54.5 5.5zm-12.7 7.4a4.1 4.1 0 1 1 0 8.2 4.1 4.1 0 0 1 0-8.2z"/>
                        <path fill="#FFD438" d="M55.5 104.5c24.3 0 22.8-10.5 22.8-10.5l-.02-10.9H55.1v-3.3h32.4s17 2 17-22.2c0-24.3-14.8-23.4-14.8-23.4h-8.8v12.4s.5 14.8-14.6 14.8H43.7s-14.1-.2-14.1 13.7v15.3s-1.5 14.1 25.9 14.1zm12.7-7.4a4.1 4.1 0 1 1 0-8.2 4.1 4.1 0 0 1 0 8.2z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Python</span>
                </div>

                {{-- Node.js --}}
                <div class="tech-item">
                    <svg viewBox="0 0 256 289">
                        <path fill="#539E43" d="M128 0L0 74v148l128 74 128-74V74L128 0zm0 33l99 57v115l-99 57-99-57V90l99-57z"/>
                        <path fill="#539E43" d="M128 50l75 43v87l-75 43-75-43V93l75-43z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Node.js</span>
                </div>

                {{-- TypeScript --}}
                <div class="tech-item">
                    <svg viewBox="0 0 128 128">
                        <rect width="128" height="128" rx="16" fill="#3178C6"/>
                        <path fill="#ffffff" d="M72.2 89.2c2.1 3.2 5.5 5.2 9.7 5.2 5.3 0 8.8-2.7 8.8-6.6 0-4.3-3.4-5.9-9.5-8.5-8.9-3.8-14.7-8.1-14.7-17.7 0-9.7 7.7-17.1 19.3-17.1 7.7 0 13.2 2.7 17.2 9.1l-7.7 4.9c-2.3-3.8-5.3-5.2-9.4-5.2-5.1 0-8.1 2.8-8.1 6.1 0 4 3 5.4 9 7.9 9.9 4.2 15.3 8.6 15.3 18.2 0 11.2-8.6 17.9-20.7 17.9-9.7 0-16.7-3.7-20.3-10.6l8.1-3.6zM26.4 55.8h37.4v9.6H46.7v36.8H35.4V65.4H26.4v-9.6z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">TypeScript</span>
                </div>

                {{-- Flutter --}}
                <div class="tech-item">
                    <svg viewBox="0 0 166 202">
                        <path fill="#47C5FB" d="M100.8 0L0 100.8l31.2 31.2L163.2 0z"/>
                        <path fill="#02569B" d="M100.8 132.8L69.6 164l31.2 31.2 62.4-62.4H100.8z"/>
                        <path fill="#0175C2" d="M52.8 147.2l31.2-31.2 31.2 31.2-31.2 31.2z"/>
                        <path fill="#00B4AB" d="M115.2 84.8L62.4 137.6l38.4 38.4 62.4-62.4z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Flutter</span>
                </div>

                {{-- Docker --}}
                <div class="tech-item">
                    <svg viewBox="0 0 24 24">
                        <path fill="#2496ED" d="M13.983 11.078h2.119a.186.186 0 00.186-.185V9.006a.186.186 0 00-.186-.186h-2.119a.185.185 0 00-.185.186v1.887c0 .102.083.185.185.185zm-2.954-5.43h2.118a.186.186 0 00.186-.186V3.574a.186.186 0 00-.186-.185h-2.118a.185.185 0 00-.185.185v1.888c0 .102.082.185.185.185zm0 2.716h2.118a.187.187 0 00.186-.186V6.29a.186.186 0 00-.186-.185h-2.118a.185.185 0 00-.185.185v1.887c0 .102.082.186.185.186zm-2.93 0h2.12a.186.186 0 00.184-.186V6.29a.185.185 0 00-.185-.185H8.1a.185.185 0 00-.185.185v1.887c0 .102.083.186.185.186zm-2.964 0h2.119a.186.186 0 00.185-.186V6.29a.185.185 0 00-.185-.185H5.136a.186.186 0 00-.186.185v1.887c0 .102.084.186.186.186zm5.893 2.715h2.119a.186.186 0 00.186-.185V9.006a.186.186 0 00-.186-.186h-2.119a.185.185 0 00-.185.186v1.887c0 .102.082.185.185.185zm-2.93 0h2.12a.185.185 0 00.184-.185V9.006a.185.185 0 00-.184-.186h-2.12a.185.185 0 00-.184.186v1.887c0 .102.083.185.185.185zm-2.964 0h2.119a.185.185 0 00.185-.185V9.006a.185.185 0 00-.185-.186h-2.119a.186.186 0 00-.186.186v1.887c0 .102.084.185.186.185zm-2.92 0h2.12a.185.185 0 00.184-.185V9.006a.185.185 0 00-.184-.186h-2.12a.185.185 0 00-.184.186v1.887c0 .102.082.185.185.185zM23.77 12.33c-.37-.775-1.574-.95-2.288-.737-.09-.283-.243-.53-.448-.735-.783-.78-2.023-.687-2.673.125-.97-.565-2.164-.53-3.13.064-.24.148-.44.33-.61.532H1.002a.85.85 0 00-.85.85c0 1.942.348 3.864 1.026 5.666.868 2.302 2.373 4.142 4.35 5.32 2.12 1.264 4.593 1.886 7.046 1.77 4.962-.234 9.387-2.968 11.45-7.46.305-.662.39-1.397.246-2.11-.1-.497-.36-.934-.73-1.285z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Docker</span>
                </div>

                {{-- Vue.js --}}
                <div class="tech-item">
                    <svg viewBox="0 0 261 226">
                        <path fill="#42b883" d="M161.096.001l-30.625 53.042L99.846.001H0l130.471 226L260.942 0z"/>
                        <path fill="#35495e" d="M161.096.001l-30.625 53.042L99.846.001H52.246l78.225 135.49L208.696.001z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Vue.js</span>
                </div>

                {{-- Tailwind CSS --}}
                <div class="tech-item">
                    <svg viewBox="0 0 48 48">
                        <path fill="#06B6D4" d="M24 10c-6.627 0-10.828 3.314-12.604 9.941 2.651-3.313 5.745-4.556 9.284-3.727 2.02.473 3.463 1.94 5.06 3.562C28.344 22.42 31.428 25.556 38 25.556c6.627 0 10.828-3.314 12.604-9.942-2.651 3.314-5.745 4.557-9.284 3.728-2.02-.473-3.463-1.94-5.06-3.562C33.656 13.136 30.572 10 24 10zM10 24.556C3.373 24.556-.828 27.87-2.604 34.497c2.651-3.314 5.745-4.557 9.284-3.728 2.02.473 3.463 1.94 5.06 3.562C14.344 36.976 17.428 40.112 24 40.112c6.627 0 10.828-3.314 12.604-9.942-2.651 3.314-5.745 4.557-9.284 3.728-2.02-.473-3.463-1.94-5.06-3.562C19.656 27.692 16.572 24.556 10 24.556z"/>
                    </svg>
                    <span class="text-white font-semibold text-xs md:text-sm">Tailwind CSS</span>
                </div>
            </div>
        </div>
    </div>
</section>
