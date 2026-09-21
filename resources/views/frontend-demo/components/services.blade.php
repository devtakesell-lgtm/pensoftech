<section class="bg-gray-50 py-24 md:py-32">
    <div class="max-w-7xl mx-auto px-6 lg:px-12" x-data="{ activeTab: 'web-development' }">
        
        <div class="text-center mb-16">
            <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-sm mb-4 block">Our Expertise</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
                Our Services
            </h2>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto text-lg">
                We deliver scalable, world-class technology solutions tailored to your business needs.
            </p>
        </div>

        {{-- Category Tabs --}}
        <div class="flex flex-wrap justify-center gap-3 mb-16">
            <button @click="activeTab = 'web-development'" 
                    :class="activeTab === 'web-development' ? 'bg-[#4fd1c5] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                    class="px-6 py-2.5 rounded-full font-medium transition-all duration-300">
                Web Development
            </button>
            <button @click="activeTab = 'ai-solutions'" 
                    :class="activeTab === 'ai-solutions' ? 'bg-[#4fd1c5] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                    class="px-6 py-2.5 rounded-full font-medium transition-all duration-300">
                AI Solutions
            </button>
            <button @click="activeTab = 'cloud-ops'" 
                    :class="activeTab === 'cloud-ops' ? 'bg-[#4fd1c5] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:border-gray-300 hover:bg-gray-50'"
                    class="px-6 py-2.5 rounded-full font-medium transition-all duration-300">
                Cloud Ops
            </button>
        </div>

        {{-- Service Grids --}}
        <div class="relative min-h-[400px]">
            
            {{-- Web Development Grid --}}
            <div x-show="activeTab === 'web-development'" 
                 x-transition:enter="transition ease-out duration-500 delay-100"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300 absolute top-0 left-0 w-full"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                {{-- Card 1 --}}
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] transition-all duration-300 group">
                    <div class="w-14 h-14 rounded-2xl bg-[#4fd1c5]/10 flex items-center justify-center mb-6 text-[#4fd1c5] text-2xl group-hover:scale-110 transition-transform duration-300">
                        💻
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Custom Web Apps</h3>
                    <p class="text-gray-500 mb-6 leading-relaxed">Scale your SaaS with robust, high-performance web applications and dynamic user experiences built on modern frameworks.</p>
                    <a href="#" class="text-[#4fd1c5] font-medium inline-flex items-center gap-2 group-hover:gap-3 transition-all">
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
                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
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
                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
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
</section>
