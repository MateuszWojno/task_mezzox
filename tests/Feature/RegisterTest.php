<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register(): void
    {

        $email = "unique." . fake()->unique()->safeEmail();
        $password = fake()->password(10);
        $firstName = fake()->name();
        $lastName = fake()->lastName();

        $response = $this->postJson(route(name: 'auth.register'), data: [
            'email'      => $email,
            'password'   => $password,
            'first_name' => $firstName,
            'last_name'  => $lastName,
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'message'
        ]);
        $response->assertJsonFragment([
            'message' => 'Użytkownik został utworzony'
        ]);
        $this->assertDatabaseHas(User::class, [
            'email'      => $email,
            'first_name' => $firstName,
            'last_name'  => $lastName,
        ]);
    }

    public function test_register_email_must_be_valid(): void
    {

        $email = 'nieprawidlowy.mail';
        $password = fake()->password();
        $firstName = fake()->name();
        $lastName = fake()->lastName();

        $response = $this->postJson(route(name: 'auth.register', parameters: [
            'email'           => $email,
            'password'        => $password,
            'password_repeat' => $password,
            'first_name'      => $firstName,
            'last_name'       => $lastName
        ]));

        $response->assertUnprocessable();

        $response
            ->assertJsonStructure(['message', 'errors']);
        $response->assertJsonFragment([
            "message" => "The email field must be a valid email address.",
            "errors"  => [
                "email" => [
                    "The email field must be a valid email address.",
                ]]
        ]);
    }

    public function test_register_email_must_not_be_empty(): void
    {

        $email = null;
        $password = fake()->password();
        $firstName = fake()->name();
        $lastName = fake()->lastName();

        $response = $this->postJson(route(name: 'auth.register', parameters: [
            'email'           => $email,
            'password'        => $password,
            'password_repeat' => $password,
            'first_name'      => $firstName,
            'last_name'       => $lastName
        ]));

        $response->assertUnprocessable();

        $response->assertJsonStructure(['message', 'errors']);

        $response->assertJsonFragment([
            "message" => "The email field is required.",
            "errors"  => [
                "email" => [
                    "The email field is required.",
                ]
            ]
        ]);
    }

    public function test_register_email_must_unique(): void
    {

        $user = User::factory()->create();
        $email = $user->email;

        $password = fake()->password();
        $firstName = fake()->name();
        $lastName = fake()->lastName();

        $response = $this->postJson(route(name: 'auth.register', parameters: [
            'email'           => $email,
            'password'        => $password,
            'password_repeat' => $password,
            'first_name'      => $firstName,
            'last_name'       => $lastName
        ]));

        $response->assertUnprocessable();

        $response->assertJsonStructure(['message', 'errors']);

        $response->assertJsonFragment([
            "message" => "The email has already been taken.",
            "errors"  => [
                "email" => [
                    "The email has already been taken.",
                ]
            ]
        ]);
    }

    public function test_register_password_cannot_be_empty(): void
    {

        $user = User::factory()->create();
        $email = fake()->email();

        $password = null;
        $firstName = fake()->name();
        $lastName = fake()->lastName();

        $response = $this->postJson(route(name: 'auth.register', parameters: [
            'email'      => $email,
            'password'   => $password,
            'first_name' => $firstName,
            'last_name'  => $lastName
        ]));

        $response->assertUnprocessable();

        $response->assertJsonStructure(['message', 'errors']);

        $response->assertJsonFragment([
            "message" => "The password field is required.",
            "errors"  => [
                "password" => [
                    "The password field is required.",
                ]
            ]
        ]);
    }

    public function test_register_first_name_cannot_be_empty(): void
    {

        $user = User::factory()->create();
        $email = fake()->email();

        $password = fake()->password(10);
        $firstName = null;
        $lastName = fake()->lastName();

        $response = $this->postJson(route(name: 'auth.register', parameters: [
            'email'      => $email,
            'password'   => $password,
            'first_name' => $firstName,
            'last_name'  => $lastName
        ]));

        $response->assertUnprocessable();

        $response->assertJsonStructure(['message', 'errors']);

        $response->assertJsonFragment([
            "message" => "The first name field is required.",
            "errors"  => [
                "first_name" => [
                    "The first name field is required.",
                ]
            ]
        ]);
    }

    public function test_register_last_name_cannot_be_empty(): void
    {
        $user = User::factory()->create();
        $email = fake()->email();

        $password = fake()->password();
        $firstName = fake()->firstName();
        $lastName = null;

        $response = $this->postJson(route(name: 'auth.register', parameters: [
            'email'      => $email,
            'password'   => $password,
            'first_name' => $firstName,
            'last_name'  => $lastName
        ]));

        $response->assertUnprocessable();

        $response->assertJsonStructure(['message', 'errors']);

        $response->assertJsonFragment([
            "message" => "The last name field is required.",
            "errors"  => [
                "last_name" => [
                    "The last name field is required.",
                ]
            ]
        ]);
    }

}
