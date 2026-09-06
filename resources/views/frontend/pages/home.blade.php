
@extends('frontend.layouts.front-master')

@section('title', 'Home')

@section('content')
     <!-- HERO -->
  <section class="hero">
    <div class="container hero-grid">
      <div>
        <div class="kicker">PenSoftTech · Dhaka &amp; remote-first</div>
        <h1>Software that runs your business.<br>Marketing that grows it.</h1>
        <p class="hero-sub">PenSoftTech is a two-discipline partner: we design and build custom software, and we plan and run digital marketing that brings in customers. Most agencies do one. We're accountable for both, under one roof.</p>
        <div class="btn-row">
          <a href="{{ route('software-development') }}" class="btn btn-indigo">Explore Software Development</a>
          <a href="{{ route('digital-marketing') }}" class="btn btn-coral">Explore Digital Marketing</a>
        </div>
        <div class="hero-meta">
          <div><b>60+</b><span>Projects shipped</span></div>
          <div><b>35+</b><span>Clients served</span></div>
          <div><b>8 yrs</b><span>In business</span></div>
          <div><b>2</b><span>Disciplines, 1 partner</span></div>
        </div>
      </div>
      <div class="hero-visual reveal">
        <div class="split-panel">
          <svg viewBox="0 0 480 480" xmlns="http://www.w3.org/2000/svg">
            <rect width="480" height="480" fill="#10151A"/>
            <path d="M0 480L480 0V480H0Z" fill="#181F2E"/>
            <g stroke="#3B4FE0" stroke-width="1" opacity="0.5">
              <path d="M40 40H240V240H40V40Z" fill="none"/>
              <path d="M40 80H240 M40 120H240 M40 160H240 M40 200H240"/>
              <path d="M80 40V240 M120 40V240 M160 40V240 M200 40V240"/>
            </g>
            <rect x="40" y="40" width="80" height="80" fill="#3B4FE0" opacity="0.85"/>
            <rect x="160" y="160" width="80" height="80" fill="none" stroke="#8C9BFF" stroke-width="2"/>
            <g stroke="#FF5A36" stroke-width="3" fill="none" stroke-linecap="round">
              <path d="M260 420 C 300 380, 320 340, 300 300 S 360 220, 340 160" />
            </g>
            <circle cx="340" cy="160" r="7" fill="#FF5A36"/>
            <circle cx="300" cy="300" r="5" fill="#FF8F6E"/>
            <path d="M420 100L440 120L420 140" stroke="#FF5A36" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M260 100H400" stroke="#FF5A36" stroke-width="3" stroke-dasharray="2 10" stroke-linecap="round"/>
          </svg>
        </div>
      </div>
    </div>
  </section>

  <!-- TRUST BAR -->
  <section class="trust-bar">
    <div class="container">
      <span class="trust-label">Trusted by teams building online</span>
      <div class="trust-logos">
        <span>Northbay</span>
        <span>Kolori</span>
        <span>Vertex Retail</span>
        <span>Harbor&amp;Co</span>
        <span>Ashen Labs</span>
        <span>Ferrylane</span>
      </div>
    </div>
  </section>

  <!-- VERTICALS -->
  <section class="section">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow-line"><span class="dot"></span>What we do</div>
        <h2>Two disciplines. Built to work together.</h2>
        <p>Hire us for one vertical or both — either way, you get a team that understands how product and growth affect each other.</p>
      </div>

      <div class="verticals">
        <div class="vertical-panel is-indigo reveal">
          <span class="tag">Software Development</span>
          <h3>Custom software, built to your workflow</h3>
          <p class="desc">Web apps, mobile apps and internal tools engineered by a senior team — from first architecture decision to production support.</p>
          <ul class="svc-list">
            <li>Web &amp; SaaS application development</li>
            <li>Mobile apps — iOS &amp; Android</li>
            <li>Custom &amp; enterprise software</li>
            <li>API &amp; systems integration</li>
            <li>QA, DevOps &amp; ongoing support</li>
          </ul>
          <a href="{{ route('software-development') }}" class="btn btn-ghost-light">See software services</a>
        </div>
        <div class="vertical-panel is-coral reveal">
          <span class="tag">Digital Marketing &amp; Ads</span>
          <h3>Marketing that's tied to revenue</h3>
          <p class="desc">SEO, paid media and content programs run by specialists who report on pipeline and revenue, not just impressions.</p>
          <ul class="svc-list">
            <li>SEO &amp; organic growth</li>
            <li>Paid search &amp; social advertising</li>
            <li>Content &amp; social media management</li>
            <li>Branding &amp; creative</li>
            <li>Analytics, tracking &amp; reporting</li>
          </ul>
          <a href="{{ route('digital-marketing') }}" class="btn btn-ghost">See marketing services</a>
        </div>
      </div>
    </div>
  </section>

  <!-- WHY US -->
  <section class="section section--tight">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow-line is-soft"><span class="dot"></span>Why PenSoftTech</div>
        <h2>What you get that a single-discipline shop can't offer</h2>
      </div>
      <div class="diff-list">
        <div class="diff-row reveal">
          <h4>One accountable team</h4>
          <p>No hand-off between a dev shop and an ad agency pointing fingers at each other. If a landing page converts poorly, the same company that built it can fix the code and the campaign.</p>
        </div>
        <div class="diff-row reveal">
          <h4>Senior people on your account</h4>
          <p>Engineers and marketers with 5+ years of experience run your work directly — not a rotating cast of junior contractors managed by an account exec.</p>
        </div>
        <div class="diff-row reveal">
          <h4>Fixed scope, fixed price</h4>
          <p>Every engagement starts with a written scope and timeline. You know the cost before work begins, and change requests are quoted, not buried in the bill.</p>
        </div>
        <div class="diff-row reveal">
          <h4>Built to hand off</h4>
          <p>You own the code, the ad accounts and the analytics from day one. If you ever want to bring work in-house, everything is documented and portable.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- STATS -->
  <x-frontend.components.ui.status-band/>

  <!-- PROCESS -->
  <section class="section">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow-line"><span class="dot"></span>How we work</div>
        <h2>A process that stays the same, whichever team you hire</h2>
      </div>
      <div class="process-grid">
        <div class="process-step reveal">
          <div class="num">01</div>
          <h4>Discover</h4>
          <p>We audit your product, market and current numbers, then agree on what success looks like.</p>
        </div>
        <div class="process-step reveal">
          <div class="num">02</div>
          <h4>Plan</h4>
          <p>A scoped roadmap or media plan with milestones, cost and the metrics we'll be judged on.</p>
        </div>
        <div class="process-step reveal">
          <div class="num">03</div>
          <h4>Build &amp; launch</h4>
          <p>Sprints or campaign flights with weekly visibility — you see progress, not just a final reveal.</p>
        </div>
        <div class="process-step reveal">
          <div class="num">04</div>
          <h4>Grow</h4>
          <p>Post-launch support, optimisation and reporting so results compound instead of plateauing.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CASE STUDIES -->
  <section class="section section--tight">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow-line is-soft"><span class="dot"></span>Recent work</div>
        <h2>A mix of builds and campaigns</h2>
      </div>
      <div class="card-grid cols-3">
        <div class="case-card is-indigo reveal">
          <div class="thumb">
            <svg viewBox="0 0 400 250" xmlns="http://www.w3.org/2000/svg">
              <rect width="400" height="250" fill="#EAECFB"/>
              <rect x="30" y="30" width="150" height="190" fill="#3B4FE0"/>
              <rect x="200" y="30" width="170" height="88" fill="#10151A"/>
              <rect x="200" y="132" width="170" height="88" fill="#8C9BFF"/>
            </svg>
          </div>
          <div class="body">
            <span class="tag">Software Development</span>
            <h4>Inventory platform for Vertex Retail</h4>
            <p>Replaced three spreadsheets with one real-time inventory and ordering system across 40 stores.</p>
            <div class="result">Order errors down <b>72%</b> in the first quarter</div>
          </div>
        </div>
        <div class="case-card reveal">
          <div class="thumb">
            <svg viewBox="0 0 400 250" xmlns="http://www.w3.org/2000/svg">
              <rect width="400" height="250" fill="#FFE9E1"/>
              <circle cx="120" cy="125" r="70" fill="#FF5A36"/>
              <path d="M220 60 L370 60 L370 110 L220 110Z" fill="#10151A"/>
              <path d="M220 140 L340 140 L340 190 L220 190Z" fill="#FF8F6E"/>
            </svg>
          </div>
          <div class="body">
            <span class="tag">Digital Marketing</span>
            <h4>Paid search relaunch for Harbor&amp;Co</h4>
            <p>Rebuilt account structure and landing pages for a home-goods retailer's search campaigns.</p>
            <div class="result">Cost per lead down <b>46%</b>, spend unchanged</div>
          </div>
        </div>
        <div class="case-card is-indigo reveal">
          <div class="thumb">
            <svg viewBox="0 0 400 250" xmlns="http://www.w3.org/2000/svg">
              <rect width="400" height="250" fill="#EAECFB"/>
              <rect x="30" y="60" width="340" height="30" fill="#3B4FE0"/>
              <rect x="30" y="105" width="220" height="30" fill="#10151A"/>
              <rect x="30" y="150" width="280" height="30" fill="#8C9BFF"/>
            </svg>
          </div>
          <div class="body">
            <span class="tag">Software Development</span>
            <h4>Booking app for Ferrylane Tours</h4>
            <p>iOS and Android booking app with live availability, payments and a staff-facing admin panel.</p>
            <div class="result">4.7★ rating, <b>12,000+</b> downloads in year one</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TECH MARQUEE -->
  <div class="marquee">
    <div class="marquee-track">
      <span>React</span><span>Node.js</span><span>Next.js</span><span>Flutter</span><span>PostgreSQL</span><span>AWS</span><span>Google Ads</span><span>Meta Ads</span><span>HubSpot</span><span>Shopify</span>
      <span>React</span><span>Node.js</span><span>Next.js</span><span>Flutter</span><span>PostgreSQL</span><span>AWS</span><span>Google Ads</span><span>Meta Ads</span><span>HubSpot</span><span>Shopify</span>
    </div>
  </div>

  <!-- TESTIMONIALS -->
  <section class="section">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow-line"><span class="dot"></span>Client feedback</div>
        <h2>What it's like to work with us</h2>
      </div>
      <div class="testimonial-wrap">
        <div class="testimonial is-active">
          <blockquote>"PenSoftTech rebuilt our booking system and then took over our Google Ads. Having one team accountable for both meant nothing fell through the cracks."</blockquote>
          <div class="who">
            <div class="initials">RA</div>
            <div><b>Rafiq Ahmed</b><span>Founder, Ferrylane Tours</span></div>
          </div>
        </div>
        <div class="testimonial">
          <blockquote>"Our cost per lead dropped by nearly half within two months. The reporting is honest — they tell us when something isn't working, not just when it is."</blockquote>
          <div class="who">
            <div class="initials">SN</div>
            <div><b>Sadia Nasrin</b><span>Marketing Lead, Harbor&amp;Co</span></div>
          </div>
        </div>
        <div class="testimonial">
          <blockquote>"We've used three dev shops before this one. PenSoftTech is the first that shipped on the date they promised, with documentation we could actually hand to our own engineers."</blockquote>
          <div class="who">
            <div class="initials">TK</div>
            <div><b>Tanvir Kabir</b><span>COO, Vertex Retail</span></div>
          </div>
        </div>
        <div class="testi-nav">
          <button data-testi-prev aria-label="Previous testimonial">&#8592;</button>
          <button data-testi-next aria-label="Next testimonial">&#8594;</button>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="section section--tight">
    <div class="container">
      <div class="cta-banner">
        <div class="content">
          <h2>Tell us what you're trying to build or grow</h2>
          <p>Book a 30-minute call. We'll come with questions, not a sales script.</p>
        </div>
        <div class="btn-row">
          <a href="{{ route('contact') }}" class="btn btn-coral">Start a project</a>
          <a href="{{ route('about') }}" class="btn btn-ghost-light">Learn about us</a>
        </div>
      </div>
    </div>
  </section>
@endsection
