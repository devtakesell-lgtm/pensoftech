/**
 * Demo Vertical — JavaScript
 * Uses: GSAP 3 + ScrollTrigger, Swiper 11 (loaded via CDN in demo-master.blade.php)
 * Handles: custom cursor, hero slider, scroll animations, card tilt, counters, testimonials
 */

document.addEventListener('DOMContentLoaded', function () {

    // ── 1. CUSTOM CURSOR ──────────────────────────────────────────────
    const cursor      = document.getElementById('demoCursor');
    const cursorTrail = document.getElementById('demoCursorTrail');

    if (cursor && cursorTrail) {
        let mouseX = 0;
        let mouseY = 0;
        let trailX = 0;
        let trailY = 0;

        document.addEventListener('mousemove', function (e) {
            mouseX = e.clientX;
            mouseY = e.clientY;
            cursor.style.left = mouseX + 'px';
            cursor.style.top  = mouseY + 'px';
        });

        // Smooth trailing cursor with rAF
        function animateTrail() {
            trailX += (mouseX - trailX) * 0.11;
            trailY += (mouseY - trailY) * 0.11;
            cursorTrail.style.left = trailX + 'px';
            cursorTrail.style.top  = trailY + 'px';
            requestAnimationFrame(animateTrail);
        }
        animateTrail();

        // Expand cursor on interactive elements
        document.querySelectorAll('a, button, [data-cursor-expand]').forEach(function (el) {
            el.addEventListener('mouseenter', function () { cursor.classList.add('is-expanded'); });
            el.addEventListener('mouseleave', function () { cursor.classList.remove('is-expanded'); });
        });
    }

    // ── 2. NAVBAR SCROLL EFFECT ──────────────────────────────────────
    const navbar = document.getElementById('demoNav');
    if (navbar) {
        window.addEventListener('scroll', function () {
            navbar.classList.toggle('is-solid', window.scrollY > 40);
        }, { passive: true });
    }

    // ── 3. SWIPER HERO SLIDER ────────────────────────────────────────
    const heroSwiperEl = document.querySelector('.demo-hero-swiper');
    let heroSwiper     = null;

    if (heroSwiperEl && typeof Swiper !== 'undefined') {
        heroSwiper = new Swiper('.demo-hero-swiper', {
            effect:    'fade',
            fadeEffect: { crossFade: true },
            speed:     900,
            autoplay: {
                delay:               6000,
                disableOnInteraction: false,
            },
            loop: true,
            on: {
                slideChange: function () {
                    updateSliderUI(this.realIndex);
                },
            },
        });

        const sliderLines   = document.querySelectorAll('.demo-slider-line');
        const slideCounter  = document.querySelector('.demo-slide-counter');
        const realSlideCount = document.querySelectorAll('.demo-hero-swiper .swiper-slide:not(.swiper-slide-duplicate)').length;

        function updateSliderUI(index) {
            sliderLines.forEach(function (line, i) {
                line.classList.toggle('is-active', i === index);
            });
            if (slideCounter) {
                const current = String(index + 1).padStart(2, '0');
                const total   = String(realSlideCount).padStart(2, '0');
                slideCounter.textContent = current + ' / ' + total;
            }
        }
        updateSliderUI(0);

        const prevBtn = document.getElementById('sliderPrev');
        const nextBtn = document.getElementById('sliderNext');
        if (prevBtn) { prevBtn.addEventListener('click', function () { heroSwiper.slidePrev(); }); }
        if (nextBtn) { nextBtn.addEventListener('click', function () { heroSwiper.slideNext(); }); }
    }

    // ── 4. GSAP ANIMATIONS ───────────────────────────────────────────
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        // Hero headline — staggered word reveal
        const heroWords = document.querySelectorAll('.demo-hero-word');
        if (heroWords.length) {
            gsap.from(heroWords, {
                opacity:  0,
                y:        44,
                stagger:  0.10,
                duration: 0.75,
                ease:     'power3.out',
                delay:    0.25,
            });
        }

        // Hero badge, subtext, buttons
        gsap.from('.demo-slide-badge', {
            opacity:  0,
            y:        18,
            duration: 0.55,
            ease:     'power2.out',
            delay:    0.10,
        });
        gsap.from('.demo-hero-sub', {
            opacity:  0,
            y:        20,
            duration: 0.6,
            ease:     'power2.out',
            delay:    0.7,
        });
        gsap.from('.demo-hero-btns > *', {
            opacity:  0,
            y:        18,
            stagger:  0.10,
            duration: 0.55,
            ease:     'power2.out',
            delay:    0.88,
        });

        // Crystal mouse parallax
        const crystalWrap = document.getElementById('crystalWrap');
        if (crystalWrap) {
            document.addEventListener('mousemove', function (e) {
                const xShift = (e.clientX / window.innerWidth  - 0.5) * 28;
                const yShift = (e.clientY / window.innerHeight - 0.5) * 18;
                gsap.to(crystalWrap, {
                    x:        xShift,
                    y:        yShift,
                    duration: 1.4,
                    ease:     'power1.out',
                });
            });
        }

        // Section eyebrows slide in
        document.querySelectorAll('.demo-eyebrow').forEach(function (el) {
            gsap.from(el, {
                scrollTrigger: { trigger: el, start: 'top 92%', once: true },
                opacity:  0,
                x:        -14,
                duration: 0.5,
                ease:     'power2.out',
            });
        });

        // Section titles
        document.querySelectorAll('.demo-section-title, .demo-section-sub').forEach(function (el) {
            gsap.from(el, {
                scrollTrigger: { trigger: el, start: 'top 90%', once: true },
                opacity:  0,
                y:        24,
                duration: 0.65,
                ease:     'power3.out',
            });
        });

        // Staggered card groups
        document.querySelectorAll('[data-stagger-parent]').forEach(function (parent) {
            const items = parent.querySelectorAll('[data-stagger-child]');
            gsap.from(items, {
                scrollTrigger: { trigger: parent, start: 'top 86%', once: true },
                opacity:  0,
                y:        38,
                stagger:  0.11,
                duration: 0.70,
                ease:     'power3.out',
            });
        });

        // Generic reveal elements
        document.querySelectorAll('.demo-reveal').forEach(function (el) {
            gsap.from(el, {
                scrollTrigger: { trigger: el, start: 'top 88%', once: true },
                opacity:  0,
                y:        30,
                duration: 0.68,
                ease:     'power3.out',
            });
        });

        // Stats bar number counters
        document.querySelectorAll('.demo-stat-num[data-count]').forEach(function (el) {
            const target = parseFloat(el.getAttribute('data-count'));
            const suffix = el.getAttribute('data-suffix') || '';
            ScrollTrigger.create({
                trigger: el,
                start:   'top 92%',
                once:    true,
                onEnter: function () {
                    gsap.to({ value: 0 }, {
                        value:    target,
                        duration: 1.6,
                        ease:     'power2.out',
                        onUpdate: function () {
                            el.textContent = Math.round(this.targets()[0].value) + suffix;
                        },
                    });
                },
            });
        });

        // Featured case study slide-in
        const caseFeatured = document.querySelector('.demo-case-featured');
        if (caseFeatured) {
            gsap.from(caseFeatured, {
                scrollTrigger: { trigger: caseFeatured, start: 'top 85%', once: true },
                opacity:  0,
                y:        36,
                duration: 0.75,
                ease:     'power3.out',
            });
        }

        // Job rows
        const jobRows = document.querySelectorAll('.demo-job-row');
        if (jobRows.length) {
            gsap.from(jobRows, {
                scrollTrigger: { trigger: '.demo-jobs-list', start: 'top 86%', once: true },
                opacity:  0,
                x:        -24,
                stagger:  0.08,
                duration: 0.55,
                ease:     'power2.out',
            });
        }

        // CTA box
        const ctaBox = document.querySelector('.demo-cta-box');
        if (ctaBox) {
            gsap.from(ctaBox, {
                scrollTrigger: { trigger: ctaBox, start: 'top 88%', once: true },
                opacity:  0,
                scale:    0.97,
                duration: 0.7,
                ease:     'power3.out',
            });
        }
    }

    // ── 5. 3D CARD TILT ──────────────────────────────────────────────
    document.querySelectorAll('[data-tilt]').forEach(function (card) {
        card.addEventListener('mousemove', function (e) {
            const rect    = card.getBoundingClientRect();
            const xRatio  = (e.clientX - rect.left) / rect.width  - 0.5;
            const yRatio  = (e.clientY - rect.top)  / rect.height - 0.5;
            const rotateX = yRatio * -6;
            const rotateY = xRatio *  6;
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-3px)`;
        });
        card.addEventListener('mouseleave', function () {
            card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
            card.style.transition = 'transform 0.4s ease';
        });
        card.addEventListener('mouseenter', function () {
            card.style.transition = 'border-color 0.3s ease';
        });
    });

    // ── 6. TESTIMONIAL SLIDER ─────────────────────────────────────────
    const testiSlides = document.querySelectorAll('.demo-testi-slide');
    const testiDots   = document.querySelectorAll('.demo-testi-dot');
    let currentTesti  = 0;

    function showTestimonial(index) {
        testiSlides.forEach(function (slide, i) {
            slide.classList.toggle('is-active', i === index);
        });
        testiDots.forEach(function (dot, i) {
            dot.classList.toggle('is-active', i === index);
        });
        currentTesti = index;
    }

    const testPrev = document.getElementById('testPrev');
    const testNext = document.getElementById('testNext');
    if (testPrev) {
        testPrev.addEventListener('click', function () {
            showTestimonial((currentTesti - 1 + testiSlides.length) % testiSlides.length);
        });
    }
    if (testNext) {
        testNext.addEventListener('click', function () {
            showTestimonial((currentTesti + 1) % testiSlides.length);
        });
    }
    testiDots.forEach(function (dot, i) {
        dot.addEventListener('click', function () { showTestimonial(i); });
    });

    if (testiSlides.length) {
        showTestimonial(0);
        // Auto-rotate every 8 seconds
        setInterval(function () {
            showTestimonial((currentTesti + 1) % testiSlides.length);
        }, 8000);
    }

    // ── 7. MARQUEE PAUSE ON FOCUS ─────────────────────────────────────
    const marqueeTrack = document.querySelector('.demo-marquee-track');
    if (marqueeTrack) {
        marqueeTrack.addEventListener('mouseenter', function () {
            marqueeTrack.style.animationPlayState = 'paused';
        });
        marqueeTrack.addEventListener('mouseleave', function () {
            marqueeTrack.style.animationPlayState = 'running';
        });
    }

});

