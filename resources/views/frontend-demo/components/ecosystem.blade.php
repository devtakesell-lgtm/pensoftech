<section id="ecosystem" class="relative bg-[#fafafa] text-[#10151A] min-h-screen flex flex-col justify-center overflow-hidden py-12">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute inset-0" style="background-image: radial-gradient(rgba(0, 0, 0, 0.04) 1px, transparent 1px); background-size: 30px 30px;"></div>
    </div>

    {{-- Header --}}
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center mb-8 lg:mb-12">
        <span class="text-[#FF5A36] font-bold tracking-widest uppercase text-sm mb-3 block">The Ecosystem</span>
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight">
            Engineered for <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-orange-500" style="background-image: linear-gradient(to right, #3B4FE0, #FF5A36); -webkit-background-clip: text; color: transparent;">Growth</span>
        </h2>
        <p class="text-gray-500 mt-4 max-w-2xl mx-auto text-lg">
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
                <span class="text-5xl font-extrabold" style="background-image: linear-gradient(to bottom right, #3B4FE0, #FF5A36); -webkit-background-clip: text; color: transparent;">P</span>
            </div>
        </div>

        {{-- Left Cards --}}
        <div id='card-l1' class='network-card absolute top-[6%] xl:top-[12%] left-[12%] xl:left-[20%] w-64 bg-white border-2 border-transparent rounded-2xl p-5 z-20 shadow-[0_8px_30px_rgba(0,0,0,0.08)]'>
            <svg class='absolute inset-0 w-full h-full pointer-events-none rounded-2xl' preserveAspectRatio='none'>
                <rect width='100%' height='100%' rx='16' fill='none' stroke='url(#brandGradient)' stroke-width='3' class='card-trace-path opacity-0' style='stroke-linecap: round;'></rect>
            </svg>
            <div class='relative z-10'>
                <div class='w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center mb-3 text-xl border border-gray-200'>🧠</div>
                <h3 class='text-base font-bold mb-1 text-gray-900'>AI & Deep Tech</h3>
                <p class='text-xs text-gray-500 leading-relaxed'>Intelligent algorithms that optimize operations and scale growth.</p>
            </div>
        </div>

        <div id='card-l2' class='network-card absolute top-[50%] -translate-y-1/2 left-[2%] xl:left-[8%] w-64 bg-white border-2 border-transparent rounded-2xl p-5 z-20 shadow-[0_8px_30px_rgba(0,0,0,0.08)]'>
            <svg class='absolute inset-0 w-full h-full pointer-events-none rounded-2xl' preserveAspectRatio='none'>
                <rect width='100%' height='100%' rx='16' fill='none' stroke='url(#brandGradient)' stroke-width='3' class='card-trace-path opacity-0' style='stroke-linecap: round;'></rect>
            </svg>
            <div class='relative z-10'>
                <div class='w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center mb-3 text-xl border border-gray-200'>🏭</div>
                <h3 class='text-base font-bold mb-1 text-gray-900'>Real Estate</h3>
                <p class='text-xs text-gray-500 leading-relaxed'>Digital twins and property management platforms.</p>
            </div>
        </div>

        <div id='card-l3' class='network-card absolute bottom-[6%] xl:bottom-[12%] left-[12%] xl:left-[20%] w-64 bg-white border-2 border-transparent rounded-2xl p-5 z-20 shadow-[0_8px_30px_rgba(0,0,0,0.08)]'>
            <svg class='absolute inset-0 w-full h-full pointer-events-none rounded-2xl' preserveAspectRatio='none'>
                <rect width='100%' height='100%' rx='16' fill='none' stroke='url(#brandGradient)' stroke-width='3' class='card-trace-path opacity-0' style='stroke-linecap: round;'></rect>
            </svg>
            <div class='relative z-10'>
                <div class='w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center mb-3 text-xl border border-gray-200'>🌍</div>
                <h3 class='text-base font-bold mb-1 text-gray-900'>Enterprise Mobility</h3>
                <p class='text-xs text-gray-500 leading-relaxed'>Secure, scalable applications for global enterprises.</p>
            </div>
        </div>

        {{-- Right Cards --}}
        <div id='card-r1' class='network-card absolute top-[6%] xl:top-[12%] right-[12%] xl:right-[20%] w-64 bg-white border-2 border-transparent rounded-2xl p-5 z-20 shadow-[0_8px_30px_rgba(0,0,0,0.08)]'>
            <svg class='absolute inset-0 w-full h-full pointer-events-none rounded-2xl' preserveAspectRatio='none'>
                <rect width='100%' height='100%' rx='16' fill='none' stroke='url(#brandGradient)' stroke-width='3' class='card-trace-path opacity-0' style='stroke-linecap: round;'></rect>
            </svg>
            <div class='relative z-10'>
                <div class='w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center mb-3 text-xl border border-gray-200'>🛡️</div>
                <h3 class='text-base font-bold mb-1 text-gray-900'>Agro & Health</h3>
                <p class='text-xs text-gray-500 leading-relaxed'>Data-driven systems ensuring safety and high yield.</p>
            </div>
        </div>

        <div id='card-r2' class='network-card absolute top-[50%] -translate-y-1/2 right-[2%] xl:right-[8%] w-64 bg-white border-2 border-transparent rounded-2xl p-5 z-20 shadow-[0_8px_30px_rgba(0,0,0,0.08)]'>
            <svg class='absolute inset-0 w-full h-full pointer-events-none rounded-2xl' preserveAspectRatio='none'>
                <rect width='100%' height='100%' rx='16' fill='none' stroke='url(#brandGradient)' stroke-width='3' class='card-trace-path opacity-0' style='stroke-linecap: round;'></rect>
            </svg>
            <div class='relative z-10'>
                <div class='w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center mb-3 text-xl border border-gray-200'>☁️</div>
                <h3 class='text-base font-bold mb-1 text-gray-900'>Cloud & Infra</h3>
                <p class='text-xs text-gray-500 leading-relaxed'>High-availability cloud architecture for zero downtime.</p>
            </div>
        </div>

        <div id='card-r3' class='network-card absolute bottom-[6%] xl:bottom-[12%] right-[12%] xl:right-[20%] w-64 bg-white border-2 border-transparent rounded-2xl p-5 z-20 shadow-[0_8px_30px_rgba(0,0,0,0.08)]'>
            <svg class='absolute inset-0 w-full h-full pointer-events-none rounded-2xl' preserveAspectRatio='none'>
                <rect width='100%' height='100%' rx='16' fill='none' stroke='url(#brandGradient)' stroke-width='3' class='card-trace-path opacity-0' style='stroke-linecap: round;'></rect>
            </svg>
            <div class='relative z-10'>
                <div class='w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center mb-3 text-xl border border-gray-200'>🛍️</div>
                <h3 class='text-base font-bold mb-1 text-gray-900'>Digital Platforms</h3>
                <p class='text-xs text-gray-500 leading-relaxed'>Immersive e-commerce and customer experience portals.</p>
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
