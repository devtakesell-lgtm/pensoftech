<section id="ecosystem" class="relative bg-[#fafafa] text-[#10151A] py-10 md:py-16 lg:min-h-screen flex flex-col justify-center overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute inset-0" style="background-image: radial-gradient(rgba(0, 0, 0, 0.04) 1px, transparent 1px); background-size: 30px 30px;"></div>
    </div>

    {{-- Header --}}
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center mb-6 lg:mb-12">
        <span class="text-[#FF5A36] font-bold tracking-widest uppercase text-xs md:text-sm mb-1.5 md:mb-3 block">The Ecosystem</span>
        <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold tracking-tight">
            Engineered for <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-orange-500" style="background-image: linear-gradient(to right, #3B4FE0, #FF5A36); -webkit-background-clip: text; color: transparent;">Growth</span>
        </h2>
        <p class="text-gray-500 mt-2 max-w-xl mx-auto text-xs md:text-base leading-relaxed">
            A unified high-performance ecosystem where your software and marketing work together seamlessly.
        </p>
    </div>

    {{-- Desktop Layout (Network 100vh) --}}
    <div class="hidden lg:block relative w-full max-w-7xl mx-auto h-[600px] xl:h-[700px] z-10" id="network-container">
        
        {{-- SVG Canvas for connecting lines --}}
        <svg id="network-svg" class="absolute inset-0 w-full h-full pointer-events-none" style="z-index: 0;">
            {{-- We put DEFS in HTML so they render perfectly across all browsers --}}
            <defs>
                <linearGradient id="brandGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#3B4FE0" />
                    <stop offset="100%" stop-color="#FF5A36" />
                </linearGradient>
                <filter id="neonGlow" x="-20%" y="-20%" width="140%" height="140%">
                    <feGaussianBlur stdDeviation="6" result="blur" />
                    <feComposite in="SourceGraphic" in2="blur" operator="over" />
                </filter>
            </defs>
            {{-- A group for dynamic paths --}}
            <g id="network-paths"></g>
        </svg>

        {{-- Center Hub --}}
        <div id="hub-center" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-white border border-gray-200 rounded-full flex items-center justify-center shadow-[0_12px_40px_rgba(0,0,0,0.1)] z-20">
            <div class="w-16 h-16 relative flex items-center justify-center">
                <div class="absolute inset-0 rounded-full bg-[#3B4FE0] opacity-10 animate-ping"></div>
                @if(setting('company_logo'))
                    <img src="{{ asset(setting('company_logo')) }}" alt="Logo" class="w-14 h-14 object-contain relative z-10 rounded-lg">
                @else
                    <span class="text-5xl font-extrabold relative z-10" style="background-image: linear-gradient(to bottom right, #3B4FE0, #FF5A36); -webkit-background-clip: text; color: transparent;">{{ substr(setting('company_name', 'P'), 0, 1) }}</span>
                @endif
            </div>
        </div>

        {{-- Left Cards --}}
        @php
            $leftCards = $ecosystems->take(3);
            $rightCards = $ecosystems->skip(3)->take(3);
            $positionsL = [
                'top-[6%] xl:top-[12%] left-[12%] xl:left-[20%]',
                'top-[50%] -translate-y-1/2 left-[2%] xl:left-[8%]',
                'bottom-[6%] xl:bottom-[12%] left-[12%] xl:left-[20%]'
            ];
            $positionsR = [
                'top-[6%] xl:top-[12%] right-[12%] xl:right-[20%]',
                'top-[50%] -translate-y-1/2 right-[2%] xl:right-[8%]',
                'bottom-[6%] xl:bottom-[12%] right-[12%] xl:right-[20%]'
            ];
        @endphp

        @foreach($leftCards as $index => $eco)
        <div id='card-l{{ $index + 1 }}' class='network-card absolute {{ $positionsL[$index] ?? $positionsL[0] }} w-64 bg-white border-2 border-transparent rounded-2xl p-5 z-20 shadow-[0_8px_30px_rgba(0,0,0,0.08)]'>
            <svg class='absolute inset-0 w-full h-full pointer-events-none rounded-2xl' preserveAspectRatio='none'>
                <rect width='100%' height='100%' rx='16' fill='none' stroke='url(#brandGradient)' stroke-width='3' class='card-trace-path opacity-0' style='stroke-linecap: round;'></rect>
            </svg>
            <div class='relative z-10'>
                <div class='w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center mb-3 text-xl border border-gray-200'>{{ $eco->icon ?? '✨' }}</div>
                <h3 class='text-base font-bold mb-1 text-gray-900'>{{ $eco->name }}</h3>
                <p class='text-xs text-gray-500 leading-relaxed'>{{ Str::limit($eco->short_description, 60) }}</p>
            </div>
        </div>
        @endforeach

        {{-- Right Cards --}}
        @foreach($rightCards->values() as $index => $eco)
        <div id='card-r{{ $index + 1 }}' class='network-card absolute {{ $positionsR[$index] ?? $positionsR[0] }} w-64 bg-white border-2 border-transparent rounded-2xl p-5 z-20 shadow-[0_8px_30px_rgba(0,0,0,0.08)]'>
            <svg class='absolute inset-0 w-full h-full pointer-events-none rounded-2xl' preserveAspectRatio='none'>
                <rect width='100%' height='100%' rx='16' fill='none' stroke='url(#brandGradient)' stroke-width='3' class='card-trace-path opacity-0' style='stroke-linecap: round;'></rect>
            </svg>
            <div class='relative z-10'>
                <div class='w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center mb-3 text-xl border border-gray-200'>{{ $eco->icon ?? '✨' }}</div>
                <h3 class='text-base font-bold mb-1 text-gray-900'>{{ $eco->name }}</h3>
                <p class='text-xs text-gray-500 leading-relaxed'>{{ Str::limit($eco->short_description, 60) }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Mobile Layout (Centered Animated Circuit with Connecting Beams & Border Traces) --}}
    <style>
        @media (max-width: 1023px) {
            .mobile-eco-section {
                position: relative;
                width: 100%;
                max-width: 360px;
                margin: 0 auto;
            }

            /* Connecting vertical line styling */
            .mobile-beam-track {
                width: 2px;
                height: 28px;
                margin: 0 auto;
                background: rgba(0, 0, 0, 0.1);
                position: relative;
                overflow: hidden;
            }

            .mobile-beam-head {
                position: absolute;
                left: 0;
                width: 100%;
                height: 14px;
                background: linear-gradient(to bottom, #3B4FE0, #FF5A36);
                box-shadow: 0 0 8px #FF5A36;
                border-radius: 2px;
                opacity: 0;
            }

            /* Card SVG border trace path */
            .mobile-rect-trace {
                stroke-dasharray: 120 1200;
                stroke-dashoffset: 1200;
                opacity: 0;
                filter: drop-shadow(0 0 6px #FF5A36) drop-shadow(0 0 10px #3B4FE0);
                transition: opacity 0.2s;
            }

            /* 6s cycle for total loop, 1s per card step */
            /* Loop 1 */
            .card-step-1 .mobile-beam-head { animation: beamDrop 6s infinite 0s; }
            .card-step-1 .mobile-rect-trace { animation: rectTrace 6s infinite 0.2s; }

            .card-step-2 .mobile-beam-head { animation: beamDrop 6s infinite 1s; }
            .card-step-2 .mobile-rect-trace { animation: rectTrace 6s infinite 1.2s; }

            .card-step-3 .mobile-beam-head { animation: beamDrop 6s infinite 2s; }
            .card-step-3 .mobile-rect-trace { animation: rectTrace 6s infinite 2.2s; }

            .card-step-4 .mobile-beam-head { animation: beamDrop 6s infinite 3s; }
            .card-step-4 .mobile-rect-trace { animation: rectTrace 6s infinite 3.2s; }

            .card-step-5 .mobile-beam-head { animation: beamDrop 6s infinite 4s; }
            .card-step-5 .mobile-rect-trace { animation: rectTrace 6s infinite 4.2s; }

            .card-step-6 .mobile-beam-head { animation: beamDrop 6s infinite 5s; }
            .card-step-6 .mobile-rect-trace { animation: rectTrace 6s infinite 5.2s; }

            /* Keyframes */
            @keyframes beamDrop {
                0% { top: -14px; opacity: 1; }
                15% { top: 100%; opacity: 1; }
                20% { top: 100%; opacity: 0; }
                100% { top: 100%; opacity: 0; }
            }

            @keyframes rectTrace {
                0% { stroke-dashoffset: 1200; opacity: 0; }
                5% { opacity: 1; }
                25% { stroke-dashoffset: 0; opacity: 1; }
                30% { opacity: 0; }
                100% { opacity: 0; }
            }
        }
    </style>

    <div class="block lg:hidden relative w-full z-10 px-4 mt-6">
        {{-- Gradient definition for mobile traces --}}
        <svg class="w-0 h-0 absolute pointer-events-none">
            <defs>
                <linearGradient id="mobileBrandGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#3B4FE0" />
                    <stop offset="100%" stop-color="#FF5A36" />
                </linearGradient>
            </defs>
        </svg>

        <div class="mobile-eco-section">
            
            @foreach($ecosystems as $index => $eco)
            {{-- Top lead-in beam or Connector --}}
            <div class="mobile-beam-track card-step-{{ $index + 1 }}">
                <div class="mobile-beam-head"></div>
            </div>

            {{-- Card --}}
            <div class="relative w-full card-step-{{ $index + 1 }}">
                <div class="relative w-full rounded-2xl bg-[#0B111E] p-4.5 shadow-[0_12px_32px_rgba(0,0,0,0.2)] overflow-hidden border border-white/10">
                    <svg class="absolute inset-0 w-full h-full pointer-events-none rounded-2xl" preserveAspectRatio="none">
                        <rect width="100%" height="100%" rx="16" fill="none" stroke="url(#mobileBrandGrad)" stroke-width="3" class="mobile-rect-trace"></rect>
                    </svg>
                    <div class="relative z-10 flex items-center gap-3.5 p-1">
                        <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center text-xl border border-white/15 shrink-0">{{ $eco->icon ?? '✨' }}</div>
                        <div>
                            <h3 class="text-base font-bold text-white leading-tight">{{ $eco->name }}</h3>
                            <p class="text-xs text-gray-400 mt-1 leading-normal">{{ Str::limit($eco->short_description, 50) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Bottom lead-out beam --}}
            <div class="mobile-beam-track card-step-1">
                <div class="mobile-beam-head"></div>
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap !== 'undefined' && window.innerWidth >= 1024) {
        
        const container = document.getElementById('network-container');
        const pathsGroup = document.getElementById('network-paths');
        const centerHub = document.getElementById('hub-center');
        
        const leftCards = ['card-l1', 'card-l2', 'card-l3'];
        const rightCards = ['card-r1', 'card-r2', 'card-r3'];

        function getCenter(el) {
            const containerRect = container.getBoundingClientRect();
            const rect = el.getBoundingClientRect();
            return {
                x: rect.left - containerRect.left + rect.width / 2,
                y: rect.top - containerRect.top + rect.height / 2
            };
        }

        let networkAnimation = null;

        function drawNetwork() {
            pathsGroup.innerHTML = ''; 
            const startPoint = getCenter(centerHub);
            const pathsData = [];

            const createPath = (cardId, isRight) => {
                const cardEl = document.getElementById(cardId);
                if (!cardEl) return;
                
                const endPoint = getCenter(cardEl);
                
                // Attach to the inner edge of the card
                const cardWidth = cardEl.offsetWidth;
                if (isRight) {
                    endPoint.x = endPoint.x - (cardWidth / 2);
                } else {
                    endPoint.x = endPoint.x + (cardWidth / 2);
                }

                // FIX FOR SVG FILTER BUG ON STRAIGHT HORIZONTAL LINES
                // Browsers hide SVG filters on elements with 0 height bounding boxes.
                if (Math.abs(endPoint.y - startPoint.y) < 2) {
                    endPoint.y += 1;
                }

                // Attach to the edge of the hub
                const hubRadius = centerHub.offsetWidth / 2;
                const spX = startPoint.x + (isRight ? hubRadius : -hubRadius);

                // Curve logic
                const offset = Math.abs(endPoint.x - spX) * 0.4;
                const cp1x = spX + (isRight ? offset : -offset);
                const cp1y = startPoint.y;
                const cp2x = endPoint.x + (isRight ? -offset : offset);
                const cp2y = endPoint.y;
                
                const pathString = `M ${spX} ${startPoint.y} C ${cp1x} ${cp1y}, ${cp2x} ${cp2y}, ${endPoint.x} ${endPoint.y}`;
                
                // Dim line
                const bgPath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                bgPath.setAttribute('d', pathString);
                bgPath.setAttribute('fill', 'none');
                bgPath.setAttribute('stroke', 'rgba(0,0,0,0.08)');
                bgPath.setAttribute('stroke-width', '2');
                pathsGroup.appendChild(bgPath);
                
                // Animated pulse
                const pulsePath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                pulsePath.setAttribute('d', pathString);
                pulsePath.setAttribute('fill', 'none');
                pulsePath.setAttribute('stroke', 'url(#brandGradient)'); // Or '#3B4FE0' if gradient fails
                pulsePath.setAttribute('stroke-width', '4');
                pulsePath.setAttribute('stroke-linecap', 'round');
                pulsePath.setAttribute('filter', 'url(#neonGlow)');
                pathsGroup.appendChild(pulsePath);
                
                pathsData.push({ pulsePath, card: cardEl });
            };

            leftCards.forEach(id => createPath(id, false));
            rightCards.forEach(id => createPath(id, true));
            
            return pathsData;
        }

        function initAnimation() {
            const pathsData = drawNetwork();
            
            if (networkAnimation) networkAnimation.kill();
            // Added repeatDelay so there is a 1-second pause before the next simultaneous burst
            networkAnimation = gsap.timeline({ repeat: -1, repeatDelay: 1 });
            
            pathsData.forEach(({pulsePath, card}, index) => {
                const lineLength = pulsePath.getTotalLength();
                const dashLength = lineLength * 0.3; 
                
                const tracePath = card.querySelector('.card-trace-path');
                if(!tracePath) return; 
                
                const traceLength = tracePath.getTotalLength();
                
                gsap.set(pulsePath, { strokeDasharray: `${dashLength} ${lineLength}`, strokeDashoffset: lineLength, opacity: 0 });
                gsap.set(tracePath, { strokeDasharray: traceLength, strokeDashoffset: traceLength, opacity: 0 });
                
                // Set startTime to 0 for all elements so they animate exactly at the same time!
                const startTime = 0; 
                const travelDuration = 1;
                const traceDuration = 1.3;
                
                // Pulse travel
                networkAnimation.to(pulsePath, { opacity: 1, duration: 0.1 }, startTime)
                                .to(pulsePath, { strokeDashoffset: -dashLength, duration: travelDuration, ease: 'power2.inOut' }, startTime)
                                .to(pulsePath, { opacity: 0, duration: 0.2 }, startTime + travelDuration - 0.2);
                
                // Border trace
                const hitTime = startTime + travelDuration - 0.3; 
                networkAnimation.to(tracePath, { opacity: 1, duration: 0.1 }, hitTime)
                                .to(tracePath, { strokeDashoffset: 0, duration: traceDuration, ease: 'power1.inOut' }, hitTime)
                                .to(tracePath, { opacity: 0, duration: 0.8 }, hitTime + traceDuration);
                                
                networkAnimation.to(card, {
                    y: -4,
                    boxShadow: '0 12px 40px rgba(59,79,224,0.15)',
                    duration: traceDuration / 2,
                    yoyo: true,
                    repeat: 1,
                    ease: 'power1.inOut'
                }, hitTime);
            });
        }

        // Initialize with a longer delay to ensure full CSS/layout paint
        setTimeout(initAnimation, 800); 
        
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (window.innerWidth >= 1024) {
                    initAnimation();
                } else if (networkAnimation) {
                    networkAnimation.kill();
                    pathsGroup.innerHTML = '';
                }
            }, 300);
        });
    }
});
</script>
@endpush
