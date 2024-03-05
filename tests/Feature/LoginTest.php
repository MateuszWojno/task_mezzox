<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;


    /**
     * A basic feature test example.
     */


    public function test_login(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson(route(name: 'auth.login', parameters: [
            'email'    => $user->email,
            'password' => 'password',
        ]));

        $response->assertStatus(200);

        $response->assertJsonStructure(['token'])->assertJsonFragment(['token_type' => 'Bearer']);
    }

    public function test_login_fail_with_wrong_password(): void
    {

        $user = User::factory()->create();

        $response = $this->postJson(route(name: 'auth.login', parameters: [
            'email'    => $user->email,
            'password' => 'wrong_password',
        ]));

        $response->assertStatus(401);

        $response->assertJsonStructure(['message'])->assertJsonFragment(['message' => 'Niepoprawne dane logowania']);
    }

    public function test_login_fail_with_empty_inputs(): void
    {

        $user = User::factory()->create();

        $response = $this->postJson(route(name: 'auth.login', parameters: []));

        $response->assertUnprocessable();

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'email',
                'password',
            ]])->assertJsonFragment([
            'errors' => [
                'email'    => ["The email field is required."],
                'password' => ["The password field is required."]
            ]
        ]);
    }


}
