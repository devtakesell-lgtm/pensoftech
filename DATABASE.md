# DATABASE.md — Pensoftech Database Reference

> **Purpose of this file:** Any AI agent or developer working on this project can read this file and immediately understand the complete database structure without exploring any other files. Keep this file up to date when you add or change tables.

---

## Quick Relationship Map

```
roles
  └── users (role_id)
        ├── leads (assigned_to)
        └── quotes (created_by)

clients
  ├── projects (client_id)
  │     ├── project_service [pivot] → services
  │     └── case_studies (project_id)
  │           └── case_study_metrics (case_study_id)
  └── leads (client_id) [nullable — set after conversion]

leads
  ├── lead_service [pivot] → services
  └── quotes (lead_id)
        └── quote_services (quote_id) → services

blog_categories → blogs → blog_tag [pivot] → blog_tags

pages → seo_metas [morph]
services → seo_metas [morph]
projects → seo_metas [morph]
blogs → seo_metas [morph]
jobs_listings → seo_metas [morph]

job_categories → jobs_listings → job_applications
```

---

## Tables

### `roles`
Defines internal team roles (e.g., Administrator, Sales Manager).

| Column       | Type    | Nullable | Notes                         |
|-------------|---------|----------|-------------------------------|
| id           | bigint  | No       | Primary key                   |
| name         | string  | No       | Human-readable name           |
| slug         | string  | No       | Unique, URL-safe identifier   |
| description  | text    | Yes      | What this role can do         |
| is_active    | boolean | No       | Default `true`                |
| created_at   | timestamp | Yes    |                               |
| updated_at   | timestamp | Yes    |                               |

**Relationships:**
- A Role has many Users.
- A Role belongs to many Permissions (via `permission_role` pivot).

---

### `permissions`
Granular actions a role can perform (e.g., "Edit Leads", "Delete Users").

| Column       | Type    | Nullable | Notes                              |
|-------------|---------|----------|------------------------------------|
| id           | bigint  | No       | Primary key                        |
| name         | string  | No       | Human-readable (e.g., "Edit Leads")|
| slug         | string  | No       | Unique                             |
| module       | string  | Yes      | Groups permissions (e.g., "leads") |
| description  | text    | Yes      |                                    |
| created_at   | timestamp | Yes    |                                    |
| updated_at   | timestamp | Yes    |                                    |

**Relationships:**
- A Permission belongs to many Roles (via `permission_role` pivot).

---

### `permission_role` (pivot)
Links roles to their permissions.

| Column        | Type   | Notes                       |
|--------------|--------|-----------------------------|
| id            | bigint | Primary key                 |
| role_id       | bigint | FK → roles, cascade delete  |
| permission_id | bigint | FK → permissions, cascade   |
| created_at    | timestamp |                          |
| updated_at    | timestamp |                          |

**Unique constraint:** `(role_id, permission_id)` — no duplicate assignments.

---

### `users`
Internal staff accounts for the agency.

| Column            | Type    | Nullable | Notes                                |
|------------------|---------|----------|--------------------------------------|
| id                | bigint  | No       | Primary key                          |
| role_id           | bigint  | Yes      | FK → roles, nullOnDelete             |
| name              | string  | No       |                                      |
| email             | string  | No       | Unique                               |
| phone             | string  | Yes      |                                      |
| avatar            | string  | Yes      | File path                            |
| is_active         | boolean | No       | Default `true`                       |
| email_verified_at | timestamp | Yes   |                                      |
| password          | string  | No       | Hashed                               |
| remember_token    | string  | Yes      |                                      |
| created_at        | timestamp | Yes   |                                      |
| updated_at        | timestamp | Yes   |                                      |
| deleted_at        | timestamp | Yes   | Soft delete                          |

**Relationships:**
- A User belongs to one Role.
- A User has one Client (if the user is a client portal account).
- A User has many Leads (as `assigned_to`).
- A User has many Quotes (as `created_by`).
- A User has many Blogs (as `author_id`).

---

### `currencies`
Currencies used in leads and quotes.

