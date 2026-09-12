<?php

use App\Enums\ContentStatus;
use App\Enums\LeadStatus;
use App\Models\Currency;
use App\Models\Industry;
use App\Models\Lead;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
});

test('unauthenticated guests are redirected to admin login when accessing leads', function () {
    $response = $this->get(route('admin.leads'));
    $response->assertRedirect(route('admin.login'));
});

test('user without view-leads permission cannot view leads index', function () {
    $role = Role::create(['name' => 'limited-staff', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin']); // no view-leads

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $response = $this->actingAs($user)->get(route('admin.leads'));
    $response->assertStatus(403);
});

test('user with view-leads permission can view leads index, see KPIs, and filter leads', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $lead = Lead::factory()->create([
        'name' => 'Enterprise Prospect Alpha',
        'status' => LeadStatus::New,
        'budget' => 15000,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.leads'));
    $response->assertStatus(200);
    $response->assertSee('Pipeline Value');
    $response->assertSee('Enterprise Prospect Alpha');

    // Test Search filter
    $searchResponse = $this->actingAs($admin)->get(route('admin.leads', ['search' => 'Prospect Alpha']));
    $searchResponse->assertStatus(200);
    $searchResponse->assertSee('Enterprise Prospect Alpha');

    // Test Search filter no matches
    $emptySearchResponse = $this->actingAs($admin)->get(route('admin.leads', ['search' => 'NonExistentXYZ']));
    $emptySearchResponse->assertStatus(200);
    $emptySearchResponse->assertDontSee('Enterprise Prospect Alpha');
});

test('scopeFilter filters leads accurately across all parameters and handles empty values', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $salesRep = User::factory()->create(['name' => 'Agent Smith', 'is_active' => true]);
    $industryA = Industry::factory()->create(['name' => 'Healthcare']);
    $industryB = Industry::factory()->create(['name' => 'Fintech']);

    $lead1 = Lead::factory()->create([
        'name' => 'Dr. John Watson',
        'status' => LeadStatus::New,
        'lead_source' => 'linkedin',
        'industry_id' => $industryA->id,
        'assigned_to' => $salesRep->id,
    ]);

    $lead2 = Lead::factory()->create([
        'name' => 'Sherlock Holmes',
        'status' => LeadStatus::Qualified,
        'lead_source' => 'website',
        'industry_id' => $industryB->id,
        'assigned_to' => null,
    ]);

    // Test filter by status
    $resStatus = $this->actingAs($admin)->get(route('admin.leads', ['status' => 'new']));
    $resStatus->assertSee('Dr. John Watson');
    $resStatus->assertDontSee('Sherlock Holmes');

    // Test filter by source
    $resSource = $this->actingAs($admin)->get(route('admin.leads', ['source' => 'website']));
    $resSource->assertSee('Sherlock Holmes');
    $resSource->assertDontSee('Dr. John Watson');

    // Test filter by industry
    $resIndustry = $this->actingAs($admin)->get(route('admin.leads', ['industry_id' => $industryA->id]));
    $resIndustry->assertSee('Dr. John Watson');
    $resIndustry->assertDontSee('Sherlock Holmes');

    // Test filter by assignee
    $resAssignee = $this->actingAs($admin)->get(route('admin.leads', ['assigned_to' => $salesRep->id]));
    $resAssignee->assertSee('Dr. John Watson');
    $resAssignee->assertDontSee('Sherlock Holmes');

    // Test empty query parameters don't break or exclude leads
    $resEmpty = $this->actingAs($admin)->get(route('admin.leads', [
        'search' => '',
        'status' => '',
        'source' => '',
        'industry_id' => '',
        'assigned_to' => '',
    ]));
    $resEmpty->assertSee('Dr. John Watson');
    $resEmpty->assertSee('Sherlock Holmes');
});

test('user without create-leads permission cannot access create form or store lead', function () {
    $role = Role::create(['name' => 'lead-reader', 'guard_name' => 'web']);
    $role->syncPermissions(['access-admin', 'view-leads']);

    $user = User::factory()->create(['is_active' => true]);
    $user->assignRole($role);

    $this->actingAs($user)->get(route('admin.leads.create'))->assertStatus(403);

    $this->actingAs($user)->post(route('admin.leads.store'), [
        'name' => 'Unauthorized Lead',
        'status' => 'new',
    ])->assertStatus(403);
});

test('user with create-leads permission can create and store lead with services', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $industry = Industry::factory()->create();
    $currency = Currency::factory()->create(['is_active' => true]);
    $service = Service::factory()->create(['status' => ContentStatus::Published]);

    $this->actingAs($admin)->get(route('admin.leads.create'))->assertStatus(200);

    $response = $this->actingAs($admin)->post(route('admin.leads.store'), [
        'name' => 'Jonathan Vance',
        'company_name' => 'Vance Global',
        'email' => 'vance@example.com',
        'phone' => '+1234567890',
        'website' => 'https://vanceglobal.com',
        'industry_id' => $industry->id,
        'currency_id' => $currency->id,
        'lead_source' => 'website',
        'lead_type' => 'new_project',
        'budget' => 25000,
        'status' => 'new',
        'message' => 'Need full stack Laravel and mobile application architecture.',
        'service_ids' => [$service->id],
        'utm_source' => 'linkedin',
    ]);

    $response->assertRedirect(route('admin.leads'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('leads', [
        'name' => 'Jonathan Vance',
        'company_name' => 'Vance Global',
        'email' => 'vance@example.com',
        'budget' => 25000,
        'status' => 'new',
    ]);

    $createdLead = Lead::where('email', 'vance@example.com')->first();
    expect($createdLead->services)->toHaveCount(1);
    expect($createdLead->services->first()->id)->toBe($service->id);
});

test('store lead validates required fields', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $response = $this->actingAs($admin)->post(route('admin.leads.store'), [
        'name' => '',
        'status' => 'invalid-status',
        'email' => 'not-an-email',
    ]);

    $response->assertSessionHasErrors(['name', 'status', 'email']);
});

test('user with view-leads permission can view lead dossier show page', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $lead = Lead::factory()->create([
        'name' => 'Sophia Carter',
        'company_name' => 'Carter Holdings',
        'email' => 'sophia@carter.com',
        'message' => 'Custom ERP software redesign',
        'status' => LeadStatus::Qualified,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.leads.show', $lead));
    $response->assertStatus(200);
    $response->assertSee('Sophia Carter');
    $response->assertSee('Carter Holdings');
    $response->assertSee('Custom ERP software redesign');
});

test('user with edit-leads permission can update lead and change status', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $lead = Lead::factory()->create([
        'name' => 'Original Lead Name',
        'status' => LeadStatus::New,
        'budget' => 5000,
    ]);

    $this->actingAs($admin)->get(route('admin.leads.edit', $lead))->assertStatus(200);

    $response = $this->actingAs($admin)->put(route('admin.leads.update', $lead), [
        'name' => 'Updated Lead Name',
        'company_name' => 'Updated Company',
        'status' => 'qualified',
        'budget' => 12000,
    ]);

    $response->assertRedirect(route('admin.leads'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('leads', [
        'id' => $lead->id,
        'name' => 'Updated Lead Name',
        'status' => 'qualified',
        'budget' => 12000,
    ]);

    // Test quick status transition patch route
    $patchResponse = $this->actingAs($admin)->patch(route('admin.leads.update-status', $lead), [
        'status' => 'proposal_sent',
    ]);

    $patchResponse->assertSessionHas('success');
    expect($lead->fresh()->status)->toBe(LeadStatus::ProposalSent);
});

test('user with edit-leads permission can convert lead into client', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $lead = Lead::factory()->create([
        'name' => 'Michael Scott',
        'company_name' => 'Dunder Mifflin',
        'website' => 'https://dundermifflin.com',
        'status' => LeadStatus::Qualified,
        'client_id' => null,
    ]);

    $response = $this->actingAs($admin)->post(route('admin.leads.convert', $lead));
    $response->assertRedirect(route('admin.leads.show', $lead));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('clients', [
        'company_name' => 'Dunder Mifflin',
        'contact_person' => 'Michael Scott',
    ]);

    $lead->refresh();
    expect($lead->client_id)->not->toBeNull();
    expect($lead->status)->toBe(LeadStatus::Converted);
});

test('user with delete-leads permission can soft delete lead', function () {
    $admin = User::factory()->create(['is_active' => true]);
    $admin->assignRole('administrator');

    $lead = Lead::factory()->create(['name' => 'Lead to Delete']);

    $response = $this->actingAs($admin)->delete(route('admin.leads.destroy', $lead));
    $response->assertRedirect(route('admin.leads'));
    $response->assertSessionHas('success');

    $this->assertSoftDeleted('leads', ['id' => $lead->id]);
});
