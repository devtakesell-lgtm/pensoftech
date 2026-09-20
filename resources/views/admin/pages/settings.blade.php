@extends('admin.layouts.admin-master')

@section('title', 'Settings')

@section('content')
    <div class="heading d-flex justify-content-between align-items-center mb-4">
        <div>
            <small class="text-muted text-uppercase fw-bold" style="letter-spacing: 1px;">Agency Admin</small>
            <h1 class="mt-1 mb-0">Settings</h1>
            <p class="text-muted mt-1">Manage your PenSoftTech agency configuration and global preferences.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert"
            style="border-radius: 8px; border: none; background-color: #ecfdf5; color: #065f46;">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="settings-wrapper">

            <!-- Sidebar Navigation -->
            <div class="settings-nav">
                <a class="settings-nav-item selected" onclick="switchTab('general', this)">
                    <i class="bi bi-building"></i> General
                </a>
                <a class="settings-nav-item" onclick="switchTab('seo', this)">
                    <i class="bi bi-globe"></i> SEO & Meta
                </a>
                <a class="settings-nav-item" onclick="switchTab('tracking', this)">
                    <i class="bi bi-graph-up-arrow"></i> Tracking
                </a>
                <a class="settings-nav-item" onclick="switchTab('social', this)">
                    <i class="bi bi-share"></i> Social Links
                </a>
                <a class="settings-nav-item" onclick="switchTab('system', this)">
                    <i class="bi bi-gear"></i> System Preferences
                </a>
            </div>

            <!-- Content Area -->
            <div class="form-area-wrapper">

                <!-- General Settings -->
                <div id="general" class="settings-card active">
                    <h3>General Settings</h3>
                    <p>Core information and brand identity for your agency.</p>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Company Name</label>
                            <input type="text" name="company_name" value="{{ setting('company_name') }}"
                                placeholder="e.g. PenSoftTech">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Default Currency</label>
                            <select name="default_currency_id">
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" {{ $currency->is_default ? 'selected' : '' }}>
                                        {{ $currency->code }} ({{ $currency->symbol }}) - {{ $currency->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Contact Email</label>
                            <input type="email" name="contact_email" value="{{ setting('contact_email') }}"
                                placeholder="hello@company.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Contact Phone</label>
                            <input type="text" name="contact_phone" value="{{ setting('contact_phone') }}"
                                placeholder="+880...">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Office Location</label>
                        <input type="text" name="office_location" value="{{ setting('office_location') }}"
                            placeholder="Full address">
                    </div>

                    <div class="form-group">
                        <label>Working Hours</label>
                        <input type="text" name="working_hours" value="{{ setting('working_hours') }}"
                            placeholder="Sat- thu (9am -6pm)">
                    </div>

                    <div class="settings-action-bar">
                        <button type="submit" class="btn primary px-4 py-2">Save Changes</button>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div id="seo" class="settings-card">
                    <h3>SEO & Meta</h3>
                    <p>Default tags and descriptions for search engine optimization.</p>

                    <div class="form-group">
                        <label>Default Meta Title</label>
                        <input type="text" name="seo_meta_title" value="{{ setting('seo_meta_title') }}">
                        <span class="help-text">Appears in search engine results and browser tabs.</span>
                    </div>

                    <div class="form-group">
                        <label>Default Meta Description</label>
                        <textarea name="seo_meta_description" rows="3">{{ setting('seo_meta_description') }}</textarea>
                        <span class="help-text">A brief summary of your agency to attract clicks from search results.</span>
                    </div>

                    <div class="form-group">
                        <label>Meta Keywords</label>
                        <input type="text" name="seo_meta_keywords" value="{{ setting('seo_meta_keywords') }}"
                            placeholder="software, agency, digital...">
                    </div>

                    <div class="form-group mt-4 mb-2">
                        <x-admin.components.forms.image-upload name="seo_og_image" label="Default Open Graph Image"
                            :current="setting('seo_og_image')" aspect="banner" />
                        <span class="help-text">The image displayed when a link to your site is shared on social
                            media.</span>
                    </div>

                    <div class="settings-action-bar">
                        <button type="submit" class="btn primary px-4 py-2">Save Changes</button>
                    </div>
                </div>

                <!-- Tracking Settings -->
                <div id="tracking" class="settings-card">
                    <h3>Tracking & Analytics</h3>
                    <p>Configure third-party analytics and custom scripts.</p>

                    <div class="form-group">
                        <label>Google Analytics ID</label>
                        <input type="text" name="ga_id" value="{{ setting('ga_id') }}" placeholder="G-XXXXXXXXXX">
                    </div>

                    <div class="form-group">
                        <label>Google Tag Manager ID</label>
                        <input type="text" name="gtm_id" value="{{ setting('gtm_id') }}" placeholder="GTM-XXXXXXX">
                    </div>

                    <div class="form-group">
                        <label>Meta Pixel ID</label>
                        <input type="text" name="meta_pixel_id" value="{{ setting('meta_pixel_id') }}"
                            placeholder="Enter pixel ID">
                    </div>

                    <hr class="my-4" style="border-color: #eaeaea;">

                    {{-- <div class="form-group">
                        <label>Custom Header Scripts</label>
                        <textarea class="text-monospace" name="custom_header_scripts" rows="4" placeholder="<script>
                            ...
                        </script>">{{ setting('custom_header_scripts') }}</textarea>
                        <span class="help-text">Code injected just before the closing &lt;/head&gt; tag.</span>
                    </div>

                    <div class="form-group">
                        <label>Custom Footer Scripts</label>
                        <textarea class="text-monospace" name="custom_footer_scripts" rows="4" placeholder="<script>
                            ...
                        </script>">{{ setting('custom_footer_scripts') }}</textarea>
                        <span class="help-text">Code injected just before the closing &lt;/body&gt; tag.</span>
                    </div> --}}

                    <div class="settings-action-bar">
                        <button type="submit" class="btn primary px-4 py-2">Save Changes</button>
                    </div>
                </div>

                <!-- Social Settings -->
                <div id="social" class="settings-card">
                    <h3>Social Links</h3>
                    <p>Manage URLs for your agency's social media presence.</p>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-facebook" style="color: #1877F2;"></i> Facebook</label>
                            <input type="url" name="facebook_url" value="{{ setting('facebook_url') }}"
                                placeholder="https://facebook.com/...">
                        </div>
                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-linkedin" style="color: #0A66C2;"></i> LinkedIn</label>
                            <input type="url" name="linkedin_url" value="{{ setting('linkedin_url') }}"
                                placeholder="https://linkedin.com/...">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-twitter-x"></i> Twitter / X</label>
                            <input type="url" name="twitter_url" value="{{ setting('twitter_url') }}"
                                placeholder="https://x.com/...">
                        </div>
                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-instagram" style="color: #E4405F;"></i> Instagram</label>
                            <input type="url" name="instagram_url" value="{{ setting('instagram_url') }}"
                                placeholder="https://instagram.com/...">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-youtube" style="color: #FF0000;"></i> YouTube</label>
                            <input type="url" name="youtube_url" value="{{ setting('youtube_url') }}"
                                placeholder="https://youtube.com/...">
                        </div>
                        <div class="col-md-6 form-group">
                            <label><i class="bi bi-github"></i> GitHub</label>
                            <input type="url" name="github_url" value="{{ setting('github_url') }}"
                                placeholder="https://github.com/...">
                        </div>
                    </div>

                    <div class="settings-action-bar">
                        <button type="submit" class="btn primary px-4 py-2">Save Changes</button>
                    </div>
                </div>

                <!-- System Settings -->
                <div id="system" class="settings-card">
                    <h3>System Preferences</h3>
                    <p>Configure internal platform behavior and webhooks.</p>

                    <div class="form-group">
                        <label>System Admin Email</label>
                        <input type="email" name="system_admin_email" value="{{ setting('system_admin_email') }}"
                            placeholder="admin@pensofttech.com">
                        <span class="help-text">Receives critical system alerts and lead notifications.</span>
                    </div>

                    {{-- <div class="form-group">
                        <label>Slack Webhook URL</label>
                        <input type="url" name="slack_webhook_url" value="{{ setting('slack_webhook_url') }}"
                            placeholder="https://hooks.slack.com/...">
                        <span class="help-text">Used for pushing platform activity to Slack channels.</span>
                    </div> --}}

                    <div class="toggle-wrapper mt-4">
                        <div class="flex-grow-1">
                            <h4 style="margin: 0 0 4px 0; font-size: 13px;">Auto-Approve Blog Comments</h4>
                            <p style="margin: 0; font-size: 10px; color: #858ea0;">When enabled, new comments won't require
                                manual review.</p>
                        </div>
                        <div class="toggle-switch">
                            <input type="hidden" name="auto_approve_comments" value="0">
                            <input type="checkbox" name="auto_approve_comments" value="1"
                                {{ setting('auto_approve_comments') ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </div>
                    </div>

                    <div class="settings-action-bar">
                        <button type="submit" class="btn primary px-4 py-2">Save Changes</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function switchTab(tabId, element) {
            // Hide all cards
            document.querySelectorAll('.settings-card').forEach(card => {
                card.classList.remove('active');
            });

            // Remove selected state from nav
            document.querySelectorAll('.settings-nav-item').forEach(nav => {
                nav.classList.remove('selected');
            });

            // Show target card
            document.getElementById(tabId).classList.add('active');

            // Highlight clicked nav
            element.classList.add('selected');
        }
    </script>
@endpush