| Column        | Type    | Nullable | Notes                         |
|--------------|---------|----------|-------------------------------|
| id            | bigint  | No       | Primary key                   |
| name          | string  | No       | e.g., "US Dollar"             |
| code          | string  | No       | Unique, e.g., "USD"           |
| symbol        | string  | No       | e.g., "$"                     |
| exchange_rate | decimal(10,4) | No | Relative to USD base         |
| is_default    | boolean | No       | Only one should be true       |
| is_active     | boolean | No       | Default `true`                |
| created_at    | timestamp | Yes    |                               |
| updated_at    | timestamp | Yes    |                               |

**Relationships:**
- A Currency has many Leads.
- A Currency has many Quotes.

---

### `industries`
Industry verticals used to categorize leads and projects.

| Column            | Type    | Nullable | Notes                  |
|------------------|---------|----------|------------------------|
| id                | bigint  | No       | Primary key            |
| name              | string  | No       |                        |
| slug              | string  | No       | Unique                 |
| short_description | string  | Yes      |                        |
| description       | text    | Yes      |                        |
| icon              | string  | Yes      | Icon class or file     |
| image             | string  | Yes      | File path              |
| is_active         | boolean | No       | Default `true`         |
| sort_order        | int     | No       | Default `0`            |
| created_at        | timestamp | Yes    |                        |
| updated_at        | timestamp | Yes    |                        |

**Relationships:**
- An Industry has many Projects.
- An Industry has many Leads.

---

### `service_categories`
Groups services into departments (e.g., "Web Development", "Design").

| Column            | Type    | Nullable | Notes          |
|------------------|---------|----------|----------------|
| id                | bigint  | No       | Primary key    |
| name              | string  | No       |                |
| slug              | string  | No       | Unique         |
| short_description | string  | Yes      |                |
| description       | text    | Yes      |                |
| icon              | string  | Yes      |                |
| image             | string  | Yes      |                |
| sort_order        | int     | No       | Default `0`    |
| is_active         | boolean | No       | Default `true` |
| created_at        | timestamp | Yes    |                |
| updated_at        | timestamp | Yes    |                |

**Relationships:**
- A ServiceCategory has many Services.

> ⚠️ **Business Rule:** You **cannot delete** a ServiceCategory if it still has Services attached (restrictOnDelete). Archive it or move services first.

---

### `services`
The individual services the agency offers.

| Column              | Type    | Nullable | Notes                              |
|--------------------|---------|----------|------------------------------------|
| id                  | bigint  | No       | Primary key                        |
| service_category_id | bigint  | No       | FK → service_categories, **restrict** delete |
| name                | string  | No       |                                    |
| slug                | string  | No       | Unique                             |
| short_description   | string  | Yes      |                                    |
| description         | text    | Yes      |                                    |
| icon                | string  | Yes      |                                    |
| featured_image      | string  | Yes      |                                    |
| banner_image        | string  | Yes      |                                    |
| status              | string  | No       | Default `published` — uses `ContentStatus` enum |
| is_featured         | boolean | No       | Default `false`                    |
| sort_order          | int     | No       | Default `0`                        |
| created_at          | timestamp | Yes    |                                    |
| updated_at          | timestamp | Yes    |                                    |

**Enum:** `ContentStatus` — `draft`, `published`, `archived`

**Relationships:**
- A Service belongs to a ServiceCategory.
- A Service belongs to many Projects (via `project_service` pivot).
- A Service belongs to many Leads (via `lead_service` pivot).
- A Service has a polymorphic SeoMeta (via `seo_metas`).

---

### `clients`
Companies or individuals the agency has worked with.

| Column         | Type    | Nullable | Notes                              |
|---------------|---------|----------|------------------------------------|
| id             | bigint  | No       | Primary key                        |
| user_id        | bigint  | Yes      | FK → users, unique, nullOnDelete — only if client has portal access |
| company_name   | string  | No       |                                    |
| contact_person | string  | Yes      | Primary point of contact name      |
| website        | string  | Yes      |                                    |
| address        | text    | Yes      |                                    |
| city           | string  | Yes      |                                    |
| country        | string  | Yes      |                                    |
| is_active      | boolean | No       | Default `true`                     |
| created_at     | timestamp | Yes    |                                    |
| updated_at     | timestamp | Yes    |                                    |
| deleted_at     | timestamp | Yes    | Soft delete                        |

