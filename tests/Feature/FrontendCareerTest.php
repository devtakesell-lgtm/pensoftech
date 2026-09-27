<?php

use App\Enums\EmploymentType;
use App\Enums\JobApplicationStatus;
use App\Enums\JobStatus;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobCategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('careers hub returns successful response and renders open positions', function () {
    $category = JobCategory::factory()->create([
        'name' => 'Core Systems Engineering',
    ]);

    $openJob = Job::factory()->create([
        'title' => 'Staff Distributed Systems Engineer',
        'job_category_id' => $category->id,
        'status' => JobStatus::Open,
        'employment_type' => EmploymentType::Remote,
        'location' => 'Worldwide (Remote)',
    ]);

    $draftJob = Job::factory()->create([
        'title' => 'Secret Stealth Engineer',
        'status' => JobStatus::Draft,
    ]);

    $response = $this->get(route('careers.index'));

    $response->assertStatus(200);
    $response->assertSee('Staff Distributed Systems Engineer');
    $response->assertSee('Core Systems Engineering');
    $response->assertSee('Full-Access Professional Gym Membership');
    $response->assertDontSee('Secret Stealth Engineer');
});

test('careers hub filters by category slug', function () {
    $catEngineering = JobCategory::factory()->create(['name' => 'Engineering', 'slug' => 'engineering']);
    $catDesign = JobCategory::factory()->create(['name' => 'Product Design', 'slug' => 'product-design']);

    $job1 = Job::factory()->create([
        'title' => 'Senior Backend Engineer',
        'job_category_id' => $catEngineering->id,
        'status' => JobStatus::Open,
    ]);

    $job2 = Job::factory()->create([
        'title' => 'Principal Product Designer',
        'job_category_id' => $catDesign->id,
        'status' => JobStatus::Open,
    ]);

    $response = $this->get(route('careers.index', ['category' => 'engineering']));

    $response->assertStatus(200);
    $response->assertSee('Senior Backend Engineer');
    $response->assertDontSee('Principal Product Designer');
});

test('careers hub filters by employment type', function () {
    $jobRemote = Job::factory()->create([
        'title' => 'Cloud Platform Architect',
        'status' => JobStatus::Open,
        'employment_type' => EmploymentType::Remote,
    ]);

    $jobContract = Job::factory()->create([
        'title' => 'Security Audit Consultant',
        'status' => JobStatus::Open,
        'employment_type' => EmploymentType::Contract,
    ]);

    $response = $this->get(route('careers.index', ['type' => EmploymentType::Remote->value]));

    $response->assertStatus(200);
    $response->assertSee('Cloud Platform Architect');
    $response->assertDontSee('Security Audit Consultant');
});

test('single job page returns successful response for open job', function () {
    $category = JobCategory::factory()->create(['name' => 'Infrastructure']);

    $job = Job::factory()->create([
        'title' => 'Lead Site Reliability Engineer',
        'job_category_id' => $category->id,
        'status' => JobStatus::Open,
        'description' => 'Architect and maintain high-throughput Kubernetes clusters.',
        'requirements' => 'Expertise in Go, Kubernetes, and Terraform.',
        'benefits' => 'Competitive base + equity + pro gym VIP pass.',
    ]);

    $response = $this->get(route('careers.show', $job->slug));

    $response->assertStatus(200);
    $response->assertSee('Lead Site Reliability Engineer');
    $response->assertSee('Architect and maintain high-throughput Kubernetes clusters');
    $response->assertSee('Expertise in Go, Kubernetes, and Terraform');
    $response->assertSee('Apply for this Role');
});

test('single job page returns 404 for draft or closed jobs', function () {
    $draftJob = Job::factory()->create([
        'title' => 'Unpublished Developer',
        'status' => JobStatus::Draft,
    ]);

    $closedJob = Job::factory()->create([
        'title' => 'Old Expired Role',
        'status' => JobStatus::Closed,
    ]);

    $this->get(route('careers.show', $draftJob->slug))->assertStatus(404);
    $this->get(route('careers.show', $closedJob->slug))->assertStatus(404);
});

test('candidate application fails validation when required fields are missing', function () {
    $job = Job::factory()->create(['status' => JobStatus::Open]);

    $response = $this->from(route('careers.show', $job->slug))
        ->post(route('careers.apply', $job->slug), [
            'name' => '',
            'email' => 'invalid-email',
        ]);

    $response->assertRedirect(route('careers.show', $job->slug));
    $response->assertSessionHasErrors(['name', 'email', 'cv_file']);
    expect(JobApplication::count())->toBe(0);
});

test('candidate can submit application with cv file upload successfully', function () {
    Storage::fake('public');

    $job = Job::factory()->create([
        'title' => 'Senior Frontend Engineer',
        'status' => JobStatus::Open,
    ]);

    $file = UploadedFile::fake()->create('curriculum_vitae.pdf', 1024, 'application/pdf');

    $response = $this->from(route('careers.show', $job->slug))
        ->post(route('careers.apply', $job->slug), [
            'name' => 'Jordan Peterson',
            'email' => 'jordan@example.com',
            'phone' => '+1 415-555-2671',
            'address' => 'Austin, TX',
            'cv_file' => $file,
            'cover_letter' => 'Excited to contribute to PenSoftTech architectural initiatives.',
            'linkedin_url' => 'https://linkedin.com/in/jordanp',
            'github_url' => 'https://github.com/jordanp',
        ]);

    $response->assertRedirect(route('careers.show', $job->slug));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('job_applications', [
        'job_id' => $job->id,
        'name' => 'Jordan Peterson',
        'email' => 'jordan@example.com',
        'phone' => '+1 415-555-2671',
        'status' => JobApplicationStatus::Applied->value,
    ]);

    $application = JobApplication::where('email', 'jordan@example.com')->first();
    expect($application)->not->toBeNull();
    expect($application->cv_file)->not->toBeNull();
    Storage::disk('public')->assertExists($application->cv_file);
});

test('candidate cannot apply to a closed or draft job', function () {
    $closedJob = Job::factory()->create(['status' => JobStatus::Closed]);

    $file = UploadedFile::fake()->create('resume.pdf', 500, 'application/pdf');

    $response = $this->post(route('careers.apply', $closedJob->slug), [
        'name' => 'Sarah Connor',
        'email' => 'sarah@example.com',
        'cv_file' => $file,
    ]);

    $response->assertStatus(404);
    $this->assertDatabaseMissing('job_applications', [
        'email' => 'sarah@example.com',
    ]);
});

test('single job page renders clean title and seo meta tags', function () {
    $job = Job::factory()->create([
        'title' => 'Senior Laravel Architect',
        'status' => JobStatus::Open,
        'description' => 'Build resilient enterprise architectures.',
    ]);

    $job->seo()->create([
        'meta_title' => 'Top Senior Laravel Architect Role in Tech',
        'meta_description' => 'Custom SEO Meta description for Laravel role.',
        'meta_keywords' => 'laravel, php, architecture',
        'canonical_url' => 'https://pensoftech.com/careers/senior-laravel-architect',
    ]);

    $response = $this->get(route('careers.show', $job->slug));

    $response->assertStatus(200);
    $response->assertSee('<title>Senior Laravel Architect — Careers at PenSoftTech</title>', false);
    $response->assertSee('content="Top Senior Laravel Architect Role in Tech"', false);
    $response->assertSee('content="Custom SEO Meta description for Laravel role."', false);
    $response->assertSee('content="laravel, php, architecture"', false);
    $response->assertSee('href="https://pensoftech.com/careers/senior-laravel-architect"', false);
});
