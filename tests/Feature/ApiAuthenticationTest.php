<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ApiAuthenticationTest extends TestCase
{
    use WithoutMiddleware;
    public function test_login_with_correct_credentials()
    {
        $this->postJson(route('api.auth.login'), [
            'email'    => 'user@user.com',
            'password' => '123456'
        ])
        ->assertSuccessful();
    }

    public function test_login_with_wrong_credentials()
    {
        $this->postJson(route('api.auth.login'), [
            'email'    => 'user@user.com',
            'password' => 'invalid-password'
        ],
        [
            'accept'  =>  'application/json'
        ]
        )->assertStatus(401)->assertJson([
            'message' => 'error',
            'errors'  => 'Wrong Email Or Password'
        ]);
    }
}