**Relationships:**
- A Client belongs to one User (optional portal account).
- A Client has many Projects.
- A Client has many Leads.

> **Business Rule:** To get a client's case studies, use: `$client->projects->each->caseStudies`. There is no direct `client_id` on case_studies.

---

### `projects`
Work delivered for a client. The main portfolio entity.

| Column            | Type    | Nullable | Notes                              |
|------------------|---------|----------|------------------------------------|
| id                | bigint  | No       | Primary key                        |
| client_id         | bigint  | **No**   | FK → clients, **restrict** delete. A project must have a client. |
| industry_id       | bigint  | Yes      | FK → industries, nullOnDelete      |
| title             | string  | No       |                                    |
| slug              | string  | No       | Unique                             |
| short_description | string  | Yes      |                                    |
| description       | text    | Yes      |                                    |
| project_url       | string  | Yes      | Live URL of the delivered project  |
| featured_image    | string  | Yes      |                                    |
| start_date        | date    | Yes      |                                    |
| completion_date   | date    | Yes      |                                    |
| status            | string  | No       | Default `ongoing` — uses `ProjectStatus` enum |
| is_featured       | boolean | No       | Default `false`                    |
| sort_order        | int     | No       | Default `0`                        |
| created_at        | timestamp | Yes    |                                    |
| updated_at        | timestamp | Yes    |                                    |
| deleted_at        | timestamp | Yes    | Soft delete                        |

**Enum:** `ProjectStatus` — `upcoming`, `ongoing`, `completed`, `on_hold`

**Relationships:**
- A Project belongs to a Client.
- A Project belongs to an Industry (optional).
- A Project belongs to many Services (via `project_service` pivot).
- A Project has many CaseStudies.
- A Project has a polymorphic SeoMeta.

---

### `project_service` (pivot)
Links projects to the services used to deliver them.

| Column     | Type   | Notes                               |
|-----------|--------|-------------------------------------|
| id         | bigint | Primary key                         |
| project_id | bigint | FK → projects, cascade delete       |
| service_id | bigint | FK → services, cascade delete       |
| created_at | timestamp |                                  |
| updated_at | timestamp |                                  |

**Unique constraint:** `(project_id, service_id)`

---

### `case_studies`
Detailed write-ups of how a project was delivered. Used for the portfolio page.

| Column         | Type      | Nullable | Notes                               |
|---------------|-----------|----------|-------------------------------------|
| id             | bigint    | No       | Primary key                         |
| project_id     | bigint    | No       | FK → projects, cascade delete       |
| title          | string    | No       |                                     |
| slug           | string    | No       | Unique                              |
| challenge      | text      | Yes      | What problem the client had         |
| solution       | text      | Yes      | What the agency did                 |
| result         | text      | Yes      | Measurable outcomes                 |
| content        | longtext  | Yes      | Full rich-text body                 |
| featured_image | string    | Yes      |                                     |
| status         | string    | No       | Default `draft` — uses `ContentStatus` enum |
| published_at   | timestamp | Yes      |                                     |
| created_at     | timestamp | Yes      |                                     |
| updated_at     | timestamp | Yes      |                                     |
| deleted_at     | timestamp | Yes      | Soft delete                         |

**Enum:** `ContentStatus` — `draft`, `published`, `archived`

**Relationships:**
- A CaseStudy belongs to a Project.
- A CaseStudy has many CaseStudyMetrics.
- A CaseStudy has a polymorphic SeoMeta.

> **Business Rule:** There is NO `client_id` on case_studies. To get the client: `$caseStudy->project->client`. This avoids two sources of truth.

---

### `case_study_metrics`
Key performance numbers shown on a case study (e.g., "200% Conversion Increase").

