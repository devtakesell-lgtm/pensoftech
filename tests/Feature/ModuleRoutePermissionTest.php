<?php

use App\Models\Role;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
});

test('administrator can access all admin module routes', function (string $routeName) {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $response = $this->actingAs($admin)->get(route($routeName));

    $response->assertStatus(200);
})->with([
    'admin.dashboard',
    'admin.leads',
    'admin.clients',
    'admin.quotes',
    'admin.services',
    'admin.projects.index',
    'admin.case-studies.index',
    'admin.industries',
    'admin.pages.index',
    'admin.blog.index',
    'admin.jobs.index',
    'admin.users',
    'admin.roles.index',
    'admin.permissions.index',
    'admin.analytics',
    'admin.settings',
]);

test('sales manager can access sales module routes but is forbidden from unauthorized modules', function () {
    $salesUser = User::factory()->create(['is_active' => true]);
    $salesUser->assignRole('sales-manager');

    // Permitted routes
    $this->actingAs($salesUser)->get(route('admin.leads'))->assertStatus(200);
    $this->actingAs($salesUser)->get(route('admin.quotes'))->assertStatus(200);
    $this->actingAs($salesUser)->get(route('admin.clients'))->assertStatus(200);
    $this->actingAs($salesUser)->get(route('admin.services'))->assertStatus(200);

    // Forbidden routes (blocked by Route Group middleware / Controller Gate)
    $this->actingAs($salesUser)->get(route('admin.users'))->assertStatus(403);
    $this->actingAs($salesUser)->get(route('admin.roles.index'))->assertStatus(403);
    $this->actingAs($salesUser)->get(route('admin.settings'))->assertStatus(403);
    $this->actingAs($salesUser)->get(route('admin.blog.index'))->assertStatus(403);
});

test('content writer can access content module routes but is forbidden from system routes', function () {
    $writer = User::factory()->create(['is_active' => true]);
    $writer->assignRole('content-writer');

    // Permitted routes
    $this->actingAs($writer)->get(route('admin.blog.index'))->assertStatus(200);
    $this->actingAs($writer)->get(route('admin.pages.index'))->assertStatus(200);
    $this->actingAs($writer)->get(route('admin.case-studies.index'))->assertStatus(200);

    // Forbidden routes
    $this->actingAs($writer)->get(route('admin.leads'))->assertStatus(403);
    $this->actingAs($writer)->get(route('admin.quotes'))->assertStatus(403);
    $this->actingAs($writer)->get(route('admin.users'))->assertStatus(403);
    $this->actingAs($writer)->get(route('admin.settings'))->assertStatus(403);
});

test('granular user create route is forbidden for staff with only view-users permission', function () {
    $customRole = Role::create(['name' => 'user-viewer', 'guard_name' => 'web']);
    $customRole->syncPermissions(['access-admin', 'view-users']);

    $staff = User::factory()->create(['is_active' => true]);
    $staff->assignRole('user-viewer');

    // Allowed to view user listing
    $this->actingAs($staff)->get(route('admin.users'))->assertStatus(200);

    // Forbidden from create form
    $this->actingAs($staff)->get(route('admin.users.create'))->assertStatus(403);
});

test('sidebar navigation only renders links matching user capabilities', function () {
    $salesUser = User::factory()->create(['is_active' => true]);
    $salesUser->assignRole('sales-manager');

    $response = $this->actingAs($salesUser)->get(route('admin.dashboard'));
    $response->assertStatus(200);

    // Should see permitted links
    $response->assertSee(route('admin.leads'));
    $response->assertSee(route('admin.quotes'));
    $response->assertSee(route('admin.clients'));

    // Should NOT see unauthorized links in the navigation
    $response->assertDontSee(route('admin.users'));
    $response->assertDontSee(route('admin.settings'));
    $response->assertDontSee(route('admin.blog.index'));
});
