<section class="py-24 bg-white text-black relative z-20 -mt-10 mx-6 lg:mx-12 rounded-3xl shadow-2xl overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-16">

            {{-- Left: Contact Info (2 columns wide) --}}
            <div class="lg:col-span-2 space-y-12" data-aos="fade-right">
                <div>
                    <h3 class="text-3xl font-bold tracking-tight mb-4">
                        {{ $page->content_title ?? 'Get in Touch' }}
                    </h3>
                    <p class="text-gray-600 text-lg">
                        {{ $page->content_subtitle ?? "We'd love to hear from you. Our friendly team is always here to chat." }}
                    </p>
                </div>

                <div class="space-y-8">
                    {{-- Chat to our team --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold mb-1">Chat to our team</h4>
                            <p class="text-gray-500 mb-2">Speak to our friendly team.</p>
                            <a href="mailto:{{ setting('contact_email', 'hello@pensofttech.com') }}"
                                class="text-black font-semibold hover:text-[#4fd1c5] transition-colors">
                                {{ setting('contact_email', 'hello@pensofttech.com') }}
                            </a>
                        </div>
                    </div>

                    {{-- Call us --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold mb-1">Call us</h4>
                            <p class="text-gray-500 mb-2">{{ setting('working_hours', 'Sat - Thu (9am - 6pm)') }}</p>
                            <a href="tel:{{ setting('contact_phone', '+8801618-854811') }}"
                                class="text-black font-semibold hover:text-[#4fd1c5] transition-colors">
                                {{ setting('contact_phone', '+8801618-854811') }}
                            </a>
                        </div>
                    </div>

                    {{-- Office --}}
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold mb-1">Visit us</h4>
                            <p class="text-gray-500 mb-2">Visit our office HQ.</p>
                            <span class="text-black font-semibold leading-relaxed block">
                                {{ setting('office_location', 'Third Floor, Darussalam Tower, Kollyanpur, Mirpur Road, Dhaka-1207') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Contact Form (3 columns wide) --}}
            <div class="lg:col-span-3 bg-gray-50 p-8 md:p-12 rounded-2xl" data-aos="fade-left">
                @if (session('success'))
                    <div
                        class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <div>
                            <p class="font-semibold text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-black mb-2">First
                                name</label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                                class="w-full px-4 py-3 rounded-lg border @error('first_name') border-red-500 @else border-gray-200 @enderror focus:border-black focus:ring-1 focus:ring-black outline-none transition-all"
                                placeholder="First name" required>
                            @error('first_name')
                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-black mb-2">Last name</label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                                class="w-full px-4 py-3 rounded-lg border @error('last_name') border-red-500 @else border-gray-200 @enderror focus:border-black focus:ring-1 focus:ring-black outline-none transition-all"
                                placeholder="Last name" required>
                            @error('last_name')
                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-black mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-3 rounded-lg border @error('email') border-red-500 @else border-gray-200 @enderror focus:border-black focus:ring-1 focus:ring-black outline-none transition-all"
                                placeholder="you@company.com" required>
                            @error('email')
                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-black mb-2">Phone number <span
                                    class="text-gray-400 font-normal">(Optional)</span></label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                class="w-full px-4 py-3 rounded-lg border @error('phone') border-red-500 @else border-gray-200 @enderror focus:border-black focus:ring-1 focus:ring-black outline-none transition-all"
                                placeholder="+1 (555) 000-0000">
                            @error('phone')
                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="company" class="block text-sm font-semibold text-black mb-2">Company <span
                                class="text-gray-400 font-normal">(Optional)</span></label>
                        <input type="text" id="company" name="company" value="{{ old('company') }}"
                            class="w-full px-4 py-3 rounded-lg border @error('company') border-red-500 @else border-gray-200 @enderror focus:border-black focus:ring-1 focus:ring-black outline-none transition-all"
                            placeholder="Your company">
                        @error('company')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-black mb-2">Message</label>
                        <textarea id="message" name="message" rows="4"
                            class="w-full px-4 py-3 rounded-lg border @error('message') border-red-500 @else border-gray-200 @enderror focus:border-black focus:ring-1 focus:ring-black outline-none transition-all resize-none"
                            placeholder="Tell us about your project..." required>{{ old('message') }}</textarea>
                        @error('message')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-black text-white py-4 rounded-lg font-bold hover:bg-gray-800 transition-colors cursor-pointer">
                        Send message
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>