| Column         | Type    | Nullable | Notes                          |
|---------------|---------|----------|--------------------------------|
| id             | bigint  | No       | Primary key                    |
| case_study_id  | bigint  | No       | FK → case_studies, cascade     |
| metric_name    | string  | No       | e.g., "Conversion Rate Increase" |
| metric_value   | string  | No       | e.g., "200"                    |
| metric_suffix  | string  | Yes      | e.g., "%" or "+"               |
| sort_order     | int     | No       | Default `0`                    |
| created_at     | timestamp | Yes    |                                |
| updated_at     | timestamp | Yes    |                                |

**Relationships:**
- A CaseStudyMetric belongs to a CaseStudy.

---

### `leads`
Incoming inquiries. Can exist without a client until converted.

| Column       | Type     | Nullable | Notes                                    |
|-------------|----------|----------|------------------------------------------|
| id           | bigint   | No       | Primary key                              |
| client_id    | bigint   | **Yes**  | FK → clients, nullOnDelete. **Null** until the lead is converted to a client. |
| industry_id  | bigint   | Yes      | FK → industries, nullOnDelete            |
| assigned_to  | bigint   | Yes      | FK → users, nullOnDelete. Sales person.  |
| currency_id  | bigint   | Yes      | FK → currencies, nullOnDelete            |
| lead_source  | string   | Yes      | e.g., "website", "referral", "linkedin"  |
| lead_type    | string   | Yes      | e.g., "new_project", "retainer"          |
| name         | string   | No       | Lead's full name                         |
| company_name | string   | Yes      |                                          |
| email        | string   | Yes      |                                          |
| phone        | string   | Yes      |                                          |
| website      | string   | Yes      |                                          |
| message      | text     | Yes      | Original inquiry message                 |
| budget       | decimal(15,2) | Yes |                                         |
| status       | string   | No       | Default `new` — uses `LeadStatus` enum   |
| utm_source   | string   | Yes      | Marketing attribution                    |
| utm_medium   | string   | Yes      | Marketing attribution                    |
| utm_campaign | string   | Yes      | Marketing attribution                    |
| utm_content  | string   | Yes      | Marketing attribution                    |
| gclid        | string   | Yes      | Google Click ID                          |
| fbclid       | string   | Yes      | Facebook Click ID                        |
| ip_address   | string   | Yes      |                                          |
| created_at   | timestamp | Yes     |                                          |
| updated_at   | timestamp | Yes     |                                          |
| deleted_at   | timestamp | Yes     | Soft delete                              |

**Enum:** `LeadStatus` — `new`, `contacted`, `qualified`, `proposal_sent`, `converted`, `lost`

**Relationships:**
- A Lead belongs to a Client (nullable — set when converted).
- A Lead belongs to an Industry (optional).
- A Lead belongs to a User as `assignee` (via `assigned_to`).
- A Lead belongs to a Currency.
- A Lead belongs to many Services (via `lead_service` pivot).
- A Lead has many Quotes.

> **Business Rule:** A Lead can exist without a Client. When it is converted, set `client_id` to link it to the newly created (or existing) Client record.

---

### `lead_service` (pivot)
Tracks which services a lead is interested in.

| Column     | Type   | Notes                         |
|-----------|--------|-------------------------------|
| id         | bigint | Primary key                   |
| lead_id    | bigint | FK → leads, cascade delete    |
| service_id | bigint | FK → services, cascade delete |
| created_at | timestamp |                            |
| updated_at | timestamp |                            |

**Unique constraint:** `(lead_id, service_id)`

---

### `quotes`
Formal price proposals sent to leads.

