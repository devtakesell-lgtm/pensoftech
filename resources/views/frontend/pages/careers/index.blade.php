@extends('frontend.layouts.front-master')

@section('title', 'Careers & Engineering Opportunities — PenSoftTech')
@section('meta_description',
    'Join our elite engineering and product squads at PenSoftTech. Explore full-time in-office
    software engineering, UI/UX, and cloud architecture careers.')

@section('content')
    <main>
        {{-- ====================================================================
             1. HERO SECTION (DARK) - 2-Column with Visual Showcase
             ==================================================================== --}}
        <section class="bg-black text-gray-100 pt-36 md:pt-44 pb-20 md:pb-28 relative overflow-hidden">
            {{-- Ambient Lighting Glows --}}
            <div class="absolute top-1/4 -left-48 w-96 h-96 bg-[#4fd1c5]/10 rounded-full blur-[140px] pointer-events-none">
            </div>
            <div class="absolute top-1/3 -right-48 w-96 h-96 bg-[#319795]/10 rounded-full blur-[140px] pointer-events-none">
            </div>

            <div class="max-w-7xl mx-auto px-5 lg:px-12 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

                    {{-- Left Column: Copy & Actions (7 cols) --}}
                    <div class="lg:col-span-7 text-left">
                        <nav class="flex items-center gap-2 text-xs font-semibold text-gray-400 mb-6 uppercase tracking-wider"
                            aria-label="Breadcrumb">
                            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                            <span>/</span>
                            <span class="text-[#4fd1c5]">Careers</span>
                        </nav>

                        <div
                            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#4fd1c5]/10 border border-[#4fd1c5]/25 text-[#4fd1c5] text-xs font-bold uppercase tracking-widest mb-6">
                            <span class="w-2 h-2 rounded-full bg-[#4fd1c5] animate-pulse"></span>
                            We Are Hiring ({{ $totalOpenRoles }} Active {{ Str::plural('Role', $totalOpenRoles) }})
                        </div>

                        <h1
                            class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white tracking-tight leading-[1.1] mb-6">
                            Build Systems That Power <br class="hidden sm:inline" />
                            <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-[#4fd1c5] via-teal-300 to-[#2c988e]">
                                Global Scale
                            </span>
                        </h1>

                        <p class="text-base sm:text-lg text-gray-300 font-normal leading-relaxed max-w-xl mb-8">
                            We assemble elite squads to engineer scalable SaaS platforms, robust cloud architectures, and
                            transformative digital systems. Join engineers who take pride in on-site craftsmanship, rapid
                            collaboration, and clean code.
                        </p>

                        <div class="flex flex-wrap items-center gap-4 mb-12">
                            <a href="#open-roles"
                                class="bg-[#4fd1c5] hover:bg-[#38b2a6] text-black font-extrabold py-3.5 px-8 rounded-full text-sm transition-all duration-300 transform hover:scale-105 hover:shadow-[0_0_25px_rgba(79,209,197,0.4)] inline-flex items-center gap-2">
                                <span>Explore Open Positions</span>
                                <i class="bi bi-arrow-down"></i>
                            </a>
                            <a href="#culture"
                                class="bg-white/5 hover:bg-white/10 text-white font-bold py-3.5 px-7 rounded-full text-sm border border-white/10 transition-all duration-300 inline-flex items-center gap-2">
                                <span>Why PenSoftTech</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>

                        {{-- Quick Metrics --}}
                        <div class="grid grid-cols-3 gap-4 pt-8 border-t border-white/10 max-w-lg">
                            <div>
                                <h3 class="text-2xl sm:text-3xl font-extrabold text-[#4fd1c5]">100%</h3>
                                <p class="text-xs text-gray-400 mt-1">In-Office Synergy</p>
                            </div>
                            <div>
                                <h3 class="text-2xl sm:text-3xl font-extrabold text-white">VIP Pass</h3>
                                <p class="text-xs text-gray-400 mt-1">Free Pro Gym Access</p>
                            </div>
                            <div>
                                <h3 class="text-2xl sm:text-3xl font-extrabold text-white">Direct</h3>
                                <p class="text-xs text-gray-400 mt-1">Senior Mentorship</p>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Multi-Layer Visual Showcase (5 cols) --}}
                    <div class="lg:col-span-5 relative">
                        {{-- Background Glow --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-tr from-[#4fd1c5]/25 via-teal-500/10 to-transparent rounded-3xl blur-2xl transform translate-x-4 translate-y-4 pointer-events-none">
                        </div>

                        {{-- Main Feature Image Container (Clean view, no text collision) --}}
                        <div class="relative rounded-3xl overflow-hidden border border-white/15 shadow-2xl bg-[#111] group">
                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=1000"
                                alt="PenSoftTech In-Office Team Collaboration"
                                class="w-full h-[420px] sm:h-[480px] object-cover group-hover:scale-105 transition-transform duration-700">

                            {{-- Subtle Gradient Overlay --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none">
                            </div>

                            {{-- Clean Corner Tag --}}
                            <div
                                class="absolute top-4 left-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/75 backdrop-blur-md border border-white/15 text-xs text-white font-semibold pointer-events-none">
                                <span class="w-2 h-2 rounded-full bg-[#4fd1c5] animate-pulse"></span>
                                <span>Engineering Hub</span>
                            </div>
                        </div>

                        {{-- Floating Glass Card: Team Culture (Top Right) --}}
                        <div
                            class="absolute -top-5 -right-3 sm:-right-6 bg-black/90 backdrop-blur-xl border border-white/15 px-4 py-3.5 rounded-2xl shadow-2xl flex items-center gap-3 z-20">
                            <div
                                class="w-10 h-10 rounded-xl bg-[#4fd1c5]/15 border border-[#4fd1c5]/30 flex items-center justify-center text-[#4fd1c5] text-lg">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <p class="text-[11px] text-gray-400 font-medium">Work Culture</p>
                                <p class="text-xs font-bold text-white">In-Office Synergy</p>
                            </div>
                        </div>

                        {{-- Floating Glass Card: Gym Perk (Bottom Left - Clear of any underlying text) --}}
                        <div
                            class="absolute -bottom-5 -left-3 sm:-left-6 bg-black/90 backdrop-blur-xl border border-[#4fd1c5]/40 px-4 py-3.5 rounded-2xl shadow-2xl flex items-center gap-3 z-20">
                            <div
                                class="w-10 h-10 rounded-xl bg-[#4fd1c5] flex items-center justify-center text-black text-lg font-bold">
                                <i class="bi bi-heart-pulse-fill"></i>
                            </div>
                            <div>
                                <p class="text-[11px] text-[#4fd1c5] font-bold">Exclusive Perk</p>
                                <p class="text-xs font-extrabold text-white">Free Pro Gym VIP Pass</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        {{-- ====================================================================
             2. CULTURE & VALUES (LIGHT) - With Real Workplace Image
             ==================================================================== --}}
        <section id="culture" class="py-24 bg-white text-gray-900 relative scroll-mt-16">
            <div class="max-w-7xl mx-auto px-5 lg:px-12">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-[#0d9488] font-bold tracking-widest uppercase text-xs sm:text-sm mb-3 block">OUR
                        CULTURE & CREED</span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight">
                        How We Build at PenSoftTech
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base mt-4 leading-relaxed">
                        We don't do corporate bureaucracy, bloated hierarchies, or pointless meetings. We prioritize
                        autonomy, craft, and outcomes.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                    {{-- Left: Atmospheric Team Environment Photo (5 cols) --}}
                    <div class="lg:col-span-5 relative">
                        <div class="rounded-3xl overflow-hidden border border-gray-200 shadow-xl relative group">
                            <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=1000"
                                alt="Engineers Reviewing Architecture"
                                class="w-full h-[460px] object-cover group-hover:scale-105 transition-transform duration-700">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent">
                            </div>

                            <div class="absolute bottom-6 left-6 right-6 text-white">
                                <blockquote class="text-sm font-semibold italic text-gray-200 mb-2 leading-relaxed">
                                    "We don't build software just to close tickets; we architect systems that stand the test
                                    of global scale."
                                </blockquote>
                                <span class="text-xs text-[#4fd1c5] font-bold uppercase tracking-wider block">— Engineering
                                    Philosophy</span>
                            </div>
                        </div>
                    </div>

                    {{-- Right: 4 Culture Pillars (7 cols) --}}
                    <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Value 1 --}}
                        <div
                            class="p-6 rounded-2xl bg-[#f8fafc] border border-gray-100 hover:border-[#0d9488]/40 transition-all duration-300 shadow-sm hover:shadow-md">
                            <div
                                class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-200/80 flex items-center justify-center text-[#0d9488] text-xl mb-4">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h3 class="text-base font-extrabold text-gray-900 mb-2">Extreme Ownership</h3>
                            <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">
                                From RFC architecture to deploy, you own your code. Smart builders get full trust to execute
                                without micromanagement.
                            </p>
                        </div>

                        {{-- Value 2 --}}
                        <div
                            class="p-6 rounded-2xl bg-[#f8fafc] border border-gray-100 hover:border-[#0d9488]/40 transition-all duration-300 shadow-sm hover:shadow-md">
                            <div
                                class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-200/80 flex items-center justify-center text-[#0d9488] text-xl mb-4">
                                <i class="bi bi-code-slash"></i>
                            </div>
                            <h3 class="text-base font-extrabold text-gray-900 mb-2">Engineering Craft</h3>
                            <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">
                                Clean code, strict static types, and thorough automated test suites. We treat software as an
                                exacting discipline.
                            </p>
                        </div>

                        {{-- Value 3 --}}
                        <div
                            class="p-6 rounded-2xl bg-[#f8fafc] border border-gray-100 hover:border-[#0d9488]/40 transition-all duration-300 shadow-sm hover:shadow-md">
                            <div
                                class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-200/80 flex items-center justify-center text-[#0d9488] text-xl mb-4">
                                <i class="bi bi-lightning-charge"></i>
                            </div>
                            <h3 class="text-base font-extrabold text-gray-900 mb-2">In-Person Synergy</h3>
                            <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">
                                We whiteboard complex flows together, pair program in real time, and solve tough
                                architectural puzzles side-by-side with zero communication lag.
                            </p>
                        </div>

                        {{-- Value 4 --}}
                        <div
                            class="p-6 rounded-2xl bg-[#f8fafc] border border-gray-100 hover:border-[#0d9488]/40 transition-all duration-300 shadow-sm hover:shadow-md">
                            <div
                                class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-200/80 flex items-center justify-center text-[#0d9488] text-xl mb-4">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <h3 class="text-base font-extrabold text-gray-900 mb-2">Hands-On Mentorship</h3>
                            <p class="text-gray-600 text-xs sm:text-sm leading-relaxed">
                                Learn directly from seasoned software architects on live production architectures.
                                Fast-track your engineering skills through direct, everyday in-office guidance.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- ====================================================================
             3. EXCLUSIVE WELLNESS & PRO GYM (DARK) - Dedicated Commercial Gym Showcase
             ==================================================================== --}}
        <section class="py-24 bg-[#0a0a0a] text-gray-100 relative overflow-hidden border-t border-b border-white/10">
            <div class="max-w-7xl mx-auto px-5 lg:px-12 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs sm:text-sm mb-3 block">EXCLUSIVE
                        COMPANY PERK</span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        Work Strong, Build Great: Barakha Gym
                    </h2>
                    <p class="text-gray-400 text-sm sm:text-base mt-4 leading-relaxed">
                        Great software begins with physical vitality and a clear mind. We proudly own and operate a full
                        commercial fitness center—offering 100% complimentary VIP all-access for every PenSoftTech employee.
                    </p>
                </div>

                {{-- FEATURED HERO PERK: Company-Owned Professional Gym (Full Feature Card with Photo) --}}
                <div
                    class="mb-10 rounded-3xl bg-gradient-to-r from-white/[0.06] via-white/[0.02] to-transparent border border-[#4fd1c5]/35 p-6 sm:p-10 lg:p-12 relative overflow-hidden shadow-[0_0_50px_rgba(79,209,197,0.08)] group">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">

                        {{-- Left: Gym Text Content (7 cols) --}}
                        <div class="lg:col-span-7">
                            <div class="flex items-center gap-3 mb-5">
                                <span
                                    class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#4fd1c5]/15 border border-[#4fd1c5]/40 text-[#4fd1c5] text-xs font-black tracking-wider uppercase">
                                    <i class="bi bi-heart-pulse-fill"></i>
                                    Company-Owned Facility
                                </span>
                                <span
                                    class="text-xs font-semibold text-gray-300 bg-white/10 px-3 py-1 rounded-full border border-white/10">
                                    100% Free VIP Membership
                                </span>
                            </div>

                            <h3 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white mb-4 leading-tight">
                                Full-Access Professional Gym Membership
                            </h3>

                            <p class="text-gray-300 text-sm sm:text-base leading-relaxed mb-6">
                                We own and operate a real, full-scale commercial fitness center. Every PenSoftTech employee
                                receives <strong class="text-white font-semibold">100% free, unlimited VIP access</strong>.
                                Train on Olympic weightlifting platforms, commercial cardio equipment, and get guidance from
                                certified trainers—your physical health and daily energy are fully sponsored by us.
                            </p>

                            <div class="grid grid-cols-2 sm:grid-cols-2 gap-3 pt-6 border-t border-white/10">
                                <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-gray-200">
                                    <i class="bi bi-check2-circle text-[#4fd1c5] text-lg"></i>
                                    <span>Zero Membership Fees</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-gray-200">
                                    <i class="bi bi-check2-circle text-[#4fd1c5] text-lg"></i>
                                    <span>Commercial-Grade Equipment</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-gray-200">
                                    <i class="bi bi-check2-circle text-[#4fd1c5] text-lg"></i>
                                    <span>Certified Personal Trainers</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs sm:text-sm font-semibold text-gray-200">
                                    <i class="bi bi-check2-circle text-[#4fd1c5] text-lg"></i>
                                    <span>Flexible Workout Hours</span>
                                </div>
                            </div>
                        </div>

                        {{-- Right: Pro Gym Photo Showcase (5 cols) --}}
                        <div class="lg:col-span-5 relative">
                            <div
                                class="rounded-2xl overflow-hidden border border-white/15 shadow-2xl relative group/gym h-[280px] sm:h-[340px]">
                                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=1000"
                                    alt="PenSoftTech Company Professional Gym"
                                    class="w-full h-full object-cover group-hover/gym:scale-105 transition-transform duration-700">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent">
                                </div>
                                <div
                                    class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-xs text-white font-medium">
                                    <span
                                        class="inline-flex items-center gap-1.5 bg-black/60 backdrop-blur-md px-3 py-1 rounded-full border border-white/10">
                                        <i class="bi bi-geo-alt text-[#4fd1c5]"></i> Commercial Fitness Center
                                    </span>
                                    <span class="text-[#4fd1c5] font-bold">Free for all staff</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                {{-- Authentic On-Site Engineering Perks Strip --}}
                <div class="p-6 sm:p-8 rounded-3xl bg-white/[0.03] border border-white/10">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- On-Site Perk 1 --}}
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-[#4fd1c5]/10 border border-[#4fd1c5]/30 flex items-center justify-center text-[#4fd1c5] text-lg shrink-0">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white mb-1">Competitive Pay & Bonuses</h4>
                                <p class="text-xs text-gray-400 leading-relaxed">
                                    Market-competitive salary structure with regular appraisal cycles and performance
                                    bonuses.
                                </p>
                            </div>
                        </div>

                        {{-- On-Site Perk 2 --}}
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-[#4fd1c5]/10 border border-[#4fd1c5]/30 flex items-center justify-center text-[#4fd1c5] text-lg shrink-0">
                                <i class="bi bi-person-workspace"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white mb-1">Direct Senior Mentorship</h4>
                                <p class="text-xs text-gray-400 leading-relaxed">
                                    Work side-by-side with experienced software architects. Real-time pair programming and
                                    code reviews.
                                </p>
                            </div>
                        </div>

                        {{-- On-Site Perk 3 --}}
                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-[#4fd1c5]/10 border border-[#4fd1c5]/30 flex items-center justify-center text-[#4fd1c5] text-lg shrink-0">
                                <i class="bi bi-laptop"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white mb-1">Modern Office Environment</h4>
                                <p class="text-xs text-gray-400 leading-relaxed">
                                    High-speed dedicated fiber connection, collaborative spaces, and an energetic in-person
                                    team vibe.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- ====================================================================
             4. "LIFE AT PENSOFTECH" PHOTO GALLERY (LIGHT)
             ==================================================================== --}}
        <section class="py-20 bg-white text-gray-900 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-5 lg:px-12">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                    <div>
                        <span
                            class="text-[#0d9488] font-bold tracking-widest uppercase text-xs sm:text-sm mb-2 block">BEHIND
                            THE SCENES</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                            Life at PenSoftTech
                        </h2>
                    </div>
                    <p class="text-gray-600 text-sm max-w-md">
                        A snapshot into our daily cadence: high-focus engineering sprints, fitness breaks at our gym, and
                        celebratory gatherings.
                    </p>
                </div>

                {{-- Photo Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm h-64 group relative">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=600"
                            alt="Pair Programming"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute bottom-3 left-3 text-xs font-bold text-white">Collaboration</span>
                    </div>
                    <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm h-64 group relative">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=600"
                            alt="Company Gym Workout"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute bottom-3 left-3 text-xs font-bold text-white">Pro Gym Training</span>
                    </div>
                    <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm h-64 group relative">
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=600"
                            alt="Deep Work Coding"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute bottom-3 left-3 text-xs font-bold text-white">Deep Work</span>
                    </div>
                    <div class="rounded-2xl overflow-hidden border border-gray-200 shadow-sm h-64 group relative">
                        <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&q=80&w=600"
                            alt="Team Dinners"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <span class="absolute bottom-3 left-3 text-xs font-bold text-white">Celebrations</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ====================================================================
             5. OPEN POSITIONS DIRECTORY (LIGHT)
             ==================================================================== --}}
        <section id="open-roles" class="py-24 bg-[#f8fafc] text-gray-900 relative scroll-mt-16">
            <div class="max-w-7xl mx-auto px-5 lg:px-12">
                <div class="text-center max-w-3xl mx-auto mb-14">
                    <span class="text-[#0d9488] font-bold tracking-widest uppercase text-xs sm:text-sm mb-3 block">CURRENT
                        OPENINGS</span>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight">
                        Find Your Next Opportunity
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base mt-4 leading-relaxed">
                        Discover where your talents can have the highest architectural and business impact.
                    </p>
                </div>

                {{-- Filter Bar --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-6 mb-10 shadow-sm">
                    <form method="GET" action="{{ route('careers.index') }}#open-roles"
                        class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center justify-between">

                        {{-- Search Input --}}
                        <div class="relative flex-grow max-w-md">
                            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" name="search" value="{{ $searchQuery ?? '' }}"
                                placeholder="Search by role title or location..."
                                class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 text-sm placeholder-gray-400 focus:outline-none focus:border-[#0d9488] focus:bg-white transition-colors">
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            {{-- Employment Type Filter --}}
                            <select name="type" onchange="this.form.submit()"
                                class="py-3 px-4 rounded-xl bg-gray-50 border border-gray-200 text-gray-900 text-sm focus:outline-none focus:border-[#0d9488] transition-colors cursor-pointer">
                                <option value="" class="text-gray-600">All Employment Types</option>
                                @foreach ($employmentTypes as $type)
                                    <option value="{{ $type->value }}"
                                        {{ ($selectedType ?? '') === $type->value ? 'selected' : '' }}>
                                        {{ $type->label() }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Filter Submit & Reset --}}
                            <button type="submit"
                                class="bg-[#0d9488] hover:bg-[#0f766e] text-white font-extrabold px-6 py-3 rounded-xl text-sm transition-all duration-200 shadow-sm">
                                Filter
                            </button>

                            @if (!empty($searchQuery) || !empty($selectedType) || !empty($selectedCategory))
                                <a href="{{ route('careers.index') }}#open-roles"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-3 rounded-xl text-sm transition-all duration-200">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>

                    {{-- Category Pills --}}
                    @if ($categories->isNotEmpty())
                        <div class="flex flex-wrap items-center gap-2 mt-5 pt-5 border-t border-gray-100">
                            <a href="{{ route('careers.index', array_filter(['type' => $selectedType, 'search' => $searchQuery])) }}#open-roles"
                                class="px-4 py-1.5 rounded-full text-xs font-bold transition-all duration-200 {{ empty($selectedCategory) ? 'bg-[#0d9488] text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:text-gray-900 hover:bg-gray-200 border border-gray-200' }}">
                                All Departments
                            </a>
                            @foreach ($categories as $category)
                                <a href="{{ route('careers.index', array_filter(['category' => $category->slug, 'type' => $selectedType, 'search' => $searchQuery])) }}#open-roles"
                                    class="px-4 py-1.5 rounded-full text-xs font-bold transition-all duration-200 {{ ($selectedCategory ?? '') === $category->slug ? 'bg-[#0d9488] text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:text-gray-900 hover:bg-gray-200 border border-gray-200' }}">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Job Cards List --}}
                <div class="space-y-4">
                    @forelse($jobs as $job)
                        <div
                            class="p-6 sm:p-8 rounded-2xl bg-white border border-gray-200 hover:border-[#0d9488]/60 transition-all duration-300 group hover:shadow-md">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                                <div class="space-y-3">
                                    <div class="flex flex-wrap items-center gap-2">
                                        @if ($job->category)
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-50 text-[#0d9488] border border-teal-200/60">
                                                {{ $job->category->name }}
                                            </span>
                                        @endif
                                        @if ($job->employment_type)
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                                {{ $job->employment_type->label() }}
                                            </span>
                                        @endif
                                        @if ($job->location)
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-medium bg-gray-50 text-gray-600 border border-gray-200 inline-flex items-center gap-1">
                                                <i class="bi bi-geo-alt text-[#0d9488]"></i>
                                                {{ $job->location }}
                                            </span>
                                        @endif
                                    </div>

                                    <h3
                                        class="text-xl sm:text-2xl font-extrabold text-gray-900 group-hover:text-[#0d9488] transition-colors">
                                        <a href="{{ route('careers.show', $job->slug) }}">
                                            {{ $job->title }}
                                        </a>
                                    </h3>

                                    <p class="text-gray-600 text-sm max-w-3xl line-clamp-2 leading-relaxed">
                                        {{ Str::limit(strip_tags($job->description), 160) }}
                                    </p>

                                    <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 pt-1">
                                        @if ($job->experience)
                                            <span><strong class="text-gray-700">Experience:</strong>
                                                {{ $job->experience }}</span>
                                        @endif
                                        @if ($job->vacancy)
                                            <span><strong class="text-gray-700">Vacancies:</strong>
                                                {{ $job->vacancy }}</span>
                                        @endif
                                        @if ($job->deadline)
                                            <span><strong class="text-gray-700">Deadline:</strong>
                                                {{ $job->deadline->format('M d, Y') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div
                                    class="flex items-center lg:flex-col lg:items-end justify-between pt-4 lg:pt-0 border-t lg:border-t-0 border-gray-100">
                                    <a href="{{ route('careers.show', $job->slug) }}"
                                        class="bg-[#0d9488] hover:bg-[#0f766e] text-white font-extrabold px-6 py-3 rounded-full text-xs sm:text-sm transition-all duration-300 transform group-hover:scale-105 inline-flex items-center gap-2 whitespace-nowrap shadow-sm">
                                        <span>View Role & Apply</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 px-6 rounded-3xl bg-white border border-gray-200 shadow-sm">
                            <div
                                class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-2xl mx-auto mb-4">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No Matching Positions Found</h3>
                            <p class="text-gray-600 text-sm max-w-md mx-auto mb-6">
                                We don't currently have active openings matching your filter criteria. Try resetting filters
                                or submit a general application below.
                            </p>
                            <a href="{{ route('careers.index') }}#open-roles"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-2.5 rounded-full text-xs font-bold inline-flex items-center gap-1.5 transition-colors">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- General Application Callout --}}
                <div
                    class="mt-16 rounded-3xl p-8 sm:p-12 bg-white border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="max-w-xl">
                        <span class="text-[#0d9488] font-bold tracking-widest uppercase text-xs mb-2 block">FUTURE SQUAD
                            INVITATION</span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-3 leading-tight">
                            Don't see your specific role?
                        </h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            We are continuously seeking extraordinary software engineers, UI/UX masters, and product
                            thinkers. Drop us your resume and tell us how you'd like to push our engineering forward.
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('contact') }}"
                            class="bg-gray-900 hover:bg-black text-white font-extrabold px-8 py-4 rounded-full text-sm transition-all duration-300 transform hover:scale-105 inline-flex items-center gap-2 whitespace-nowrap shadow-md">
                            <span>Send Open Profile</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ====================================================================
             6. GLOBAL CTA SECTION (DARK)
             ==================================================================== --}}
        <div id="contact">
            @include('frontend.components.global.cta')
        </div>
    </main>
@endsection
