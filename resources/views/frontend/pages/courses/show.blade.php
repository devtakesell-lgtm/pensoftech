@extends('frontend.layouts.front-master')

@section('title', $course->title . ' — PenSoftTech Academy')
@section('meta_title', $course->seo?->meta_title ?? $course->title . ' — PenSoftTech Academy')
@section('meta_description', $course->seo?->meta_description ?? $course->subtitle ?? Str::limit(strip_tags($course->description), 160))
@section('meta_keywords', $course->seo?->meta_keywords)
@section('canonical_url', $course->seo?->canonical_url ?? route('courses.show', $course->slug))

@if ($course->thumbnail_url)
    @section('og_image', $course->thumbnail_url)
@endif

@section('content')
    @php
        $symbol = $course->currency?->symbol ?? $defaultCurrency?->symbol ?? '৳';
        $seatsLeft = $course->max_seats ? max(0, $course->max_seats - $enrolledCount) : null;
        $applyUrl = Route::has('courses.apply') ? route('courses.apply', $course->slug) : '#enroll-section';
    @endphp

    <main>
        {{-- 1. HERO HEADER (DARK) --}}
        <section class="bg-black text-gray-100 pt-36 md:pt-44 pb-16 relative overflow-hidden">
            <div class="absolute top-1/4 -right-48 w-96 h-96 bg-[#4fd1c5]/10 rounded-full blur-[140px] pointer-events-none"></div>
            <div class="absolute top-2/3 -left-48 w-96 h-96 bg-[#319795]/10 rounded-full blur-[140px] pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-5 lg:px-12 relative z-10">
                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-2 text-xs font-semibold text-gray-400 mb-6 uppercase tracking-wider" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                    <span>/</span>
                    <a href="{{ route('courses.index') }}" class="hover:text-white transition-colors">Courses</a>
                    <span>/</span>
                    <span class="text-[#4fd1c5] truncate max-w-[200px] sm:max-w-md">{{ $course->title }}</span>
                </nav>

                <div class="max-w-4xl">
                    {{-- Badges --}}
                    <div class="flex flex-wrap items-center gap-2.5 mb-5">
                        @if ($course->category)
                            <span class="px-3.5 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-[#4fd1c5]/10 text-[#4fd1c5] border border-[#4fd1c5]/25">
                                {{ $course->category->name }}
                            </span>
                        @endif
                        <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-white/10 text-gray-200 border border-white/15 inline-flex items-center gap-1.5">
                            <i class="bi {{ $course->delivery_mode->icon() }} text-[#4fd1c5]"></i>
                            {{ $course->delivery_mode->label() }}
                        </span>
                        @if ($course->batch_no)
                            <span class="px-3.5 py-1 rounded-full text-xs font-bold bg-white/10 text-gray-200 border border-white/15">
                                {{ $course->batch_no }}
                            </span>
                        @endif
                        @if ($course->is_free)
                            <span class="px-3.5 py-1 rounded-full text-xs font-extrabold bg-[#4fd1c5] text-black">
                                FREE PROGRAM
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-[1.15] mb-5">
                        {{ $course->title }}
                    </h1>

                    @if ($course->subtitle)
                        <p class="text-base sm:text-lg text-gray-300 leading-relaxed mb-8">
                            {{ $course->subtitle }}
                        </p>
                    @endif

                    {{-- Quick Info Bar --}}
                    <div class="flex flex-wrap items-center gap-6 pt-6 border-t border-white/10 text-sm text-gray-300">
                        @if ($course->instructor)
                            <div class="flex items-center gap-3">
                                @if ($course->instructor->avatar_url)
                                    <img src="{{ $course->instructor->avatar_url }}" alt="{{ $course->instructor->name }}"
                                        class="w-10 h-10 rounded-full object-cover border border-[#4fd1c5]/50">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-[#4fd1c5]/20 text-[#4fd1c5] font-bold flex items-center justify-center">
                                        {{ strtoupper(substr($course->instructor->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-xs text-gray-400">Mentor / Instructor</div>
                                    <div class="font-bold text-white">{{ $course->instructor->name }}</div>
                                </div>
                            </div>
                        @endif

                        @if ($course->start_date)
                            <div>
                                <div class="text-xs text-gray-400">Batch Starts</div>
                                <div class="font-bold text-white">{{ $course->start_date->format('d M, Y') }}</div>
                            </div>
                        @endif

                        @if ($course->enrollment_deadline)
                            <div>
                                <div class="text-xs text-gray-400">Application Deadline</div>
                                <div class="font-bold text-[#4fd1c5]">{{ $course->enrollment_deadline->format('d M, Y') }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- 2. COURSE BODY & STICKY SIDEBAR --}}
        <section class="py-12 md:py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-5 lg:px-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                    {{-- Left Column (8 cols) --}}
                    <div class="lg:col-span-8 space-y-10">

                        {{-- Thumbnail / Preview Banner --}}
                        @if ($course->thumbnail_url)
                            <div class="rounded-2xl overflow-hidden border border-gray-200 bg-white shadow-sm">
                                <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="w-full h-auto max-h-[420px] object-cover">
                            </div>
                        @endif

                        {{-- What You Will Learn --}}
                        @if (is_array($course->what_you_will_learn) && count($course->what_you_will_learn) > 0)
                            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8 shadow-sm">
                                <h2 class="text-2xl font-extrabold text-gray-900 mb-6 flex items-center gap-2.5">
                                    <i class="bi bi-stars text-[#38b2a6]"></i>
                                    <span>What You Will Learn</span>
                                </h2>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach ($course->what_you_will_learn as $outcome)
                                        <div class="flex items-start gap-3">
                                            <span class="w-5 h-5 rounded-full bg-teal-50 text-[#2c988e] flex items-center justify-center shrink-0 mt-0.5">
                                                <i class="bi bi-check-lg text-sm font-bold"></i>
                                            </span>
                                            <span class="text-sm text-gray-700 leading-relaxed">{{ $outcome }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Course Overview --}}
                        <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8 shadow-sm">
                            <h2 class="text-2xl font-extrabold text-gray-900 mb-5">Course Overview</h2>
                            <div class="prose prose-slate max-w-none text-gray-700 leading-relaxed">
                                {!! $course->description !!}
                            </div>
                        </div>

                        {{-- Interactive Curriculum Accordion --}}
                        @if ($course->modules->count() > 0)
                            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8 shadow-sm" x-data="{ activeModule: 0 }">
                                <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
                                    <h2 class="text-2xl font-extrabold text-gray-900">Course Curriculum</h2>
                                    <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                        {{ $course->modules->count() }} {{ Str::plural('Module', $course->modules->count()) }}
                                        • {{ $course->modules->sum(fn ($m) => $m->lessons->count()) }} Lessons
                                    </span>
                                </div>

                                <div class="space-y-3">
                                    @foreach ($course->modules as $index => $module)
                                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                                            <button type="button"
                                                @click="activeModule = activeModule === {{ $index }} ? null : {{ $index }}"
                                                class="w-full px-5 py-4 bg-gray-50/80 hover:bg-gray-100/80 flex items-center justify-between gap-4 text-left transition-colors">
                                                <div>
                                                    <div class="text-xs font-bold text-[#2c988e] uppercase tracking-wider mb-0.5">
                                                        Module {{ $module->order }}
                                                    </div>
                                                    <div class="font-bold text-gray-900">{{ $module->title }}</div>
                                                </div>
                                                <div class="flex items-center gap-3 shrink-0">
                                                    <span class="text-xs text-gray-500">{{ $module->lessons->count() }} {{ Str::plural('Lesson', $module->lessons->count()) }}</span>
                                                    <i class="bi bi-chevron-down text-gray-500 transition-transform duration-200"
                                                        :class="activeModule === {{ $index }} ? 'rotate-180' : ''"></i>
                                                </div>
                                            </button>

                                            <div x-show="activeModule === {{ $index }}" x-collapse class="border-t border-gray-200 bg-white divide-y divide-gray-100">
                                                @if ($module->description)
                                                    <div class="px-5 py-3 text-xs text-gray-500 bg-gray-50/40">
                                                        {{ $module->description }}
                                                    </div>
                                                @endif
                                                @forelse ($module->lessons as $lesson)
                                                    <div class="px-5 py-3.5 flex items-center justify-between gap-4">
                                                        <div class="flex items-center gap-3 min-w-0">
                                                            <i class="bi {{ $lesson->lesson_type->icon() }} text-[#38b2a6] shrink-0"></i>
                                                            <div class="min-w-0">
                                                                <div class="text-sm font-medium text-gray-800 truncate">{{ $lesson->title }}</div>
                                                                <div class="text-[11px] text-gray-400">{{ $lesson->lesson_type->label() }}</div>
                                                            </div>
                                                        </div>
                                                        @if ($lesson->duration_minutes)
                                                            <span class="text-xs text-gray-500 shrink-0">{{ $lesson->duration_minutes }} min</span>
                                                        @endif
                                                    </div>
                                                @empty
                                                    <div class="px-5 py-4 text-xs text-gray-400">Syllabus details coming soon.</div>
                                                @endforelse
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Prerequisites --}}
                        @if (is_array($course->prerequisites) && count($course->prerequisites) > 0)
                            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8 shadow-sm">
                                <h2 class="text-2xl font-extrabold text-gray-900 mb-5">Prerequisites & Requirements</h2>
                                <ul class="space-y-3">
                                    @foreach ($course->prerequisites as $req)
                                        <li class="flex items-start gap-3 text-sm text-gray-700">
                                            <i class="bi bi-arrow-right-circle-fill text-[#38b2a6] mt-0.5 shrink-0"></i>
                                            <span>{{ $req }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Instructor Profile --}}
                        @if ($course->instructor)
                            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8 shadow-sm">
                                <h2 class="text-2xl font-extrabold text-gray-900 mb-6">Your Mentor</h2>
                                <div class="flex flex-col sm:flex-row gap-6 items-start">
                                    @if ($course->instructor->avatar_url)
                                        <img src="{{ $course->instructor->avatar_url }}" alt="{{ $course->instructor->name }}"
                                            class="w-24 h-24 rounded-2xl object-cover border border-gray-200 shrink-0">
                                    @else
                                        <div class="w-24 h-24 rounded-2xl bg-teal-50 text-[#2c988e] font-extrabold text-2xl flex items-center justify-center shrink-0">
                                            {{ strtoupper(substr($course->instructor->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $course->instructor->name }}</h3>
                                        <p class="text-sm font-semibold text-[#2c988e] mb-3">{{ $course->instructor->designation }}</p>
                                        @if ($course->instructor->bio)
                                            <p class="text-sm text-gray-600 leading-relaxed mb-4">{{ $course->instructor->bio }}</p>
                                        @endif
                                        @if (is_array($course->instructor->skills) && count($course->instructor->skills) > 0)
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($course->instructor->skills as $skill)
                                                    <span class="px-2.5 py-1 rounded-md bg-gray-100 text-gray-700 text-xs font-medium">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Right Column: Sticky Enrollment Card (4 cols) --}}
                    <div class="lg:col-span-4" id="enroll-section">
                        <div class="sticky top-28 bg-white rounded-2xl border border-gray-200 shadow-lg p-6 md:p-7">
                            {{-- Price Header --}}
                            <div class="pb-5 mb-5 border-b border-gray-100">
                                @if ($course->is_free)
                                    <div class="inline-block px-3 py-1 rounded-full bg-teal-50 text-[#2c988e] text-xs font-extrabold uppercase tracking-wider mb-2">
                                        100% Free Scholarship Program
                                    </div>
                                    <div class="text-3xl font-black text-gray-900">Free</div>
                                    <p class="text-xs text-gray-500 mt-1">Selection based on screening & interview</p>
                                @else
                                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Course Fee</div>
                                    <div class="flex items-baseline gap-2.5">
                                        <span class="text-3xl font-black text-gray-900">
                                            {{ $symbol }}{{ number_format($course->effectivePrice(), 0) }}
                                        </span>
                                        @if ($course->discount_price && $course->price > $course->discount_price)
                                            <span class="text-base text-gray-400 line-through">
                                                {{ $symbol }}{{ number_format($course->price, 0) }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Batch & Schedule Details --}}
                            <ul class="space-y-3.5 text-sm text-gray-600 mb-6">
                                <li class="flex items-start gap-3">
                                    <i class="bi {{ $course->delivery_mode->icon() }} text-[#38b2a6] mt-0.5"></i>
                                    <div>
                                        <span class="text-gray-400 text-xs block">Format</span>
                                        <strong class="text-gray-900">{{ $course->delivery_mode->label() }}</strong>
                                    </div>
                                </li>

                                @if ($course->venue)
                                    <li class="flex items-start gap-3">
                                        <i class="bi bi-geo-alt text-[#38b2a6] mt-0.5"></i>
                                        <div>
                                            <span class="text-gray-400 text-xs block">Office Venue</span>
                                            <strong class="text-gray-900">{{ $course->venue }}</strong>
                                        </div>
                                    </li>
                                @endif

                                @if ($course->class_schedule)
                                    <li class="flex items-start gap-3">
                                        <i class="bi bi-clock text-[#38b2a6] mt-0.5"></i>
                                        <div>
                                            <span class="text-gray-400 text-xs block">Class Schedule</span>
                                            <strong class="text-gray-900">{{ $course->class_schedule }}</strong>
                                        </div>
                                    </li>
                                @endif

                                @if ($course->duration_weeks || $course->total_classes)
                                    <li class="flex items-start gap-3">
                                        <i class="bi bi-journal-bookmark text-[#38b2a6] mt-0.5"></i>
                                        <div>
                                            <span class="text-gray-400 text-xs block">Duration & Classes</span>
                                            <strong class="text-gray-900">
                                                {{ $course->duration_weeks ? $course->duration_weeks . ' Weeks' : '' }}
                                                {{ $course->total_classes ? '(' . $course->total_classes . ' Classes)' : '' }}
                                            </strong>
                                        </div>
                                    </li>
                                @endif

                                @if ($course->max_seats)
                                    <li class="flex items-start gap-3">
                                        <i class="bi bi-people text-[#38b2a6] mt-0.5"></i>
                                        <div>
                                            <span class="text-gray-400 text-xs block">Seat Availability</span>
                                            <strong class="text-gray-900">
                                                {{ $seatsLeft }} of {{ $course->max_seats }} Seats Available
                                            </strong>
                                        </div>
                                    </li>
                                @endif
                            </ul>

                            {{-- Primary CTA --}}
                            @if ($course->intro_video_url)
                                <a href="{{ $course->intro_video_url }}" target="_blank"
                                    class="w-full mb-3 inline-flex items-center justify-center gap-2 py-3 px-5 rounded-xl border border-gray-200 text-gray-800 font-bold text-sm hover:bg-gray-50 transition-colors">
                                    <i class="bi bi-play-circle text-red-500"></i>
                                    <span>Watch Intro Video</span>
                                </a>
                            @endif

                            <a href="{{ $applyUrl }}"
                                class="w-full inline-flex items-center justify-center gap-2 bg-[#4fd1c5] hover:bg-[#38b2a6] text-black font-extrabold py-3.5 px-6 rounded-xl text-sm transition-all duration-300 shadow-[0_4px_15px_rgba(79,209,197,0.35)]">
                                <span>{{ $course->is_free ? 'Apply for Free Batch' : 'Enroll Now' }}</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>

                            @if ($course->enrollment_deadline)
                                <p class="text-center text-xs text-gray-500 mt-3">
                                    Applications close on <strong>{{ $course->enrollment_deadline->format('d M, Y') }}</strong>
                                </p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
