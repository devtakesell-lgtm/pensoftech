<?php

use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('admin login page can be rendered', function () {
    $response = $this->get(route('admin.login'));

    $response->assertStatus(200);
});

test('staff member can authenticate at admin login', function () {
    $role = Role::firstOrCreate(['slug' => 'administrator'], ['name' => 'Administrator', 'is_active' => true]);
    $user = User::create([
        'role_id' => $role->id,
        'name' => 'Staff Member',
        'email' => 'staff@pensoftech.com',
        'password' => Hash::make('secret123'),
        'is_active' => true,
    ]);

    $response = $this->post(route('admin.login.submit'), [
        'email' => 'staff@pensoftech.com',
        'password' => 'secret123',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect(route('admin.dashboard'));
});

test('deactivated staff member cannot authenticate', function () {
    $role = Role::firstOrCreate(['slug' => 'administrator'], ['name' => 'Administrator', 'is_active' => true]);
    User::create([
        'role_id' => $role->id,
        'name' => 'Inactive Staff',
        'email' => 'inactive@pensoftech.com',
        'password' => Hash::make('secret123'),
        'is_active' => false,
    ]);

    $response = $this->post(route('admin.login.submit'), [
        'email' => 'inactive@pensoftech.com',
        'password' => 'secret123',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
});

test('client accounts cannot log in through admin login', function () {
    $clientRole = Role::firstOrCreate(['slug' => 'client'], ['name' => 'Client', 'is_active' => true]);
    User::create([
        'role_id' => $clientRole->id,
        'name' => 'Client User',
        'email' => 'client@example.com',
        'password' => Hash::make('secret123'),
        'is_active' => true,
    ]);

    $response = $this->post(route('admin.login.submit'), [
        'email' => 'client@example.com',
        'password' => 'secret123',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
});

test('staff member can log out from admin panel', function () {
    $role = Role::firstOrCreate(['slug' => 'administrator'], ['name' => 'Administrator', 'is_active' => true]);
    $user = User::factory()->create([
        'role_id' => $role->id,
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->post(route('admin.logout'));

    $this->assertGuest();
    $response->assertRedirect(route('admin.login'));
});

test('client login page can be rendered', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
});

test('client registration page can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

test('new clients can self-register and get authenticated', function () {
    $response = $this->post(route('register.submit'), [
        'name' => 'Alex Morgan',
        'email' => 'alex@acme.com',
        'company_name' => 'Acme Inc',
        'phone' => '+1 555-1234',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();

    $user = User::where('email', 'alex@acme.com')->first();
    expect($user)->not->toBeNull();
    expect($user->role->slug)->toBe('client');

    $client = Client::where('user_id', $user->id)->first();
    expect($client)->not->toBeNull();
    expect($client->company_name)->toBe('Acme Inc');

    $response->assertRedirect(route('home'));
});

test('client can authenticate through client login', function () {
    $clientRole = Role::firstOrCreate(['slug' => 'client'], ['name' => 'Client', 'is_active' => true]);
    $clientUser = User::create([
        'role_id' => $clientRole->id,
        'name' => 'Client User',
        'email' => 'client2@example.com',
        'password' => Hash::make('secret123'),
        'is_active' => true,
    ]);

    $response = $this->post(route('login.submit'), [
        'email' => 'client2@example.com',
        'password' => 'secret123',
    ]);

    $this->assertAuthenticatedAs($clientUser);
    $response->assertRedirect(route('home'));
});

test('authenticated staff member visiting admin login is redirected to dashboard', function () {
    $role = Role::firstOrCreate(['slug' => 'administrator'], ['name' => 'Administrator', 'is_active' => true]);
    $user = User::factory()->create([
        'role_id' => $role->id,
        'is_active' => true,
    ]);

    $response = $this->actingAs($user)->get(route('admin.login'));

    $response->assertRedirect(route('admin.dashboard'));
});

test('authenticated client user visiting admin login is redirected to home', function () {
    $clientRole = Role::firstOrCreate(['slug' => 'client'], ['name' => 'Client', 'is_active' => true]);
    $clientUser = User::factory()->create([
        'role_id' => $clientRole->id,
        'is_active' => true,
    ]);

    $response = $this->actingAs($clientUser)->get(route('admin.login'));

    $response->assertRedirect(route('home'));
});
