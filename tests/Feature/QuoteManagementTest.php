<?php

use App\Enums\QuoteStatus;
use App\Models\Lead;
use App\Models\Quote;
use App\Models\QuoteService;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
});

test('unauthenticated guests are redirected to admin login when accessing quotes', function () {
    $response = $this->get(route('admin.quotes'));
    $response->assertRedirect(route('admin.login'));
});

test('user without view-quotes permission cannot view quotes index', function () {
    $role = Role::create(['name' => 'limited-staff', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin']); // no view-quotes

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $response = $this->actingAs($user)->get(route('admin.quotes'));
    $response->assertStatus(403);
});

test('user with view-quotes permission can view quotes index, see KPIs, services, and enum status badge', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $lead = Lead::factory()->create([
        'name' => 'Acme Corporation',
        'company_name' => 'Acme Global Holdings',
    ]);

    $service = Service::factory()->create([
        'name' => 'Full-Stack Web Development',
    ]);

    $quote = Quote::factory()->create([
        'lead_id' => $lead->id,
        'title' => 'E-Commerce Platform Rebuild',
        'quote_number' => 'Q-ACME01',
        'status' => QuoteStatus::Sent,
        'budget_min' => 10000,
        'budget_max' => 25000,
    ]);

    QuoteService::create([
        'quote_id' => $quote->id,
        'service_id' => $service->id,
        'quantity' => 1,
        'unit_price' => 25000,
        'total_price' => 25000,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.quotes'));

    $response->assertStatus(200);
    $response->assertSee('Quotes & Proposals');
    $response->assertSee('Pipeline Value');
    $response->assertSee('Total Quotes');
    $response->assertSee('Sent Proposals');
    $response->assertSee('Q-ACME01');
    $response->assertSee('E-Commerce Platform Rebuild');
    $response->assertSee('Acme Global Holdings');
    $response->assertSee('Full-Stack Web Development');
    $response->assertSee('quote-status-sent');
    $response->assertSee('bi-send');
    $response->assertSee('Sent');

    // Test Search filter
    $searchResponse = $this->actingAs($admin)->get(route('admin.quotes', ['search' => 'ACME01']));
    $searchResponse->assertStatus(200);
    $searchResponse->assertSee('Q-ACME01');

    // Test Search filter no matches
    $emptySearchResponse = $this->actingAs($admin)->get(route('admin.quotes', ['search' => 'NonExistentXYZQuote']));
    $emptySearchResponse->assertStatus(200);
    $emptySearchResponse->assertDontSee('Q-ACME01');
    $emptySearchResponse->assertSee('No Quotes Found');

    // Test Status filter
    $statusResponse = $this->actingAs($admin)->get(route('admin.quotes', ['status' => 'sent']));
    $statusResponse->assertStatus(200);
    $statusResponse->assertSee('Q-ACME01');

    $otherStatusResponse = $this->actingAs($admin)->get(route('admin.quotes', ['status' => 'accepted']));
    $otherStatusResponse->assertStatus(200);
    $otherStatusResponse->assertDontSee('Q-ACME01');
});
