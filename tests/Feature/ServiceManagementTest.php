<?php

use App\Enums\ContentStatus;
use App\Models\Client;
use App\Models\Industry;
use App\Models\Project;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
    Storage::fake('public');
});

test('unauthenticated guests are redirected to admin login when accessing services', function () {
    $response = $this->get(route('admin.services'));
    $response->assertRedirect(route('admin.login'));
});

test('user without view-services permission cannot view services index', function () {
    $role = Role::create(['name' => 'limited-staff', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin']); // no view-services

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $response = $this->actingAs($user)->get(route('admin.services'));
    $response->assertStatus(403);
});

test('user with view-services permission can view services list and filter by search', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $category = ServiceCategory::factory()->create(['name' => 'Engineering']);
    $service = Service::factory()->create([
        'service_category_id' => $category->id,
        'name' => 'Unique Mobile App Dev',
        'status' => ContentStatus::Published,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.services'));
    $response->assertStatus(200);
    $response->assertSee('Services Management');
    $response->assertSee('Unique Mobile App Dev');

    // Test Search filter
    $searchResponse = $this->actingAs($admin)->get(route('admin.services', ['search' => 'Unique Mobile']));
    $searchResponse->assertStatus(200);
    $searchResponse->assertSee('Unique Mobile App Dev');

    $emptySearchResponse = $this->actingAs($admin)->get(route('admin.services', ['search' => 'NonExistentServiceXYZ']));
    $emptySearchResponse->assertStatus(200);
    $emptySearchResponse->assertDontSee('Unique Mobile App Dev');
});

test('user without create-services permission cannot access create form or store service', function () {
    $role = Role::create(['name' => 'reader', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin', 'view-services']);

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $this->actingAs($user)->get(route('admin.services.create'))->assertStatus(403);

    $category = ServiceCategory::factory()->create();

    $this->actingAs($user)->post(route('admin.services.store'), [
        'name' => 'Unauthorized Service',
        'service_category_id' => $category->id,
        'status' => 'published',
    ])->assertStatus(403);
});

test('user with create-services permission can store service with image uploads', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $category = ServiceCategory::factory()->create(['name' => 'Cloud Computing']);

    $featuredImage = UploadedFile::fake()->image('thumb.jpg', 600, 600);
    $bannerImage = UploadedFile::fake()->image('banner.jpg', 1200, 630);

    $response = $this->actingAs($admin)->post(route('admin.services.store'), [
        'name' => 'DevOps Automation',
        'slug' => 'devops-automation',
        'service_category_id' => $category->id,
        'short_description' => 'CI/CD pipeline setup and cloud deployments.',
        'description' => 'Detailed DevOps service description.',
        'icon' => 'bi-cloud-arrow-up',
        'featured_image' => $featuredImage,
        'banner_image' => $bannerImage,
        'status' => 'published',
        'is_featured' => 1,
        'sort_order' => 5,
    ]);

    $response->assertRedirect(route('admin.services'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('services', [
        'name' => 'DevOps Automation',
        'slug' => 'devops-automation',
        'service_category_id' => $category->id,
        'icon' => 'bi-cloud-arrow-up',
        'status' => 'published',
        'is_featured' => true,
        'sort_order' => 5,
    ]);

    $service = Service::where('slug', 'devops-automation')->first();
    expect($service->featured_image)->not->toBeNull();
    Storage::disk('public')->assertExists($service->featured_image);
    Storage::disk('public')->assertExists($service->banner_image);
});

test('user without edit-services permission cannot view edit form or update service', function () {
    $role = Role::create(['name' => 'creator', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin', 'view-services', 'create-services']);

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $service = Service::factory()->create();

    $this->actingAs($user)->get(route('admin.services.edit', $service))->assertStatus(403);

    $this->actingAs($user)->put(route('admin.services.update', $service), [
        'name' => 'Hacked Name',
        'slug' => $service->slug,
        'service_category_id' => $service->service_category_id,
        'status' => 'published',
    ])->assertStatus(403);
});

test('user with edit-services permission can update service and replace media', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $category = ServiceCategory::factory()->create();
    $service = Service::factory()->create([
        'service_category_id' => $category->id,
        'name' => 'Old Service Name',
        'slug' => 'old-service-name',
        'status' => ContentStatus::Draft,
    ]);

    $newFeaturedImage = UploadedFile::fake()->image('new-thumb.png', 500, 500);

    $response = $this->actingAs($admin)->put(route('admin.services.update', $service), [
        'name' => 'Updated Service Title',
        'slug' => 'updated-service-title',
        'service_category_id' => $category->id,
        'short_description' => 'Updated short summary.',
        'description' => 'Updated long description.',
        'icon' => 'bi-gear-wide-connected',
        'featured_image' => $newFeaturedImage,
        'status' => 'published',
        'is_featured' => 0,
        'sort_order' => 1,
    ]);

    $response->assertRedirect(route('admin.services'));
    $response->assertSessionHas('success');

    $service->refresh();
    expect($service->name)->toBe('Updated Service Title');
    expect($service->slug)->toBe('updated-service-title');
    expect($service->status)->toBe(ContentStatus::Published);
    expect($service->is_featured)->toBeFalse();
    Storage::disk('public')->assertExists($service->featured_image);
});

test('user without delete-services permission cannot delete service', function () {
    $role = Role::create(['name' => 'editor', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin', 'view-services', 'edit-services']);

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $service = Service::factory()->create();

    $this->actingAs($user)->delete(route('admin.services.destroy', $service))->assertStatus(403);
    $this->assertDatabaseHas('services', ['id' => $service->id]);
});

test('service deletion is safeguarded when linked to projects', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $client = Client::factory()->create();
    $industry = Industry::factory()->create();

    $service = Service::factory()->create(['name' => 'Critical Core Service']);
    $project = Project::factory()->create([
        'client_id' => $client->id,
        'industry_id' => $industry->id,
    ]);
    $service->projects()->attach($project);

    $response = $this->actingAs($admin)->delete(route('admin.services.destroy', $service));
    $response->assertRedirect(route('admin.services'));
    $response->assertSessionHas('error');

    $this->assertDatabaseHas('services', ['id' => $service->id]);
});

test('user with delete-services permission can delete unlinked service', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $service = Service::factory()->create([
        'name' => 'Obsolete Temporary Service',
        'featured_image' => 'services/temp.jpg',
    ]);
    Storage::disk('public')->put('services/temp.jpg', 'image-content');

    $response = $this->actingAs($admin)->delete(route('admin.services.destroy', $service));
    $response->assertRedirect(route('admin.services'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('services', ['id' => $service->id]);
    Storage::disk('public')->assertMissing('services/temp.jpg');
});
