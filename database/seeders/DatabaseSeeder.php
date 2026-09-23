<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * ORDER MATTERS: each seeder depends on the ones above it being done first.
     * For example, UserSeeder needs RoleSeeder to have already created roles,
     * and LeadSeeder needs Currency, Industry, and User records to exist.
     */
    public function run(): void
    {
        // ── Step 1: Reference / lookup tables (no foreign keys) ─────────────
        $this->call(PermissionSeeder::class);  // permissions (must exist before role matrix sync)
        $this->call(RoleSeeder::class);        // roles and permission matrix mapping
        $this->call(CurrencySeeder::class);    // currencies (needed by leads, quotes)
        $this->call(IndustrySeeder::class);    // industries (needed by leads, projects)

        // ── Step 2: Users (needs roles) ──────────────────────────────────────
        $this->call(UserSeeder::class);

        // ── Step 3: Services (needs service categories) ───────────────────────
        $this->call(ServiceCategorySeeder::class);
        $this->call(ServiceSeeder::class);

        // ── Step 4: Clients ───────────────────────────────────────────────────
        $this->call(ClientSeeder::class);

        // ── Step 5: Projects (needs clients, industries, services) ────────────
        $this->call(ProjectSeeder::class);    // also seeds project_service pivot

        // ── Step 6: Case Studies (needs projects) ─────────────────────────────
        $this->call(CaseStudySeeder::class);
        $this->call(CaseStudyMetricSeeder::class);

        // ── Step 7: Leads (needs industries, currencies, users, services) ─────
        $this->call(LeadSeeder::class);       // also seeds lead_service pivot

        // ── Step 8: Quotes (needs leads, currencies, users) ───────────────────
        $this->call(QuoteSeeder::class);
        $this->call(QuoteServiceSeeder::class);

        // ── Step 9: Blog content ──────────────────────────────────────────────
        $this->call(BlogCategorySeeder::class);
        $this->call(BlogTagSeeder::class);
        $this->call(BlogSeeder::class);       // also seeds blog_tag pivot

        // ── Step 10: Static pages ─────────────────────────────────────────────
        $this->call(PageSeeder::class);

        // ── Step 11: SEO meta (needs projects, services, blogs, pages) ────────
        $this->call(SeoMetaSeeder::class);

        // ── Step 12: Careers ──────────────────────────────────────────────────
        $this->call(JobCategorySeeder::class);
        $this->call(JobSeeder::class);
        $this->call(JobApplicationSeeder::class);

        // ── Step 13: Settings ─────────────────────────────────────────────────
        $this->call(SettingSeeder::class);
    }
}
