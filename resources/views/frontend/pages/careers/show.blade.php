@extends('frontend.layouts.front-master')

{{-- 1. Browser Tab Title --}}
@section('title', $job->title . ' — Careers at PenSoftTech')

{{-- 2. SEO Meta Tags --}}
@section('meta_title', $job->seo?->meta_title ?? $job->title . ' — Careers at PenSoftTech')
@section('meta_description', $job->seo?->meta_description ?? Str::limit(strip_tags($job->description), 160))
@section('meta_keywords', $job->seo?->meta_keywords)
@section('canonical_url', $job->seo?->canonical_url ?? route('careers.show', $job->slug))

@if ($job->seo?->og_image)
    @section('og_image', asset('storage/' . $job->seo->og_image))
@endif

@if ($job->seo?->schema_json)
    @section('seo_schema')
        <script type="application/ld+json">
            {!! json_encode($job->seo->schema_json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endsection
@endif

@section('content')
    <main>
        {{-- ====================================================================
             1. HERO HEADER (DARK)
             ==================================================================== --}}
        <section class="bg-black text-gray-100 pt-36 md:pt-44 pb-16 relative overflow-hidden">
            {{-- Ambient Glows --}}
            <div class="absolute top-1/4 -right-48 w-96 h-96 bg-[#4fd1c5]/10 rounded-full blur-[140px] pointer-events-none">
            </div>
            <div class="absolute top-2/3 -left-48 w-96 h-96 bg-[#319795]/10 rounded-full blur-[140px] pointer-events-none">
            </div>

            <div class="max-w-7xl mx-auto px-5 lg:px-12 relative z-10">
                {{-- Breadcrumb Navigation --}}
                <nav class="flex items-center gap-2 text-xs font-semibold text-gray-400 mb-8 uppercase tracking-wider"
                    aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                    <span>/</span>
                    <a href="{{ route('careers.index') }}" class="hover:text-white transition-colors">Careers</a>
                    <span>/</span>
                    <span class="text-[#4fd1c5] truncate max-w-[200px] sm:max-w-md">{{ $job->title }}</span>
                </nav>

                {{-- Role Header --}}
                <div class="max-w-5xl">
                    <div class="flex flex-wrap items-center gap-2.5 mb-6">
                        @if ($job->category)
                            <span
                                class="px-3.5 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-[#4fd1c5]/10 text-[#4fd1c5] border border-[#4fd1c5]/25">
                                {{ $job->category->name }}
                            </span>
                        @endif
                        @if ($job->employment_type)
                            <span
                                class="px-3.5 py-1 rounded-full text-xs font-bold bg-white/10 text-gray-200 border border-white/15">
                                {{ $job->employment_type->label() }}
                            </span>
                        @endif
                        @if ($job->location)
                            <span
                                class="px-3.5 py-1 rounded-full text-xs font-medium bg-white/5 text-gray-300 border border-white/10 inline-flex items-center gap-1.5">
                                <i class="bi bi-geo-alt text-[#4fd1c5]"></i>
                                {{ $job->location }}
                            </span>
                        @endif
                        @if ($job->experience)
                            <span
                                class="px-3.5 py-1 rounded-full text-xs font-medium bg-white/5 text-gray-300 border border-white/10">
                                Exp: {{ $job->experience }}
                            </span>
                        @endif
                        @if ($job->vacancy)
                            <span
                                class="px-3.5 py-1 rounded-full text-xs font-medium bg-white/5 text-gray-300 border border-white/10">
                                {{ $job->vacancy }} {{ Str::plural('Vacancy', $job->vacancy) }}
                            </span>
                        @endif
                        @if ($job->deadline)
                            <span
                                class="px-3.5 py-1 rounded-full text-xs font-medium bg-white/5 text-gray-300 border border-white/10">
                                Apply before: {{ $job->deadline->format('M d, Y') }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl sm:text-5xl md:text-6xl font-black text-white tracking-tight leading-[1.15] mb-6">
                        {{ $job->title }}
                    </h1>

                    <div class="flex items-center gap-4">
                        <a href="#apply-card"
                            class="bg-[#4fd1c5] hover:bg-[#38b2a6] text-black font-extrabold py-3 px-7 rounded-full text-xs sm:text-sm transition-all duration-300 transform hover:scale-105 inline-flex items-center gap-2 shadow-lg shadow-[#4fd1c5]/20">
                            <span>Apply for this Role</span>
                            <i class="bi bi-arrow-down"></i>
                        </a>
                        <a href="{{ route('careers.index') }}#open-roles"
                            class="text-gray-400 hover:text-white text-xs sm:text-sm font-semibold inline-flex items-center gap-1.5 transition-colors">
                            <i class="bi bi-arrow-left"></i>
                            <span>All Open Positions</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ====================================================================
             2. BODY & APPLICATION FUNNEL (LIGHT)
             ==================================================================== --}}
        <section class="py-20 bg-[#f8fafc] text-gray-900 relative">
            <div class="max-w-7xl mx-auto px-5 lg:px-12">

                {{-- Flash Alerts --}}
                @if (session('success'))
                    <div
                        class="mb-10 p-5 rounded-2xl bg-teal-50 border border-teal-200 text-teal-900 flex items-center gap-3 shadow-sm">
                        <i class="bi bi-check-circle-fill text-[#0d9488] text-2xl"></i>
                        <div>
                            <h4 class="font-bold text-sm text-[#0d9488]">Application Received Successfully</h4>
                            <p class="text-xs text-teal-800 mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div
                        class="mb-10 p-5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 flex items-center gap-3 shadow-sm">
                        <i class="bi bi-exclamation-triangle-fill text-rose-600 text-2xl"></i>
                        <div>
                            <h4 class="font-bold text-sm text-rose-700">Please review the form errors</h4>
                            <ul class="text-xs text-rose-700 mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- 2-Column Split: Details & Sticky Application Form --}}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">

                    {{-- Left Content: Role Narrative & Specs (7 cols) --}}
                    <div class="lg:col-span-7 space-y-10">

                        {{-- Overview --}}
                        <div class="p-8 sm:p-10 rounded-3xl bg-white border border-gray-200 shadow-sm space-y-4">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#0d9488]"></span>
                                Role Overview
                            </h2>
                            <div
                                class="text-gray-700 text-sm sm:text-base leading-relaxed space-y-4 whitespace-pre-line font-normal">
                                {{ $job->description }}
                            </div>
                        </div>

                        {{-- Requirements --}}
                        @if ($job->requirements)
                            <div class="p-8 sm:p-10 rounded-3xl bg-white border border-gray-200 shadow-sm space-y-4">
                                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-2.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#0d9488]"></span>
                                    Requirements & Technical Bar
                                </h2>
                                <div
                                    class="text-gray-700 text-sm sm:text-base leading-relaxed space-y-3 whitespace-pre-line font-normal">
                                    {{ $job->requirements }}
                                </div>
                            </div>
                        @endif

                        {{-- Benefits & Compensation with Visuals --}}
                        <div class="p-8 sm:p-10 rounded-3xl bg-white border border-gray-200 shadow-sm space-y-6">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#0d9488]"></span>
                                What We Offer You
                            </h2>

                            @if ($job->benefits)
                                <div
                                    class="text-gray-700 text-sm sm:text-base leading-relaxed whitespace-pre-line font-normal pb-4 border-b border-gray-100">
                                    {{ $job->benefits }}
                                </div>
                            @endif

                            {{-- Featured Pro Gym Banner in Benefits --}}
                            <div
                                class="rounded-2xl border border-teal-200/90 overflow-hidden bg-gradient-to-r from-teal-50 via-white to-teal-50/50 p-6 flex flex-col sm:flex-row items-center gap-6">
                                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=400"
                                    alt="Commercial Fitness Facility"
                                    class="w-full sm:w-36 h-28 rounded-xl object-cover shadow-sm">
                                <div>
                                    <span
                                        class="text-[10px] font-bold tracking-widest uppercase text-[#0d9488] bg-teal-100/70 px-2.5 py-0.5 rounded-full">
                                        COMPANY-SPONSORED
                                    </span>
                                    <h4 class="text-base font-extrabold text-gray-900 mt-1 mb-1">Full-Access Professional
                                        Gym Membership</h4>
                                    <p class="text-xs text-gray-600 leading-relaxed">
                                        100% free VIP pass to our commercial fitness center. Olympic weights, cardio zones,
                                        and certified personal trainers fully covered.
                                    </p>
                                </div>
                            </div>

                            {{-- Core Perks Cards --}}
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200">
                                    <div class="text-[#0d9488] text-lg mb-1"><i class="bi bi-cash-stack"></i></div>
                                    <h4 class="text-xs font-bold text-gray-900 mb-1">Competitive Pay</h4>
                                    <p class="text-[11px] text-gray-500">Regular appraisal cycles & performance bonuses.</p>
                                </div>
                                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200">
                                    <div class="text-[#0d9488] text-lg mb-1"><i class="bi bi-mortarboard"></i></div>
                                    <h4 class="text-xs font-bold text-gray-900 mb-1">Direct Mentorship</h4>
                                    <p class="text-[11px] text-gray-500">Learn directly alongside senior lead architects.
                                    </p>
                                </div>
                                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200">
                                    <div class="text-[#0d9488] text-lg mb-1"><i class="bi bi-people"></i></div>
                                    <h4 class="text-xs font-bold text-gray-900 mb-1">In-Office Synergy</h4>
                                    <p class="text-[11px] text-gray-500">High-speed fiber & collaborative workspaces.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Back navigation --}}
                        <div>
                            <a href="{{ route('careers.index') }}#open-roles"
                                class="text-gray-600 hover:text-[#0d9488] text-sm font-bold inline-flex items-center gap-2 transition-colors">
                                <i class="bi bi-arrow-left"></i>
                                <span>View All Open Positions</span>
                            </a>
                        </div>
                    </div>

                    {{-- Right Column: Sticky Quick Application Form (5 cols) --}}
                    <div class="lg:col-span-5 lg:sticky lg:top-28">
                        <div class="p-8 sm:p-10 rounded-3xl bg-white border border-gray-200 shadow-md relative overflow-hidden"
                            id="apply-card">

                            <div class="mb-6">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-50 border border-teal-200 text-[#0d9488] font-bold tracking-widest uppercase text-[10px] mb-3">
                                    Direct Application
                                </span>
                                <h3 class="text-2xl font-extrabold text-gray-900 mb-2">Apply for this Role</h3>
                                <p class="text-xs sm:text-sm text-gray-600">
                                    Send us your resume and links. Our engineering leads personally review every single
                                    application.
                                </p>
                            </div>

                            <form action="{{ route('careers.apply', $job->slug) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-4" x-data="{ fileName: null }">
                                @csrf

                                {{-- Full Name --}}
                                <div>
                                    <label for="name"
                                        class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                        Full Name <span class="text-[#0d9488]">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        required placeholder="e.g. Alex Morgan"
                                        class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:border-[#0d9488] focus:bg-white transition-colors @error('name') border-rose-500 @enderror">
                                    @error('name')
                                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Email Address --}}
                                <div>
                                    <label for="email"
                                        class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                        Email Address <span class="text-[#0d9488]">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        required placeholder="alex@example.com"
                                        class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:border-[#0d9488] focus:bg-white transition-colors @error('email') border-rose-500 @enderror">
                                    @error('email')
                                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Phone & Address row --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label for="phone"
                                            class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                            Phone Number
                                        </label>
                                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                            placeholder="+1 555-0199"
                                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:border-[#0d9488] focus:bg-white transition-colors">
                                    </div>
                                    <div>
                                        <label for="address"
                                            class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                            Location / City
                                        </label>
                                        <input type="text" name="address" id="address"
                                            value="{{ old('address') }}" placeholder="City, Country"
                                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:border-[#0d9488] focus:bg-white transition-colors">
                                    </div>
                                </div>

                                {{-- CV / Resume Upload Box --}}
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                        Upload Resume / CV <span class="text-[#0d9488]">*</span>
                                    </label>
                                    <div
                                        class="relative border-2 border-dashed border-gray-300 hover:border-[#0d9488] rounded-2xl p-5 text-center transition-colors cursor-pointer bg-gray-50 hover:bg-teal-50/20">
                                        <input type="file" name="cv_file" id="cv_file" required
                                            accept=".pdf,.doc,.docx"
                                            @change="fileName = $event.target.files[0] ? $event.target.files[0].name : null"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <div class="space-y-1 pointer-events-none">
                                            <i class="bi bi-cloud-arrow-up text-2xl text-[#0d9488]"></i>
                                            <p class="text-xs font-semibold text-gray-800"
                                                x-text="fileName ? fileName : 'Click to upload or drag & drop'"></p>
                                            <p class="text-[11px] text-gray-500">PDF, DOC, DOCX up to 5MB</p>
                                        </div>
                                    </div>
                                    @error('cv_file')
                                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Professional Links --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label for="linkedin_url"
                                            class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                            LinkedIn URL
                                        </label>
                                        <input type="url" name="linkedin_url" id="linkedin_url"
                                            value="{{ old('linkedin_url') }}" placeholder="https://linkedin.com/in/..."
                                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:border-[#0d9488] focus:bg-white transition-colors">
                                    </div>
                                    <div>
                                        <label for="github_url"
                                            class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                            GitHub / Portfolio
                                        </label>
                                        <input type="url" name="github_url" id="github_url"
                                            value="{{ old('github_url') }}" placeholder="https://github.com/..."
                                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:border-[#0d9488] focus:bg-white transition-colors">
                                    </div>
                                </div>

                                {{-- Cover Note --}}
                                <div>
                                    <label for="cover_letter"
                                        class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                        Cover Note / Message
                                    </label>
                                    <textarea name="cover_letter" id="cover_letter" rows="3"
                                        placeholder="Briefly tell us why you are interested in this position..."
                                        class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:border-[#0d9488] focus:bg-white transition-colors">{{ old('cover_letter') }}</textarea>
                                </div>

                                {{-- Submit Button --}}
                                <div class="pt-2">
                                    <button type="submit"
                                        class="w-full bg-[#0d9488] hover:bg-[#0f766e] text-white font-extrabold py-4 px-6 rounded-xl text-sm transition-all duration-300 transform hover:scale-[1.02] shadow-md flex items-center justify-center gap-2">
                                        <span>Submit Application</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>

                                <p class="text-[11px] text-gray-500 text-center mt-3">
                                    We value your privacy. Your information is reviewed strictly for employment purposes.
                                </p>
                            </form>

                        </div>
                    </div>

                </div>

                {{-- Related Open Roles --}}
                @if (isset($relatedJobs) && $relatedJobs->isNotEmpty())
                    <div class="mt-20 pt-14 border-t border-gray-200">
                        <div class="text-left mb-8">
                            <span class="text-[#0d9488] font-bold tracking-widest uppercase text-xs mb-2 block">EXPLORE
                                MORE ROLES</span>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Other Opportunities in this Area
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach ($relatedJobs as $related)
                                <div
                                    class="p-6 rounded-2xl bg-white border border-gray-200 hover:border-[#0d9488]/60 transition-all duration-300 group flex flex-col justify-between shadow-sm hover:shadow-md">
                                    <div>
                                        <div class="flex items-center gap-2 mb-3">
                                            @if ($related->employment_type)
                                                <span
                                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                                    {{ $related->employment_type->label() }}
                                                </span>
                                            @endif
                                            @if ($related->location)
                                                <span class="text-[11px] text-gray-500">
                                                    {{ $related->location }}
                                                </span>
                                            @endif
                                        </div>
                                        <h4
                                            class="text-lg font-bold text-gray-900 group-hover:text-[#0d9488] transition-colors mb-2">
                                            <a href="{{ route('careers.show', $related->slug) }}">
                                                {{ $related->title }}
                                            </a>
                                        </h4>
                                        <p class="text-gray-600 text-xs line-clamp-2 mb-4 leading-relaxed">
                                            {{ Str::limit(strip_tags($related->description), 100) }}
                                        </p>
                                    </div>
                                    <div>
                                        <a href="{{ route('careers.show', $related->slug) }}"
                                            class="text-[#0d9488] text-xs font-bold inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                            <span>View Role</span>
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </section>

        {{-- ====================================================================
             3. GLOBAL CTA SECTION (DARK)
             ==================================================================== --}}
        <div id="contact">
            @include('frontend.components.global.cta')
        </div>
    </main>
@endsection
