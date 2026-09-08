<?php

test('all frontend routes return a successful response', function (string $route) {
    $response = $this->get(route($route));

    $response->assertStatus(200);
})->with([
    'home',
    'about',
    'contact',
    'digital-marketing',
    'software-development',
]);
