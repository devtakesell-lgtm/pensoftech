<?php

use App\Models\User;
use App\Notifications\NewLeadReceived;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
});

test('website project inquiries notify active staff who can view leads', function () {
    Notification::fake();

    $recipient = User::factory()->create(['is_active' => true]);
    $recipient->assignRole('sales-manager');

    $inactiveRecipient = User::factory()->create(['is_active' => false]);
    $inactiveRecipient->assignRole('sales-manager');

    $nonRecipient = User::factory()->create(['is_active' => true]);
    $nonRecipient->assignRole('developer');

    $response = $this->post(route('start-project.store'), [
        'name' => 'Jane Prospect',
        'email' => 'jane@example.com',
        'message' => 'I need a new website.',
    ]);

    $response->assertRedirect(route('start-project'));

    Notification::assertSentTo(
        $recipient,
        NewLeadReceived::class,
        fn (NewLeadReceived $notification, array $channels): bool => $notification->lead->email === 'jane@example.com'
            && $channels === ['mail', 'database'],
    );
    Notification::assertNotSentTo($inactiveRecipient, NewLeadReceived::class);
    Notification::assertNotSentTo($nonRecipient, NewLeadReceived::class);
});
