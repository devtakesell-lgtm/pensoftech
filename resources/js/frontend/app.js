/**
 * Frontend JavaScript Bundle
 * Uses: GSAP 3 + ScrollTrigger, Swiper 11, Lenis (loaded in front-master.blade.php)
 * Handles: custom cursor, navbar scroll, hero slider, GSAP animations, counters, and responsive UI
 */

document.addEventListener('DOMContentLoaded', function () {
    
    // ── 0. LENIS SMOOTH SCROLL ────────────────────────────────────────
    let lenis;
    if (typeof Lenis !== 'undefined') {
        lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            direction: 'vertical',
            gestureDirection: 'vertical',
            smooth: true,
            mouseMultiplier: 1,
            smoothTouch: false,
            touchMultiplier: 2,
            infinite: false,
        });

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);
    }

    // ── 1. CUSTOM CURSOR ──────────────────────────────────────────────
    const cursor      = document.getElementById('frontendCursor');
    const cursorTrail = document.getElementById('frontendCursorTrail');

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

        function animateTrail() {
            trailX += (mouseX - trailX) * 0.11;
            trailY += (mouseY - trailY) * 0.11;
            cursorTrail.style.left = trailX + 'px';
            cursorTrail.style.top  = trailY + 'px';
            requestAnimationFrame(animateTrail);
        }
        animateTrail();

        document.querySelectorAll('a, button, [data-cursor-expand]').forEach(function (el) {
            el.addEventListener('mouseenter', function () { cursor.classList.add('is-expanded'); });
            el.addEventListener('mouseleave', function () { cursor.classList.remove('is-expanded'); });
        });
    }

    // ── 2. NAVBAR SCROLL EFFECT ──────────────────────────────────────
    const navbar = document.getElementById('mainNav');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                navbar.classList.remove('bg-transparent', 'py-6');
                navbar.classList.add('bg-black/85', 'backdrop-blur-xl', 'py-4', 'border-b', 'border-white/10');
            } else {
                navbar.classList.add('bg-transparent', 'py-6');
                navbar.classList.remove('bg-black/85', 'backdrop-blur-xl', 'py-4', 'border-b', 'border-white/10');
            }
        }, { passive: true });
    }

    // ── 3. GSAP ANIMATIONS ───────────────────────────────────────────
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        if (lenis) {
            lenis.on('scroll', ScrollTrigger.update);
            gsap.ticker.add((time)=>{
                lenis.raf(time * 1000)
            });
            gsap.ticker.lagSmoothing(0, 0);
        }
    }

    // ── 4. 3D CARD TILT ──────────────────────────────────────────────
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

});
