<footer class="bg-[#0f172a] pt-10 md:pt-20 pb-8 md:pb-10 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-5 lg:px-12">
        
        {{-- Top Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-8 mb-8 md:mb-16">
            
            {{-- Brand Column (Col Span 4) --}}
            <div class="col-span-2 lg:col-span-4">
                <a href="/" class="inline-flex items-center gap-3 text-white text-xl md:text-2xl font-bold mb-3 md:mb-6">
                    <div class="w-7 h-7 md:w-8 md:h-8 bg-[#4fd1c5] rounded-lg flex items-center justify-center text-white text-lg md:text-xl font-black">
                        P
                    </div>
                    Pensoftech
                </a>
                <p class="text-gray-400 text-xs md:text-sm leading-relaxed mb-4 md:mb-6 max-w-sm">
                    Pensoftech specializes in launching and scaling world-class B2B SaaS platforms with expert product, engineering, and growth strategies.
                </p>
                <div class="text-gray-400 space-y-1.5 text-xs md:text-sm">
                    <p><a href="mailto:hello@pensoftech.com" class="hover:text-white transition-colors">hello@pensoftech.com</a></p>
                    <p>+1 (555) 123-4567 | San Francisco, CA</p>
                </div>
            </div>

            {{-- Spacer for LG --}}
            <div class="hidden lg:block lg:col-span-2"></div>

            {{-- Links: Company (Col Span 2) --}}
            <div class="col-span-1 lg:col-span-2">
                <h4 class="text-white font-bold tracking-wider uppercase text-xs md:text-sm mb-3 md:mb-6">Company</h4>
                <ul class="space-y-2.5 md:space-y-4 text-xs md:text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Our Team</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Careers</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Case Studies</a></li>
                </ul>
            </div>

            {{-- Links: Services (Col Span 2) --}}
            <div class="col-span-1 lg:col-span-2">
                <h4 class="text-white font-bold tracking-wider uppercase text-xs md:text-sm mb-3 md:mb-6">Services</h4>
                <ul class="space-y-2.5 md:space-y-4 text-xs md:text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">SaaS Design</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Web Dev</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Cloud Architecture</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Backend</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">DevOps</a></li>
                </ul>
            </div>

            {{-- Links: Resources (Col Span 2) --}}
            <div class="col-span-2 sm:col-span-1 lg:col-span-2 mt-2 sm:mt-0">
                <h4 class="text-white font-bold tracking-wider uppercase text-xs md:text-sm mb-3 md:mb-6">Resources</h4>
                <ul class="space-y-2.5 md:space-y-4 text-xs md:text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Whitepapers</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Webinars</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">API</a></li>
                </ul>
            </div>

        </div>

        {{-- Bottom Copyright Bar --}}
        <div class="border-t border-white/10 pt-6 md:pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-500 text-xs md:text-sm text-center md:text-left">
                &copy; {{ date('Y') }} Pensoftech Inc. All Rights Reserved. 
                <span class="mx-1 sm:mx-2">|</span> <a href="#" class="hover:text-white transition-colors">Privacy</a>
                <span class="mx-1 sm:mx-2">|</span> <a href="#" class="hover:text-white transition-colors">Terms</a>
            </p>
            
            {{-- Social Icons --}}
            <div class="flex items-center gap-4">
                <a href="#" class="text-gray-500 hover:text-white transition-colors">
                    <span class="sr-only">Twitter</span>
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <a href="#" class="text-gray-500 hover:text-white transition-colors">
                    <span class="sr-only">LinkedIn</span>
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd"/></svg>
                </a>
                <a href="#" class="text-gray-500 hover:text-white transition-colors">
                    <span class="sr-only">GitHub</span>
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                </a>
            </div>
        </div>

    </div>
</footer>
