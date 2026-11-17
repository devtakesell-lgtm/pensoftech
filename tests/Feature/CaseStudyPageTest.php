<?php

use App\Enums\ContentStatus;
use App\Models\CaseStudy;
use App\Models\CaseStudyMetric;
use App\Models\Client;
use App\Models\Industry;
use App\Models\Project;

beforeEach(function () {
    $this->industry = Industry::factory()->create([
        'name' => 'Fintech',
        'slug' => 'fintech',
        'is_active' => true,
    ]);

    $this->client = Client::factory()->create([
        'company_name' => 'Stripe Partner Corp',
        'is_active' => true,
    ]);

    $this->project = Project::factory()->create([
        'client_id' => $this->client->id,
        'industry_id' => $this->industry->id,
        'title' => 'Global Payment Engine',
        'slug' => 'global-payment-engine',
    ]);

    $this->caseStudy = CaseStudy::factory()->create([
        'project_id' => $this->project->id,
        'title' => 'Scaling Payment Infrastructure to 10M Transactions',
        'slug' => 'scaling-payment-infrastructure-to-10m-transactions',
        'result' => 'Achieved 99.999% uptime with 300% throughput increase.',
        'status' => ContentStatus::Published,
        'published_at' => now(),
    ]);

    $this->metric = CaseStudyMetric::create([
        'case_study_id' => $this->caseStudy->id,
        'metric_name' => 'Conversion Increase',
        'metric_value' => '300',
        'metric_suffix' => '%',
        'sort_order' => 1,
    ]);
});

test('case studies index page renders published case studies', function () {
    $response = $this->get(route('case-studies.index'));

    $response->assertOk()
        ->assertSee('Transformative Stories')
        ->assertSee('Scaling Payment Infrastructure')
        ->assertSee('Fintech')
        ->assertSee('Stripe Partner Corp')
        ->assertSee('300%')
        ->assertSee('Conversion Increase');
});

test('case studies index page filters by industry', function () {
    $otherIndustry = Industry::factory()->create([
        'name' => 'Healthcare',
        'slug' => 'healthcare',
        'is_active' => true,
    ]);

    $otherProject = Project::factory()->create([
        'client_id' => $this->client->id,
        'industry_id' => $otherIndustry->id,
    ]);

    $otherCaseStudy = CaseStudy::factory()->create([
        'project_id' => $otherProject->id,
        'title' => 'Healthcare EHR Modernization',
        'slug' => 'healthcare-ehr-modernization',
        'status' => ContentStatus::Published,
        'published_at' => now(),
    ]);

    $response = $this->get(route('case-studies.index', ['industry' => 'fintech']));

    $response->assertOk()
        ->assertSee('Scaling Payment Infrastructure')
        ->assertDontSee('Healthcare EHR Modernization');
});

test('case study show page renders detail narrative and metrics', function () {
    $response = $this->get(route('case-studies.show', $this->caseStudy->slug));

    $response->assertOk()
        ->assertSee($this->caseStudy->title)
        ->assertSee('Achieved 99.999% uptime')
        ->assertSee('300%')
        ->assertSee('Conversion Increase')
        ->assertSee('Stripe Partner Corp');
});

test('draft case study returns 404', function () {
    $draft = CaseStudy::factory()->create([
        'project_id' => $this->project->id,
        'status' => ContentStatus::Draft,
        'slug' => 'draft-case-study-unreleased',
    ]);

    $response = $this->get(route('case-studies.show', $draft->slug));

    $response->assertNotFound();
});

test('home page renders database case studies', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('Client Success Stories')
        ->assertSee($this->caseStudy->title)
        ->assertSee('300%')
        ->assertSee('Fintech');
});
