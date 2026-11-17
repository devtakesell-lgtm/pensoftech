<?php

use App\Models\Role;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
});

test('unauthenticated guests are redirected to admin login from roles page', function () {
    $response = $this->get(route('admin.roles.index'));
    $response->assertRedirect(route('admin.login'));
});

test('client user cannot access roles or permissions pages', function () {
    $client = User::factory()->create(['is_active' => true]);
    $client->assignRole('client');

    $this->actingAs($client)->get(route('admin.roles.index'))->assertStatus(403);
    $this->actingAs($client)->get(route('admin.permissions.index'))->assertStatus(403);
});

test('administrator can view roles list and permissions audit', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $rolesResponse = $this->actingAs($admin)->get(route('admin.roles.index'));
    $rolesResponse->assertStatus(200);
    $rolesResponse->assertSee('administrator');
    $rolesResponse->assertSee('sales-manager');

    $permsResponse = $this->actingAs($admin)->get(route('admin.permissions.index'));
    $permsResponse->assertStatus(200);
    $permsResponse->assertSee('access-admin');
    $permsResponse->assertSee('view-leads');
});

test('administrator can create a new role and sync permissions', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $response = $this->actingAs($admin)->post(route('admin.roles.store'), [
        'name' => 'QA Engineer',
        'description' => 'Quality assurance and software testing deliverables.',
        'permissions' => ['access-admin', 'view-projects', 'edit-projects'],
    ]);

    $response->assertRedirect(route('admin.roles.index'));
    $response->assertSessionHas('success');

    $createdRole = Role::findByName('qa-engineer', 'web');
    expect($createdRole)->not->toBeNull()
        ->and($createdRole->hasPermissionTo('view-projects'))->toBeTrue()
        ->and($createdRole->hasPermissionTo('access-admin'))->toBeTrue()
        ->and($createdRole->hasPermissionTo('delete-users'))->toBeFalse();
});

test('administrator can update an existing role permissions', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $role = Role::create([
        'name' => 'tech-lead',
        'guard_name' => 'web',
        'description' => 'Technical team lead',
    ]);
    $role->syncPermissions(['access-admin', 'view-projects']);

    $response = $this->actingAs($admin)->put(route('admin.roles.update', $role), [
        'name' => 'tech-lead',
        'description' => 'Updated lead description',
        'permissions' => ['access-admin', 'view-projects', 'create-projects', 'edit-projects'],
    ]);

    $response->assertRedirect(route('admin.roles.index'));
    $response->assertSessionHas('success');

    expect($role->fresh()->hasPermissionTo('create-projects'))->toBeTrue();
});

test('system roles cannot be deleted', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $adminRole = Role::findByName('administrator', 'web');

    $response = $this->actingAs($admin)->delete(route('admin.roles.destroy', $adminRole));

    $response->assertRedirect(route('admin.roles.index'));
    $response->assertSessionHas('error');
    expect(Role::findByName('administrator', 'web'))->not->toBeNull();
});
