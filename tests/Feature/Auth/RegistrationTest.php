<?php

use App\Livewire\Auth\Register;
use Livewire\Livewire;

test('registration screen can be rendered', function () {
    $response = $this->get('/inscription');

    $response->assertStatus(200);
});

// test('new users can register', function () {
//     $response = Livewire::test(Register::class)
//         ->set('pseudo', 'Test User')
//         ->set('email', 'test@example.com')
//         ->set('password', 'password')
//         ->set('password_confirmation', 'password')
//         ->call('register');

//     $response
//         ->assertHasNoErrors()
//         ->assertRedirect(route('dashboard', absolute: false));

//     $this->assertAuthenticated();
// });