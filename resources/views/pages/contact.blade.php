@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <section class="section" style="padding-top:64px;padding-bottom:0;">
    <div class="container">
      <div class="kicker">Contact</div>
      <h1 style="font-size:clamp(32px,4.6vw,50px);max-width:18ch;margin-top:14px;">Tell us what you're trying to build or grow</h1>
      <p style="color:var(--slate);font-size:17px;max-width:56ch;margin-top:16px;">Fill in the form and pick whichever service fits — or say "not sure" and we'll help you figure it out on the call. We reply within one business day.</p>
    </div>
  </section>

  <section class="section">
    <div class="container contact-grid">

      <div>
        <div class="contact-info-item">
          <span class="label">Email</span>
          <a href="mailto:hello@pensofttech.com">hello@pensofttech.com</a>
        </div>
        <div class="contact-info-item">
          <span class="label">Phone</span>
          <a href="tel:+8801700000000">+880 1700-000000</a>
        </div>
        <div class="contact-info-item">
          <span class="label">Office</span>
          <p>Level 6, Gulshan Avenue, Dhaka 1212, Bangladesh</p>
        </div>
        <div class="contact-info-item">
          <span class="label">Hours</span>
          <p>Sunday – Thursday, 9:00 AM – 6:00 PM (GMT+6)</p>
        </div>

        <div style="margin-top:40px;">
          <div class="eyebrow-line is-soft"><span class="dot"></span>Prefer to skip the form?</div>
          <p style="color:var(--slate);font-size:15px;max-width:40ch;">Email us directly with a few lines about your project and the best time to call — we'll take it from there.</p>
        </div>
      </div>

      <div>
        <form id="contact-form" novalidate>
          <div class="form-row">
            <div class="field">
              <label for="name">Full name</label>
              <input type="text" id="name" name="name" required>
              <span class="err-msg">Please enter your name.</span>
            </div>
            <div class="field">
              <label for="email">Work email</label>
              <input type="email" id="email" name="email" required>
              <span class="err-msg">Please enter a valid email.</span>
            </div>
          </div>
          <div class="form-row">
            <div class="field">
              <label for="company">Company</label>
              <input type="text" id="company" name="company" required>
              <span class="err-msg">Please enter your company name.</span>
            </div>
            <div class="field">
              <label for="phone">Phone (optional)</label>
              <input type="tel" id="phone" name="phone">
            </div>
          </div>
          <div class="form-row">
            <div class="field">
              <label for="service">Service you need</label>
              <select id="service" name="service" required>
                <option value="">Select one</option>
                <option value="software">Software Development</option>
                <option value="marketing">Digital Marketing / Ads</option>
                <option value="both">Both</option>
                <option value="unsure">Not sure yet</option>
              </select>
              <span class="err-msg">Please select an option.</span>
            </div>
            <div class="field">
              <label for="budget">Estimated budget</label>
              <select id="budget" name="budget" required>
                <option value="">Select a range</option>
                <option value="under-5k">Under $5,000</option>
                <option value="5k-15k">$5,000 – $15,000</option>
                <option value="15k-50k">$15,000 – $50,000</option>
                <option value="50k-plus">$50,000+</option>
              </select>
              <span class="err-msg">Please select a budget range.</span>
            </div>
          </div>
          <div class="field">
            <label for="message">Project details</label>
            <textarea id="message" name="message" required placeholder="What are you trying to build or grow, and by when?"></textarea>
            <span class="err-msg">Tell us a little about the project.</span>
          </div>
          <button type="submit" class="btn btn-primary">Send message</button>
          <div class="form-success" role="status"></div>
        </form>
      </div>

    </div>
  </section>

  <!-- MAP PLACEHOLDER -->
  <section class="section--tight">
    <div class="container">
      <div style="border:1px solid var(--line);border-radius:var(--radius-md);aspect-ratio:16/5;overflow:hidden;">
        <svg viewBox="0 0 1200 375" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
          <rect width="1200" height="375" fill="#EAEDE9"/>
          <g stroke="#DBE0DB" stroke-width="1">
            <path d="M0 75H1200 M0 150H1200 M0 225H1200 M0 300H1200"/>
            <path d="M150 0V375 M350 0V375 M550 0V375 M750 0V375 M950 0V375"/>
          </g>
          <circle cx="600" cy="187" r="10" fill="#FF5A36"/>
          <circle cx="600" cy="187" r="22" fill="none" stroke="#FF5A36" stroke-width="2" opacity="0.4"/>
          <text x="630" y="192" font-family="Sora, sans-serif" font-size="16" fill="#10151A" font-weight="600">PenSoftTech — Gulshan, Dhaka</text>
        </svg>
      </div>
    </div>
  </section>
@endsection
