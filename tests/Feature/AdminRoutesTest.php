<?php

test('admin dashboard returns a successful response', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertStatus(200);
});

test('all admin pages return a successful response', function (string $routeName) {
    $response = $this->get(route($routeName));

    $response->assertStatus(200);
})->with([
    'admin.leads',
    'admin.clients',
    'admin.quotes',
    'admin.services',
    'admin.projects',
    'admin.case-studies',
    'admin.industries',
    'admin.pages',
    'admin.blog',
    'admin.careers',
    'admin.users',
    'admin.analytics',
    'admin.settings',
]);
