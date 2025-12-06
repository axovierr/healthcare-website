<?php

use App\Models\Role;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Role::create(['name' => 'patient']);
});

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $this->withoutExceptionHandling();
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    if ($response->status() !== 302) {
        dump($response->status());
        dump($response->getContent());
    }
    $this->assertAuthenticated();
    $response->assertRedirect(route('patient.dashboard', absolute: false));
});
