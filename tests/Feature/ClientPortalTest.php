<?php

use App\Enums\ContentStatus;
use App\Enums\ProjectStatus;
use App\Models\Client;
use App\Models\Project;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;

test('unauthenticated guests are redirected to login when visiting client portal', function () {
    $response = $this->get(route('client.dashboard'));

    $response->assertRedirect(route('login'));
});

test('authenticated client can view client dashboard and stats', function () {
    $clientRole = Role::firstOrCreate(['slug' => 'client'], ['name' => 'Client', 'is_active' => true]);
    $user = User::factory()->create(['role_id' => $clientRole->id]);
    $client = Client::create([
        'user_id' => $user->id,
        'company_name' => 'Acme Corp',
        'contact_person' => $user->name,
        'is_active' => true,
    ]);

    Project::create([
        'client_id' => $client->id,
        'title' => 'Sample Web App',
        'slug' => 'sample-web-app',
        'status' => ProjectStatus::Ongoing,
    ]);

    $response = $this->actingAs($user)->get(route('client.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Sample Web App');
    $response->assertSee('Welcome back');
});

test('authenticated client can view their projects list and individual project details', function () {
    $clientRole = Role::firstOrCreate(['slug' => 'client'], ['name' => 'Client', 'is_active' => true]);
    $user = User::factory()->create(['role_id' => $clientRole->id]);
    $client = Client::create([
        'user_id' => $user->id,
        'company_name' => 'Acme Corp',
        'contact_person' => $user->name,
        'is_active' => true,
    ]);

    $project = Project::create([
        'client_id' => $client->id,
        'title' => 'Acme Mobile App',
        'slug' => 'acme-mobile-app',
        'status' => ProjectStatus::Completed,
        'short_description' => 'A cross platform mobile application.',
    ]);

    // Test listing
    $listResponse = $this->actingAs($user)->get(route('client.projects.index'));
    $listResponse->assertStatus(200);
    $listResponse->assertSee('Acme Mobile App');

    // Test detail view
    $showResponse = $this->actingAs($user)->get(route('client.projects.show', $project));
    $showResponse->assertStatus(200);
    $showResponse->assertSee('Acme Mobile App');
    $showResponse->assertSee('A cross platform mobile application.');
});

test('client cannot view another clients project details', function () {
    $clientRole = Role::firstOrCreate(['slug' => 'client'], ['name' => 'Client', 'is_active' => true]);
    $userOne = User::factory()->create(['role_id' => $clientRole->id]);
    $clientOne = Client::create([
        'user_id' => $userOne->id,
        'company_name' => 'Client One Corp',
        'contact_person' => $userOne->name,
        'is_active' => true,
    ]);

    $userTwo = User::factory()->create(['role_id' => $clientRole->id]);
    $clientTwo = Client::create([
        'user_id' => $userTwo->id,
        'company_name' => 'Client Two Corp',
        'contact_person' => $userTwo->name,
        'is_active' => true,
    ]);

    $projectOfTwo = Project::create([
        'client_id' => $clientTwo->id,
        'title' => 'Secret Project Two',
        'slug' => 'secret-project-two',
        'status' => ProjectStatus::Ongoing,
    ]);

    // User One tries to view User Two's project
    $response = $this->actingAs($userOne)->get(route('client.projects.show', $projectOfTwo));

    $response->assertStatus(403);
});

test('client can view inquiries list and submit a new service request', function () {
    $clientRole = Role::firstOrCreate(['slug' => 'client'], ['name' => 'Client', 'is_active' => true]);
    $user = User::factory()->create(['role_id' => $clientRole->id]);
    $client = Client::create([
        'user_id' => $user->id,
        'company_name' => 'Innovate Tech',
        'contact_person' => $user->name,
        'is_active' => true,
    ]);

    $service = Service::factory()->create([
        'name' => 'Custom Cloud Infrastructure',
        'status' => ContentStatus::Published,
    ]);

    // View create page
    $createResponse = $this->actingAs($user)->get(route('client.leads.create'));
    $createResponse->assertStatus(200);
    $createResponse->assertSee('Custom Cloud Infrastructure');

    // Submit inquiry
    $postResponse = $this->actingAs($user)->post(route('client.leads.store'), [
        'project_title' => 'AWS Migration Project',
        'service_ids' => [$service->id],
        'budget' => 8500,
        'message' => 'We need help migrating our legacy infrastructure to AWS ECS and RDS.',
    ]);

    $postResponse->assertRedirect(route('client.leads.index'));
    $postResponse->assertSessionHas('success');

    $this->assertDatabaseHas('leads', [
        'client_id' => $client->id,
        'email' => $user->email,
        'budget' => 8500,
    ]);

    // View inquiries list
    $indexResponse = $this->actingAs($user)->get(route('client.leads.index'));
    $indexResponse->assertStatus(200);
    $indexResponse->assertSee('AWS Migration Project');
});