| Column      | Type     | Nullable | Notes                               |
|------------|----------|----------|-------------------------------------|
| id          | bigint   | No       | Primary key                         |
| lead_id     | bigint   | No       | FK → leads, cascade delete          |
| currency_id | bigint   | Yes      | FK → currencies, nullOnDelete       |
| quote_number| string   | No       | Unique, e.g., "QT-2024-001"         |
| title       | string   | No       | e.g., "Website Redesign Proposal"   |
| description | text     | Yes      |                                     |
| budget_min  | decimal(15,2) | Yes |                                   |
| budget_max  | decimal(15,2) | Yes |                                   |
| status      | string   | No       | Default `draft` — uses `QuoteStatus` enum |
| valid_until | date     | Yes      |                                     |
| created_by  | bigint   | Yes      | FK → users, nullOnDelete            |
| created_at  | timestamp | Yes     |                                     |
| updated_at  | timestamp | Yes     |                                     |
| deleted_at  | timestamp | Yes     | Soft delete                         |

**Enum:** `QuoteStatus` — `draft`, `sent`, `accepted`, `rejected`, `expired`

**Relationships:**
- A Quote belongs to a Lead.
- A Quote belongs to a Currency.
- A Quote belongs to a User as `creator` (via `created_by`).
- A Quote has many QuoteServices (line items).

---

### `quote_services`
Individual line items inside a quote.

| Column      | Type     | Nullable | Notes                               |
|------------|----------|----------|-------------------------------------|
| id          | bigint   | No       | Primary key                         |
| quote_id    | bigint   | No       | FK → quotes, cascade delete         |
| service_id  | bigint   | **No**   | FK → services, **restrict** delete. A line item must have a service. |
| quantity    | int      | No       | Default `1`                         |
| unit_price  | decimal(15,2) | No |                                    |
| total_price | decimal(15,2) | No | Always = quantity × unit_price     |
| description | text     | Yes      | Custom note for this line item      |
| created_at  | timestamp | Yes     |                                     |
| updated_at  | timestamp | Yes     |                                     |

**Relationships:**
- A QuoteService belongs to a Quote.
- A QuoteService belongs to a Service.

> **Business Rule:** `service_id` is **not nullable**. You cannot have a quote line item without knowing which service was sold.

---

### `blog_categories`
Groups blog posts by topic.

| Column      | Type    | Nullable | Notes          |
|------------|---------|----------|----------------|
| id          | bigint  | No       | Primary key    |
| name        | string  | No       |                |
| slug        | string  | No       | Unique         |
| description | text    | Yes      |                |
| is_active   | boolean | No       | Default `true` |
| created_at  | timestamp | Yes    |                |
| updated_at  | timestamp | Yes    |                |

**Relationships:**
- A BlogCategory has many Blogs.

---

### `blog_tags`
Keywords used to tag blog posts (many-to-many).

| Column     | Type   | Nullable | Notes   |
|-----------|--------|----------|---------|
| id         | bigint | No       | Primary key |
| name       | string | No       |         |
| slug       | string | No       | Unique  |
| created_at | timestamp | Yes   |         |
| updated_at | timestamp | Yes   |         |

**Relationships:**
- A BlogTag belongs to many Blogs (via `blog_tag` pivot).

---

### `blogs`
Blog posts published on the agency website.

| Column           | Type      | Nullable | Notes                               |
|-----------------|-----------|----------|-------------------------------------|
| id               | bigint    | No       | Primary key                         |
| blog_category_id | bigint    | Yes      | FK → blog_categories, nullOnDelete  |
| author_id        | bigint    | Yes      | FK → users, nullOnDelete            |
| title            | string    | No       |                                     |
| slug             | string    | No       | Unique                              |
| excerpt          | text      | Yes      | Short summary for cards/meta        |
| content          | longtext  | No       | Full rich-text body                 |
| featured_image   | string    | Yes      |                                     |
| status           | string    | No       | Default `draft` — uses `ContentStatus` enum |
| published_at     | timestamp | Yes      |                                     |
| reading_time     | int       | Yes      | In minutes                          |
| views            | bigint    | No       | Default `0`                         |
| created_at       | timestamp | Yes      |                                     |
| updated_at       | timestamp | Yes      |                                     |
| deleted_at       | timestamp | Yes      | Soft delete                         |

**Enum:** `ContentStatus` — `draft`, `published`, `archived`

