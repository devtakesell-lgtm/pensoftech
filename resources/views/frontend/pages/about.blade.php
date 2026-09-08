@extends('frontend.layouts.front-master')

@section('title', 'About Us')

@section('content')

  <section class="section" style="padding-top:64px;padding-bottom:64px;">
    <div class="container">
      <div class="kicker">About PenSoftTech</div>
      <h1 style="font-size:clamp(32px,4.6vw,54px);max-width:16ch;margin-top:14px;">Built by people who got tired of hand-offs</h1>
    </div>
  </section>

  <!-- STORY -->
  <section class="section section--tight">
    <div class="container story-grid">
      <div>
        <div class="eyebrow-line"><span class="dot"></span>Our story</div>
        <h2 style="font-size:28px;">Why software and marketing, together</h2>
      </div>
      <div>
        <p>PenSoftTech started in 2018 as a small software team building web apps for local businesses in Dhaka. Again and again, clients would ship a good product and then struggle to get anyone to use it — not because the software was wrong, but because nobody owned the job of bringing people to it.</p>
        <p>So we built a second team. Not a referral partner, not a reseller — an in-house digital marketing group that could sit in the same room as the engineers, look at the same product, and plan how to get it in front of the right people.</p>
        <p>Today PenSoftTech runs both disciplines as equal, independently capable teams. Some clients hire us for one. Many hire us for both, because a landing page that converts and a checkout flow that works are, in practice, the same problem.</p>
      </div>
    </div>
  </section>

  <!-- MISSION / VALUES -->
  <section class="section">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow-line is-soft"><span class="dot"></span>What we believe</div>
        <h2>The principles behind how we work</h2>
      </div>
      <div class="card-grid cols-2">
        <div class="value-card reveal">
          <h4>Say what we don't know</h4>
          <p>If a channel isn't working or a feature is riskier than it looks, we say so before spending your budget finding out.</p>
        </div>
        <div class="value-card reveal">
          <h4>Ship in small pieces</h4>
          <p>Two-week sprints and monthly campaign reviews mean you see real progress constantly, not a single reveal at the end.</p>
        </div>
        <div class="value-card reveal">
          <h4>You own what we build</h4>
          <p>Code, ad accounts and analytics belong to you from day one — our job is to be worth keeping, not hard to leave.</p>
        </div>
        <div class="value-card reveal">
          <h4>Numbers over opinions</h4>
          <p>Decisions get made from data — conversion rates, load times, cost per lead — not from whoever has the loudest opinion in the room.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- STATS -->

  <x-frontend.components.ui.status-band/>


  <!-- TEAM -->
  <section class="section">
    <div class="container">
      <div class="section-head">
        <div class="eyebrow-line"><span class="dot"></span>Leadership</div>
        <h2>The people you'd actually talk to</h2>
      </div>
      <div class="card-grid cols-3">
        <div class="team-card reveal">
          <div class="team-avatar" style="background:#3B4FE0;">MH</div>
          <h4>Mahmudul Hasan</h4>
          <span>Co-founder &amp; Head of Engineering</span>
        </div>
        <div class="team-card reveal">
          <div class="team-avatar" style="background:#FF5A36;">FA</div>
          <h4>Farzana Akter</h4>
          <span>Co-founder &amp; Head of Marketing</span>
        </div>
        <div class="team-card reveal">
          <div class="team-avatar" style="background:#10151A;">SI</div>
          <h4>Shakil Islam</h4>
          <span>Lead Product Engineer</span>
        </div>
        <div class="team-card reveal">
          <div class="team-avatar" style="background:#5B6470;">NR</div>
          <h4>Nusrat Rahman</h4>
          <span>Paid Media Lead</span>
        </div>
        <div class="team-card reveal">
          <div class="team-avatar" style="background:#3B4FE0;">AH</div>
          <h4>Arif Hossain</h4>
          <span>Mobile Engineering Lead</span>
        </div>
        <div class="team-card reveal">
          <div class="team-avatar" style="background:#FF5A36;">TS</div>
          <h4>Tania Sultana</h4>
          <span>SEO &amp; Content Lead</span>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="section section--tight">
    <div class="container">
      <div class="cta-banner">
        <div class="content">
          <h2>Want to meet the team?</h2>
          <p>Book a call and we'll bring the right specialists — engineering, marketing, or both.</p>
        </div>
        <div class="btn-row">
          <a href="{{ route('contact') }}" class="btn btn-coral">Get in touch</a>
        </div>
      </div>
    </div>
  </section>

@endsection
