<?php

use App\Models\Role;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
});

test('unauthenticated guests are redirected to admin login when accessing users', function () {
    $response = $this->get(route('admin.users'));
    $response->assertRedirect(route('admin.login'));
});

test('user without view-users permission cannot view users index', function () {
    $role = Role::create(['name' => 'restricted-staff', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin']); // only access-admin, no view-users

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $response = $this->actingAs($user)->get(route('admin.users'));
    $response->assertStatus(403);
});

test('user with view-users permission can view users index and search', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $response = $this->actingAs($admin)->get(route('admin.users'));
    $response->assertStatus(200);
    $response->assertSee('Users Management');
    $response->assertSee($admin->email);
});

test('user without create-users permission cannot access create form or store user', function () {
    $role = Role::create(['name' => 'viewer', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin', 'view-users']);

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $this->actingAs($user)->get(route('admin.users.create'))->assertStatus(403);

    $this->actingAs($user)->post(route('admin.users.store'), [
        'name' => 'New User',
        'email' => 'new@pensoftech.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role_id' => Role::where('name', 'developer')->first()->id,
    ])->assertStatus(403);
});

test('user with create-users permission can create user and assign role', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $targetRole = Role::where('name', 'project-manager')->first();

    $createPageResponse = $this->actingAs($admin)->get(route('admin.users.create'));
    $createPageResponse->assertStatus(200);
    $createPageResponse->assertSee('Assign Agency Role');

    $response = $this->actingAs($admin)->post(route('admin.users.store'), [
        'name' => 'Zubair Ahmed',
        'email' => 'zubair@pensoftech.com',
        'phone' => '+880 1711-223344',
        'role_id' => $targetRole->id,
        'password' => 'SecretPassword123!',
        'password_confirmation' => 'SecretPassword123!',
        'is_active' => '1',
    ]);

    $response->assertRedirect(route('admin.users'));
    $response->assertSessionHas('success');

    $createdUser = User::where('email', 'zubair@pensoftech.com')->first();
    expect($createdUser)->not->toBeNull()
        ->and($createdUser->name)->toBe('Zubair Ahmed')
        ->and($createdUser->role_id)->toBe($targetRole->id)
        ->and($createdUser->hasRole('project-manager'))->toBeTrue();
});

test('user without edit-users permission cannot access edit form or update user', function () {
    $role = Role::create(['name' => 'limited-editor', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin', 'view-users']);

    $staff = User::factory()->create(['is_active' => true]);
    $staff->assignRole($role);

    $targetUser = User::factory()->create(['is_active' => true]);

    $this->actingAs($staff)->get(route('admin.users.edit', $targetUser))->assertStatus(403);

    $this->actingAs($staff)->put(route('admin.users.update', $targetUser), [
        'name' => 'Hacked Name',
        'email' => $targetUser->email,
        'role_id' => Role::where('name', 'developer')->first()->id,
    ])->assertStatus(403);
});

test('user with edit-users permission can update user details and reassign role', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $devRole = Role::where('name', 'developer')->first();
    $salesRole = Role::where('name', 'sales-manager')->first();

    $member = User::factory()->create([
        'name' => 'Initial Developer',
        'email' => 'dev@pensoftech.com',
        'role_id' => $devRole->id,
        'is_active' => true,
    ]);
    $member->assignRole($devRole);

    $editResponse = $this->actingAs($admin)->get(route('admin.users.edit', $member));
    $editResponse->assertStatus(200);
    $editResponse->assertSee('Edit Team Member');

    $response = $this->actingAs($admin)->put(route('admin.users.update', $member), [
        'name' => 'Promoted Sales Manager',
        'email' => 'promoted@pensoftech.com',
        'phone' => '+880 1811-998877',
        'role_id' => $salesRole->id,
        'is_active' => '1',
    ]);

    $response->assertRedirect(route('admin.users'));
    $response->assertSessionHas('success');

    $updatedMember = $member->fresh();
    expect($updatedMember->name)->toBe('Promoted Sales Manager')
        ->and($updatedMember->email)->toBe('promoted@pensoftech.com')
        ->and($updatedMember->role_id)->toBe($salesRole->id)
        ->and($updatedMember->hasRole('sales-manager'))->toBeTrue()
        ->and($updatedMember->hasRole('developer'))->toBeFalse();
});

test('cannot delete own logged in account', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

    $response->assertRedirect(route('admin.users'));
    $response->assertSessionHas('error', 'You cannot delete your own account.');

    expect(User::find($admin->id))->not->toBeNull();
});

test('cannot delete the last active administrator', function () {
    // Only 1 administrator
    User::query()->delete();
    $soleAdmin = User::factory()->create(['is_active' => true]);
    $soleAdmin->assignRole('administrator');

    // Create a staff user who has delete-users permission
    $staffRole = Role::create(['name' => 'manager', 'guard_name' => 'web']);
    $staffRole->syncPermissions(['access-admin', 'delete-users']);

    $staff = User::factory()->create(['is_active' => true]);
    $staff->assignRole($staffRole);

    $response = $this->actingAs($staff)->delete(route('admin.users.destroy', $soleAdmin));

    $response->assertRedirect(route('admin.users'));
    $response->assertSessionHas('error', 'Cannot delete the last remaining active administrator.');

    expect(User::find($soleAdmin->id))->not->toBeNull();
});

test('user with delete-users permission can delete a staff user', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $targetUser = User::factory()->create(['name' => 'To Be Deleted']);
    $devRole = Role::where('name', 'developer')->first();
    $targetUser->assignRole($devRole);

    $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $targetUser));

    $response->assertRedirect(route('admin.users'));
    $response->assertSessionHas('success');

    expect(User::find($targetUser->id))->toBeNull(); // soft deleted
    expect(User::withTrashed()->find($targetUser->id))->not->toBeNull();
});
