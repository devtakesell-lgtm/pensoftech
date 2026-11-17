<?php

use App\Enums\ProjectStatus;
use App\Models\Client;
use App\Models\Industry;
use App\Models\Project;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
});

test('unauthenticated guests are redirected to admin login when accessing projects', function () {
    $response = $this->get(route('admin.projects.index'));
    $response->assertRedirect(route('admin.login'));
});

test('user without view-projects permission cannot view projects index', function () {
    $role = Role::create(['name' => 'limited-staff', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin']); // no view-projects

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $response = $this->actingAs($user)->get(route('admin.projects.index'));
    $response->assertStatus(403);
});

test('user with view-projects permission can view projects index', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $client = Client::factory()->create();
    $industry = Industry::factory()->create();
    $project = Project::factory()->create([
        'title' => 'Alpha Software Suite',
        'status' => ProjectStatus::Ongoing,
        'client_id' => $client->id,
        'industry_id' => $industry->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.projects.index'));
    $response->assertStatus(200);
    $response->assertSee('Alpha Software Suite');
});

test('user without create-projects permission cannot access create form or store project', function () {
    $role = Role::create(['name' => 'project-reader', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin', 'view-projects']);

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $this->actingAs($user)->get(route('admin.projects.create'))->assertStatus(403);

    $this->actingAs($user)->post(route('admin.projects.store'), [
        'title' => 'Unauthorized Project',
    ])->assertStatus(403);
});

test('user with create-projects permission can create and store project', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $client = Client::factory()->create();
    $industry = Industry::factory()->create();
    $service = Service::factory()->create();

    Storage::fake('public');
    $file = UploadedFile::fake()->image('project.jpg');

    $this->actingAs($admin)->get(route('admin.projects.create'))->assertStatus(200);

    $response = $this->actingAs($admin)->post(route('admin.projects.store'), [
        'title' => 'Beta Software Suite',
        'short_description' => 'A new beta software.',
        'description' => 'Detailed description of beta software.',
        'status' => 'upcoming',
        'client_id' => $client->id,
        'industry_id' => $industry->id,
        'services' => [$service->id],
        'featured_image' => $file,
    ]);

    $project = Project::where('title', 'Beta Software Suite')->first();

    $response->assertRedirect(route('admin.projects.show', $project));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('projects', [
        'title' => 'Beta Software Suite',
        'slug' => 'beta-software-suite',
        'status' => 'upcoming',
        'client_id' => $client->id,
    ]);

    expect($project->services)->toHaveCount(1);
    expect($project->services->first()->id)->toBe($service->id);

    // Verify file was stored
    Storage::disk('public')->assertExists($project->featured_image);
});

test('user with view-projects permission can view project dossier show page', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $client = Client::factory()->create();
    $industry = Industry::factory()->create();
    $project = Project::factory()->create([
        'title' => 'Gamma App Rebuild',
        'short_description' => 'Complete rebuild of legacy app',
        'status' => ProjectStatus::Completed,
        'client_id' => $client->id,
        'industry_id' => $industry->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.projects.show', $project));
    $response->assertStatus(200);
    $response->assertSee('Gamma App Rebuild');
    $response->assertSee('Complete rebuild of legacy app');
});

test('user with edit-projects permission can update project', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $client = Client::factory()->create();
    $industry = Industry::factory()->create();
    $project = Project::factory()->create([
        'title' => 'Original Title',
        'slug' => 'original-title',
        'client_id' => $client->id,
        'industry_id' => $industry->id,
    ]);

    $this->actingAs($admin)->get(route('admin.projects.edit', $project))->assertStatus(200);

    $response = $this->actingAs($admin)->put(route('admin.projects.update', $project), [
        'title' => 'Updated Title',
        'short_description' => 'Updated short desc',
        'description' => 'Updated full desc',
        'status' => 'ongoing',
        'client_id' => $client->id,
        'industry_id' => $industry->id,
    ]);

    $response->assertRedirect(route('admin.projects.show', $project));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => 'Updated Title',
        'slug' => 'updated-title', // verified slug updated
        'status' => 'ongoing',
    ]);
});

test('user with delete-projects permission can soft delete project', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $client = Client::factory()->create();
    $industry = Industry::factory()->create();
    $project = Project::factory()->create([
        'title' => 'Project to Delete',
        'client_id' => $client->id,
        'industry_id' => $industry->id,
    ]);

    $response = $this->actingAs($admin)->delete(route('admin.projects.destroy', $project));
    $response->assertRedirect(route('admin.projects.index'));
    $response->assertSessionHas('success');

    $this->assertSoftDeleted('projects', ['id' => $project->id]);
});
