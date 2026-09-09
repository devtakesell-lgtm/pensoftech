<?php

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

test('unauthenticated guests are redirected to admin login when accessing service categories', function () {
    $response = $this->get(route('admin.service-categories.index'));
    $response->assertRedirect(route('admin.login'));
});

test('user without view-services permission cannot view service categories', function () {
    $role = Role::create(['name' => 'limited-staff', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin']); // no view-services

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $response = $this->actingAs($user)->get(route('admin.service-categories.index'));
    $response->assertStatus(403);
});

test('user with view-services permission can view service categories and filter by search and status', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $activeCat = ServiceCategory::factory()->create([
        'name' => 'Alpha Active Category',
        'is_active' => true,
    ]);

    $inactiveCat = ServiceCategory::factory()->create([
        'name' => 'Beta Inactive Category',
        'is_active' => false,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.service-categories.index'));
    $response->assertStatus(200);
    $response->assertSee('Service Categories');
    $response->assertSee('Alpha Active Category');
    $response->assertSee('Beta Inactive Category');

    // Search filter test
    $searchResponse = $this->actingAs($admin)->get(route('admin.service-categories.index', ['search' => 'Alpha Active']));
    $searchResponse->assertStatus(200);
    $searchResponse->assertSee('Alpha Active Category');
    $searchResponse->assertDontSee('Beta Inactive Category');

    // Status filter test (active)
    $statusResponse = $this->actingAs($admin)->get(route('admin.service-categories.index', ['status' => 'active']));
    $statusResponse->assertStatus(200);
    $statusResponse->assertSee('Alpha Active Category');
    $statusResponse->assertDontSee('Beta Inactive Category');
});

test('user without create-services permission cannot create service category', function () {
    $role = Role::create(['name' => 'viewer-staff', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin', 'view-services']); // no create-services

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $this->actingAs($user)->get(route('admin.service-categories.create'))->assertStatus(403);

    $this->actingAs($user)->post(route('admin.service-categories.store'), [
        'name' => 'Test Category',
    ])->assertStatus(403);
});

test('user with create-services permission can view create form and store category with image', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $this->actingAs($admin)->get(route('admin.service-categories.create'))->assertStatus(200);

    $image = UploadedFile::fake()->image('category_banner.jpg', 800, 600);

    $payload = [
        'name' => 'Cloud Infrastructure',
        'slug' => 'cloud-infrastructure',
        'short_description' => 'Scalable AWS and DevOps architecture',
        'description' => 'Full enterprise cloud solutions and deployment automation.',
        'icon' => 'bi-cloud',
        'image' => $image,
        'sort_order' => 1,
        'is_active' => '1',
    ];

    $response = $this->actingAs($admin)->post(route('admin.service-categories.store'), $payload);

    $response->assertRedirect(route('admin.service-categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('service_categories', [
        'name' => 'Cloud Infrastructure',
        'slug' => 'cloud-infrastructure',
        'icon' => 'bi-cloud',
        'is_active' => true,
    ]);

    $category = ServiceCategory::where('slug', 'cloud-infrastructure')->first();
    expect($category)->not->toBeNull();
    expect($category->image)->not->toBeNull();
    Storage::disk('public')->assertExists($category->image);
});

test('user with edit-services permission can update category and replace image', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $oldImage = UploadedFile::fake()->image('old_cat.jpg');
    $oldPath = $oldImage->store('service-categories', 'public');

    $category = ServiceCategory::factory()->create([
        'name' => 'Original Category',
        'slug' => 'original-category',
        'image' => $oldPath,
    ]);

    $this->actingAs($admin)->get(route('admin.service-categories.edit', $category))->assertStatus(200);

    $newImage = UploadedFile::fake()->image('new_cat.jpg');

    $updatePayload = [
        'name' => 'Updated Category Name',
        'slug' => 'updated-category-name',
        'short_description' => 'Updated summary text',
        'description' => 'Updated full description',
        'icon' => 'bi-check2-all',
        'image' => $newImage,
        'sort_order' => 5,
        'is_active' => '1',
    ];

    $response = $this->actingAs($admin)->put(route('admin.service-categories.update', $category), $updatePayload);

    $response->assertRedirect(route('admin.service-categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('service_categories', [
        'id' => $category->id,
        'name' => 'Updated Category Name',
        'slug' => 'updated-category-name',
    ]);

    // Old image deleted from disk, new image stored
    Storage::disk('public')->assertMissing($oldPath);
    $category->refresh();
    Storage::disk('public')->assertExists($category->image);
});

test('category deletion is prevented if active services are linked to it', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $category = ServiceCategory::factory()->create(['name' => 'Has Active Services']);
    Service::factory()->create([
        'service_category_id' => $category->id,
        'name' => 'Connected Service',
    ]);

    $response = $this->actingAs($admin)->delete(route('admin.service-categories.destroy', $category));

    $response->assertRedirect(route('admin.service-categories.index'));
    $response->assertSessionHas('error');

    $this->assertDatabaseHas('service_categories', [
        'id' => $category->id,
    ]);
});

test('category without linked services can be deleted cleanly and image is removed from disk', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $image = UploadedFile::fake()->image('cat_to_delete.png');
    $imagePath = $image->store('service-categories', 'public');

    $category = ServiceCategory::factory()->create([
        'name' => 'Orphan Category',
        'image' => $imagePath,
    ]);

    $response = $this->actingAs($admin)->delete(route('admin.service-categories.destroy', $category));

    $response->assertRedirect(route('admin.service-categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('service_categories', [
        'id' => $category->id,
    ]);

    Storage::disk('public')->assertMissing($imagePath);
});
