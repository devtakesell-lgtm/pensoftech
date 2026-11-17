@extends('frontend.layouts.front-master')

@section('title', 'Software Development')

@section('content')
      <section class="page-hero is-indigo">
    <div class="page-hero-bg bg-blueprint"></div>
    <div class="container page-hero-grid">
      <div>
        <div class="kicker">Software Development</div>
        <h1>Custom software that fits how your team actually works</h1>
        <p class="lead">We design, build and maintain web apps, mobile apps and internal tools — with senior engineers on your account from the first architecture call to production support.</p>
      </div>
      <div class="page-hero-services">
        <span>Web &amp; SaaS apps</span>
        <span>Mobile apps</span>
        <span>Custom software</span>
        <span>API integration</span>
        <span>QA &amp; DevOps</span>
      </div>
    </div>
  </section>

  <!-- SERVICES -->
  <section class="section">
    <div class="container">
      <div class="section-head section-head--wide">
        <div class="eyebrow-line is-soft"><span class="dot"></span>Services</div>
        <h2>Everything from a first prototype to a production system</h2>
        <p>Every engagement starts with a scoped plan — you'll know what's being built, by when, and what it costs before a line of code is written.</p>
      </div>
      <div class="card-grid cols-3">
        <div class="svc-card reveal">
          <h4>Web &amp; SaaS applications</h4>
          <p>Multi-tenant SaaS products, internal dashboards and customer-facing web apps built on modern, maintainable stacks.</p>
          <ul>
            <li>React / Next.js front ends</li>
            <li>Node.js &amp; Python back ends</li>
            <li>Multi-tenant &amp; subscription billing</li>
          </ul>
        </div>
        <div class="svc-card reveal">
          <h4>Mobile app development</h4>
          <p>Native-feeling iOS and Android apps from a single Flutter or React Native codebase, or fully native when it's warranted.</p>
          <ul>
            <li>iOS &amp; Android release management</li>
            <li>Offline-first &amp; push notifications</li>
            <li>App Store &amp; Play Store submission</li>
          </ul>
        </div>
        <div class="svc-card reveal">
          <h4>Custom &amp; enterprise software</h4>
          <p>Purpose-built systems for operations, inventory, logistics or finance that off-the-shelf software can't handle.</p>
          <ul>
            <li>Legacy system modernisation</li>
            <li>Role-based access &amp; audit trails</li>
            <li>On-premise or cloud deployment</li>
          </ul>
        </div>
        <div class="svc-card reveal">
          <h4>API &amp; systems integration</h4>
          <p>Connect your CRM, payment provider, ERP and marketing stack so data moves automatically instead of by hand.</p>
          <ul>
            <li>REST &amp; GraphQL API design</li>
            <li>Third-party &amp; payment gateway integration</li>
            <li>Data migration &amp; sync</li>
          </ul>
        </div>
        <div class="svc-card reveal">
          <h4>QA &amp; test automation</h4>
          <p>Manual and automated testing built into every sprint, so releases don't trade speed for stability.</p>
          <ul>
            <li>Automated regression suites</li>
            <li>Load &amp; performance testing</li>
            <li>Manual QA for critical flows</li>
          </ul>
        </div>
        <div class="svc-card reveal">
          <h4>DevOps &amp; ongoing support</h4>
          <p>CI/CD pipelines, cloud infrastructure and a support retainer once your product is live and needs to stay that way.</p>
          <ul>
            <li>AWS / GCP infrastructure setup</li>
            <li>CI/CD pipeline configuration</li>
            <li>SLA-backed maintenance retainers</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ENGAGEMENT MODELS -->
  <section class="section section--tight">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow-line is-soft"><span class="dot"></span>Ways to work with us</div>
        <h2>Three engagement models, one team</h2>
      </div>
      <div class="diff-list">
        <div class="diff-row reveal">
          <h4>Fixed-scope project</h4>
          <p>Best for a defined product with a clear end point — an app launch, a platform migration, an MVP. Priced and scheduled up front.</p>
        </div>
        <div class="diff-row reveal">
          <h4>Dedicated team</h4>
          <p>A ring-fenced group of engineers who work as an extension of your team, sprint by sprint, for ongoing product development.</p>
        </div>
        <div class="diff-row reveal">
          <h4>Support &amp; maintenance retainer</h4>
          <p>For software already in production — bug fixes, small features and uptime monitoring on a monthly SLA.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- PROCESS -->
  <section class="section">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow-line is-soft"><span class="dot"></span>Our build process</div>
        <h2>How a software engagement runs</h2>
      </div>
      <div class="process-grid">
        <div class="process-step reveal"><div class="num">01</div><h4>Discovery &amp; architecture</h4><p>We map requirements, users and constraints, then decide the technical approach before estimating cost.</p></div>
        <div class="process-step reveal"><div class="num">02</div><h4>Design &amp; scoping</h4><p>Wireframes, data models and a sprint-by-sprint roadmap you sign off before development starts.</p></div>
        <div class="process-step reveal"><div class="num">03</div><h4>Build in sprints</h4><p>Two-week sprints with a working demo at the end of each one — nothing is a surprise at launch.</p></div>
        <div class="process-step reveal"><div class="num">04</div><h4>Launch &amp; support</h4><p>Deployment, monitoring and a documented handover, with an optional retainer for what comes after.</p></div>
      </div>
    </div>
  </section>

  <!-- CASE STUDIES -->
  <section class="section section--tight">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow-line is-soft"><span class="dot"></span>Recent builds</div>
        <h2>Software we've shipped</h2>
      </div>
      <div class="card-grid cols-3">
        <div class="case-card is-indigo reveal">
          <div class="thumb"><svg viewBox="0 0 400 250" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="250" fill="#EAECFB"/><rect x="30" y="30" width="150" height="190" fill="#3B4FE0"/><rect x="200" y="30" width="170" height="88" fill="#10151A"/><rect x="200" y="132" width="170" height="88" fill="#8C9BFF"/></svg></div>
          <div class="body">
            <span class="tag">Web platform</span>
            <h4>Inventory &amp; ordering system — Vertex Retail</h4>
            <p>Real-time stock, purchase orders and store-level reporting for a 40-location retail chain.</p>
            <div class="result">Order errors down <b>72%</b>, reporting time from days to minutes</div>
          </div>
        </div>
        <div class="case-card is-indigo reveal">
          <div class="thumb"><svg viewBox="0 0 400 250" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="250" fill="#EAECFB"/><rect x="30" y="60" width="340" height="30" fill="#3B4FE0"/><rect x="30" y="105" width="220" height="30" fill="#10151A"/><rect x="30" y="150" width="280" height="30" fill="#8C9BFF"/></svg></div>
          <div class="body">
            <span class="tag">Mobile app</span>
            <h4>Booking app — Ferrylane Tours</h4>
            <p>iOS and Android app with live availability, in-app payments and a staff admin panel.</p>
            <div class="result"><b>12,000+</b> downloads and a 4.7★ average rating in year one</div>
          </div>
        </div>
        <div class="case-card is-indigo reveal">
          <div class="thumb"><svg viewBox="0 0 400 250" xmlns="http://www.w3.org/2000/svg"><rect width="400" height="250" fill="#EAECFB"/><circle cx="130" cy="125" r="60" fill="none" stroke="#3B4FE0" stroke-width="10"/><rect x="230" y="70" width="140" height="110" fill="#10151A"/></svg></div>
          <div class="body">
            <span class="tag">Systems integration</span>
            <h4>CRM &amp; billing sync — Northbay</h4>
            <p>Connected a legacy CRM to a modern billing system, removing a manual monthly reconciliation process.</p>
            <div class="result">18 hours of manual work removed every month</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="section">
    <div class="container" style="max-width:820px;">
      <div class="section-head">
        <div class="eyebrow-line is-soft"><span class="dot"></span>Common questions</div>
        <h2>Software development FAQ</h2>
      </div>
      <div class="faq-list">
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">How long does a typical project take?</button>
          <div class="faq-a"><p>A focused MVP usually takes 8–12 weeks. Larger platforms or multi-phase builds run 4–9 months, scoped into sprints so you see working software throughout, not just at the end.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">Who owns the code once the project is done?</button>
          <div class="faq-a"><p>You do. Source code, infrastructure access and documentation are handed over as part of every engagement — there's no lock-in to keep us involved.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">Can you work with our existing developers?</button>
          <div class="faq-a"><p>Yes. We regularly join as a dedicated team alongside an in-house team, or take over specific modules while your developers focus elsewhere.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">What if requirements change mid-project?</button>
          <div class="faq-a"><p>Change is normal. Sprint-based scoping means new requirements are estimated and slotted into the plan without derailing what's already been agreed.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q" aria-expanded="false">Do you offer support after launch?</button>
          <div class="faq-a"><p>Yes — a monthly maintenance retainer with an agreed SLA covers bug fixes, small enhancements and uptime monitoring for as long as you need it.</p></div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="section section--tight">
    <div class="container">
      <div class="cta-banner">
        <div class="content">
          <h2>Have a product in mind?</h2>
          <p>Send us the brief, however rough. We'll come back with an approach and a realistic estimate.</p>
        </div>
        <div class="btn-row">
          <a href="{{ route('contact') }}" class="btn btn-indigo">Start a software project</a>
        </div>
      </div>
    </div>
  </section>
@endsection
