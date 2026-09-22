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
            
            {{-- 1. Web Development Accordion --}}
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden transition-all duration-300">
                <button @click="mobileAccordion = (mobileAccordion === 'web-development' ? null : 'web-development')" 
                        class="w-full flex items-center justify-between p-4 text-left font-bold text-gray-900 bg-white transition-colors"
                        :class="mobileAccordion === 'web-development' ? 'border-b border-gray-100' : ''">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-[#4fd1c5]/10 text-[#4fd1c5] flex items-center justify-center text-base">💻</span>
                        <span class="text-sm font-extrabold">Web Development</span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">3 Services</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-300" 
                         :class="mobileAccordion === 'web-development' ? 'rotate-180 text-[#4fd1c5]' : ''" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div x-show="mobileAccordion === 'web-development'" 
                     x-collapse
                     class="p-3.5 bg-gray-50/50 space-y-3">
                    
                    {{-- Web Dev Card 1 --}}
                    <div class="bg-white rounded-xl p-3.5 border border-gray-100 shadow-sm">
                        <div class="flex items-start justify-between gap-3 mb-1.5">
                            <h4 class="text-sm font-bold text-gray-900">Custom Web Apps</h4>
                            <span class="text-[#4fd1c5] font-bold text-sm">→</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed mb-2.5">Scale your SaaS with robust, high-performance web applications built on modern frameworks.</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">Next.js</span>
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">Laravel</span>
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">APIs</span>
                        </div>
                    </div>

                    {{-- Web Dev Card 2 --}}
                    <div class="bg-white rounded-xl p-3.5 border border-gray-100 shadow-sm">
                        <div class="flex items-start justify-between gap-3 mb-1.5">
                            <h4 class="text-sm font-bold text-gray-900">E-Commerce Platforms</h4>
                            <span class="text-[#4fd1c5] font-bold text-sm">→</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed mb-2.5">High-converting, secure, and scalable e-commerce solutions tailored for global reach.</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">Shopify</span>
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">Custom Checkout</span>
                        </div>
                    </div>

                    {{-- Web Dev Card 3 --}}
                    <div class="bg-white rounded-xl p-3.5 border border-gray-100 shadow-sm">
                        <div class="flex items-start justify-between gap-3 mb-1.5">
                            <h4 class="text-sm font-bold text-gray-900">Progressive Web Apps</h4>
                            <span class="text-[#4fd1c5] font-bold text-sm">→</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed mb-2.5">Deliver native app-like experiences right in the browser with offline-capable PWAs.</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">PWA</span>
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">Fast & Offline</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- 2. AI Solutions Accordion --}}
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden transition-all duration-300">
                <button @click="mobileAccordion = (mobileAccordion === 'ai-solutions' ? null : 'ai-solutions')" 
                        class="w-full flex items-center justify-between p-4 text-left font-bold text-gray-900 bg-white transition-colors"
                        :class="mobileAccordion === 'ai-solutions' ? 'border-b border-gray-100' : ''">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-base">🤖</span>
                        <span class="text-sm font-extrabold">AI & Machine Learning</span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">2 Services</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-300" 
                         :class="mobileAccordion === 'ai-solutions' ? 'rotate-180 text-[#4fd1c5]' : ''" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div x-show="mobileAccordion === 'ai-solutions'" 
                     x-collapse
                     class="p-3.5 bg-gray-50/50 space-y-3"
                     style="display: none;">
                    
                    {{-- AI Card 1 --}}
                    <div class="bg-white rounded-xl p-3.5 border border-gray-100 shadow-sm">
                        <div class="flex items-start justify-between gap-3 mb-1.5">
                            <h4 class="text-sm font-bold text-gray-900">Machine Learning Models</h4>
                            <span class="text-[#4fd1c5] font-bold text-sm">→</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed mb-2.5">Integrate advanced machine learning models to automate processes and predict trends.</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">Python</span>
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">PyTorch</span>
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">Predictive AI</span>
                        </div>
                    </div>

                    {{-- AI Card 2 --}}
                    <div class="bg-white rounded-xl p-3.5 border border-gray-100 shadow-sm">
                        <div class="flex items-start justify-between gap-3 mb-1.5">
                            <h4 class="text-sm font-bold text-gray-900">NLP & Chatbots</h4>
                            <span class="text-[#4fd1c5] font-bold text-sm">→</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed mb-2.5">Enhance customer support with intelligent, natural language processing conversational AI.</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">OpenAI / LLMs</span>
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">Vector DB</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- 3. Cloud Ops Accordion --}}
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden transition-all duration-300">
                <button @click="mobileAccordion = (mobileAccordion === 'cloud-ops' ? null : 'cloud-ops')" 
                        class="w-full flex items-center justify-between p-4 text-left font-bold text-gray-900 bg-white transition-colors"
                        :class="mobileAccordion === 'cloud-ops' ? 'border-b border-gray-100' : ''">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-base">☁️</span>
                        <span class="text-sm font-extrabold">Cloud & DevOps</span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">1 Service</span>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-300" 
                         :class="mobileAccordion === 'cloud-ops' ? 'rotate-180 text-[#4fd1c5]' : ''" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div x-show="mobileAccordion === 'cloud-ops'" 
                     x-collapse
                     class="p-3.5 bg-gray-50/50 space-y-3"
                     style="display: none;">
                    
                    {{-- Cloud Card 1 --}}
                    <div class="bg-white rounded-xl p-3.5 border border-gray-100 shadow-sm">
                        <div class="flex items-start justify-between gap-3 mb-1.5">
                            <h4 class="text-sm font-bold text-gray-900">Cloud Migration & Architecture</h4>
                            <span class="text-[#4fd1c5] font-bold text-sm">→</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed mb-2.5">Seamlessly transition legacy infrastructure to scalable, secure, and cost-effective cloud.</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">AWS</span>
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">Docker</span>
                            <span class="text-[10px] font-semibold bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md">Kubernetes</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- =========================================================
             DESKTOP ONLY: Standard Tab & Multi-Column Grid
             ========================================================= --}}
        <div class="hidden md:block">
            {{-- Category Tabs (Desktop) --}}
            <div class="flex justify-center gap-3 mb-10">
                <button @click="activeTab = 'web-development'" 
                        :class="activeTab === 'web-development' ? 'bg-[#4fd1c5] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                        class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300">
                    Web Development
                </button>
                <button @click="activeTab = 'ai-solutions'" 
                        :class="activeTab === 'ai-solutions' ? 'bg-[#4fd1c5] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                        class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300">
                    AI Solutions
                </button>
                <button @click="activeTab = 'cloud-ops'" 
                        :class="activeTab === 'cloud-ops' ? 'bg-[#4fd1c5] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                        class="px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300">
                    Cloud Ops
                </button>
            </div>

            {{-- Service Grids (Desktop) --}}
            <div class="relative min-h-[350px]">
                
                {{-- Web Development Grid --}}
                <div x-show="activeTab === 'web-development'" 
                     x-transition:enter="transition ease-out duration-500 delay-100"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-300 absolute top-0 left-0 w-full"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="grid grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    {{-- Card 1 --}}
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-[#4fd1c5]/10 flex items-center justify-center mb-6 text-[#4fd1c5] text-2xl group-hover:scale-110 transition-transform duration-300">
                            💻
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Custom Web Apps</h3>
                        <p class="text-gray-500 mb-6 leading-relaxed">Scale your SaaS with robust, high-performance web applications and dynamic user experiences built on modern frameworks.</p>
                        <a href="#" class="text-[#4fd1c5] font-semibold inline-flex items-center gap-1.5 group-hover:gap-2.5 transition-all">
                            Learn More <span class="text-lg">→</span>
                        </a>
                    </div>

                    {{-- Card 2 --}}
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-[#4fd1c5]/10 flex items-center justify-center mb-6 text-[#4fd1c5] text-2xl group-hover:scale-110 transition-transform duration-300">
                            🛒
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">E-Commerce Platforms</h3>
                        <p class="text-gray-500 mb-6 leading-relaxed">High-converting, secure, and scalable e-commerce solutions tailored for enterprise growth and global reach.</p>
                        <a href="#" class="text-[#4fd1c5] font-medium inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                            Learn More <span class="text-lg">→</span>
                        </a>
                    </div>

                    {{-- Card 3 --}}
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-[#4fd1c5]/10 flex items-center justify-center mb-6 text-[#4fd1c5] text-2xl group-hover:scale-110 transition-transform duration-300">
                            📱
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Progressive Web Apps</h3>
                        <p class="text-gray-500 mb-6 leading-relaxed">Deliver native app-like experiences right in the browser with blazing fast, offline-capable progressive web apps.</p>
                        <a href="#" class="text-[#4fd1c5] font-medium inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                            Learn More <span class="text-lg">→</span>
                        </a>
                    </div>
                </div>

                {{-- AI Solutions Grid --}}
                <div x-show="activeTab === 'ai-solutions'" x-cloak
                     x-transition:enter="transition ease-out duration-500 delay-100"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-300 absolute top-0 left-0 w-full"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="grid grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    {{-- Card 1 --}}
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-[#4fd1c5]/10 flex items-center justify-center mb-6 text-[#4fd1c5] text-2xl group-hover:scale-110 transition-transform duration-300">
                            🤖
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Machine Learning</h3>
                        <p class="text-gray-500 mb-6 leading-relaxed">Integrate advanced machine learning models to automate processes, predict trends, and optimize workflows.</p>
                        <a href="#" class="text-[#4fd1c5] font-medium inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                            Learn More <span class="text-lg">→</span>
                        </a>
                    </div>
                    
                    {{-- Card 2 --}}
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-[#4fd1c5]/10 flex items-center justify-center mb-6 text-[#4fd1c5] text-2xl group-hover:scale-110 transition-transform duration-300">
                            🗣️
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">NLP & Chatbots</h3>
                        <p class="text-gray-500 mb-6 leading-relaxed">Enhance customer support and engagement with intelligent, natural language processing conversational AI.</p>
                        <a href="#" class="text-[#4fd1c5] font-medium inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                            Learn More <span class="text-lg">→</span>
                        </a>
                    </div>
                </div>

                {{-- Cloud Ops Grid --}}
                <div x-show="activeTab === 'cloud-ops'" x-cloak
                     x-transition:enter="transition ease-out duration-500 delay-100"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-300 absolute top-0 left-0 w-full"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="grid grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    {{-- Card 1 --}}
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-[#4fd1c5]/10 flex items-center justify-center mb-6 text-[#4fd1c5] text-2xl group-hover:scale-110 transition-transform duration-300">
                            ☁️
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Cloud Migration</h3>
                        <p class="text-gray-500 mb-6 leading-relaxed">Seamlessly transition your legacy infrastructure to scalable, secure, and cost-effective cloud environments.</p>
                        <a href="#" class="text-[#4fd1c5] font-medium inline-flex items-center gap-2 group-hover:gap-3 transition-all">
                            Learn More <span class="text-lg">→</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