**Relationships:**
- A Blog belongs to a BlogCategory.
- A Blog belongs to a User as `author`.
- A Blog belongs to many BlogTags (via `blog_tag` pivot).
- A Blog has a polymorphic SeoMeta.

---

### `blog_tag` (pivot)
Links blog posts to their tags.

| Column    | Type   | Notes                          |
|----------|--------|--------------------------------|
| id        | bigint | Primary key                    |
| blog_id   | bigint | FK → blogs, cascade delete     |
| tag_id    | bigint | FK → blog_tags, cascade delete |

**Unique constraint:** `(blog_id, tag_id)`

---

### `pages`
Static CMS pages (About, Services, Contact, etc.).

| Column         | Type    | Nullable | Notes                               |
|---------------|---------|----------|-------------------------------------|
| id             | bigint  | No       | Primary key                         |
| title          | string  | No       |                                     |
| slug           | string  | No       | Unique                              |
| subtitle       | string  | Yes      |                                     |
| content        | longtext| Yes      | Rich-text body                      |
| featured_image | string  | Yes      |                                     |
| template       | string  | No       | Default `default`. Maps to a Blade view (e.g., `about`, `contact`) |
| status         | string  | No       | Default `published` — uses `ContentStatus` enum |
| sort_order     | int     | No       | Default `0`                         |
| created_at     | timestamp | Yes    |                                     |
| updated_at     | timestamp | Yes    |                                     |

**Relationships:**
- A Page has a polymorphic SeoMeta.

---

### `seo_metas`
SEO metadata for any content model. Uses Laravel's polymorphic relationship.

| Column           | Type   | Nullable | Notes                                    |
|-----------------|--------|----------|------------------------------------------|
| id               | bigint | No       | Primary key                              |
| seoable_id       | bigint | No       | ID of the parent model                   |
| seoable_type     | string | No       | Class name of the parent model           |
| meta_title       | string | Yes      |                                          |
| meta_description | string | Yes      | Keep under 160 characters                |
| meta_keywords    | string | Yes      |                                          |
| canonical_url    | string | Yes      |                                          |
| robots           | string | No       | Default `index, follow`                  |
| og_title         | string | Yes      | Open Graph title for social sharing      |
| og_description   | string | Yes      |                                          |
| og_image         | string | Yes      |                                          |
| schema_json      | json   | Yes      | Structured data for Google              |
| created_at       | timestamp | Yes   |                                          |
| updated_at       | timestamp | Yes   |                                          |

**Models that have SEO meta:** Project, Service, Blog, Page, Job

**How to use:** `$project->seo->meta_title`
**How to create:** `$project->seo()->create([...])`

---

### `job_categories`
Groups job listings by department.

| Column     | Type   | Nullable | Notes   |
|-----------|--------|----------|---------|
| id         | bigint | No       | Primary key |
| name       | string | No       |         |
| slug       | string | No       | Unique  |
| created_at | timestamp | Yes   |         |
| updated_at | timestamp | Yes   |         |

**Relationships:**
- A JobCategory has many Jobs.

---

### `jobs_listings`
Open positions posted on the agency's careers page.

| Column          | Type    | Nullable | Notes                                |
|----------------|---------|----------|--------------------------------------|
| id              | bigint  | No       | Primary key                          |
| job_category_id | bigint  | Yes      | FK → job_categories, nullOnDelete    |
| title           | string  | No       |                                      |
| slug            | string  | No       | Unique                               |
| employment_type | string  | Yes      | Uses `EmploymentType` enum           |
| location        | string  | Yes      | e.g., "Dhaka, Bangladesh" or "Remote"|
| experience      | string  | Yes      | e.g., "2-3 years"                    |
| vacancy         | int     | No       | Default `1`                          |
| description     | text    | No       |                                      |
| requirements    | text    | Yes      |                                      |
| benefits        | text    | Yes      |                                      |
| deadline        | date    | Yes      |                                      |
| status          | string  | No       | Default `draft` — uses `JobStatus` enum |
| created_at      | timestamp | Yes    |                                      |
| updated_at      | timestamp | Yes    |                                      |
| deleted_at      | timestamp | Yes    | Soft delete                          |

