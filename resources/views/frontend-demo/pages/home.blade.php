@extends('frontend-demo.layouts.demo-master')

@section('title', 'PenSoftTech — World-Class Design Demo')

@section('content')

    {{-- ============================================================
     NAVBAR
     ============================================================ --}}
    <nav id="demoNav" class="demo-navbar" role="navigation" aria-label="Demo site navigation">
        <div class="demo-container demo-nav-inner">

            {{-- Logo --}}
            <a href="{{ route('demo.home') }}" class="demo-logo" aria-label="PenSoftTech homepage">
                <span class="demo-logo-icon" aria-hidden="true">P</span>
                <span class="demo-logo-name">PenSoftTech</span>
            </a>

            {{-- Nav links --}}
            <ul class="demo-nav-links" role="list">
                <li><a href="#services">Services</a></li>
                <li><a href="#work">Work</a></li>
                <li><a href="#blog">Insights</a></li>
                <li><a href="#careers">Careers</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>

            {{-- CTA --}}
            <a href="#contact" class="demo-nav-cta">Start a Project →</a>
        </div>
    </nav>

    {{-- ============================================================
     HERO SLIDER
     ============================================================ --}}
    <section class="demo-hero" aria-label="Hero">
        <div class="swiper demo-hero-swiper">
            <div class="swiper-wrapper">

                {{-- ── Slide 1: "We design and build digital products." + Crystal --}}
                <div class="swiper-slide">
                    <div class="demo-slide-inner">
                        <div class="demo-slide-content">
                            <div class="demo-slide-badge">
                                <span class="demo-badge-dot" aria-hidden="true"></span>
                                Software Development & Digital Marketing
                            </div>

                            <h1 class="demo-hero-headline">
                                <span class="demo-hero-word" style="display:block">We design</span>
                                <span class="demo-hero-word" style="display:block">and build</span>
                                <span class="demo-hero-word" style="display:block">digital</span>
                                <span class="demo-hero-word accent-line" style="display:inline-block">products.</span>
                            </h1>

                            <p class="demo-hero-sub">
                                PenSoftTech partners with ambitious companies to build custom software
                                and run digital marketing that drives real, measurable growth.
                            </p>

                            <div class="demo-hero-btns">
                                <a href="#contact" class="demo-btn-primary" data-cursor-expand>Start a Project →</a>
                                <a href="#work" class="demo-btn-ghost" data-cursor-expand>View Our Work</a>
                            </div>
                        </div>

                        {{-- 3D Crystal visual --}}
                        <div class="demo-hero-visual" aria-hidden="true">
                            <div class="crystal-wrap" id="crystalWrap">
                                <div class="crystal-glow"></div>
                                <svg class="crystal-svg" viewBox="0 0 300 340" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <linearGradient id="cg-top" x1="0" y1="0" x2="1"
                                            y2="1">
                                            <stop offset="0%" stop-color="#d4c5ff" />
                                            <stop offset="100%" stop-color="#a084ff" />
                                        </linearGradient>
                                        <linearGradient id="cg-ul" x1="0" y1="0" x2="1"
                                            y2="1">
                                            <stop offset="0%" stop-color="#7655ff" />
                                            <stop offset="100%" stop-color="#4825d8" />
                                        </linearGradient>
                                        <linearGradient id="cg-ur" x1="1" y1="0" x2="0"
                                            y2="1">
                                            <stop offset="0%" stop-color="#9070ee" />
                                            <stop offset="100%" stop-color="#5030c8" />
                                        </linearGradient>
                                        <linearGradient id="cg-mid" x1="0" y1="0" x2="1"
                                            y2="1">
                                            <stop offset="0%" stop-color="#8a66ff" />
                                            <stop offset="100%" stop-color="#5535dd" />
                                        </linearGradient>
                                        <linearGradient id="cg-ll" x1="0" y1="0" x2="1"
                                            y2="1">
                                            <stop offset="0%" stop-color="#5030c0" />
                                            <stop offset="100%" stop-color="#3010a0" />
                                        </linearGradient>
                                        <linearGradient id="cg-bl" x1="0" y1="0" x2="1"
                                            y2="1">
                                            <stop offset="0%" stop-color="#4020b0" />
                                            <stop offset="100%" stop-color="#200890" />
                                        </linearGradient>
                                        <linearGradient id="cg-br" x1="1" y1="0" x2="0"
                                            y2="1">
                                            <stop offset="0%" stop-color="#3818a8" />
                                            <stop offset="100%" stop-color="#180878" />
                                        </linearGradient>
                                    </defs>
                                    {{-- Top cap face (brightest) --}}
                                    <polygon points="150,12 258,82 150,108 42,82" fill="url(#cg-top)" opacity="0.95" />
                                    {{-- Upper left --}}
                                    <polygon points="42,82 150,108 88,198" fill="url(#cg-ul)" opacity="0.9" />
                                    {{-- Upper right --}}
                                    <polygon points="258,82 212,198 150,108" fill="url(#cg-ur)" opacity="0.85" />
                                    {{-- Mid center --}}
                                    <polygon points="88,198 150,108 212,198" fill="url(#cg-mid)" opacity="0.92" />
                                    {{-- Lower side left --}}
                                    <polygon points="42,82 88,198 28,236" fill="url(#cg-ll)" opacity="0.72" />
                                    {{-- Lower side right --}}
                                    <polygon points="258,82 272,236 212,198" fill="url(#cg-ll)" opacity="0.72" />
                                    {{-- Bottom left --}}
                                    <polygon points="28,236 88,198 150,328" fill="url(#cg-bl)" opacity="0.82" />
                                    {{-- Bottom right --}}
                                    <polygon points="272,236 150,328 212,198" fill="url(#cg-br)" opacity="0.78" />
                                    {{-- Bottom mid --}}
                                    <polygon points="88,198 212,198 150,328" fill="url(#cg-mid)" opacity="0.68" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Slide 2: "Custom software, engineered to scale." + Dashboard --}}
                <div class="swiper-slide">
                    <div class="demo-slide-inner">
                        <div class="demo-slide-content">
                            <div class="demo-slide-badge">
                                <span class="demo-badge-dot" aria-hidden="true"></span>
                                Software Development
                            </div>

                            <h1 class="demo-hero-headline">
                                <span class="demo-hero-word" style="display:block">Custom</span>
                                <span class="demo-hero-word" style="display:block">software,</span>
                                <span class="demo-hero-word accent-line" style="display:inline-block">engineered</span>
                                <span class="demo-hero-word" style="display:block">to scale.</span>
                            </h1>

                            <p class="demo-hero-sub">
                                From SaaS platforms to enterprise systems — we build software that's
                                fast, secure, and built to grow with your business.
                            </p>

                            <div class="demo-hero-btns">
                                <a href="#services" class="demo-btn-primary" data-cursor-expand>Explore Software →</a>
                                <a href="#work" class="demo-btn-ghost" data-cursor-expand>See Projects</a>
                            </div>
                        </div>

                        {{-- Dashboard card visual --}}
                        <div class="demo-hero-visual" aria-hidden="true">
                            <div class="demo-dash-card">
                                <div class="demo-dash-topbar">
                                    <span class="demo-dash-dot" style="background:#ff5d7d"></span>
                                    <span class="demo-dash-dot" style="background:#f6c90e"></span>
                                    <span class="demo-dash-dot" style="background:#4fd1c5"></span>
                                    <div class="demo-dash-bar"></div>
                                </div>
                                <div class="demo-dash-chart">
                                    <svg viewBox="0 0 380 130" xmlns="http://www.w3.org/2000/svg"
                                        preserveAspectRatio="none">
                                        <defs>
                                            <linearGradient id="chartGrad" x1="0" y1="0" x2="0"
                                                y2="1">
                                                <stop offset="0%" stop-color="rgba(118,85,255,0.5)" />
                                                <stop offset="100%" stop-color="rgba(118,85,255,0)" />
                                            </linearGradient>
                                        </defs>
                                        <path
                                            d="M0,110 C40,90 80,100 120,70 C160,40 200,55 240,35 C280,15 320,30 380,10 L380,130 L0,130 Z"
                                            fill="url(#chartGrad)" />
                                        <path d="M0,110 C40,90 80,100 120,70 C160,40 200,55 240,35 C280,15 320,30 380,10"
                                            fill="none" stroke="#7655ff" stroke-width="2" />
                                        {{-- Data points --}}
                                        <circle cx="120" cy="70" r="4" fill="#7655ff" />
                                        <circle cx="240" cy="35" r="4" fill="#7655ff" />
                                        <circle cx="380" cy="10" r="4" fill="#a084ff" />
                                    </svg>
                                </div>
                                <div class="demo-dash-chips">
                                    <div class="demo-dash-chip">
                                        <div class="demo-dash-chip-num" style="color:#4fd1c5">↓ 72%</div>
                                        <div class="demo-dash-chip-lbl">Error rate</div>
                                    </div>
                                    <div class="demo-dash-chip">
                                        <div class="demo-dash-chip-num">40</div>
                                        <div class="demo-dash-chip-lbl">Stores unified</div>
                                    </div>
                                    <div class="demo-dash-chip">
                                        <div class="demo-dash-chip-num" style="color:#a084ff">4.7★</div>
                                        <div class="demo-dash-chip-lbl">App Store rating</div>
                                    </div>
                                    <div class="demo-dash-chip">
                                        <div class="demo-dash-chip-num" style="color:#f6ad55">$2M</div>
                                        <div class="demo-dash-chip-lbl">Cost saved</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Slide 3: "Marketing tied to revenue." + Chart --}}
                <div class="swiper-slide">
                    <div class="demo-slide-inner">
                        <div class="demo-slide-content">
                            <div class="demo-slide-badge">
                                <span class="demo-badge-dot" aria-hidden="true"></span>
                                Digital Marketing
                            </div>

                            <h1 class="demo-hero-headline">
                                <span class="demo-hero-word" style="display:block">Marketing</span>
                                <span class="demo-hero-word" style="display:block">tied to</span>
                                <span class="demo-hero-word accent-line" style="display:inline-block">revenue.</span>
                            </h1>

                            <p class="demo-hero-sub">
                                We run SEO, paid search, and content that's measured in pipeline,
                                not pageviews. One accountable team from click to close.
                            </p>

                            <div class="demo-hero-btns">
                                <a href="#services" class="demo-btn-primary" data-cursor-expand>Explore Marketing →</a>
                                <a href="#work" class="demo-btn-ghost" data-cursor-expand>See Results</a>
                            </div>
                        </div>

                        {{-- Growth chart visual --}}
                        <div class="demo-hero-visual" aria-hidden="true">
                            <div class="demo-chart-visual-wrap">
                                <div class="demo-chart-label">Revenue Growth — Q1 to Q4</div>
                                <div class="demo-chart-bars">
                                    <div class="demo-bar" style="height:38%" title="Q1"></div>
                                    <div class="demo-bar" style="height:52%" title="Q2"></div>
                                    <div class="demo-bar" style="height:61%" title="Q3 — after PenSoftTech"></div>
                                    <div class="demo-bar" style="height:78%" title="Q4"></div>
                                    <div class="demo-bar" style="height:88%" title="Q1 Y2"></div>
                                    <div class="demo-bar" style="height:100%" title="Q2 Y2"></div>
                                </div>
                                <div class="demo-chart-metrics">
                                    <div class="demo-chart-metric-item">
                                        <div class="demo-chart-metric-num" style="color:#4fd1c5">↓46%</div>
                                        <div class="demo-chart-metric-lbl">Cost per lead</div>
                                    </div>
                                    <div class="demo-chart-metric-item">
                                        <div class="demo-chart-metric-num">3.2×</div>
                                        <div class="demo-chart-metric-lbl">ROAS</div>
                                    </div>
                                    <div class="demo-chart-metric-item">
                                        <div class="demo-chart-metric-num" style="color:#a084ff">↑218%</div>
                                        <div class="demo-chart-metric-lbl">Organic traffic</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- /swiper-wrapper --}}
        </div>{{-- /swiper --}}

        {{-- Slider indicator UI --}}
        <div class="demo-slider-ui" aria-hidden="true">
            <div class="demo-slider-lines">
                <div class="demo-slider-line is-active">
                    <div class="demo-slider-line-fill"></div>
                </div>
                <div class="demo-slider-line">
                    <div class="demo-slider-line-fill"></div>
                </div>
                <div class="demo-slider-line">
                    <div class="demo-slider-line-fill"></div>
                </div>
            </div>
            <span class="demo-slide-counter">01 / 03</span>
        </div>

        {{-- Arrow controls --}}
        <div class="demo-slider-arrows" aria-label="Slider navigation">
            <button class="demo-slider-arrow" id="sliderPrev" aria-label="Previous slide">←</button>
            <button class="demo-slider-arrow" id="sliderNext" aria-label="Next slide">→</button>
        </div>

        {{-- Stats bar --}}
        <div class="demo-stats-bar" role="list" aria-label="Key statistics">
            <div class="demo-stat-item" role="listitem">
                <span class="demo-stat-num" data-count="60" data-suffix="+">60+</span>
                <span class="demo-stat-lbl">Projects Delivered</span>
            </div>
            <div class="demo-stat-item" role="listitem">
                <span class="demo-stat-num" data-count="35" data-suffix="+">35+</span>
                <span class="demo-stat-lbl">Happy Clients</span>
            </div>
            <div class="demo-stat-item" role="listitem">
                <span class="demo-stat-num" data-count="8" data-suffix=" yrs">8 yrs</span>
                <span class="demo-stat-lbl">In Business</span>
            </div>
            <div class="demo-stat-item" role="listitem">
                <span class="demo-stat-num" data-count="98" data-suffix="%">98%</span>
                <span class="demo-stat-lbl">Satisfaction Rate</span>
            </div>
        </div>
    </section>

    {{-- ============================================================
     TRUSTED BY — MARQUEE
     ============================================================ --}}
    <div class="demo-trusted" aria-label="Trusted by">
        <span class="demo-trusted-label">Trusted by →</span>
        <div class="demo-marquee-outer">
            {{-- Duplicated for seamless loop --}}
            <div class="demo-marquee-track" aria-hidden="true">
                <span class="demo-marquee-item">Vertex Retail</span>
                <span class="demo-marquee-item">Harbor&amp;Co</span>
                <span class="demo-marquee-item">Ferrylane Tours</span>
                <span class="demo-marquee-item">NexaGroup</span>
                <span class="demo-marquee-item">BluePeak Tech</span>
                <span class="demo-marquee-item">Orion Ventures</span>
                <span class="demo-marquee-item">Cascade Systems</span>
                <span class="demo-marquee-item">Meridian Labs</span>
                {{-- Duplicated set for seamless loop --}}
                <span class="demo-marquee-item">Vertex Retail</span>
                <span class="demo-marquee-item">Harbor&amp;Co</span>
                <span class="demo-marquee-item">Ferrylane Tours</span>
                <span class="demo-marquee-item">NexaGroup</span>
                <span class="demo-marquee-item">BluePeak Tech</span>
                <span class="demo-marquee-item">Orion Ventures</span>
                <span class="demo-marquee-item">Cascade Systems</span>
                <span class="demo-marquee-item">Meridian Labs</span>
            </div>
        </div>
    </div>

    {{-- ============================================================
     SERVICES
     ============================================================ --}}
    <section class="demo-section" id="services" aria-labelledby="services-title">
        <div class="demo-container">
            <span class="demo-eyebrow demo-reveal">What We Do</span>
            <h2 class="demo-section-title demo-reveal" id="services-title">Two disciplines,<br>one accountable team.</h2>
            <p class="demo-section-sub demo-reveal">
                Most agencies do one or the other. We do both — which means your software and
                your marketing are always aligned around the same goal: revenue.
            </p>

            <div class="demo-service-cards" data-stagger-parent>
                {{-- Software Development --}}
                <div class="demo-service-card is-dev" data-tilt data-stagger-child>
                    <span class="demo-service-num">01 — Software Development</span>
                    <div class="demo-service-icon" aria-hidden="true">⟨/⟩</div>
                    <h3 class="demo-service-title">Custom software, built to scale.</h3>
                    <p class="demo-service-desc">
                        From idea to production — we architect, build, and maintain software
                        your business actually depends on. Clean code, real delivery.
                    </p>
                    <ul class="demo-service-list" aria-label="Software services">
                        <li>Web & SaaS Platform Development</li>
                        <li>Mobile Apps — iOS & Android</li>
                        <li>Custom Enterprise Software</li>
                        <li>API Design & Integration</li>
                        <li>QA, Testing & DevOps</li>
                    </ul>
                    <a href="#work" class="demo-service-link">Explore Software Services →</a>
                </div>

                {{-- Digital Marketing --}}
                <div class="demo-service-card is-mkt" data-tilt data-stagger-child>
                    <span class="demo-service-num">02 — Digital Marketing</span>
                    <div class="demo-service-icon" aria-hidden="true">📈</div>
                    <h3 class="demo-service-title">Marketing tied to revenue.</h3>
                    <p class="demo-service-desc">
                        We report on pipeline, not pageviews. Every campaign is built around
                        driving qualified leads that convert to paying customers.
                    </p>
                    <ul class="demo-service-list" aria-label="Marketing services">
                        <li>SEO & Organic Growth</li>
                        <li>Paid Search & Social (Google, Meta)</li>
                        <li>Content Marketing & Copywriting</li>
                        <li>Branding & Creative Design</li>
                        <li>Analytics, CRO & Reporting</li>
                    </ul>
                    <a href="#work" class="demo-service-link">Explore Marketing Services →</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
     PROJECTS / WORK
     ============================================================ --}}
    <section class="demo-section" id="work" aria-labelledby="work-title">
        <div class="demo-container">
            <div class="demo-section-header-row">
                <div>
                    <span class="demo-eyebrow demo-reveal">Our Work</span>
                    <h2 class="demo-section-title demo-reveal" id="work-title">Selected recent projects.</h2>
                </div>
                <a href="#" class="demo-link-subtle demo-reveal">See All Projects →</a>
            </div>

            <div class="demo-project-cards" data-stagger-parent>

                {{-- Project 1 --}}
                <div class="demo-project-card" data-tilt data-stagger-child>
                    <div class="demo-project-thumb" aria-hidden="true">
                        <svg viewBox="0 0 400 250" xmlns="http://www.w3.org/2000/svg">
                            <rect width="400" height="250" fill="#0f1117" />
                            <rect x="20" y="20" width="80" height="12" rx="3"
                                fill="rgba(118,85,255,0.3)" />
                            <rect x="20" y="40" width="120" height="8" rx="2"
                                fill="rgba(255,255,255,0.08)" />
                            <rect x="20" y="60" width="360" height="1" fill="rgba(255,255,255,0.06)" />
                            {{-- Sidebar --}}
                            <rect x="20" y="70" width="70" height="160" rx="6"
                                fill="rgba(118,85,255,0.08)" stroke="rgba(118,85,255,0.15)" stroke-width="1" />
                            <rect x="28" y="80" width="54" height="6" rx="2"
                                fill="rgba(255,255,255,0.15)" />
                            <rect x="28" y="94" width="40" height="5" rx="2"
                                fill="rgba(255,255,255,0.06)" />
                            <rect x="28" y="106" width="48" height="5" rx="2"
                                fill="rgba(255,255,255,0.06)" />
                            <rect x="28" y="118" width="36" height="5" rx="2"
                                fill="rgba(255,255,255,0.06)" />
                            {{-- Main area --}}
                            <rect x="102" y="70" width="278" height="160" rx="6"
                                fill="rgba(255,255,255,0.03)" stroke="rgba(255,255,255,0.06)" stroke-width="1" />
                            {{-- Chart --}}
                            <polyline points="110,195 145,175 180,160 215,140 250,120 285,100 320,95 355,80 370,75"
                                fill="none" stroke="#7655ff" stroke-width="2" stroke-linecap="round" />
                            <polygon
                                points="110,195 145,175 180,160 215,140 250,120 285,100 320,95 355,80 370,75 370,210 110,210"
                                fill="url(#pg1)" opacity="0.4" />
                            <defs>
                                <linearGradient id="pg1" x1="0" y1="0" x2="0"
                                    y2="1">
                                    <stop offset="0%" stop-color="#7655ff" stop-opacity="0.6" />
                                    <stop offset="100%" stop-color="#7655ff" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            {{-- Stat chips --}}
                            <rect x="110" y="78" width="60" height="28" rx="4"
                                fill="rgba(79,209,197,0.12)" stroke="rgba(79,209,197,0.2)" stroke-width="1" />
                            <text x="140" y="97" text-anchor="middle" font-size="10" font-weight="700" fill="#4fd1c5"
                                font-family="sans-serif">↓72% err</text>
                        </svg>
                    </div>
                    <div class="demo-project-body">
                        <p class="demo-project-name">Vertex Retail Platform</p>
                        <span class="demo-project-tag">Software Development</span>
                        <span class="demo-metric-pill purple">↓72% order errors</span>
                    </div>
                </div>

                {{-- Project 2 --}}
                <div class="demo-project-card" data-tilt data-stagger-child>
                    <div class="demo-project-thumb" aria-hidden="true">
                        <svg viewBox="0 0 400 250" xmlns="http://www.w3.org/2000/svg">
                            <rect width="400" height="250" fill="#0f1117" />
                            <rect x="20" y="20" width="100" height="12" rx="3"
                                fill="rgba(255,93,125,0.25)" />
                            <rect x="20" y="40" width="140" height="8" rx="2"
                                fill="rgba(255,255,255,0.08)" />
                            <rect x="20" y="60" width="360" height="1" fill="rgba(255,255,255,0.06)" />
                            {{-- Bar chart --}}
                            <rect x="30" y="200" width="30" height="50" rx="3"
                                fill="rgba(118,85,255,0.25)" />
                            <rect x="70" y="175" width="30" height="75" rx="3"
                                fill="rgba(118,85,255,0.35)" />
                            <rect x="110" y="155" width="30" height="95" rx="3"
                                fill="rgba(118,85,255,0.45)" />
                            <rect x="150" y="135" width="30" height="115" rx="3"
                                fill="rgba(118,85,255,0.55)" />
                            <rect x="190" y="110" width="30" height="140" rx="3"
                                fill="rgba(118,85,255,0.70)" />
                            <rect x="230" y="90" width="30" height="160" rx="3"
                                fill="rgba(118,85,255,0.85)" />
                            {{-- KPI card --}}
                            <rect x="280" y="80" width="100" height="150" rx="8"
                                fill="rgba(255,93,125,0.1)" stroke="rgba(255,93,125,0.2)" stroke-width="1" />
                            <text x="330" y="118" text-anchor="middle" font-size="9" font-weight="600"
                                fill="rgba(255,140,153,0.8)" font-family="sans-serif">COST / LEAD</text>
                            <text x="330" y="148" text-anchor="middle" font-size="22" font-weight="800" fill="#fff"
                                font-family="sans-serif">↓46%</text>
                            <text x="330" y="168" text-anchor="middle" font-size="8" fill="rgba(255,255,255,0.4)"
                                font-family="sans-serif">vs. prev. agency</text>
                        </svg>
                    </div>
                    <div class="demo-project-body">
                        <p class="demo-project-name">Harbor&amp;Co Marketing</p>
                        <span class="demo-project-tag">Digital Marketing</span>
                        <span class="demo-metric-pill teal">↓46% cost per lead</span>
                    </div>
                </div>

                {{-- Project 3 --}}
                <div class="demo-project-card" data-tilt data-stagger-child>
                    <div class="demo-project-thumb" aria-hidden="true">
                        <svg viewBox="0 0 400 250" xmlns="http://www.w3.org/2000/svg">
                            <rect width="400" height="250" fill="#0f1117" />
                            {{-- Phone mockup --}}
                            <rect x="130" y="15" width="140" height="220" rx="18" fill="#111827"
                                stroke="rgba(255,255,255,0.1)" stroke-width="1.5" />
                            <rect x="138" y="25" width="124" height="200" rx="12" fill="#050507" />
                            {{-- Status bar --}}
                            <rect x="145" y="30" width="60" height="5" rx="2"
                                fill="rgba(255,255,255,0.08)" />
                            {{-- App content --}}
                            <rect x="144" y="44" width="112" height="40" rx="6"
                                fill="rgba(118,85,255,0.12)" stroke="rgba(118,85,255,0.2)" stroke-width="1" />
                            <rect x="152" y="52" width="60" height="6" rx="2"
                                fill="rgba(255,255,255,0.2)" />
                            <rect x="152" y="64" width="40" height="5" rx="2"
                                fill="rgba(255,255,255,0.1)" />
                            <rect x="144" y="92" width="50" height="50" rx="6"
                                fill="rgba(79,209,197,0.1)" stroke="rgba(79,209,197,0.15)" stroke-width="1" />
                            <rect x="202" y="92" width="54" height="50" rx="6"
                                fill="rgba(246,173,85,0.1)" stroke="rgba(246,173,85,0.15)" stroke-width="1" />
                            <rect x="144" y="150" width="112" height="6" rx="2"
                                fill="rgba(255,255,255,0.06)" />
                            <rect x="144" y="163" width="80" height="5" rx="2"
                                fill="rgba(255,255,255,0.06)" />
                            <rect x="144" y="178" width="112" height="28" rx="6"
                                fill="rgba(118,85,255,0.25)" />
                            <text x="200" y="197" text-anchor="middle" font-size="9" font-weight="700" fill="#fff"
                                font-family="sans-serif">Book Now</text>
                            {{-- Rating badge --}}
                            <rect x="245" y="55" width="70" height="28" rx="6"
                                fill="rgba(246,173,85,0.15)" stroke="rgba(246,173,85,0.25)" stroke-width="1" />
                            <text x="280" y="73" text-anchor="middle" font-size="11" font-weight="800" fill="#f6ad55"
                                font-family="sans-serif">4.7 ★</text>
                        </svg>
                    </div>
                    <div class="demo-project-body">
                        <p class="demo-project-name">Ferrylane Booking App</p>
                        <span class="demo-project-tag">Software Development</span>
                        <span class="demo-metric-pill orange">4.7★ App Store</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================================
     CASE STUDIES
     ============================================================ --}}
    <section class="demo-section" id="case-studies" aria-labelledby="case-title">
        <div class="demo-container">
            <span class="demo-eyebrow demo-reveal">Case Studies</span>
            <h2 class="demo-section-title demo-reveal" id="case-title">The work behind the numbers.</h2>

            {{-- Featured case study --}}
            <div class="demo-case-featured demo-reveal">
                <div class="demo-case-thumb" aria-hidden="true">
                    <svg viewBox="0 0 300 280" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
                        <defs>
                            <linearGradient id="case-grad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#7655ff" />
                                <stop offset="50%" stop-color="#a084ff" />
                                <stop offset="100%" stop-color="#4fd1c5" />
                            </linearGradient>
                        </defs>
                        <rect width="300" height="280" fill="#0a0c14" />
                        <ellipse cx="80" cy="80" rx="120" ry="100"
                            fill="rgba(118,85,255,0.25)" style="filter:blur(30px)" />
                        <ellipse cx="220" cy="200" rx="100" ry="80"
                            fill="rgba(79,209,197,0.18)" style="filter:blur(25px)" />
                        <ellipse cx="150" cy="140" rx="80" ry="60"
                            fill="rgba(160,132,255,0.12)" style="filter:blur(20px)" />
                        {{-- Floating shapes --}}
                        <rect x="60" y="60" width="80" height="80" rx="16" fill="rgba(118,85,255,0.3)"
                            transform="rotate(15,100,100)" />
                        <rect x="150" y="130" width="60" height="60" rx="12" fill="rgba(79,209,197,0.25)"
                            transform="rotate(-10,180,160)" />
                        <circle cx="100" cy="200" r="30" fill="rgba(246,173,85,0.2)" />
                    </svg>
                </div>
                <div class="demo-case-body">
                    <span class="demo-case-tag">Software Development</span>
                    <h3 class="demo-case-title">
                        How we rebuilt Vertex Retail's operations — from 3 spreadsheets to one live system.
                    </h3>
                    <p class="demo-case-desc">
                        Vertex Retail was running 40 stores on a patchwork of spreadsheets and legacy software.
                        We designed and built a unified inventory and order management platform in 6 months.
                    </p>
                    <div class="demo-case-metrics" role="list" aria-label="Project results">
                        <div role="listitem">
                            <span class="demo-case-metric-num">72%</span>
                            <div class="demo-case-metric-lbl">↓ Error reduction</div>
                        </div>
                        <div role="listitem">
                            <span class="demo-case-metric-num">$2M</span>
                            <div class="demo-case-metric-lbl">Annual cost saved</div>
                        </div>
                        <div role="listitem">
                            <span class="demo-case-metric-num">40</span>
                            <div class="demo-case-metric-lbl">Stores unified</div>
                        </div>
                    </div>
                    <a href="#" class="demo-case-link">Read Full Case Study →</a>
                </div>
            </div>

            {{-- Additional case study rows --}}
            <div class="demo-case-list" role="list">
                <a href="#" class="demo-case-row demo-reveal" role="listitem">
                    <div class="demo-case-row-thumb" aria-hidden="true">
                        <svg viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg">
                            <rect width="56" height="56" fill="#0f1117" />
                            <rect x="8" y="38" width="8" height="10" rx="2"
                                fill="rgba(118,85,255,0.5)" />
                            <rect x="20" y="28" width="8" height="20" rx="2"
                                fill="rgba(118,85,255,0.7)" />
                            <rect x="32" y="18" width="8" height="30" rx="2"
                                fill="rgba(118,85,255,0.9)" />
                            <rect x="44" y="10" width="8" height="38" rx="2" fill="#7655ff" />
                        </svg>
                    </div>
                    <div>
                        <div class="demo-case-row-name">Harbor&amp;Co</div>
                        <div class="demo-case-row-sub">Paid Search Campaign Relaunch</div>
                    </div>
                    <span class="demo-case-row-metric">↓46% CPL</span>
                    <span class="demo-case-row-read">Read →</span>
                </a>

                <a href="#" class="demo-case-row demo-reveal" role="listitem">
                    <div class="demo-case-row-thumb" aria-hidden="true">
                        <svg viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg">
                            <rect width="56" height="56" fill="#0f1117" />
                            <rect x="16" y="10" width="24" height="36" rx="6"
                                fill="rgba(118,85,255,0.15)" stroke="rgba(118,85,255,0.25)" stroke-width="1" />
                            <rect x="21" y="16" width="14" height="8" rx="2"
                                fill="rgba(118,85,255,0.4)" />
                            <rect x="21" y="28" width="10" height="3" rx="1"
                                fill="rgba(255,255,255,0.15)" />
                            <rect x="21" y="34" width="14" height="6" rx="3"
                                fill="rgba(79,209,197,0.3)" />
                        </svg>
                    </div>
                    <div>
                        <div class="demo-case-row-name">Ferrylane Tours</div>
                        <div class="demo-case-row-sub">Mobile Booking App — iOS & Android</div>
                    </div>
                    <span class="demo-case-row-metric">4.7★ rating</span>
                    <span class="demo-case-row-read">Read →</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================================
     TESTIMONIALS
     ============================================================ --}}
    <section class="demo-testimonials" id="testimonials" aria-labelledby="testi-title">
        <div class="demo-testi-quote-bg" aria-hidden="true">"</div>
        <div class="demo-testi-inner">
            <h2 id="testi-title" class="sr-only">What our clients say</h2>

            {{-- Slide 1 --}}
            <div class="demo-testi-slide" aria-hidden="true">
                <blockquote class="demo-testi-text">
                    "PenSoftTech rebuilt our booking system and then took over our Google Ads.
                    Having one team accountable for both meant nothing fell through the cracks."
                </blockquote>
                <div class="demo-testi-author">
                    <div class="demo-testi-avatar" aria-hidden="true">RA</div>
                    <div>
                        <div class="demo-testi-name">Rafiq Ahmed</div>
                        <div class="demo-testi-role">Founder, Ferrylane Tours</div>
                    </div>
                </div>
            </div>

            {{-- Slide 2 --}}
            <div class="demo-testi-slide" aria-hidden="true">
                <blockquote class="demo-testi-text">
                    "We cut our cost per lead by nearly half in the first quarter.
                    These guys don't talk about marketing — they talk about revenue."
                </blockquote>
                <div class="demo-testi-author">
                    <div class="demo-testi-avatar" aria-hidden="true">SC</div>
                    <div>
                        <div class="demo-testi-name">Sarah Chen</div>
                        <div class="demo-testi-role">Head of Growth, Harbor&amp;Co</div>
                    </div>
                </div>
            </div>

            {{-- Slide 3 --}}
            <div class="demo-testi-slide" aria-hidden="true">
                <blockquote class="demo-testi-text">
                    "The Vertex platform has unified all 40 of our stores. It's the most impactful
                    technology investment we've ever made — delivered on time and on budget."
                </blockquote>
                <div class="demo-testi-author">
                    <div class="demo-testi-avatar" aria-hidden="true">MK</div>
                    <div>
                        <div class="demo-testi-name">Marcus Kim</div>
                        <div class="demo-testi-role">CTO, Vertex Retail</div>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="demo-testi-nav" aria-label="Testimonial navigation">
                <button class="demo-testi-arrow" id="testPrev" aria-label="Previous testimonial">←</button>
                <div class="demo-testi-dots" role="tablist">
                    <button class="demo-testi-dot" role="tab" aria-label="Testimonial 1"></button>
                    <button class="demo-testi-dot" role="tab" aria-label="Testimonial 2"></button>
                    <button class="demo-testi-dot" role="tab" aria-label="Testimonial 3"></button>
                </div>
                <button class="demo-testi-arrow" id="testNext" aria-label="Next testimonial">→</button>
            </div>
        </div>
    </section>

    {{-- ============================================================
     BLOG / INSIGHTS
     ============================================================ --}}
    <section class="demo-section" id="blog" aria-labelledby="blog-title">
        <div class="demo-container">
            <div class="demo-section-header-row">
                <div>
                    <span class="demo-eyebrow demo-reveal">Insights</span>
                    <h2 class="demo-section-title demo-reveal" id="blog-title">Fresh thinking on<br>software &amp; growth.
                    </h2>
                </div>
                <a href="#" class="demo-link-subtle demo-reveal">View All Articles →</a>
            </div>

            <div class="demo-blog-grid" data-stagger-parent>

                <article class="demo-blog-card" data-stagger-child>
                    <span class="demo-blog-cat cat-software">Software</span>
                    <h3 class="demo-blog-title">5 signs your business needs custom software right now</h3>
                    <p class="demo-blog-meta">Nov 12, 2025 · 4 min read</p>
                    <a href="#" class="demo-blog-read">Read →</a>
                </article>

                <article class="demo-blog-card" data-stagger-child>
                    <span class="demo-blog-cat cat-marketing">Marketing</span>
                    <h3 class="demo-blog-title">How we cut a client's ad spend waste by 46% in 8 weeks</h3>
                    <p class="demo-blog-meta">Oct 3, 2025 · 6 min read</p>
                    <a href="#" class="demo-blog-read">Read →</a>
                </article>

                <article class="demo-blog-card" data-stagger-child>
                    <span class="demo-blog-cat cat-growth">Growth</span>
                    <h3 class="demo-blog-title">Why we report on pipeline revenue, not just impressions</h3>
                    <p class="demo-blog-meta">Sep 18, 2025 · 3 min read</p>
                    <a href="#" class="demo-blog-read">Read →</a>
                </article>

            </div>
        </div>
    </section>

    {{-- ============================================================
     CAREERS
     ============================================================ --}}
    <section class="demo-section" id="careers" aria-labelledby="careers-title">
        <div class="demo-container">
            <div class="demo-careers-header">
                <span class="demo-eyebrow demo-reveal">Join the Team</span>
                <h2 class="demo-section-title demo-reveal" id="careers-title">Work with us.</h2>
                <p class="demo-section-sub demo-reveal" style="margin-bottom:0">
                    We hire senior people who own their work and ship things they're proud of.
                    Remote-friendly, Dhaka-based studio.
                </p>
            </div>

            <div class="demo-jobs-list" role="list" aria-label="Open positions">
                <a href="#" class="demo-job-row" role="listitem">
                    <span class="demo-job-title">Senior Software Engineer</span>
                    <span class="demo-job-dept">Engineering</span>
                    <span class="demo-job-location">Dhaka · Remote</span>
                    <span class="demo-job-apply">Apply →</span>
                </a>
                <a href="#" class="demo-job-row" role="listitem">
                    <span class="demo-job-title">Paid Media Specialist</span>
                    <span class="demo-job-dept">Marketing</span>
                    <span class="demo-job-location">Dhaka · Remote</span>
                    <span class="demo-job-apply">Apply →</span>
                </a>
                <a href="#" class="demo-job-row" role="listitem">
                    <span class="demo-job-title">Frontend Developer</span>
                    <span class="demo-job-dept">Engineering</span>
                    <span class="demo-job-location">Dhaka</span>
                    <span class="demo-job-apply">Apply →</span>
                </a>
                <a href="#" class="demo-job-row" role="listitem">
                    <span class="demo-job-title">Content & SEO Strategist</span>
                    <span class="demo-job-dept">Marketing</span>
                    <span class="demo-job-location">Remote</span>
                    <span class="demo-job-apply">Apply →</span>
                </a>
            </div>

            <div class="demo-view-all demo-reveal">
                <a href="#">View All Openings →</a>
            </div>
        </div>
    </section>

    {{-- ============================================================
     CTA BANNER
     ============================================================ --}}
    <section class="demo-cta" id="contact" aria-labelledby="cta-title">
        <div class="demo-container">
            <div class="demo-cta-box">
                <h2 class="demo-cta-title" id="cta-title">Tell us what<br>you're building.</h2>
                <p class="demo-cta-sub">
                    Book a free 30-minute call. No slides, no pitch deck — just an honest conversation.
                </p>
                <a href="mailto:hello@pensoftech.com" class="demo-btn-primary" data-cursor-expand>
                    Book a Free 30-min Call →
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================================
     FOOTER
     ============================================================ --}}
    <footer class="demo-footer" role="contentinfo">
        <div class="demo-container">
            <div class="demo-footer-grid">

                {{-- Brand column --}}
                <div class="demo-footer-brand">
                    <a href="{{ route('demo.home') }}" class="demo-logo">
                        <span class="demo-logo-icon" aria-hidden="true">P</span>
                        <span class="demo-logo-name">PenSoftTech</span>
                    </a>
                    <p>Custom software and digital marketing under one accountable roof.</p>
                </div>

                {{-- Services --}}
                <div>
                    <h3 class="demo-footer-col-title">Services</h3>
                    <ul class="demo-footer-links" role="list">
                        <li><a href="#services">Software Development</a></li>
                        <li><a href="#services">Digital Marketing</a></li>
                        <li><a href="#services">SEO & Content</a></li>
                        <li><a href="#services">Paid Search</a></li>
                    </ul>
                </div>

                {{-- Company --}}
                <div>
                    <h3 class="demo-footer-col-title">Company</h3>
                    <ul class="demo-footer-links" role="list">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#case-studies">Case Studies</a></li>
                        <li><a href="#blog">Blog</a></li>
                        <li><a href="#careers">Careers</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h3 class="demo-footer-col-title">Connect</h3>
                    <ul class="demo-footer-links" role="list">
                        <li><a href="mailto:hello@pensoftech.com">hello@pensoftech.com</a></li>
                        <li><a href="#">+880 — —</a></li>
                        <li><a href="#">Dhaka, Bangladesh</a></li>
                        <li><a href="#contact">Get a Quote</a></li>
                    </ul>
                </div>
            </div>

            {{-- Bottom bar --}}
            <div class="demo-footer-bottom">
                <span class="demo-footer-copy">&copy; <span class="js-year">2025</span> PenSoftTech. All rights
                    reserved.</span>
                <div class="demo-footer-socials" aria-label="Social media links">
                    <a href="#" class="demo-social-link" aria-label="LinkedIn">in</a>
                    <a href="#" class="demo-social-link" aria-label="Twitter / X">𝕏</a>
                    <a href="#" class="demo-social-link" aria-label="GitHub">⌥</a>
                    <a href="#" class="demo-social-link" aria-label="Instagram">◈</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Screen reader utility --}}
    <style>
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
    </style>

@endsection
