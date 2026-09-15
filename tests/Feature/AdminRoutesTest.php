<?php

use App\Models\Role;
use App\Models\User;

test('unauthenticated guests are redirected to admin login', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('admin.login'));
});

test('authenticated staff can access admin dashboard', function () {
    $adminRole = Role::firstOrCreate(['slug' => 'administrator'], ['name' => 'Administrator', 'is_active' => true]);
    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_active' => true,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
});

test('client users are forbidden from accessing admin pages', function () {
    $clientRole = Role::firstOrCreate(['slug' => 'client'], ['name' => 'Client', 'is_active' => true]);
    $clientUser = User::factory()->create([
        'role_id' => $clientRole->id,
        'is_active' => true,
    ]);

    $response = $this->actingAs($clientUser)->get(route('admin.dashboard'));

    $response->assertStatus(403);
});

test('all admin pages return a successful response for authenticated staff', function (string $routeName) {
    $adminRole = Role::firstOrCreate(['slug' => 'administrator'], ['name' => 'Administrator', 'is_active' => true]);
    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_active' => true,
    ]);

    $response = $this->actingAs($admin)->get(route($routeName));

    $response->assertStatus(200);
})->with([
    'admin.leads',
    'admin.clients',
    'admin.quotes',
    'admin.services',
    'admin.projects.index',
    'admin.case-studies.index',
    'admin.industries',
    'admin.pages',
    'admin.blog',
    'admin.careers',
    'admin.users',
    'admin.analytics',
    'admin.settings',
]);