**Enums:**
- `JobStatus` — `draft`, `open`, `closed`
- `EmploymentType` — `full_time`, `part_time`, `contract`, `internship`, `remote`, `hybrid`

> ⚠️ Note: The database table name is `jobs_listings` (not `jobs`) because `jobs` is reserved by Laravel's queue system.

**Relationships:**
- A Job belongs to a JobCategory.
- A Job has many JobApplications.
- A Job has a polymorphic SeoMeta.

---

### `job_applications`
Applications submitted by candidates for a job listing.

| Column        | Type   | Nullable | Notes                            |
|--------------|--------|----------|----------------------------------|
| id            | bigint | No       | Primary key                      |
| job_id        | bigint | No       | FK → jobs_listings, cascade delete |
| name          | string | No       |                                  |
| email         | string | No       |                                  |
| phone         | string | Yes      |                                  |
| address       | text   | Yes      |                                  |
| cv_file       | string | No       | File path to uploaded CV/resume  |
| cover_letter  | text   | Yes      |                                  |
| linkedin_url  | string | Yes      |                                  |
| portfolio_url | string | Yes      |                                  |
| github_url    | string | Yes      |                                  |
| status        | string | No       | Default `applied` — uses `JobApplicationStatus` enum |
| notes         | text   | Yes      | Internal HR notes                |
| created_at    | timestamp | Yes   |                                  |
| updated_at    | timestamp | Yes   |                                  |

**Enum:** `JobApplicationStatus` — `applied`, `shortlisted`, `interviewed`, `offered`, `hired`, `rejected`

**Relationships:**
- A JobApplication belongs to a Job.

---

## Enum Reference

| Enum Class              | Used On              | Values                                                      |
|------------------------|----------------------|-------------------------------------------------------------|
| `LeadStatus`           | leads.status         | `new`, `contacted`, `qualified`, `proposal_sent`, `converted`, `lost` |
| `ProjectStatus`        | projects.status      | `upcoming`, `ongoing`, `completed`, `on_hold`               |
| `QuoteStatus`          | quotes.status        | `draft`, `sent`, `accepted`, `rejected`, `expired`          |
| `ContentStatus`        | services, blogs, case_studies, pages | `draft`, `published`, `archived`       |
| `JobStatus`            | jobs_listings.status | `draft`, `open`, `closed`                                   |
| `JobApplicationStatus` | job_applications.status | `applied`, `shortlisted`, `interviewed`, `offered`, `hired`, `rejected` |
| `EmploymentType`       | jobs_listings.employment_type | `full_time`, `part_time`, `contract`, `internship`, `remote`, `hybrid` |

---

## Key Business Rules

1. **A Lead can exist without a Client.** `leads.client_id` is nullable. When a lead is converted, set `client_id` to link it to the new or existing Client record.

2. **A Project must always have a Client.** `projects.client_id` is NOT nullable. You cannot create a project without assigning a client first.

3. **Case studies have no direct client_id.** Access the client through the project: `$caseStudy->project->client`. This avoids two sources of truth.

4. **You cannot delete a ServiceCategory that has Services.** The FK uses `restrictOnDelete`. Archive the category or reassign/delete its services first.

5. **You cannot delete a Service that is referenced in a QuoteService line item.** The FK uses `restrictOnDelete`. Archive the service instead of deleting it.

6. **The `jobs` table is named `jobs_listings`.** Laravel uses a `jobs` table internally for its queue system. The `Job` model sets `protected $table = 'jobs_listings'`.

7. **All major content tables use soft deletes.** This includes `users`, `clients`, `projects`, `case_studies`, `leads`, `quotes`, `blogs`, and `jobs_listings`. Records are never permanently deleted by default.

8. **SEO meta is polymorphic.** One `seo_metas` table serves Projects, Services, Blogs, Pages, and Jobs through Laravel's `morphOne`/`morphTo` relationship.
