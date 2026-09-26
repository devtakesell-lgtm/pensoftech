<?php

use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
});

test('unauthenticated guests are redirected to admin login when accessing reviews', function () {
    $response = $this->get(route('admin.reviews.index'));
    $response->assertRedirect(route('admin.login'));
});

test('user without view-reviews permission cannot view reviews index', function () {
    $role = Role::create(['name' => 'limited-staff', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin']);

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $response = $this->actingAs($user)->get(route('admin.reviews.index'));
    $response->assertStatus(403);
});

test('user with view-reviews permission can view reviews index', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $review = Review::factory()->create([
        'name' => 'Johnathan Doe',
        'title' => 'VP of Engineering',
        'content' => 'Outstanding development capabilities and communication.',
        'rating' => 5,
        'is_active' => true,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.reviews.index'));
    $response->assertStatus(200);
    $response->assertSee('Johnathan Doe');
    $response->assertSee('VP of Engineering');
});

test('user without create-reviews permission cannot access create form or store review', function () {
    $role = Role::create(['name' => 'review-reader', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin', 'view-reviews']);

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $this->actingAs($user)->get(route('admin.reviews.create'))->assertStatus(403);

    $this->actingAs($user)->post(route('admin.reviews.store'), [
        'name' => 'Jane Smith',
        'title' => 'Chief Executive',
        'content' => 'Great work.',
        'rating' => 5,
    ])->assertStatus(403);
});

test('user with create-reviews permission can create and store review with avatar upload', function () {
    Storage::fake('public');

    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $this->actingAs($admin)->get(route('admin.reviews.create'))->assertStatus(200);

    $file = UploadedFile::fake()->image('avatar.jpg', 300, 300);

    $response = $this->actingAs($admin)->post(route('admin.reviews.store'), [
        'name' => 'Marcus Vance',
        'title' => 'Founder & CEO',
        'content' => 'Exceptional delivery on our enterprise web app.',
        'rating' => 5,
        'sort_order' => 1,
        'is_active' => 1,
        'avatar' => $file,
    ]);

    $response->assertRedirect(route('admin.reviews.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('reviews', [
        'name' => 'Marcus Vance',
        'title' => 'Founder & CEO',
        'rating' => 5,
        'is_active' => 1,
    ]);

    $created = Review::where('name', 'Marcus Vance')->first();
    expect($created)->not->toBeNull();
    expect($created->avatar)->not->toBeNull();
    Storage::disk('public')->assertExists($created->avatar);
});

test('user without edit-reviews permission cannot access edit form or update review', function () {
    $role = Role::create(['name' => 'review-viewer', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin', 'view-reviews']);

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $review = Review::factory()->create();

    $this->actingAs($user)->get(route('admin.reviews.edit', $review))->assertStatus(403);

    $this->actingAs($user)->put(route('admin.reviews.update', $review), [
        'name' => 'Updated Reviewer',
        'title' => 'Updated Title',
        'content' => 'Updated content here.',
        'rating' => 4,
    ])->assertStatus(403);
});

test('user with edit-reviews permission can update a review', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $review = Review::factory()->create([
        'name' => 'Original Name',
        'title' => 'Original Title',
        'content' => 'Original Content',
        'rating' => 4,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.reviews.edit', $review));
    $response->assertStatus(200);
    $response->assertSee('Original Name');

    $updateResponse = $this->actingAs($admin)->put(route('admin.reviews.update', $review), [
        'name' => 'Updated Name',
        'title' => 'Updated Title',
        'content' => 'Updated Content that is detailed.',
        'rating' => 5,
        'is_active' => 1,
        'sort_order' => 2,
    ]);

    $updateResponse->assertRedirect(route('admin.reviews.index'));
    $updateResponse->assertSessionHas('success');

    $this->assertDatabaseHas('reviews', [
        'id' => $review->id,
        'name' => 'Updated Name',
        'rating' => 5,
    ]);
});

test('user without delete-reviews permission cannot delete a review', function () {
    $role = Role::create(['name' => 'review-staff', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin', 'view-reviews', 'edit-reviews']);

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $review = Review::factory()->create();

    $response = $this->actingAs($user)->delete(route('admin.reviews.destroy', $review));
    $response->assertStatus(403);

    $this->assertDatabaseHas('reviews', [
        'id' => $review->id,
        'deleted_at' => null,
    ]);
});

test('user with delete-reviews permission can soft delete a review', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $review = Review::factory()->create([
        'name' => 'Review to delete',
    ]);

    $response = $this->actingAs($admin)->delete(route('admin.reviews.destroy', $review));
    $response->assertRedirect(route('admin.reviews.index'));
    $response->assertSessionHas('success');

    $this->assertSoftDeleted('reviews', [
        'id' => $review->id,
    ]);
});

test('homepage renders active reviews and omits inactive reviews', function () {
    Review::query()->delete();

    $activeReview = Review::factory()->create([
        'name' => 'Visible Client',
        'title' => 'CEO of Visible Corp',
        'content' => 'The software PenSoftTech built revolutionized our operations.',
        'is_active' => true,
    ]);

    $inactiveReview = Review::factory()->create([
        'name' => 'Hidden Client',
        'title' => 'CEO of Hidden Corp',
        'content' => 'This text should not be visible anywhere.',
        'is_active' => false,
    ]);

    $response = $this->get(route('home'));
    $response->assertStatus(200);
    $response->assertSee('Visible Client');
    $response->assertSee('Visible Corp');
    $response->assertDontSee('Hidden Client');
});

