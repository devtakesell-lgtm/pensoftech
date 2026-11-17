<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
});

test('administrator has full access to admin dashboard and staff permissions', function () {
    $admin = User::factory()->create([
        'is_active' => true,
    ]);
    $admin->assignRole('administrator');

    expect($admin->isStaff())->toBeTrue()
        ->and($admin->isClient())->toBeFalse()
        ->and($admin->can('access-admin'))->toBeTrue()
        ->and($admin->can('view-leads'))->toBeTrue()
        ->and($admin->can('delete-users'))->toBeTrue();

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));
    $response->assertStatus(200);
});

test('client role is forbidden from admin dashboard and returns 403', function () {
    $client = User::factory()->create([
        'is_active' => true,
    ]);
    $client->assignRole('client');

    expect($client->isClient())->toBeTrue()
        ->and($client->isStaff())->toBeFalse()
        ->and($client->can('access-admin'))->toBeFalse();

    $response = $this->actingAs($client)->get(route('admin.dashboard'));
    $response->assertStatus(403);
    $response->assertSee('ACCESS RESTRICTED');
    $response->assertSee('Go to Client Portal');
});

test('sales manager can access admin dashboard and has granular sales permissions', function () {
    $salesUser = User::factory()->create([
        'is_active' => true,
    ]);
    $salesUser->assignRole('sales-manager');

    expect($salesUser->isStaff())->toBeTrue()
        ->and($salesUser->can('access-admin'))->toBeTrue()
        ->and($salesUser->can('view-leads'))->toBeTrue()
        ->and($salesUser->can('view-quotes'))->toBeTrue()
        ->and($salesUser->can('delete-users'))->toBeFalse();

    $response = $this->actingAs($salesUser)->get(route('admin.dashboard'));
    $response->assertStatus(200);
});

test('role permissions can be dynamically updated and synced in the matrix', function () {
    $developer = User::factory()->create(['is_active' => true]);
    $developer->assignRole('developer');

    // Initially developer cannot manage settings
    expect($developer->can('view-settings'))->toBeFalse();

    // Dynamically grant settings permission to developer role
    $developerRole = Role::findByName('developer', 'web');
    $developerRole->givePermissionTo('view-settings');

    expect($developer->fresh()->can('view-settings'))->toBeTrue();

    // Revoke permission dynamically
    $developerRole->revokePermissionTo('view-settings');
    expect($developer->fresh()->can('view-settings'))->toBeFalse();
});

test('deactivated user with admin role is logged out and redirected to login', function () {
    $user = User::factory()->create([
        'is_active' => false,
    ]);
    $user->assignRole('administrator');

    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    $response->assertRedirect(route('admin.login'));
    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});
