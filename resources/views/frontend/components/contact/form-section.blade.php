<section class="py-24 bg-white text-black relative z-20 -mt-10 mx-6 lg:mx-12 rounded-3xl shadow-2xl overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-16">
            
            {{-- Left: Contact Info (2 columns wide) --}}
            <div class="lg:col-span-2 space-y-12" data-aos="fade-right">
                <div>
                    <h3 class="text-3xl font-bold tracking-tight mb-4">Get in Touch</h3>
                    <p class="text-gray-600 text-lg">We'd love to hear from you. Our friendly team is always here to chat.</p>
                </div>
                
                <div class="space-y-8">
                    {{-- Email --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold mb-1">Chat to sales</h4>
                            <p class="text-gray-500 mb-2">Speak to our friendly team.</p>
                            <a href="mailto:sales@pensoftech.com" class="text-black font-semibold hover:text-[#4fd1c5] transition-colors">sales@pensoftech.com</a>
                        </div>
                    </div>
                    
                    {{-- Support --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold mb-1">Chat to support</h4>
                            <p class="text-gray-500 mb-2">We're here to help.</p>
                            <a href="mailto:support@pensoftech.com" class="text-black font-semibold hover:text-[#4fd1c5] transition-colors">support@pensoftech.com</a>
                        </div>
                    </div>

                    {{-- Office --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold mb-1">Visit us</h4>
                            <p class="text-gray-500 mb-2">Visit our office HQ.</p>
                            <span class="text-black font-semibold">100 Smith Street, Collingwood VIC 3066 AU</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Contact Form (3 columns wide) --}}
            <div class="lg:col-span-3 bg-gray-50 p-8 md:p-12 rounded-2xl" data-aos="fade-left">
                <form action="#" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-black mb-2">First name</label>
                            <input type="text" id="first_name" name="first_name" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-black focus:ring-1 focus:ring-black outline-none transition-all" placeholder="First name" required>
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-black mb-2">Last name</label>
                            <input type="text" id="last_name" name="last_name" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-black focus:ring-1 focus:ring-black outline-none transition-all" placeholder="Last name" required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-semibold text-black mb-2">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-black focus:ring-1 focus:ring-black outline-none transition-all" placeholder="you@company.com" required>
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-semibold text-black mb-2">Company</label>
                        <input type="text" id="company" name="company" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-black focus:ring-1 focus:ring-black outline-none transition-all" placeholder="Your company">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-black mb-2">Message</label>
                        <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-black focus:ring-1 focus:ring-black outline-none transition-all resize-none" placeholder="Tell us about your project..." required></textarea>
                    </div>

                    <button type="submit" class="w-full bg-black text-white py-4 rounded-lg font-bold hover:bg-gray-800 transition-colors">
                        Send message
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</section>
