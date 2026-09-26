<?php

use App\Models\Page;
use App\Models\Setting;

beforeEach(function () {
    Page::updateOrCreate(
        ['slug' => 'contact'],
        [
            'title' => 'Contact Us',
            'hero_title' => "Let's [Talk]",
            'hero_description' => 'Whether you have a specific project in mind or just want to explore possibilities, we are ready to listen.',
            'hero_banner' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa',
            'content_title' => 'Get in Touch',
            'content_subtitle' => 'We would love to hear from you. Our friendly team is always here to chat.',
            'template' => 'contact',
            'status' => 'published',
        ]
    );

    Setting::updateOrCreate(['key' => 'contact_email'], ['value' => 'hello@pensofttech.com']);
    Setting::updateOrCreate(['key' => 'contact_phone'], ['value' => '+8801618-854811']);
    Setting::updateOrCreate(['key' => 'working_hours'], ['value' => 'Sat - Thu (9am - 6pm)']);
    Setting::updateOrCreate(['key' => 'office_location'], ['value' => 'Darussalam Tower, Kollyanpur, Dhaka-1207']);
});

test('contact page loads successfully with dynamic page and settings data', function () {
    $response = $this->get(route('contact'));

    $response->assertOk()
        ->assertSee("Let's")
        ->assertSee('<span style="color: #4fd1c5;">Talk</span>', false)
        ->assertSee('Whether you have a specific project in mind')
        ->assertSee('Get in Touch')
        ->assertSee('We would love to hear from you')
        ->assertSee('Chat to our team')
        ->assertSee('hello@pensofttech.com')
        ->assertSee('Call us')
        ->assertSee('+8801618-854811')
        ->assertSee('Sat - Thu (9am - 6pm)')
        ->assertSee('Darussalam Tower, Kollyanpur, Dhaka-1207')
        ->assertSee('name="phone"', false);
});

test('contact form validates required fields', function () {
    $response = $this->post(route('contact.store'), []);

    $response->assertSessionHasErrors(['first_name', 'last_name', 'email', 'message']);
});

test('submitting contact form creates a lead with contact page source and optional phone', function () {
    $payload = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'phone' => '+8801712345678',
        'company' => 'Acme Corp',
        'message' => 'Hello, I would like to discuss a custom web project.',
    ];

    $response = $this->post(route('contact.store'), $payload);

    $response->assertRedirect(route('contact'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('leads', [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'phone' => '+8801712345678',
        'company_name' => 'Acme Corp',
        'message' => 'Hello, I would like to discuss a custom web project.',
        'lead_source' => 'Contact Page',
        'status' => 'new',
    ]);
});

test('submitting contact form without phone is allowed', function () {
    $payload = [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'email' => 'jane.smith@example.com',
        'message' => 'Inquiry without phone number provided.',
    ];

    $response = $this->post(route('contact.store'), $payload);

    $response->assertRedirect(route('contact'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('leads', [
        'name' => 'Jane Smith',
        'email' => 'jane.smith@example.com',
        'phone' => null,
        'lead_source' => 'Contact Page',
        'status' => 'new',
    ]);
});
