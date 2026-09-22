<footer class="bg-[#0b0f19] pt-12 md:pt-20 pb-8 md:pb-12 border-t border-white/10 relative overflow-hidden">
    {{-- Subtle top glow --}}
    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-3/4 h-[1px] bg-gradient-to-r from-transparent via-[#4fd1c5]/40 to-transparent">
    </div>

    <div class="max-w-7xl mx-auto px-5 lg:px-12">

        {{-- Top Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10 mb-10 md:mb-16">

            {{-- Brand Column (Col Span 4) --}}
            <div class="lg:col-span-4 flex flex-col items-start">
                <a href="/" class="inline-flex items-center gap-3 text-white text-xl md:text-2xl font-bold mb-4">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-[#4fd1c5] to-[#319795] rounded-xl flex items-center justify-center text-black text-lg font-black shadow-[0_0_15px_rgba(79,209,197,0.3)]">
                        P
                    </div>
                    <span>Pensof<span class="text-[#4fd1c5]">tech</span></span>
                </a>
                <p class="text-gray-400 text-xs sm:text-sm leading-relaxed mb-6 max-w-sm">
                    Pensoftech specializes in launching and scaling world-class B2B SaaS platforms with expert product,
                    engineering, and growth strategies.
                </p>
                <div class="flex flex-col gap-2 text-xs sm:text-sm text-gray-300">
                    <a href="mailto:hello@pensoftech.com"
                        class="inline-flex items-center gap-2 hover:text-[#4fd1c5] transition-colors">
                        <svg class="w-4 h-4 text-[#4fd1c5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        hello@pensoftech.com
                    </a>
                    <span class="inline-flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4 text-[#4fd1c5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        San Francisco, CA &amp; Dhaka, BD
                    </span>
                </div>
            </div>

            {{-- Spacer for LG --}}
            <div class="hidden lg:block lg:col-span-2"></div>

            {{-- Links: Company, Services, Resources --}}
            <div class="grid grid-cols-3 gap-6 col-span-1 md:col-span-2 lg:col-span-6">
                <div>
                    <h4
                        class="text-white font-bold tracking-wider uppercase text-xs md:text-sm mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5]"></span> Company
                    </h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Our Team</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Case Studies</a>
                        </li>
                    </ul>
                </div>

                {{-- Links: Services --}}
                <div>
                    <h4
                        class="text-white font-bold tracking-wider uppercase text-xs md:text-sm mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5]"></span> Services
                    </h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">SaaS Design</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Web Dev</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Cloud
                                Architecture</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Backend API</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">DevOps</a></li>
                    </ul>
                </div>

                {{-- Links: Resources --}}
                <div>
                    <h4
                        class="text-white font-bold tracking-wider uppercase text-xs md:text-sm mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5]"></span> Resources
                    </h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Whitepapers</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Webinars</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">API Portal</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        {{-- Bottom Copyright Bar --}}
        <div
            class="border-t border-white/10 pt-6 md:pt-8 flex flex-col-reverse sm:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-xs sm:text-sm text-center sm:text-left">
                &copy; {{ date('Y') }} Pensoftech Inc. All Rights Reserved.
                <span class="mx-1.5">|</span> <a href="#" class="hover:text-white transition-colors">Privacy
                    Policy</a>
                <span class="mx-1.5">|</span> <a href="#" class="hover:text-white transition-colors">Terms of
                    Service</a>
            </p>

            {{-- Social Icons --}}
            <div class="flex items-center gap-3">
                <a href="#"
                    class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-[#4fd1c5] hover:border-[#4fd1c5]/30 hover:bg-white/10 transition-all">
                    <span class="sr-only">Twitter</span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                    </svg>
                </a>
                <a href="#"
                    class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-[#4fd1c5] hover:border-[#4fd1c5]/30 hover:bg-white/10 transition-all">
                    <span class="sr-only">LinkedIn</span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#"
                    class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center text-gray-400 hover:text-[#4fd1c5] hover:border-[#4fd1c5]/30 hover:bg-white/10 transition-all">
                    <span class="sr-only">GitHub</span>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

    </div>
</footer>
