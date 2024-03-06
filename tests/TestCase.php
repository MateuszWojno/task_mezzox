<?php

namespace Tests;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createUsers(): void
    {
        $this->admin = User::create([
            'first_name'        => fake()->firstName(),
            'last_name'         => fake()->lastName(),
            'email'             => fake()->email(),
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('asd')
        ]);
        $this->admin->addRole('admin');
        $this->user = User::create([
            'first_name'        => fake()->firstName(),
            'last_name'         => fake()->lastName(),
            'email'             => fake()->email(),
            'email_verified_at' => Carbon::now(),
            'password'          => Hash::make('asd')
        ])->addRole('user');

    }
}
