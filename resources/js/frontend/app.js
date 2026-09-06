document.addEventListener("DOMContentLoaded", function () {
  var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* ---------- Mobile nav toggle ---------- */
  var toggle = document.querySelector(".nav-toggle");
  var nav = document.querySelector("#site-nav");
  var mobileBreakpoint = window.matchMedia("(max-width: 900px)");
  if (toggle && nav) {
    var setMenuState = function (open, moveFocus) {
      nav.classList.toggle("is-open", open);
      toggle.classList.toggle("is-open", open);
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
      toggle.setAttribute("aria-label", open ? "Close navigation menu" : "Open navigation menu");
      document.body.classList.toggle("has-open-menu", open);
      nav.setAttribute("aria-hidden", mobileBreakpoint.matches && !open ? "true" : "false");

      if (open && moveFocus) {
        var firstLink = nav.querySelector("a");
        if (firstLink) firstLink.focus();
      }
    };

    setMenuState(false, false);

    toggle.addEventListener("click", function () {
      setMenuState(!nav.classList.contains("is-open"), true);
    });

    nav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        if (mobileBreakpoint.matches) setMenuState(false, false);
      });
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape" && nav.classList.contains("is-open")) {
        setMenuState(false, false);
        toggle.focus();
      }
    });

    var handleBreakpointChange = function () {
      setMenuState(false, false);
    };
    if (mobileBreakpoint.addEventListener) {
      mobileBreakpoint.addEventListener("change", handleBreakpointChange);
    } else {
      mobileBreakpoint.addListener(handleBreakpointChange);
    }
  }

  /* ---------- Sticky header shadow ---------- */
  var header = document.querySelector(".site-header");
  if (header) {
    var onScroll = function () {
      header.classList.toggle("is-scrolled", window.scrollY > 8);
    };
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
  }

  /* ---------- Footer year ---------- */
  document.querySelectorAll(".js-year").forEach(function (el) {
    el.textContent = new Date().getFullYear();
  });

  /* ---------- Reveal on scroll ---------- */
  var revealEls = document.querySelectorAll(".reveal");
  if (revealEls.length) {
    if (reduceMotion || !("IntersectionObserver" in window)) {
      revealEls.forEach(function (el) { el.classList.add("is-visible"); });
    } else {
      var io = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              entry.target.classList.add("is-visible");
              io.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.15, rootMargin: "0px 0px -40px 0px" }
      );
      revealEls.forEach(function (el) { io.observe(el); });
    }
  }

  /* ---------- Animated stat counters ---------- */
  var stats = document.querySelectorAll(".stat b[data-count]");
  if (stats.length) {
    var animateStat = function (el) {
      var target = parseFloat(el.getAttribute("data-count"));
      var suffix = el.getAttribute("data-suffix") || "";
      if (reduceMotion) {
        el.textContent = target + suffix;
        return;
      }
      var duration = 1200;
      var start = null;
      var step = function (ts) {
        if (start === null) start = ts;
        var progress = Math.min((ts - start) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        var value = Math.round(target * eased);
        el.textContent = value + suffix;
        if (progress < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    };
    if ("IntersectionObserver" in window) {
      var statIo = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              animateStat(entry.target);
              statIo.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.4 }
      );
      stats.forEach(function (el) { statIo.observe(el); });
    } else {
      stats.forEach(animateStat);
    }
  }

  /* ---------- FAQ accordion ---------- */
  document.querySelectorAll(".faq-item").forEach(function (item) {
    var q = item.querySelector(".faq-q");
    var a = item.querySelector(".faq-a");
    if (!q || !a) return;
    q.addEventListener("click", function () {
      var isOpen = item.classList.contains("is-open");
      item.closest(".faq-list").querySelectorAll(".faq-item").forEach(function (other) {
        other.classList.remove("is-open");
        other.querySelector(".faq-a").style.maxHeight = null;
        other.querySelector(".faq-q").setAttribute("aria-expanded", "false");
      });
      if (!isOpen) {
        item.classList.add("is-open");
        a.style.maxHeight = a.scrollHeight + "px";
        q.setAttribute("aria-expanded", "true");
      }
    });
  });

  /* ---------- Testimonial slider ---------- */
  var testimonials = document.querySelectorAll(".testimonial");
  if (testimonials.length > 1) {
    var current = 0;
    var show = function (i) {
      testimonials.forEach(function (t, idx) { t.classList.toggle("is-active", idx === i); });
    };
    document.querySelectorAll("[data-testi-prev]").forEach(function (btn) {
      btn.addEventListener("click", function () {
        current = (current - 1 + testimonials.length) % testimonials.length;
        show(current);
      });
    });
    document.querySelectorAll("[data-testi-next]").forEach(function (btn) {
      btn.addEventListener("click", function () {
        current = (current + 1) % testimonials.length;
        show(current);
      });
    });
  }

  /* ---------- Contact form validation ---------- */
  var form = document.getElementById("contact-form");
  if (form) {
    var successBox = document.querySelector(".form-success");
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var valid = true;
      var fields = form.querySelectorAll("[required]");
      fields.forEach(function (field) {
        var wrap = field.closest(".field");
        var value = field.value.trim();
        var ok = value.length > 0;
        if (field.type === "email" && ok) {
          ok = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
        }
        if (wrap) wrap.classList.toggle("has-error", !ok);
        if (!ok) valid = false;
      });
      if (valid) {
        form.reset();
        if (successBox) {
          successBox.classList.add("is-visible");
          successBox.textContent = "Thanks — your message is in. We reply within one business day.";
          successBox.setAttribute("tabindex", "-1");
          successBox.focus();
        }
      }
    });
    form.querySelectorAll("[required]").forEach(function (field) {
      field.addEventListener("input", function () {
        var wrap = field.closest(".field");
        if (wrap) wrap.classList.remove("has-error");
      });
    });
  }
});
