@extends('frontend.layouts.front-master')

@section('title', 'Skill Buildup Courses & Bootcamps — PenSoftTech Academy')
@section('meta_description', 'Join practical, project-based software engineering, UI/UX, and tech bootcamps at PenSoftTech. In-person office mentorship and live training.')

@section('content')
    <main>
        {{-- 1. HERO HEADER (DARK) --}}
        <section class="bg-black text-gray-100 pt-36 md:pt-44 pb-16 md:pb-20 relative overflow-hidden">
            <div class="absolute top-1/4 -left-48 w-96 h-96 bg-[#4fd1c5]/10 rounded-full blur-[140px] pointer-events-none"></div>
            <div class="absolute top-1/3 -right-48 w-96 h-96 bg-[#319795]/10 rounded-full blur-[140px] pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-5 lg:px-12 relative z-10">
                <nav class="flex items-center gap-2 text-xs font-semibold text-gray-400 mb-6 uppercase tracking-wider" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                    <span>/</span>
                    <span class="text-[#4fd1c5]">Courses</span>
                </nav>

                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#4fd1c5]/10 border border-[#4fd1c5]/25 text-[#4fd1c5] text-xs font-bold uppercase tracking-widest mb-6">
                        <span class="w-2 h-2 rounded-full bg-[#4fd1c5] animate-pulse"></span>
                        PenSoftTech Academy ({{ $totalCourses }} Active {{ Str::plural('Program', $totalCourses) }})
                    </div>

                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white tracking-tight leading-[1.1] mb-6">
                        Hands-On <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4fd1c5] via-teal-300 to-[#2c988e]">Skill Buildup</span> Programs
                    </h1>

                    <p class="text-base sm:text-lg text-gray-300 leading-relaxed max-w-2xl">
                        Learn directly from senior engineers and product designers at our office training lab. Master real-world software architecture, teamwork, and industry workflows.
                    </p>
                </div>
            </div>
        </section>

        {{-- 2. FILTER BAR & COURSE CATALOG --}}
        <section class="py-14 md:py-20 bg-gray-50 min-h-[60vh]">
            <div class="max-w-7xl mx-auto px-5 lg:px-12">

                {{-- Filter & Search Card --}}
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm p-5 md:p-6 mb-10">
                    <form method="GET" action="{{ route('courses.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <div class="md:col-span-5 relative">
                            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="search" value="{{ $currentSearch }}"
                                placeholder="Search courses, batch, or topics..."
                                class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800 focus:outline-none focus:border-[#38b2a6] focus:ring-2 focus:ring-[#4fd1c5]/20">
                        </div>

                        <div class="md:col-span-2">
                            <select name="category" onchange="this.form.submit()"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-700 bg-white focus:outline-none focus:border-[#38b2a6]">
                                <option value="">All Categories</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->slug }}" {{ $currentCategory === $cat->slug ? 'selected' : '' }}>
                                        {{ $cat->name }} ({{ $cat->courses_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <select name="mode" onchange="this.form.submit()"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-700 bg-white focus:outline-none focus:border-[#38b2a6]">
                                <option value="">All Formats</option>
                                @foreach ($deliveryModes as $mode)
                                    <option value="{{ $mode->value }}" {{ $currentMode === $mode->value ? 'selected' : '' }}>
                                        {{ $mode->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <select name="pricing" onchange="this.form.submit()"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-700 bg-white focus:outline-none focus:border-[#38b2a6]">
                                <option value="">All Pricing</option>
                                <option value="free" {{ $currentPricing === 'free' ? 'selected' : '' }}>Free Programs</option>
                                <option value="paid" {{ $currentPricing === 'paid' ? 'selected' : '' }}>Paid Programs</option>
                            </select>
                        </div>

                        <div class="md:col-span-1 flex gap-2">
                            <button type="submit"
                                class="w-full bg-black hover:bg-gray-800 text-white font-semibold py-2.5 px-4 rounded-xl text-sm transition-colors">
                                Filter
                            </button>
                        </div>
                    </form>

                    @if (!empty($currentSearch) || !empty($currentCategory) || !empty($currentMode) || !empty($currentPricing))
                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                            <span>Showing filtered results ({{ $courses->total() }} {{ Str::plural('course', $courses->total()) }})</span>
                            <a href="{{ route('courses.index') }}" class="text-[#2c988e] hover:underline font-semibold">
                                Clear All Filters
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Course Cards Grid --}}
                @if ($courses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                        @foreach ($courses as $course)
                            @php
                                $symbol = $course->currency?->symbol ?? $defaultCurrency?->symbol ?? '৳';
                            @endphp
                            <article class="bg-white rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group">
                                {{-- Thumbnail --}}
                                <a href="{{ route('courses.show', $course->slug) }}" class="relative block aspect-[16/9] bg-gray-900 overflow-hidden">
                                    @if ($course->thumbnail_url)
                                        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-900 via-slate-800 to-teal-900 flex items-center justify-center p-6 text-center">
                                            <span class="text-[#4fd1c5] font-extrabold text-xl tracking-tight">{{ $course->title }}</span>
                                        </div>
                                    @endif

                                    {{-- Top Badges --}}
                                    <div class="absolute top-3 left-3 right-3 flex items-center justify-between gap-2">
                                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-black/75 backdrop-blur-md text-white border border-white/15 inline-flex items-center gap-1.5">
                                            <i class="bi {{ $course->delivery_mode->icon() }} text-[#4fd1c5]"></i>
                                            {{ $course->delivery_mode->label() }}
                                        </span>

                                        @if ($course->is_free)
                                            <span class="px-3 py-1 rounded-full text-[11px] font-extrabold bg-[#4fd1c5] text-black shadow-sm">
                                                FREE
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-[11px] font-extrabold bg-white text-gray-900 shadow-sm">
                                                {{ $symbol }}{{ number_format($course->effectivePrice(), 0) }}
                                            </span>
                                        @endif
                                    </div>
                                </a>

                                {{-- Card Body --}}
                                <div class="p-6 flex flex-col flex-grow">
                                    <div class="flex items-center justify-between gap-2 mb-3">
                                        <span class="text-xs font-bold uppercase tracking-wider text-[#2c988e]">
                                            {{ $course->category?->name ?? 'Academy' }}
                                        </span>
                                        @if ($course->batch_no)
                                            <span class="px-2.5 py-0.5 rounded-md bg-gray-100 text-gray-700 text-xs font-semibold">
                                                {{ $course->batch_no }}
                                            </span>
                                        @endif
                                    </div>

                                    <h2 class="text-xl font-bold text-gray-900 leading-snug mb-2 group-hover:text-[#2c988e] transition-colors">
                                        <a href="{{ route('courses.show', $course->slug) }}">
                                            {{ $course->title }}
                                        </a>
                                    </h2>

                                    @if ($course->subtitle)
                                        <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                                            {{ $course->subtitle }}
                                        </p>
                                    @endif

                                    {{-- Meta Grid --}}
                                    <div class="mt-auto pt-4 border-t border-gray-100 space-y-2 text-xs text-gray-500">
                                        @if ($course->start_date)
                                            <div class="flex items-center gap-2">
                                                <i class="bi bi-calendar-event text-[#38b2a6]"></i>
                                                <span>Starts: <strong class="text-gray-800">{{ $course->start_date->format('d M, Y') }}</strong></span>
                                            </div>
                                        @endif
                                        @if ($course->duration_weeks || $course->total_classes)
                                            <div class="flex items-center gap-2">
                                                <i class="bi bi-clock text-[#38b2a6]"></i>
                                                <span>
                                                    @if ($course->duration_weeks) {{ $course->duration_weeks }} Weeks @endif
                                                    @if ($course->duration_weeks && $course->total_classes) • @endif
                                                    @if ($course->total_classes) {{ $course->total_classes }} Classes @endif
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Footer: Instructor & CTA --}}
                                    <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            @if ($course->instructor?->avatar_url)
                                                <img src="{{ $course->instructor->avatar_url }}" alt="{{ $course->instructor->name }}"
                                                    class="w-8 h-8 rounded-full object-cover border border-gray-200 shrink-0">
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-teal-50 text-[#2c988e] font-bold text-xs flex items-center justify-center shrink-0">
                                                    {{ strtoupper(substr($course->instructor?->name ?? 'PT', 0, 2)) }}
                                                </div>
                                            @endif
                                            <span class="text-xs font-semibold text-gray-700 truncate">
                                                {{ $course->instructor?->name ?? 'PenSoftTech Team' }}
                                            </span>
                                        </div>

                                        <a href="{{ route('courses.show', $course->slug) }}"
                                            class="inline-flex items-center gap-1.5 text-xs font-bold text-black bg-[#4fd1c5]/20 hover:bg-[#4fd1c5] px-3.5 py-2 rounded-full transition-colors shrink-0">
                                            <span>Details</span>
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if ($courses->hasPages())
                        <div class="mt-12">
                            {{ $courses->links() }}
                        </div>
                    @endif
                @else
                    <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-teal-50 text-[#2c988e] flex items-center justify-center text-2xl mb-4">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Courses Found</h3>
                        <p class="text-sm text-gray-500 max-w-md mx-auto mb-6">
                            We couldn't find any published courses matching your filter criteria. Try resetting your filters or check back soon for upcoming batches!
                        </p>
                        <a href="{{ route('courses.index') }}"
                            class="inline-flex items-center gap-2 bg-black text-white font-semibold px-6 py-2.5 rounded-full text-sm hover:bg-gray-800 transition-colors">
                            View All Courses
                        </a>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
